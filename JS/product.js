let currentImageIndex = 0;
const thumbnails = document.querySelectorAll(".thumbnails img");
const mainImage = document.getElementById("main-image");

function updateMainImage() {
  mainImage.src = thumbnails[currentImageIndex].src;
  thumbnails.forEach((thumbnail) => thumbnail.classList.remove("active"));
  thumbnails[currentImageIndex].classList.add("active");
}

function changeImage(element) {
  currentImageIndex = Array.from(thumbnails).indexOf(element);
  updateMainImage();
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
  updateMainImage();
  updateCartCount();
  updateWishlistCount();

  const decreaseBtn = document.querySelector(".decrease-btn");
  const increaseBtn = document.querySelector(".increase-btn");
  const quantityInput = document.getElementById("quantity");

  decreaseBtn.addEventListener("click", () => {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
    }
  });

  increaseBtn.addEventListener("click", () => {
    let currentValue = parseInt(quantityInput.value);
    quantityInput.value = currentValue + 1;
  });
});

// Cập nhật số lượng sản phẩm trong giỏ hàng
function updateCartCount() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const totalItems = cart.reduce(
    (total, product) => total + product.quantity,
    0
  );
  const cartCountElement = document.getElementById("cart-count");
  if (totalItems > 0) {
    cartCountElement.classList.add("visible");
    cartCountElement.querySelector("label").innerText = totalItems;
  } else {
    cartCountElement.classList.remove("visible");
  }
}

// Cập nhật số lượng sản phẩm trong danh sách yêu thích
function updateWishlistCount() {
  let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
  const wishlistCountElement = document.getElementById("wishlist-count");
  if (wishlist.length > 0) {
    wishlistCountElement.classList.add("visible");
    wishlistCountElement.querySelector("label").innerText = wishlist.length;
  } else {
    wishlistCountElement.classList.remove("visible");
  }
}

// Hiển thị popup với nội dung cụ thể
function showPopupMessage(type) {
  const popupContainer = document.getElementById("popup-container");
  const addToCartMessage = document.querySelector("#add-to-cart");
  const addToWishlistMessage = document.querySelector("#wishlist");
  const errorAddToWishlistMessage = document.querySelector("#erorr-wishlist");

  addToCartMessage.style.display = "none";
  addToWishlistMessage.style.display = "none";
  errorAddToWishlistMessage.style.display = "none";

  if (type === "cart") {
    addToCartMessage.style.display = "block";
  } else if (type === "wishlist") {
    addToWishlistMessage.style.display = "block";
  } else if (type === "error-wishlist") {
    errorAddToWishlistMessage.style.display = "block";
  }

  popupContainer.style.display = "block";

  setTimeout(() => {
    popupContainer.style.display = "none";
  }, 2000);
}

// Thêm sản phẩm vào giỏ hàng
function addToCart(product) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const existingProductIndex = cart.findIndex((item) => item.id === product.id);

  if (existingProductIndex !== -1) {
    cart[existingProductIndex].quantity += product.quantity;
  } else {
    cart.push(product);
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  showPopupMessage("cart");
  updateCartCount();
}

// Thêm sản phẩm vào danh sách yêu thích
function addToWishlist(product) {
  let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
  const existingProductIndex = wishlist.findIndex(
    (item) => item.id === product.id
  );

  if (existingProductIndex === -1) {
    wishlist.push(product);
    localStorage.setItem("wishlist", JSON.stringify(wishlist));
    showPopupMessage("wishlist");
    updateWishlistCount();
  } else {
    showPopupMessage("error-wishlist");
  }
}

// Gắn sự kiện cho nút "Thêm vào giỏ hàng"
const addToCartButton = document.querySelector(".add-to-cart");
addToCartButton.addEventListener("click", (e) => {
  e.preventDefault();
  const productElement = e.target.closest(".product-info-section");
  const product = {
    id: document.getElementById("main-image").alt,
    name: productElement.querySelector("h2").innerText,
    price: parseFloat(
      productElement
        .querySelector(".discounted-price")
        .innerText.replace(" Đ", "")
        .replace(/\./g, "")
        .replace(",", ".")
    ),
    quantity: parseInt(document.getElementById("quantity").value),
    imgSrc: document.getElementById("main-image").src,
  };
  addToCart(product);
});

// Gắn sự kiện cho nút "Thêm vào yêu thích"
const wishlistButton = document.querySelector(".heart-icon");
wishlistButton.addEventListener("click", (e) => {
  e.preventDefault();
  const productElement = e.target.closest(".product-info-section");
  const product = {
    id: document.getElementById("main-image").alt,
    name: productElement.querySelector("h2").innerText,
    price: parseFloat(
      productElement
        .querySelector(".discounted-price")
        .innerText.replace(" Đ", "")
        .replace(/\./g, "")
        .replace(",", ".")
    ),
    imgSrc: document.getElementById("main-image").src,
  };
  addToWishlist(product);
});

document.addEventListener("DOMContentLoaded", () => {
  const decreaseBtn = document.querySelector(".decrease-btn");
  const increaseBtn = document.querySelector(".increase-btn");
  const quantityInput = document.getElementById("quantity");

  decreaseBtn.addEventListener("click", () => {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
    }
  });

  increaseBtn.addEventListener("click", () => {
    let currentValue = parseInt(quantityInput.value);
    quantityInput.value = currentValue + 1;
  });
});
