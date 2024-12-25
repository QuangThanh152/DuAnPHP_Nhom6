const wrapper = document.querySelector(".wrapper");
const loginLink = document.querySelector(".login-link");
const registerLink = document.querySelector(".register-link");
const btnLoginPopup = document.querySelector(".btnlogin-popup"); // Nút Login
const btnRegisterPopup = document.querySelectorAll(".btnlogin-popup")[1]; // Nút Register (phần navigation)
const iconClose = document.querySelector(".icon-closed");

// Khi click vào link Register trong form Login
registerLink.addEventListener("click", () => {
  wrapper.classList.add("active");
});

// Khi click vào link Login trong form Register
loginLink.addEventListener("click", () => {
  wrapper.classList.remove("active");
});

// Khi click vào nút Login
btnLoginPopup.addEventListener("click", () => {
  wrapper.classList.add("active-popup");
  wrapper.classList.remove("active"); // Hiện Login trước
});

// Khi click vào nút Register
btnRegisterPopup.addEventListener("click", () => {
  wrapper.classList.add("active-popup");
  wrapper.classList.add("active"); // Hiện Register trực tiếp
});

// Khi click vào icon đóng (nếu có)
iconClose?.addEventListener("click", () => {
  wrapper.classList.remove("active-popup");
  wrapper.classList.remove("active");
});
