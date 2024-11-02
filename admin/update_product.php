<?php
require '../admin/database/connectdb.php';


if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $name = $_POST['name'];
    $category = isset($_POST['category']) ? implode(',', $_POST['category']) : '';
    $brand = $_POST['brand'];
    $original_price = $_POST['original_price'];
    $discounted_price = $_POST['discounted_price'];
    $discount_percentage = $_POST['discount_percentage'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $detailed_description = $_POST['detailed_description'];
    $image_url = $_POST['image_url'];
    $theme = $_POST['theme'];
    $origin = $_POST['origin'];
    $code = $_POST['code'];
    $age = $_POST['age'];
    $brand_origin = $_POST['brand_origin'];


    $sub_images = isset($_POST['sub_images']) ? $_POST['sub_images'] : '';
    $sub_images_array = array_map('trim', explode(',', $sub_images));
    $sub_images_string = implode(',', $sub_images_array);


    $sql_check = "SELECT COUNT(*) FROM toy_products WHERE code = :code AND product_id != :product_id";

    try {
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bindParam(':code', $code);
        $stmt_check->bindParam(':product_id', $product_id);
        $stmt_check->execute();

        if ($stmt_check->fetchColumn() == 0) {

            $sql = "UPDATE toy_products SET
                name = :name,
                category = :category,
                brand = :brand,
                original_price = :original_price,
                discounted_price = :discounted_price,
                discount_percentage = :discount_percentage,
                quantity = :quantity,
                description = :description,
                detailed_description = :detailed_description,
                image_url = :image_url,
                sub_images = :sub_images,
                theme = :theme,
                origin = :origin,
                code = :code,
                age = :age,
                brand_origin = :brand_origin
                WHERE product_id = :product_id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':brand', $brand);
            $stmt->bindParam(':original_price', $original_price);
            $stmt->bindParam(':discounted_price', $discounted_price);
            $stmt->bindParam(':discount_percentage', $discount_percentage);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':detailed_description', $detailed_description);
            $stmt->bindParam(':image_url', $image_url);
            $stmt->bindParam(':sub_images', $sub_images_string);
            $stmt->bindParam(':theme', $theme);
            $stmt->bindParam(':origin', $origin);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':brand_origin', $brand_origin);
            $stmt->bindParam(':product_id', $product_id);

            if ($stmt->execute()) {
                echo "Cập nhật sản phẩm thành công!";
            } else {
                echo "Có lỗi xảy ra khi cập nhật sản phẩm.";
            }
        } else {
            echo "Sản phẩm với mã này đã tồn tại trong cơ sở dữ liệu.";
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }


    $conn = null;
} else {
    echo "ID sản phẩm không được xác định.";
}
