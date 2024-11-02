<?php
// Kết nối với cơ sở dữ liệu
require '../admin/database/connectdb.php';

// Lấy ID sản phẩm từ URL
$id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Truy vấn chi tiết sản phẩm dựa trên ID
$sql = "SELECT * FROM toy_products WHERE product_id = :product_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':product_id', $id, PDO::PARAM_INT);
$stmt->execute();

// Kiểm tra kết quả truy vấn
if ($stmt->rowCount() > 0) {
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Xử lý sub_images từ chuỗi phân cách bởi dấu phẩy
    $sub_images_string = $product['sub_images'];
    $sub_images = array_filter(array_map('trim', explode(',', $sub_images_string))); // Chia tách chuỗi và loại bỏ khoảng trắng
} else {
    echo 'Sản phẩm không tồn tại.';
    exit;
}

// Đóng kết nối
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="../images/android-icon-48x48.png" />
    <link rel="stylesheet" href="../css/product.css" />
    <link rel="stylesheet" href="../css/breadcrumb.css" />
    <script src="../JS/toy.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#header").load("../html/header.html");
            $("#footer").load("../html/footer.html");
            loadProducts();
        });
    </script>

    <title><?php echo htmlspecialchars($product['name']); ?></title>
</head>

<body>
    <div id="header"></div>
    <div class="breadcrumb"> <a href="../php/toy.php">Trang chủ</a> <a href="#">Sản phẩm</a></div>
    <div class="product-container">
        <div class="product-image-section">
            <img
                id="main-image"
                src="<?php echo htmlspecialchars($product['image_url']); ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>" />
            <div class="thumbnail-section">
                <button class="prev-btn">
                    <i class="fa-solid fa-circle-chevron-left"></i>
                </button>
                <div class="thumbnails">
                    <?php
                    foreach ($sub_images as $image) {
                        if (!empty($image)) {
                            echo '<img src="' . htmlspecialchars($image) . '" onclick="changeImage(this)" />';
                        }
                    }
                    ?>
                </div>
                <button class="next-btn">
                    <i class="fa-solid fa-circle-chevron-right"></i>
                </button>
            </div>
        </div>
        <div class="product-info-section">
            <div class="product-name">
                <h2><?php echo htmlspecialchars($product['description']); ?></h2>
                <span class="heart-icon">&#x2764;</span>
            </div>
            <p class="brand-text">Thương hiệu: <a href="#"><?php echo htmlspecialchars($product['brand']); ?></a></p>
            <div class="price-section">
                <?php if ($product['discounted_price'] > 0 && $product['discount_percentage'] > 0): ?>
                    <span class="original-price"><?php echo number_format($product['original_price'], 0, ',', '.'); ?> Đ</span>
                    <span class="discounted-price"><?php echo number_format($product['discounted_price'], 0, ',', '.'); ?> Đ</span>
                    <span class="discount">-<?php echo htmlspecialchars($product['discount_percentage']); ?>%</span>
                <?php else: ?>
                    <span class="discounted-price"><?php echo number_format($product['discounted_price'], 0, ',', '.'); ?> Đ</span>
                <?php endif; ?>
            </div>
            <button class="exclusive-offer">
                <h3>Giá độc quyền khi mua trên website</h3>
            </button>
            <ul class="shipping-info">
                <li><i class="fa-solid fa-check"></i>Hàng Chính Hãng</li>
                <li><i class="fa-solid fa-check"></i>Miễn Phí Giao Hàng Toàn Quốc Đơn Từ 500k</li>
                <li><i class="fa-solid fa-check"></i>Giao Hàng Hỏa Tốc 4 Tiếng</li>
            </ul>

            <div class="quantity-section">
                <label for="quantity"></label>
                <div class="quantity-input">
                    <button class="decrease-btn" <?php echo $product['quantity'] == 0 ? 'disabled' : ''; ?>>-</button>
                    <input type="number" id="quantity" value="1" min="1" <?php echo $product['quantity'] == 0 ? 'disabled' : ''; ?> />
                    <button class="increase-btn" <?php echo $product['quantity'] == 0 ? 'disabled' : ''; ?>>+</button>
                </div>
                <?php if ($product['quantity'] == 0): ?>
                    <button class="out-of-stock">Đã Bán Hết</button>
                <?php else: ?>
                    <button class="add-to-cart">Thêm Vào Giỏ Hàng</button>
                <?php endif; ?>
            </div>

            <div class="product-details">
                <h2>Thông tin sản phẩm</h2>
                <ul>
                    <li>Chủ đề: <?php echo htmlspecialchars($product['theme']); ?></li>
                    <li>Xuất xứ: <?php echo htmlspecialchars($product['origin']); ?></li>
                    <li>Mã: <?php echo htmlspecialchars($product['code']); ?></li>
                    <li>Tuổi: <?php echo htmlspecialchars($product['age']); ?></li>
                    <li>Thương hiệu: <?php echo htmlspecialchars($product['brand']); ?></li>
                    <li>Thương hiệu Xuất Xứ: <?php echo htmlspecialchars($product['brand_origin']); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="product-description-section">
        <h2>Mô tả sản phẩm</h2>
        <h3><?php echo htmlspecialchars($product['description']); ?></h3>
        <div><?php echo $product['detailed_description']; ?></div>
    </div>
    <div id="footer"></div>
    <script src="../JS/product.js"></script>
    <!-- Popup -->
    <div id="popup-container" class="popup-container">
        <div class="popup-content">
            <span id="close-popup" class="close-popup">&times;</span>
            <div id="add-to-cart" style="display: none;">
                <img src="../images/checked.png" />
                <h3>Sản phẩm đã được thêm vào giỏ hàng</h3>
            </div>
            <div id="wishlist" style="display: none;">
                <img src="../images/checked.png" />
                <h3>Sản phẩm đã được thêm vào danh sách yêu thích</h3>
            </div>
            <div id="erorr-wishlist" style="display: none;">
                <img src="../images/error.png" />
                <h3>Sản phẩm đã có trong danh sách yêu thích</h3>
            </div>
        </div>
    </div>
</body>

</html>