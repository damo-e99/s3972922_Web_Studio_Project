var theme = document.getElementById("theme");

// Function to set the theme cookie
function setThemeCookie(theme) {
    var expiration = new Date();
    expiration.setDate(expiration.getDate() + 365); // Expires in 365 days
    document.cookie = `theme=${theme}; expires=${expiration.toUTCString()}; path=/`;
}

// Function to get the theme preference from the cookie
function getThemeCookie() {
    var name = "theme=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var cookieArray = decodedCookie.split(';');
    for (var i = 0; i < cookieArray.length; i++) {
        var cookie = cookieArray[i].trim();
        if (cookie.indexOf(name) == 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return null;
}

// Check for a stored theme preference from the cookie
var storedTheme = getThemeCookie();
if (storedTheme === "dark-mode") {
    document.body.classList.add("dark-mode");
    theme.src = "../images/Home/Main/moon.png";
}

theme.onclick = function () {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        theme.src = "../images/Home/Main/moon.png";
        setThemeCookie("dark-mode");
    } else {
        theme.src = "../images/Home/Main/sun.png";
        setThemeCookie("light-mode"); // Set to "light-mode" or another appropriate value for the opposite theme
    }
};
