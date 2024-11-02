/* thay doi chu dang nhap thanh ten user */
window.onload = function () {
    const loggedInUser = localStorage.getItem("loggedInUser");
    const userRole = localStorage.getItem("userRole");
    const loginACC = localStorage.getItem("LogginAcc");
    if (loggedInUser) {
      const loginLink = document.getElementById("linkdangnhap");
      loginLink.innerText = `Xin chào, ${loginACC}`;
        
        // Đổi URL dựa trên role của người dùng khi click vào link
        loginLink.addEventListener("click", function (event) {
          event.preventDefault(); // Ngăn không cho liên kết hoạt động ngay
          if (userRole==1) {
            loginLink.href ="../admin/index.php";
            }else {
                loginLink.href ="../html/user.html";
              
            }
            window.location.href = loginLink.href; 
        });
      updateCartCount();
      updateWishlistCount();
    } else { $('#linkdangnhap').click(function () {
      window.location.href="../html/login.html";
    });
    }
  };