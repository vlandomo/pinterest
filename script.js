/***** popup *****/
let popup = document.getElementById("popup");
function openpopup() {
  popup.classList.add("open-popup");
}

function closepopup() {
  popup.classList.remove("open-popup");
}
/***** Dark Mode *****/
const enableDarkMode = () => {
  document.body.classList.add("dark-mode");
  localStorage.setItem("darkMode", "enabled");
};

const disableDarkMode = () => {
  document.body.classList.remove("dark-mode");
  localStorage.setItem("darkMode", "disabled");
};
// تفعيل الوضع المظلم إذا كان مفعلًا من قبل
if (localStorage.getItem("darkMode") === "enabled") {
  enableDarkMode();
}
// تبديل الوضع المظلم عند النقر على الزر
const darkModeToggleBtn = document.getElementById("toggle-dark-mode");
if (darkModeToggleBtn) {
  darkModeToggleBtn.addEventListener("click", () => {
    if (document.body.classList.contains("dark-mode")) {
      disableDarkMode();
    } else {
      enableDarkMode();
    }
  });
}
