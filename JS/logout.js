function logout() {
  localStorage.removeItem("loggedInUser");
  localStorage.removeItem("userRole");

  window.location.href = "../html/login.html";
}

document.addEventListener("DOMContentLoaded", function () {
  const logoutButton = document.querySelector('button[onclick="logout()"]');
  if (logoutButton) {
    logoutButton.addEventListener("click", logout);
  }
});
