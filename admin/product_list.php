<?php
require '../admin/database/connectdb.php';


$sql = "SELECT product_id, name, code, brand, original_price, discounted_price, discount_percentage, quantity, image_url, category FROM toy_products";
$products = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/admin_pro_list.css" />
    <link rel="shortcut icon" href="../images/android-icon-48x48.png" />
    <script src="../JS/toy.js"></script>
    <script src="../JS/logout.js"></script>
    <!-- jQuery for AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#header").load("../html/header.html");
            $("#footer").load("../html/footer.html");
            loadProducts();
        });
    </script>
    <title>Quản Lý Sản Phẩm</title>
</head>

<body>
    <div id="header"></div>
    <div class="main-content">
        <h1 class="center-text">Danh Sách Sản Phẩm</h1>
        <div class="content-wrapper">
            <div class="sidebar">
                <h2>Chức Năng</h2>
                <a href="../admin/product-management.php">Thêm sản phẩm</a>
                <a href="../admin/index.php">Trang Quản Trị</a>
                <a style="cursor: pointer;" onclick="logout()">Đăng xuất</a>
            </div>
            <div class="info">
                <div class="info-container">
                    <table class="product-table">
                        <thead class="product-header">
                            <tr>
                                <th>Hình Ảnh</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Mã Sản Phẩm</th>
                                <th>Loại Sản Phẩm</th>
                                <th>Giá Gốc</th>
                                <th>Giá Giảm</th>
                                <th>Số Lượng</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($products->rowCount() > 0): ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>
                                            <a href="../php/product_detail.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>">
                                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" width="100">
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td><?php echo htmlspecialchars($product['code']); ?></td>
                                        <td class="category"><?php echo htmlspecialchars($product['category']); ?></td>
                                        <td><?php echo number_format($product['original_price'], 0, ',', '.'); ?> VND</td>
                                        <td>
                                            <?php echo number_format($product['discounted_price'], 0, ',', '.'); ?> VND
                                            <?php if (!empty($product['discount_percentage'])): ?>
                                                (<?php echo htmlspecialchars($product['discount_percentage']); ?>%)
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                                        <td>
                                            <a href="../admin/product_edit.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>" class="edit-btn">Sửa</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">Không có sản phẩm nào trong cơ sở dữ liệu.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="footer"></div>
</body>

</html>