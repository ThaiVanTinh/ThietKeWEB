<?php
require '../admin/database/connectdb.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

$sql = "SELECT * FROM toy_products WHERE product_id = :product_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$product) {
    die("Sản phẩm không tồn tại.");
}

$allCategories = [
    'BÁN CHẠY',
    'ĐỒ CHƠI PHƯƠNG TIỆN',
    'XE ĐIỀU KHIỂN',
    'XE MÔ HÌNH',
    'XE LẮP RÁP',
    'XE SƯU TẬP',
    'ĐỒ CHƠI SÁNG TẠO',
    'BỘT NẶN',
    'BÚT MÀU VÀ BẢNG VẼ',
    'ĐỒ CHƠI LẮP GHÉP',
];

$categoriesArray = array_map('trim', explode(',', $product['category']));
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/admin_pro_mag.css" />
    <link rel="shortcut icon" href="../images/android-icon-48x48.png" />
    <script src="../JS/toy.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#header").load("../html/header.html");
            $("#footer").load("../html/footer.html");

            $("#edit-product-form").on("submit", function(event) {

                var categoryChecked = $("input[name='category[]']:checked").length > 0;
                if (!categoryChecked) {
                    alert("Vui lòng chọn ít nhất một loại sản phẩm.");
                    return false;
                }

                event.preventDefault();

                $.ajax({
                    url: 'update_product.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                    },
                    error: function() {
                        alert("Có lỗi xảy ra trong quá trình gửi dữ liệu.");
                    }
                });
            });

            $("#delete-product-btn").on("click", function() {
                if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
                    $.ajax({
                        url: 'delete_product.php',
                        type: 'POST',
                        data: {
                            product_id: <?php echo $product_id; ?>
                        },
                        success: function(response) {
                            alert(response);
                            window.location.href = '../admin/product_list.php';
                        },
                        error: function() {
                            alert("Có lỗi xảy ra trong quá trình xóa sản phẩm.");
                        }
                    });
                }
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
    <title>Chỉnh Sửa Sản Phẩm</title>
</head>

<body>
    <div id="header"></div>
    <div class="main-content">
        <h1 class="center-text">Chỉnh Sửa Sản Phẩm</h1>
        <div class="content-wrapper">
            <div class="sidebar">
                <h2>Chức Năng</h2>
                <a href="../admin/product_list.php">Danh Sách Sản Phẩm</a>
                <a href="../admin/product-management.php">Thêm sản phẩm</a>
                <a href="../admin/index.php">Trang Quản Trị</a>
                <a style="cursor: pointer;" onclick="logout()">Đăng xuất</a>
            </div>
            <div class="info">
                <div class="info-container">
                    <div class="section">
                        <h3>Thông Tin Sản Phẩm</h3>
                        <form id="edit-product-form" method="post">
                            <input type="hidden" id="product_id" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">

                            <label for="name">Tên Sản Phẩm: <span class="required">*</span></label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

                            <label for="category">Loại Sản Phẩm: <span class="required">*</span></label>
                            <div class="category-options">
                                <?php foreach ($allCategories as $categoryOption): ?>
                                    <label>
                                        <input type="checkbox" name="category[]" value="<?php echo htmlspecialchars($categoryOption); ?>" <?php echo in_array($categoryOption, $categoriesArray) ? 'checked' : ''; ?>>
                                        <?php echo htmlspecialchars($categoryOption); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <label for="brand">Thương Hiệu: <span class="required">*</span></label>
                            <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($product['brand']); ?>" required>

                            <label for="original_price">Giá Gốc: <span class="required">*</span></label>
                            <input type="number" id="original_price" name="original_price" value="<?php echo htmlspecialchars($product['original_price']); ?>" required>

                            <label for="discount_percentage">Phần Trăm Giảm:</label>
                            <input type="number" id="discount_percentage" name="discount_percentage" value="<?php echo htmlspecialchars($product['discount_percentage']); ?>">

                            <label for="discounted_price">Giá Giảm: </label>
                            <input type="number" id="discounted_price" name="discounted_price" value="<?php echo htmlspecialchars($product['discounted_price']); ?>">

                            <label for="quantity">Số Lượng: <span class="required">*</span></label>
                            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>

                            <label for="description">Mô Tả: <span class="required">*</span></label>
                            <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

                            <label for="detailed_description">Mô Tả Chi Tiết:</label>
                            <textarea id="detailed_description" name="detailed_description"><?php echo htmlspecialchars($product['detailed_description']); ?></textarea>

                            <label for="image_url">URL Hình Ảnh: <span class="required">*</span></label>
                            <textarea id="image_url" name="image_url" rows="3" required><?php echo htmlspecialchars($product['image_url']); ?></textarea>

                            <label for="sub_images">Hình Ảnh Phụ (cách nhau bằng dấu phẩy):</label>
                            <textarea id="sub_images" name="sub_images" rows="3"><?php echo htmlspecialchars($product['sub_images']); ?></textarea>

                            <label for="theme">Chủ Đề:</label>
                            <input type="text" id="theme" name="theme" value="<?php echo htmlspecialchars($product['theme']); ?>">

                            <label for="origin">Xuất Xứ:</label>
                            <input type="text" id="origin" name="origin" value="<?php echo htmlspecialchars($product['origin']); ?>">

                            <label for="code">Mã: <span class="required">*</span></label>
                            <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($product['code']); ?>" required>

                            <label for="age">Độ Tuổi:</label>
                            <input type="text" id="age" name="age" value="<?php echo htmlspecialchars($product['age']); ?>">

                            <label for="brand_origin">Nguồn Gốc Thương Hiệu:</label>
                            <input type="text" id="brand_origin" name="brand_origin" value="<?php echo htmlspecialchars($product['brand_origin']); ?>">

                            <div class="btn">
                                <button type="submit">Cập Nhật Sản Phẩm</button>
                                <button type="button" id="delete-product-btn">Xóa Sản Phẩm</button>
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