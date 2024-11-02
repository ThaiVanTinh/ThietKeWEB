<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="../css/admin_order_detail.css" />
    <link rel="shortcut icon" href="../images/android-icon-48x48.png" />
    <script src="../js/toy.js"></script>
    <script src="../js/logout.js"></script>
    <!-- jQuery for AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#header").load("../html/header.html");
            $("#footer").load("../html/footer.html");
        });

        document.addEventListener("DOMContentLoaded", () => {
            function formatPrice(price) {
                return new Intl.NumberFormat("vi-VN", {
                    style: "currency",
                    currency: "VND",
                }).format(price);
            }

            function renderOrders() {
                const orderListContainer = document.getElementById("list-order");
                let orders = JSON.parse(localStorage.getItem("orders")) || [];

                orderListContainer.innerHTML = "";

                if (orders.length > 0) {
                    const table = `
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Mã Đơn Hàng</th>
                                    <th>Người Đặt</th>
                                    <th>Sản Phẩm</th>
                                    <th>Địa Chỉ</th>
                                    <th>Giá tiền</th>
                                    <th>Trạng Thái</th>
                                    <th>Hủy</th>
                                    <th>Chi Tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${orders.map(order => {
                                    let totalAmount = order.products.reduce((sum, product) => {
                                        return sum + (product.price * product.quantity);
                                    }, 0);

                                    totalAmount += (order.shipping || 30000) - (order.discount || 0);

                                    return `
                                    <tr>
                                        <td>#${order.id}</td>
                                        <td>${localStorage.getItem("loggedInUserName")}</td>
                                        <td>${truncateProductName(order.products.map(product => product.name).join(', '))}</td>
                                        <td>${getOrderAddress()}</td>
                                        <td>${formatPrice(totalAmount)}</td>
                                        <td>
                                            <select class="order-status-select" data-id="${order.id}">
                                                <option value="Chờ xác nhận" ${order.status === "Chờ xác nhận" ? "selected" : ""}>Chờ xác nhận</option>
                                                <option value="Đang Giao" ${order.status === "Đang Giao" ? "selected" : ""}>Đang Giao</option>
                                                <option value="Đã Giao" ${order.status === "Đã Giao" ? "selected" : ""}>Đã Giao</option>
                                            </select>
                                        </td>
                                        <td><button class="remove-order" data-id="${order.id}">Hủy đơn hàng</button></td>
                                        <td><button class="view-detail" data-id="${order.id}">Xem chi tiết</button></td>
                                    </tr>
                                `}).join('')}
                            </tbody>
                        </table>
                    `;
                    orderListContainer.innerHTML = table;

                    document.querySelectorAll('.view-detail').forEach(button => {
                        button.addEventListener('click', function () {
                            const orderId = this.getAttribute("data-id");
                            viewOrderDetail(orderId);
                        });
                    });

                    document.querySelectorAll('.order-status-select').forEach(select => {
                        select.addEventListener('change', function () {
                            const orderId = this.getAttribute('data-id');
                            updateOrderStatus(orderId, this.value);
                        });
                    });

                    document.querySelectorAll(".remove-order").forEach((button) => {
                        button.addEventListener("click", (e) => {
                            const orderId = e.target.getAttribute("data-id");
                            showPopup(orderId);
                        });
                    });
                } else {
                    orderListContainer.innerHTML = "<p>Không có đơn hàng nào!</p>";
                }
            }

            function truncateProductName(name) {
                return name.length > 20 ? name.substring(0, 20) + '...' : name;
            }

            function getOrderAddress() {
                const userAddress = JSON.parse(localStorage.getItem('userAddress'));
                if (userAddress) {
                    return `${userAddress.street} ${userAddress.ward}, ${userAddress.district}, ${userAddress.city}`;
                }
                return '';
            }

            function viewOrderDetail(orderId) {
    let orders = JSON.parse(localStorage.getItem("orders")) || [];
    const order = orders.find(order => order.id == orderId);
    if (order) {
        document.querySelector("#popup-order-detail .order-detail").innerHTML = `
            <h2>Chi tiết đơn hàng #${order.id}</h2>
            <p>Trạng thái: ${order.status}</p>
            <div class="order-products">${order.products.map(product => `
                <div class="order-product">
                    <img src="${product.imgSrc}" alt="${product.name}">
                    <div class="product-info">
                        <h3>${product.name}</h3>
                        <p>Giá: ${formatPrice(product.price)}</p>
                        <p>Số lượng: ${product.quantity}</p>
                    </div>
                </div>
            `).join('')}</div>
            <p>Tổng tiền: ${formatPrice(order.products.reduce((sum, product) => sum + (product.price * product.quantity), 30000))}</p>
        `;

        document.getElementById("popup-order").style.display = "block"; 
        document.getElementById("popup-order-detail").style.display = "block"; 
        document.body.classList.add("popup-active");
    }
}


            function updateOrderStatus(orderId, newStatus) {
                let orders = JSON.parse(localStorage.getItem("orders")) || [];
                orders = orders.map(order => {
                    if (order.id == orderId) {
                        order.status = newStatus;
                    }
                    return order;
                });
                localStorage.setItem("orders", JSON.stringify(orders));
                renderOrders();
            }

            function huyDonHang(orderId) {
                let orders = JSON.parse(localStorage.getItem("orders")) || [];
                orders = orders.filter(order => order.id !== parseInt(orderId));
                localStorage.setItem("orders", JSON.stringify(orders));
                renderOrders();
            }

            function showPopup(orderId) {
                const popup = document.getElementById("popup-confirm");
                popup.style.display = 'block';
                document.getElementById("popup-confirm-order-id").textContent = `Đơn hàng #${orderId}`;

                document.getElementById("xacnhan").onclick = () => {
                    huyDonHang(orderId);
                    hidePopup();
                    showSuccessPopup();
                };

                document.getElementById("huy").onclick = () => {
                    hidePopup();
                };
            }

            function hidePopup() {
                const popup = document.getElementById("popup-confirm");
                popup.style.display = 'none';
            }

            function showSuccessPopup() {
                const popupSuccess = document.getElementById("popup-success");
                popupSuccess.style.display = 'block';

                document.getElementById("trove").onclick = () => {
                    window.location.href = 'order-management.php';
                };
                document.getElementById("tatpopup").onclick = () => {
                    popupSuccess.style.display = 'none';
                };
            }

           
            document.querySelectorAll("#popup-order-detail #tatpopup").forEach(button => {
    button.addEventListener("click", () => {
        document.getElementById("popup-order").style.display = "none";
        document.getElementById("popup-order-detail").style.display = "none";
        document.body.classList.remove("popup-active"); 
    });
});

            renderOrders();
        });
    </script>
    <title>Quản Lý Đơn Hàng</title>
</head>

<body>
    <div id="header"></div>
    <div class="main-content">
        <h1 class="center-text">Danh Sách Đơn Hàng</h1>
        <div class="content-wrapper">
            <div class="sidebar">
                <h2>Chức Năng</h2>
                <a href="../admin/product-management.php">Thêm sản phẩm</a>
                <a href="../admin/index.php">Trang Quản Trị</a>
                <a style="cursor: pointer;" onclick="logout()">Đăng xuất</a>
            </div>
            <div class="info">
                <div id="list-order" class="info-container">
                </div>
            </div>
        </div>
    </div>
    <div id="footer"></div>

  
    <div id="popup-confirm">
        <p>Bạn có chắc chắn muốn hủy <span id="popup-confirm-order-id"></span> không?</p>
        <button id="xacnhan">Xác nhận</button>
        <button id="huy">Hủy</button>
    </div>

 
    <div id="popup-success">
        <h2>Hủy đơn hàng thành công!</h2>
        <button id="trove">Trở về danh sách đơn hàng</button>
        <button id="tatpopup">Đóng</button>
    </div>

    <div id="popup-order" class="popup-order">
        <div id="popup-order-detail">
            <div class="order-detail">
            </div>
            <button id="tatpopup">Đóng</button>
        </div>
    </div>
</body>

</html>
