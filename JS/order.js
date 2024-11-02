document.addEventListener("DOMContentLoaded", () => {
  function formatPrice(price) {
    return new Intl.NumberFormat("vi-VN", {
      style: "currency",
      currency: "VND",
    }).format(price);
  }

  function displayCartItems() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const productContainer = document.querySelector(".product");

    if (cart.length === 0) {
      productContainer.innerHTML = "<p>Giỏ hàng của bạn đang trống.</p>";
      return;
    }

    let totalAmount = 0;
    cart.forEach((item) => {
      const itemTotal = item.quantity * item.price;
      totalAmount += itemTotal;

      const productDiv = document.createElement("div");
      productDiv.classList.add("product-item");
      productDiv.innerHTML = `
        <div class="img-product">
          <img src="${item.imgSrc}" alt="${item.name}" />
          <p class="product-name">${item.name}</p>
        </div>
        <div class="product-info">
          <p class="product-quantity">Số lượng: ${item.quantity}</p>
          <p class="product-price">Giá: ${formatPrice(item.price)}</p>
          <p class="product-total">Tổng: ${formatPrice(itemTotal)}</p>
        </div>
      `;

      productContainer.appendChild(productDiv);
    });

    document.querySelector(
      ".tienhang"
    ).innerText = `Tiền Hàng hóa: ${formatPrice(totalAmount)}`;

    const ship = 30000;
    const discount = 0;
    const finalAmount = totalAmount - discount + ship;

    document.querySelector(".giamgia").innerText = `Giảm giá: ${formatPrice(
      discount
    )}`;
    document.querySelector(".vanchuyen").innerText = `Vận chuyển: ${formatPrice(
      ship
    )}`;
    document.querySelector(".tongtien").innerText = `Tổng cộng: ${formatPrice(
      finalAmount
    )}`;
  }

  function validateForm() {
    const firstName = document.getElementById("first-name").value.trim();
    const lastName = document.getElementById("last-name").value.trim();
    const phoneNum = document.getElementById("phone-num").value.trim();
    const city = document.getElementById("city").value.trim();
    const district = document.getElementById("district").value.trim();
    const ward = document.getElementById("ward").value.trim();

    if (
      !firstName ||
      !lastName ||
      !phoneNum ||
      !city ||
      !district ||
      !ward ||
      phoneNum.length != 10 ||
      /\D/.test(phoneNum)
    ) {
      document.getElementById("popup-address").style.display = "block";
      return false;
    }
    return true;
  }

  document.getElementById("order-button").addEventListener("click", () => {
    if (validateForm()) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];

      if (cart.length === 0) {
        alert("Giỏ hàng của bạn đang trống.");
      } else {
        saveInfo();
        window.location.href = "pay.html";
      }
    }
  });

  document.getElementById("chonlai").addEventListener("click", () => {
    document.getElementById("popup-address").style.display = "none";
  });

  displayCartItems();
});

function saveInfo() {
  const selectedCity = citis.options[citis.selectedIndex].value;
  const selectedDistrict = districts.options[districts.selectedIndex].value;
  const selectedWard = wards.options[wards.selectedIndex].value;
  const inputStreet = document.getElementById("street").value;
  const newPhone = document.getElementById("phone-num").value;
  const firstName = document.getElementById("first-name").value;
  const lastName = document.getElementById("last-name").value;

  const updateName = `${firstName} ${lastName}`;
  const address = {
    city: selectedCity,
    district: selectedDistrict,
    ward: selectedWard,
    street: inputStreet,
  };
  localStorage.setItem("loggedInUserPhone", newPhone);
  localStorage.setItem("userAddress", JSON.stringify(address));
  localStorage.setItem("loggedInUserName", updateName);
}

document.addEventListener("DOMContentLoaded", () => {
  const addressSelect = document.getElementById("save-add");

  addressSelect.addEventListener("change", () => {
    if (addressSelect.value === "old-add") {
      const savedAddress = JSON.parse(localStorage.getItem("userAddress"));
      const savedPhone = localStorage.getItem("loggedInUserPhone");
      const savedName = localStorage.getItem("loggedInUserName");

      if (savedAddress && savedPhone && savedName) {
        const nameParts = savedName.split(" ");
        const firstName = nameParts.slice(0, -1).join(" ");
        const lastName = nameParts.slice(-1).join("");

        document.getElementById("first-name").value = firstName;
        document.getElementById("last-name").value = lastName;
        document.getElementById("phone-num").value = savedPhone;
        document.getElementById("city").value = savedAddress.city;
        document.getElementById("district").value = savedAddress.district;
        document.getElementById("ward").value = savedAddress.ward;
        document.getElementById("street").value = savedAddress.street;
      } else {
        alert("Không có địa chỉ nào được lưu trước đó.");
      }
    } else {
      document.getElementById("first-name").value = "";
      document.getElementById("last-name").value = "";
      document.getElementById("phone-num").value = "";
      document.getElementById("city").value = "";
      document.getElementById("district").value = "";
      document.getElementById("ward").value = "";
      document.getElementById("street").value = "";
    }
  });
});
