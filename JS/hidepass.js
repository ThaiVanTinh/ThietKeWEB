  /* an hien mat khau o dang nhap va dang ky */
  function togglePasswordVisibility(id) {
    const passwordField = document.getElementById(id);
    const icon = passwordField.nextElementSibling.querySelector("i");
  
    if (passwordField.type === "password") {
      passwordField.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      passwordField.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }