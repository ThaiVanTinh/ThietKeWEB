document.addEventListener('DOMContentLoaded', () => {
    const cartItemsContainer = document.getElementById('cart-items');
    const totalElement = document.getElementById('total');
    const popup = document.getElementById("popup");
    const loginContent = document.getElementById("login-content");
    const closePopupBtn = document.getElementById("close-popup");

    function loadCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartItemsContainer.innerHTML = '';

        cart.forEach(product => {
            const productElement = document.createElement('div');
            productElement.className = 'product';
            productElement.innerHTML = `
                <img src="${product.imgSrc}" alt="${product.id}" />
                <div class="product-info">
                    <h3>${product.name}</h3>
                    <p class="price">${product.price.toLocaleString()} Đ</p>
                    <div class="quantity">
                        <button class="decrease-quantity" data-id="${product.id}">-</button>
                        <span>${product.quantity}</span>
                        <button class="increase-quantity" data-id="${product.id}">+</button>
                    </div>
                    <button class="remove-product" data-id="${product.id}">Xóa</button>
                </div>
            `;
            cartItemsContainer.appendChild(productElement);
        });

        updateTotal();
    }

    function updateTotal() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalItems = 0;
        let totalPrice = 0;

        cart.forEach(product => {
            totalItems += product.quantity;
            totalPrice += product.quantity * product.price;
        });

        totalElement.innerText = `${totalItems} sản phẩm`;
        document.querySelector('.tienhang').innerText = `Tiền Hàng hóa: ${totalPrice.toLocaleString()} Đ`;
        document.querySelector('.tongtien').innerText = `Tổng cộng: ${totalPrice.toLocaleString()} Đ`;
    }

    cartItemsContainer.addEventListener('click', (e) => {
        const productId = e.target.getAttribute('data-id');
        if (e.target.classList.contains('remove-product')) {
            removeFromCart(productId);
        } else if (e.target.classList.contains('increase-quantity')) {
            changeQuantity(productId, 1);
        } else if (e.target.classList.contains('decrease-quantity')) {
            changeQuantity(productId, -1);
        }
    });

    function removeFromCart(productId) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.filter(product => product.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
    }

    function changeQuantity(productId, delta) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart = cart.map(product => {
            if (product.id === productId) {
                product.quantity += delta;
                if (product.quantity < 1) product.quantity = 1;
            }
            return product;
        });
        localStorage.setItem('cart', JSON.stringify(cart));
        loadCart();
    }

    loadCart();

    function showPopup(contentUrl) {
        loginContent.innerHTML = '';
        popup.style.display = 'block';
        fetch(contentUrl)
            .then(response => response.text())
            .then(html => {
                loginContent.innerHTML = html;
            })
            .catch(err => console.error('Error loading content:', err));
    }

    function hidePopup() {
        popup.style.display = 'none';
    }
    function handleRegisterClick() {
        showPopup('register.html');
    }

    function handleLoginClick() {
        showPopup('login.html');
    }

    document.getElementById("checkout-button").addEventListener("click", () => {
        const loggedInUser = localStorage.getItem("loggedInUser");
        if (loggedInUser === null) {
            showPopup('login.html');
            $(document).on('click', '#dangnhap', function () {
                function loginCheck() {
                    const email = document.getElementById("email").value;
                    const password = document.getElementById("password").value;
                    const users = [
                      { email: "admin@example.com", password: "admin123", role: 1 },
                      {email: "tinh@gmail.com",password: "tinh123",name: "Tinh",gender: "Nam",role: 0,},
                      {email: "huy@gmail.com",password: "huy123",name: "Huy",gender: "Nam",role: 1,},
                    ];
                    const user = users.find((user) => user.email === email && user.password === password);
                    if (user) {
                      localStorage.setItem("loggedInUser", user.email);
                      localStorage.setItem("loggedInUserName", user.name);
                      localStorage.setItem("loggedInUserPhone", user.phone);
                      localStorage.setItem("loggedInUserGender", user.gender);
                      localStorage.setItem("userRole", user.role);
                    }
                  }
                    const loginForm = document.getElementById('loginForm');
                    if (loginForm) {
                        loginForm.addEventListener('submit', (event) => {
                            event.preventDefault();
                            loginCheck();
                        });
                    }
                hidePopup();
                window.location.reload();
            });
            $(document).on('click', '#register-acc', function () {
                handleRegisterClick();
                
                $(document).on('click', '#submitButton', function (event) {
                    event.preventDefault();  
                    document.getElementById("registerForm").submit();
                    
             
                    setTimeout(() => {
                        showPopup('login.html');
                    }, 500); 
                });
            });
        } else {
            hidePopup();
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                showPopupMessage("cart")
            } else {
                window.location.href = "order.html";
            }
        }
    });

    function showPopupMessage() {
        const popupContainer = document.getElementById("popup-cart-null");
        const CartMessage = document.querySelector(".alert-cart-null")
        // Hide all messages
        CartMessage.style.display = "block";
      
        // Display the popup
        popupContainer.style.display = "block";
      
        // Hide the popup after 3 seconds
        setTimeout(() => {
          popupContainer.style.display = "none";
        }, 5000);
      }
      document.getElementById("close-popup-cart").addEventListener("click", () => {
        document.getElementById("popup-cart-null").style.display = "none";
      });

    closePopupBtn.addEventListener("click", hidePopup);


    loadCart();
});
