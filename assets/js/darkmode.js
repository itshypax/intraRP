// Function to toggle between dark mode and light mode
function toggleDarkMode() {
  const body = document.querySelector("body");
  const currentTheme = body.getAttribute("data-bs-theme");

  if (currentTheme === "dark") {
    body.setAttribute("data-bs-theme", "light");
    setCookie("darkMode", "false", 365);
  } else {
    body.setAttribute("data-bs-theme", "dark");
    setCookie("darkMode", "true", 365);
  }

  updateIcon();
}

// Function to update the icon based on the selected mode
function updateIcon() {
  const icon = document.querySelector("#darkModeIcon");
  const body = document.querySelector("body");
  const currentTheme = body.getAttribute("data-bs-theme");

  if (currentTheme === "dark") {
    icon.classList.remove("fa-moon");
    icon.classList.add("fa-sun");
  } else {
    icon.classList.remove("fa-sun");
    icon.classList.add("fa-moon");
  }
}

// Function to set a cookie
function setCookie(name, value, days) {
  const expires = new Date();
  expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

// Function to get a cookie
function getCookie(name) {
  const cookieArr = document.cookie.split(";");
  for (let i = 0; i < cookieArr.length; i++) {
    const cookiePair = cookieArr[i].split("=");
    if (name === cookiePair[0].trim()) {
      return decodeURIComponent(cookiePair[1]);
    }
  }
  return null;
}

// Check if dark mode is set in the cookie on page load
window.onload = function () {
  const darkModeCookie = getCookie("darkMode");
  const body = document.querySelector("body");

  if (darkModeCookie === "true") {
    body.setAttribute("data-bs-theme", "dark");
  } else {
    body.setAttribute("data-bs-theme", "light");
  }

  updateIcon();
};
