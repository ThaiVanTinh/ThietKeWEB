/*them san pham vao gio hang*/
document.addEventListener("DOMContentLoaded", () => {
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

      localStorage.setItem("cartCount", totalItems);
    } else {
      cartCountElement.classList.remove("visible");

      localStorage.setItem("cartCount", 0);
    }
  }

  function updateWishlistCount() {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    const wishlistCountElement = document.getElementById("wishlist-count");

    if (wishlist.length > 0) {
      wishlistCountElement.classList.add("visible");
      wishlistCountElement.querySelector("label").innerText = wishlist.length;

      localStorage.setItem("wishlistCount", wishlist.length);
    } else {
      wishlistCountElement.classList.remove("visible");

      localStorage.setItem("wishlistCount", 0);
    }
  }

  function addToCart(product) {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const existingProductIndex = cart.findIndex(
      (item) => item.id === product.id
    );

    if (existingProductIndex !== -1) {
      cart[existingProductIndex].quantity += 1;
    } else {
      product.quantity = 1;
      cart.push(product);
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    showPopupMessage("cart");
    updateCartCount();
  }

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
      showPopupMessage("wishlist-error");
    }
  }

  const addToCartButtons = document.querySelectorAll(".add-to-cart a");
  addToCartButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      const productElement = e.target.closest(".product");
      const product = {
        id: productElement.querySelector("img").alt,
        name: productElement.querySelector("p").innerText,
        price: parseFloat(
          productElement
            .querySelector(".price")
            .innerText.replace(" Đ", "")
            .replace(/\./g, "")
            .replace(",", ".")
        ),
        imgSrc: productElement.querySelector("img").src,
      };
      addToCart(product);
    });
  });

  const wishlistButtons = document.querySelectorAll(".heart-icon");
  wishlistButtons.forEach((button) => {
    button.addEventListener("click", (e) => {
      e.preventDefault();
      const productElement = e.target.closest(".product");
      const product = {
        id: productElement.querySelector("img").alt,
        name: productElement.querySelector("p").innerText,
        price: parseFloat(
          productElement
            .querySelector(".price")
            .innerText.replace(" Đ", "")
            .replace(/\./g, "")
            .replace(",", ".")
        ),
        imgSrc: productElement.querySelector("img").src,
      };
      addToWishlist(product);
    });
  });

  updateCartCount();
  updateWishlistCount();
});

/* POPUP */

function showPopupMessage(type) {
  const popupContainer = document.getElementById("popup-container");
  const addToCartMessage = document.querySelector("#add-to-cart");
  const addToWishlistMessage = document.querySelector("#wishlist");
  const errorAddToWishlistMessage = document.querySelector("#erorr-wishlist");

  // Hide all messages
  addToCartMessage.style.display = "none";
  addToWishlistMessage.style.display = "none";
  errorAddToWishlistMessage.style.display = "none";

  // Show the relevant message based on the type
  if (type === "cart") {
    addToCartMessage.style.display = "block";
  } else if (type === "wishlist") {
    addToWishlistMessage.style.display = "block";
  } else if (type === "wishlist-error") {
    errorAddToWishlistMessage.style.display = "block";
  }

  // Display the popup
  popupContainer.style.display = "block";

  // Hide the popup after 3 seconds
  setTimeout(() => {
    popupContainer.style.display = "none";
  }, 3000);
}

document.getElementById("close-popup").addEventListener("click", () => {
  document.getElementById("popup-container").style.display = "none";
});
