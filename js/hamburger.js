const hamburger_menu = document.querySelector(".hamburger_menu");
const navigation_menu = document.querySelector(".navigation_bar_menu");

hamburger_menu.addEventListener("click", () => {
  hamburger_menu.classList.toggle("active");
  navigation_menu.classList.toggle("active");
})

document.querySelectorAll(".header_link").forEach(link => {
  link.addEventListener("click", (e) => {
    hamburger_menu.classList.remove("active");
    navigation_menu.classList.remove("active");
  })
})
