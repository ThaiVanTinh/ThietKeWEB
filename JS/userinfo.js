/* hien thi thong tin khach hang*/
function displayLoggedInUserInfo() {
    document.addEventListener("DOMContentLoaded", function () {
      const loggedInUserEmail = localStorage.getItem("loggedInUser");
      const loggedInUserName = localStorage.getItem("loggedInUserName");
      const loggedInUserPhone = localStorage.getItem("loggedInUserPhone");
      const loggedInUserGender = localStorage.getItem("loggedInUserGender");
  
      if (loggedInUserEmail) {
        /*check thong tin email*/
        const emailElement = document.querySelector(".email-user");
        if (emailElement) {
          emailElement.textContent = `Email: ${loggedInUserEmail}`;
        } else {
          console.error("Email element not found.");
        }
  
        /*check thong tin ten*/
        const nameElement = document.querySelector(".user-name");
        if (nameElement) {
          nameElement.textContent = `Họ và tên: ${loggedInUserName}`;
        } else {
          console.error("Name element not found.");
        }
  
        /*check thong tin dien thoai*/
        const phoneElement = document.querySelector(".user-phone");
        if (phoneElement) {
          phoneElement.textContent = `Điện thoại: ${loggedInUserPhone}`;
        } else {
          console.error("Phone element not found.");
        }
  
        /*check thong tin gioi tinh*/
        const genderElement = document.querySelector(".gender");
        if (genderElement) {
          genderElement.textContent = `Giới tính: ${loggedInUserGender}`;
        } else {
          console.error("Gender element not found.");
        }
      } else {
        // alert("Vui lòng đăng nhập tài khoản");
        // window.location.href = "login.html";
      }
    });
  }
  