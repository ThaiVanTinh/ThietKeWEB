<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/admin_index.css" />
    <link rel="shortcut icon" href="../images/android-icon-48x48.png" />
    <script src="../JS/toy.js"></script>
    <script src="../JS/admininfor.js"></script>
    <script src="../JS/logout.js"></script>
    <!-- liên kết header và footer -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#header").load("../html/header.html");
            $("#footer").load("../html/footer.html");
        });
    </script>
    <title>Toy Store</title>
</head>

<body>
    <!-- header -->
    <div id="header"></div>
    <div class="main-content">
        <h1 class="center-text">Quản Trị Hệ Thống</h1>
        <div class="content-wrapper">
            <div class="sidebar">
                <h2>Chức Năng</h2>
                <a href="../admin/product_list.php">Quản Lý Sản Phẩm</a>
                <a href="../admin/order-management.php">Quản Lý Đơn Hàng</a>
                <a onclick="logout()">Đăng xuất</a>
            </div>
            <div class="info">
                <div class="info-container">
                    <div class="section">
                        <h3>Thông Tin Quản Trị</h3>
                        <div id="user-info">
                            <p class="user-name"><span class="text-deco">Họ và tên:</span></p>
                            <p class="user-phone"><span class="text-deco">Điện thoại:</span></p>
                            <p class="email-user">Email:</p>
                            <p class="gender"><span class="text-deco">Giới tính:</span></p>
                            <script>
                                displayLoggedInUserInfo()
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="footer"></div>

</body>

</html>