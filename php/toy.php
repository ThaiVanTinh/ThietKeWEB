<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="shortcut icon" href="../images/android-icon-48x48.png" />
  <script src="../JS/toy.js"></script>
  <!-- liên kết header và footer -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#header").load("../html/header.html");
      $("#footer").load("../html/footer.html");
      loadProducts();
    });
  </script>

  <title>Toy Store</title>
</head>

<body>
  <!-- header -->
  <div
    style="position: fixed; top: 0; left: 0; width: 100%; z-index: 1"
    id="header"></div>
  <!-- phần sale -->
  <div class="sale-container">
    <button class="prev-btn">
      <i class="fa-solid fa-circle-chevron-left"></i>
    </button>
    <div class="image-and-dots">
      <img id="main-image" />
      <div class="dots"></div>
      <!-- Dấu chấm cho hình ảnh -->
    </div>
    <button class="next-btn">
      <i class="fa-solid fa-circle-chevron-right"></i>
    </button>
    <div class="thumbnail-section">
      <div class="thumbnails">
        <img
          src="../images/sale.jpeg"
          alt="Thumbnail 1"
          onclick="changeImage(this)" />
        <img
          src="../images/sale2.jpg"
          alt="Thumbnail 2"
          onclick="changeImage(this)" />
        <img
          src="../images/sale3.jpg"
          alt="Thumbnail 3"
          onclick="changeImage(this)" />
        <img
          src="../images/sale4.jpg"
          alt="Thumbnail 4"
          onclick="changeImage(this)" />
      </div>
    </div>
  </div>
  <script>
    let currentImageIndex = 0;
    const thumbnails = document.querySelectorAll(".thumbnails img");
    const mainImage = document.getElementById("main-image");
    const dotsContainer = document.querySelector(".dots");

    function createDots() {
      dotsContainer.innerHTML = "";
      thumbnails.forEach((_, index) => {
        const dot = document.createElement("span");
        dot.classList.add("dot");
        dot.addEventListener("click", () => {
          currentImageIndex = index;
          updateMainImage();
        });
        dotsContainer.appendChild(dot);
      });
    }

    function updateMainImage() {
      mainImage.src = thumbnails[currentImageIndex].src;
      thumbnails.forEach((thumbnail) => thumbnail.classList.remove("active"));
      thumbnails[currentImageIndex].classList.add("active");

      const dots = document.querySelectorAll(".dot");
      dots.forEach((dot) => dot.classList.remove("active"));
      dots[currentImageIndex].classList.add("active");
    }

    document.querySelector(".prev-btn").addEventListener("click", () => {
      currentImageIndex =
        currentImageIndex > 0 ? currentImageIndex - 1 : thumbnails.length - 1;
      updateMainImage();
    });

    document.querySelector(".next-btn").addEventListener("click", () => {
      currentImageIndex =
        currentImageIndex < thumbnails.length - 1 ? currentImageIndex + 1 : 0;
      updateMainImage();
    });

    document.addEventListener("DOMContentLoaded", () => {
      createDots();
      updateMainImage();
    });
  </script>
  <!-- Sản phẩm -->
  <div class="container-product">
    <h2>Top Những Sản Phẩm Bán Chạy</h2>
    <div class="product-list">
      <?php include '../php/fetch_product.php'; ?>
    </div>
  </div>
  <!-- phần Danh mục -->
  <div class="popular-content">
    <h1>Danh Mục Nổi Bật</h1>
    <div class="main-popular">
      <a href="../php/filter.php?category=Xe mô hình"><img src="../images/popular car.png" /></a>
      <p>Xe Mô Hình</p>
    </div>
    <div class="sub-popular">
      <div class="sub">
        <div class="sub-img-wrapper">
          <a href="../php/filter.php?category=Đồ chơi lắp ghép"><img src="../images/popular lego.png" /></a>
        </div>
        <p>Đồ Chơi Lắp Ghép</p>
      </div>
      <div class="sub">
        <div class="sub-img-wrapper">
          <a href="../php/filter.php?category=Bút màu và bảng vẽ"><img src="../images/popular color.png" /></a>
        </div>
        <p>Bút Màu</p>
      </div>
    </div>
  </div>

  <!-- Thương hiệu nổi bật -->
  <div class="brand-container">
    <h2>Thương Hiệu Nổi Bật</h2>

    <div class="brands">
      <div class="brand">
        <a href="#"><img src="../images/duka.png" alt="Clever Hippo" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/popmart.png" alt="Peek A Boo" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/munchkin.png" alt="Vecto" /></a>
      </div>
      <div class="brand">
        <a href="../php/brand.php?brand=Hot Whells"><img src="../images/hotwheels.png" alt="Barbie" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/lego.png" alt="Hot Wheels" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/monopoly.png" alt="Beyblade" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/bakugan.png" alt="Rastar" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/polesie.png" alt="CoolKids" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/beyblade.png" alt="CoolKids" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/Nerf_logo.png" alt="CoolKids" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/play-doh.png" alt="CoolKids" /></a>
      </div>
      <div class="brand">
        <a href="#"><img src="../images/haspro.png" alt="CoolKids" /></a>
      </div>
    </div>
  </div>

  <!-- footer -->
  <div id="footer"></div>

  <!--popup-->
  <div id="popup-container" class="popup-container">
    <div class="popup-content">
      <span id="close-popup" class="close-popup">&times;</span>
      <div id="add-to-cart">
        <img src="../images/checked.png" />
        <h3>Sản phẩm đã được thêm vào giỏ hàng</h3>
      </div>
      <div id="wishlist">
        <img src="../images/checked.png" />
        <h3 id="wishlist">Sản phẩm đã được thêm vào danh sách yêu thích</h3>
      </div>
      <div id="erorr-wishlist">
        <img src="../images/checked.png" />
        <h3 id="erorr-wishlist">Sản phẩm đã có trong danh sách yêu thích</h3>
      </div>
    </div>
  </div>
</body>

</html>