<?php
require '../admin/database/connectdb.php';


if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    $sql = "DELETE FROM toy_products WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Sản phẩm đã được xóa thành công!";
    } else {
        echo "Có lỗi xảy ra khi xóa sản phẩm.";
    }
} else {
    echo "ID sản phẩm không được xác định.";
}
