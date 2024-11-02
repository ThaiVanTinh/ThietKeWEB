document.addEventListener("DOMContentLoaded", () => {
  const accountLink = document.getElementById("account");
  const userRole = localStorage.getItem("userRole");

  accountLink.addEventListener("click", function (event) {
    if (userRole == 1) {
      accountLink.href = "../admin/index.php";
    } else {
      accountLink.href = "../html/user.html";
    }
    window.location.href = accountLink.href;
  });
});

/*
các tài khoảng hiện có 
        user
        email: "tinh@gmail.com",
        password: "tinh123",
        name: "Tinh",
        gender: "Nam",
        role: 0,
     
        admin
        email: "huy@gmail.com",
        password: "huy123",
        name: "Huy",
        gender: "Nam",
        role: 1,
     
*/
