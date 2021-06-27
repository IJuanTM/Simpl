// Fontawesome attribution
console.log(`Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com 
License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License)
`)

/**
 * Check if user is using IE
 * IF so load a full screen overlay to tell them to use a modern browser
 */

if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) $("body").load("../../view/parts/errors/unsupported.phtml");

// ----------------------------------------------------------------------------------------------------

/**
 * An JQuery script I wrote to enable the 'show password' eye that lots of sites have in their forms.
 * To add your own just make sure that your password field is of type password and you have something
 * on your page to click on with the class '.toggle-password'. And thats all!
 */

// Toggle password input field type and icon on click
$(document).on('click', '.toggle-password', function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    const passwordInput = $(":text, :password");
    passwordInput.attr('type') === 'password' ? passwordInput.attr('type', 'text') : passwordInput.attr('type', 'password');
});

// Set variable
const inputPassword = document.querySelector(".input-password");

// Check if passwords are on page
if (inputPassword) {
    inputPassword.addEventListener("keyup", function (event) {
        if (event.getModifierState("CapsLock")) document.getElementById("password-warning").style.display = "inline-block";
        else document.getElementById("password-warning").style.display = "none";
    });
}

// ----------------------------------------------------------------------------------------------------

/**
 * A piece of Javascript to get the value of a range slider and print it.
 */

const sliderInput = document.getElementById("slider");
const sliderOutput = document.getElementById("output");

if (sliderInput) {
    sliderOutput.innerHTML = sliderInput.value;
    sliderInput.oninput = function () {
        sliderOutput.innerHTML = this.value;
    };
}

// ----------------------------------------------------------------------------------------------------

/**
 * Code for a loading icon, it will show as long as the page is loading
 * and or for a minimum amount of time set with the timeout.
 */

// Initialize variables
const loadIcon = document.getElementById("load");
const pageContent = document.getElementById("content");

// Check if load icon is present
if (loadIcon) {
    $(document).on('readystatechange', function () {
        $("body").css("overflow", "hidden");
        const state = document.readyState;
        if (state === "interactive") pageContent.style.visibility = "hidden";
        else if (state === "complete") {
            setTimeout(function () {
                loadIcon.style.opacity = "0";
                $("body").css("overflow", "visible");
                document.getElementById("interactive");
                setTimeout(function () {
                    loadIcon.style.visibility = "hidden";
                }, 500);
                pageContent.style.visibility = "visible";
            }, 250);
        }
    });

// 3 dot load animation
    window.setInterval(function () {
        const wait = document.getElementById("load-dot");
        if (wait.innerHTML.length >= 3) wait.innerHTML = "";
        else wait.innerHTML += ".";
    }, 250);
}

// ----------------------------------------------------------------------------------------------------

/**
 * Code for a darkmode switch, uses a checkbox with label items.
 */

// Initialize variable
const themeSwitch = document.getElementById("switch");

// Check if toggle is present
if (themeSwitch) {
    initTheme();

    // Check for switch change
    themeSwitch.addEventListener("change", function () {
        resetTheme();
    });

    // Check if localStorage cookie has darkmode set to on
    if (localStorage.getItem("switch") === "dark") $("#toggle-icon").toggleClass("fa-sun");
    else $("#toggle-icon").toggleClass("fa-moon");

    // Initializing darkmode theme
    function initTheme() {
        const darkThemeSelected = localStorage.getItem("switch") !== null && localStorage.getItem("switch") === "dark";
        themeSwitch.checked = darkThemeSelected;
        if (darkThemeSelected) document.body.setAttribute("theme", "dark");
        else document.body.removeAttribute("theme");
    }

    // Reverting back to non-darkmode theme
    function resetTheme() {
        if (themeSwitch.checked) {
            $("#toggle-icon").toggleClass("fa-sun");
            document.body.setAttribute("theme", "dark");
            localStorage.setItem("switch", "dark");
        } else {
            $("#toggle-icon").toggleClass("fa-moon");
            document.body.removeAttribute("theme");
            localStorage.removeItem("switch");
        }
    }
}

// ----------------------------------------------------------------------------------------------------

/**
 * Code for an extendable and retractable navbar menu.
 */

// Initialize variables
const menu = document.querySelector(".nav-menu");
const hamburger = document.querySelector(".hamburger");

// Collapse and retract on hamburger click
document.querySelector(".hamburger-box").addEventListener("click", function () {
    menu.classList.toggle("extended");
    hamburger.classList.toggle("is-active");
});

// Collapse back when still extended whenever the screen goes back to large
window.matchMedia("(min-width: 961px)").addEventListener("change", function () {
    menu.classList.remove("extended");
    hamburger.classList.remove("is-active");
});

// ----------------------------------------------------------------------------------------------------

/**
 * Code to show the cookie alert.
 */

const cookieAlert = document.querySelector(".cookie-card");
const acceptCookies = document.querySelector(".cookie-button");

if (cookieAlert) {

    cookieAlert.offsetHeight;

    if (!getCookie("acceptCookies")) cookieAlert.classList.add("show");

    acceptCookies.addEventListener("click", function () {
        $(".button-icon").toggleClass("fa-times fa-check");
        setCookie("acceptCookies", true, 365);
        cookieAlert.classList.remove("show");
    });

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        const name = cname + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1);
            if (c.indexOf(name) === 0) return c.substring(name.length, c.length);
        }
        return "";
    }
}

// ----------------------------------------------------------------------------------------------------

/**
 * Code to get the current active page and highlight the navbar item.
 */

// Navbar active item class
$(document).ready(function () {
    // Get page path
    let path = "/" + urlArr[1];
    if (path === "/") path = '/home';

    // Search for closest matching id of the current page path
    $(".nav-row .nav-item").each(function () {
        const id = $(this).attr('id');
        if (path.substring(0, id.length) === id) $(this).closest('div').addClass('active');
    });
});

// ----------------------------------------------------------------------------------------------------

/**
 * Smooth scroll to element using <a> and the element id.
 */

// Smooth scroll to element
$('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function (event) {
    if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
        let target = $(this.hash);
        target = target.length ? target : $("[name=" + this.hash.slice(1) + "]");
        if (target.length) {
            event.preventDefault();
            $("html, body").animate({scrollTop: target.offset().top}, 500);
        }
    }
});