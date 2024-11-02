<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/admin_pro_mag.css" />
    <link rel="shortcut icon" href="../images/android-icon-48x48.png" />
    <script src="../JS/toy.js"></script>
    <!-- jQuery for AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#header").load("../html/header.html");
            $("#footer").load("../html/footer.html");

            $("#add-product-form").on("submit", function(event) {

                var code = $("#code").val().trim();
                if (code === "") {
                    alert("Mã không được để trống.");
                    return false;
                }


                var categoryChecked = $("input[name='category[]']:checked").length > 0;
                if (!categoryChecked) {
                    alert("Vui lòng chọn ít nhất một loại sản phẩm.");
                    return false;
                }

                // Perform AJAX request
                $.ajax({
                    url: 'add_product.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);

                        $("#add-product-form")[0].reset();
                    },
                    error: function() {
                        alert("Có lỗi xảy ra trong quá trình gửi dữ liệu.");
                    }
                });


                event.preventDefault();
            });

            function calculateDiscountedPrice() {
                var originalPrice = parseFloat($("#original_price").val());
                var discountPercentage = parseFloat($("#discount_percentage").val());

                if (!isNaN(originalPrice) && !isNaN(discountPercentage)) {
                    var discountedPrice = originalPrice * (1 - (discountPercentage / 100));
                    $("#discounted_price").val(Math.round(discountedPrice));
                } else {
                    $("#discounted_price").val('');
                }
            }

            $("#original_price, #discount_percentage").on("input", calculateDiscountedPrice);
        });
    </script>
    <title>Quản Lý Sản Phẩm</title>
</head>

<body>
    <!-- header -->
    <div id="header"></div>
    <div class="main-content">
        <h1 class="center-text">Thêm Sản Phẩm</h1>
        <div class="content-wrapper">
            <div class="sidebar">
                <h2>Chức Năng</h2>
                <a href="../admin/product_list.php">Danh Sách Sản Phẩm</a>
                <a href="../admin/index.php">Trang Quản Trị</a>
                <a style="cursor: pointer;" onclick="logout()">Đăng xuất</a>
            </div>
            <div class="info">
                <div class="info-container">
                    <div class="section">
                        <h3>Thông tin sản phẩm</h3>
                        <form id="add-product-form" method="post" action="add_product.php">
                            <label for="name">Tên Sản Phẩm:<span class="required">*</span></label>
                            <input type="text" id="name" name="name" required>
                            <label for="category">Loại Sản Phẩm: <span class="required">*</span></label>
                            <div class="category-options">
                                <label><input type="checkbox" name="category[]" value="BÁN CHẠY"> BÁN CHẠY</label>
                                <label><input type="checkbox" name="category[]" value="ĐỒ CHƠI PHƯƠNG TIỆN"> ĐỒ CHƠI PHƯƠNG TIỆN</label>
                                <label><input type="checkbox" name="category[]" value="XE ĐIỀU KHIỂN"> XE ĐIỀU KHIỂN</label>
                                <label><input type="checkbox" name="category[]" value="XE MÔ HÌNH"> XE MÔ HÌNH</label>
                                <label><input type="checkbox" name="category[]" value="XE LẮP RÁP"> XE LẮP RÁP</label>
                                <label><input type="checkbox" name="category[]" value="XE SƯU TẬP"> XE SƯU TẬP</label>
                                <label><input type="checkbox" name="category[]" value="ĐỒ CHƠI SÁNG TẠO"> ĐỒ CHƠI SÁNG TẠO</label>
                                <label><input type="checkbox" name="category[]" value="BỘT NẶN"> BỘT NẶN</label>
                                <label><input type="checkbox" name="category[]" value="BÚT MÀU VÀ BẢNG VẼ"> BÚT MÀU VÀ BẢNG VẼ</label>
                                <label><input type="checkbox" name="category[]" value="ĐỒ CHƠI LẮP GHÉP"> ĐỒ CHƠI LẮP GHÉP</label>
                            </div>
                            <label for="brand">Thương Hiệu:<span class="required">*</span></label>
                            <input type="text" id="brand" name="brand" required>
                            <label for="original_price">Giá Gốc:<span class="required">*</span></label>
                            <input type="number" id="original_price" name="original_price" required>
                            <label for="discount_percentage">Phần Trăm Giảm:</label>
                            <input type="number" id="discount_percentage" name="discount_percentage">
                            <label for="discounted_price">Giá Giảm:</label>
                            <input type="number" id="discounted_price" name="discounted_price">
                            <label for="quantity">Số Lượng:<span class="required">*</span></label>
                            <input type="number" id="quantity" name="quantity" required>
                            <label for="description">Mô Tả:<span class="required">*</span></label>
                            <textarea id="description" name="description" required></textarea>
                            <label for="detailed_description">Mô Tả Chi Tiết:</label>
                            <textarea id="detailed_description" name="detailed_description"></textarea>
                            <label for="image_url">URL Hình Ảnh:<span class="required">*</span></label>
                            <textarea id="image_url" name="image_url" rows="3" required></textarea>
                            <label for="sub_images">Hình Ảnh Phụ (cách nhau bằng dấu phẩy):</label>
                            <textarea id="sub_images" name="sub_images" rows="3"></textarea>
                            <label for="theme">Chủ Đề:</label>
                            <input type="text" id="theme" name="theme">
                            <label for="origin">Xuất Xứ:</label>
                            <input type="text" id="origin" name="origin">
                            <label for="code">Mã: <span class="required">*</span></label>
                            <input type="text" id="code" name="code" required>
                            <label for="age">Độ Tuổi:</label>
                            <input type="text" id="age" name="age">
                            <label for="brand_origin">Nguồn Gốc Thương Hiệu:</label>
                            <input type="text" id="brand_origin" name="brand_origin">

                            <div class="btn">
                                <button type="submit">Thêm Sản Phẩm</button>
                                <button type="reset">Làm Mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="footer"></div>

</body>

</html>