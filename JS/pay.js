document.addEventListener("DOMContentLoaded", () => {
 
    function formatPrice(price) {
      return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
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
  
    
      document.querySelector(".tienhang").innerText = `Tiền Hàng hóa: ${formatPrice(totalAmount)}`;
  
     
      const ship=30000;
      const discount = 0; 
      const finalAmount = totalAmount - discount + ship;
  
      document.querySelector(".giamgia").innerText = `Giảm giá: ${formatPrice(discount)}`;
      document.querySelector(".vanchuyen").innerText=`Vận chuyển: ${formatPrice(ship)}`;
      document.querySelector(".tongtien").innerText = `Tổng cộng: ${formatPrice(finalAmount)}`;
    }
    document.getElementById("confirm-button").addEventListener("click", () => {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
    });
   
    displayCartItems();
  });
  
$(document).ready(function () {
   
    $('input[name="payment-method"]').change(function() {
    
        $('.qr-code').addClass('hidden');
        $('.credit-card-inputs').addClass('hidden');
        
       
        if (this.value === 'VNPAY' || this.value === 'Banking') {
            $(this).siblings('.qr-code').removeClass('hidden');
        } else if (this.value === 'credit-card') {
            $(this).siblings('.credit-card-inputs').removeClass('hidden');
        }
    });

    
    $('input[name="ngayhethan"]').on('input', function (e) {
        let value = $(this).val();
    
        
        if (value.length === 2 && e.originalEvent.inputType !== 'deleteContentBackward') {
            $(this).val(value + '/');
            value = $(this).val(); 
        }
    
       
        if (value.length === 5) {
            const [MM, YY] = value.split('/').map(num => parseInt(num, 10));
            
            if (MM < 1 || MM > 12 || YY < 23) {
                alert("Tháng và năm hết hạn không hợp lệ");
                $(this).val('');
            }
        }
    });

    
});
document.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById("popup-confirm");
    const popupsuccess=document.getElementById("popup-success")

    function savePayment() {
      const selectedPaymentMethod = document.querySelector('input[name="payment-method"]:checked');
  
      if (selectedPaymentMethod) {
          const paymentMethodValue = selectedPaymentMethod.value;
          localStorage.setItem("Payment", paymentMethodValue);
      }
  }  

    function showPopup(contentUrl) {
        popup.style.display = 'block'; 
    }

    function hidePopup() {
        popup.style.display = 'none';
    }
    document.getElementById("confirm-button").addEventListener("click", showPopup);


    $('#huydathang').click(function () {
        $('#popup-confirm').hide();
    });
    $('#xacnhandathang').click(function () {
        popupsuccess.style.display='block';
        savePayment();
        let order = {
          id: Date.now(), 
          status: "Chờ xác nhận", 
          products: JSON.parse(localStorage.getItem("cart")) || [] 
      };

    
      let orders = JSON.parse(localStorage.getItem("orders")) || [];
      orders.push(order);
      localStorage.setItem("orders", JSON.stringify(orders));

 
      localStorage.removeItem("cart");
    });
    $('#trove').click(function() {
      window.location.href = 'toy.php';});
    $('#xemdonhang').click(function() {
      window.location.href = 'order-status.html';});
});
/* hien thi lai dia chi khi nhap dia chi */
document.addEventListener('DOMContentLoaded', () => {
  function loadAndDisplayAddress() {
      const userAddress = JSON.parse(localStorage.getItem('userAddress'));

      if (userAddress) {
    
          const fullAddress = `${userAddress.street} ${userAddress.ward}, ${userAddress.district}, ${userAddress.city}`;

       
          const addressElement = document.querySelector('.user-address');
          addressElement.innerHTML = `<span class="text-deco">Địa chỉ:</span> ${fullAddress}`;
      } else {
          console.log('No saved address found in localStorage.');
          const addressElement = document.querySelector('.user-address');
          addressElement.innerHTML = `<span class="text-deco">Địa chỉ:</span> Chưa có địa chỉ nào được lưu`;
      }
  }

  loadAndDisplayAddress();
});

