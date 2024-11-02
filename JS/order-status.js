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
      orders.forEach((order) => {
        const orderItem = document.createElement("div");
        orderItem.className = "order-item";

        let totalAmount = 0;
        let productListHTML = order.products
          .map((product) => {
            const itemTotal = product.price * product.quantity;
            totalAmount += itemTotal;
            return `
              <div class="order-product">
                <img src="${product.imgSrc}" alt="${product.name}" />
                <div class="product-info">
                  <h3>${product.name}</h3>
                  <p>${product.price.toLocaleString("vi-VN")} Đ</p>
                  <p class="product-quantity">Số lượng: ${product.quantity}</p>
                </div>
              </div>`;
          })
          .join("");

        orderItem.innerHTML = `
          <h2>Đơn hàng #${order.id}</h2>
          <p>Trạng thái: <span id="status">${order.status}</span></p>
          <p><strong>Thông tin người nhận</strong></p>
          <p><span id="user-name"></span> | <span id="user-phone"></span></p>
          <p><span id="user-address"></span></p>
          <p><strong>Phương thức thanh toán:</strong> <span id="payment-method"></span></p>
          <div class="order-products">
            ${productListHTML}
          </div>
          <div class="order-total">
            <p class="tienhang">Tiền Hàng hóa: ${formatPrice(totalAmount)}</p>
            <p class="giamgia">Giảm giá: ${formatPrice(order.discount || 0)}</p>
            <p class="vanchuyen">Vận chuyển: ${formatPrice(
              order.shipping || 30000
            )}</p>
            <p class="tongtien">Tổng cộng: ${formatPrice(
              totalAmount - (order.discount || 0) + (order.shipping || 30000)
            )}</p>
           </div>
          <button class="remove-order" data-id="${order.id}">${
          order.status === "Đã Giao" ? "Trả hàng" : "Hủy đơn hàng"
        }</button>
        `;

        orderListContainer.appendChild(orderItem);

        UserInfo(orderItem);
        displayPaymentMethod(orderItem);
      });

      const removeButtons = document.querySelectorAll(".remove-order");
      removeButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
          const orderId = e.target.getAttribute("data-id");
          showPopup(orderId);
        });
      });
    } else {
      orderListContainer.innerHTML = "<p>Không có đơn hàng nào!</p>";
    }
  }

  function UserInfo(orderItem) {
    const userNameElement = orderItem.querySelector("#user-name");
    const userPhoneElement = orderItem.querySelector("#user-phone");
    const addressElement = orderItem.querySelector("#user-address");

    const userName = localStorage.getItem("loggedInUserName");
    const userPhone = localStorage.getItem("loggedInUserPhone");
    const userAddress = JSON.parse(localStorage.getItem("userAddress"));

    if (userName) userNameElement.textContent = userName;
    if (userPhone) userPhoneElement.textContent = userPhone;
    if (userAddress) {
      const fullAddress = `${userAddress.street} ${userAddress.ward}, ${userAddress.district}, ${userAddress.city}`;
      addressElement.innerHTML = fullAddress;
    }
  }

  function displayPaymentMethod(orderItem) {
    const paymentMethodElement = orderItem.querySelector("#payment-method");
    const paymentMethod = localStorage.getItem("Payment");

    paymentMethodElement.textContent = paymentMethod;
  }

  function huyDonHang(orderId) {
    let orders = JSON.parse(localStorage.getItem("orders")) || [];
    orders = orders.filter((order) => order.id !== parseInt(orderId));
    localStorage.setItem("orders", JSON.stringify(orders));
    renderOrders();
  }

  function showPopup(orderId) {
    const popup = document.getElementById("popup-confirm");
    popup.style.display = "block";

    document.getElementById("xacnhan").onclick = () => {
      huyDonHang(orderId);
      showSuccessPopup();
    };

    document.getElementById("huy").onclick = () => {
      hidePopup();
    };
  }

  function hidePopup() {
    const popup = document.getElementById("popup-confirm");
    popup.style.display = "none";
  }

  function showSuccessPopup() {
    const popupSuccess = document.getElementById("popup-success");
    popupSuccess.style.display = "block";

    document.getElementById("trove").onclick = () => {
      window.location.href = "toy.php";
    };
    document.getElementById("tatpopup").onclick = () => {
      hidePopup();
      popupSuccess.style.display = "none";
    };
  }

  renderOrders();
});
