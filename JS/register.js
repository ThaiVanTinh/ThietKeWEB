/*Kiem tra dang ky tai khoản register*/
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");
    const popup = document.getElementById("popup-confirm");
  
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      if (validateForm()) {
        const userDetails = {
          firstName: form["first-name"].value,
          lastName: form["last-name"].value,
          telephone: form["telephone"].value,
          gender: form["gender"].value,
          email: form["email"].value,
          password: password.value,
        };
        saveUser();
        popup.style.display = 'block';
        document.getElementById("xacnhan").onclick = () => {
          popup.style.display = 'none';
          window.location.href = '../html/login.html';
      };
      }
    });
  
    function validateForm() {
      if (password.value == "" || confirmPassword.value == "") {
        alert("Mật khẩu không được để trống!");
        return false;
      }
      if (
        password.value == "" ||
        confirmPassword.value == "" ||
        password.value !== confirmPassword.value
      ) {
        alert("Mật khẩu không khớp!");
        return false;
      }
      if (!validatePhoneNumber(telephone.value)) {
        alert(
          "Số điện thoại không hợp lệ! Số điện thoại phải đủ 10 chữ số và không chứa ký tự chữ."
        );
        return false;
      }
      return true;
    }
    function validatePhoneNumber(phone) {
      const phoneRegex = /^[0-9]{10}$/;
      return phoneRegex.test(phone);
    }
  });
  
  function saveUser() {
    const firstName =document.getElementById('first-name').value;
    const lastName =document.getElementById('last-name').value;
    const phone = document.getElementById('telephone').value;
    const selectgender = gender.options[gender.selectedIndex].value;
    const email = document.getElementById('email').value;
    const pass=document.getElementById('password').value;
    const userRole=0;

    const updateName =`${firstName} ${lastName}`;
    localStorage.setItem("NewUserPhone", phone);
    localStorage.setItem("NewUserName", updateName);
    localStorage.setItem("NewUserGender", selectgender);
    localStorage.setItem("NewUserEmail", email);
    localStorage.setItem("NewUserPassword",pass);
    localStorage.setItem("NewUserRole",userRole);

    console.log('New User Data:', {
      email,
      pass,
      updateName,
      selectgender,
      phone,
      userRole
  });
  }

