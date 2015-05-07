COOKIES_NAME = "COOKIES_POLICY";
var COOKIES_VALUE = "true";

function getCookie(cookieName)
{
    var cookieValue = document.cookie;
    var cookieStart = cookieValue.indexOf(" " + cookieName + "=");
    if (cookieStart == -1) {
        cookieStart = cookieValue.indexOf(cookieName + "=");
    }
    if (cookieStart == -1) {
        cookieValue = null;
    }
    else
    {
        cookieStart = cookieValue.indexOf("=", cookieStart) + 1;
        var cookieEnd = cookieValue.indexOf(";", cookieStart);
        if (cookieEnd == -1) {
            cookieEnd = cookieValue.length;
        }
        cookieValue = unescape(cookieValue.substring(cookieStart, cookieEnd));
    }
    return cookieValue;
}

function setCookie(cookieName, value, expiryDays, domain)
{
    var expiryDate = new Date();
    expiryDate.setDate(expiryDate.getDate() + expiryDays);
    var cookieValue = escape(value) + ((expiryDays == null) ? "" : "; expires=" + expiryDate.toUTCString()) + ((domain == null) ? "" : "; path=" + domain);
    document.cookie = cookieName + "=" + cookieValue;
}

function notificarCookies() {
    var isDNT = navigator.doNotTrack == "yes" || navigator.doNotTrack == "1" || navigator.msDoNotTrack == "1";
    if (isDNT) {
        return;
    } else {
        var cookieValue = getCookie(COOKIES_NAME);
        if (cookieValue != null && cookieValue != "") {
            borrarMensajeCookie();
        } else {
            mostrarMensajeCookie();
        }
    }
}

function mostrarMensajeCookie() {
    e = document.createElement('div');
    e.className = 'container-fluid alert alert-success alert-dismissible pagination-centered';
    e.id = 'avisoCookies';
    e.setAttribute('role', 'alert');
    e.style.marginBottom = "0px";
    e.style.width = "100%";
    e.style.opacity = "0.92";
    e.style.textAlign="center";
    e.style.position = "fixed";
    e.style.zIndex = "999";
    e.style.bottom = "0px";
    e.innerHTML = typeof COOKIES_STRING !== 'undefined'? COOKIES_STRING : 'This website uses <i>cookies</i> themselves and third parties to offer a better experience and service. Navigating or using our services you agree to our use of cookies. <a style="color:#fff;" class="btn btn-green" onclick="aceptarCookies()">Ok</a> <a class="btn btn-green" style="color:#fff; margin-left:5px;" href="/privacy">Privacy Policy</a>';
    document.body.insertBefore(e, document.body.lastChild);
    
}

function borrarMensajeCookie() {
    if (typeof avisoCookies !== 'undefined') {
        avisoCookies = document.getElementById("avisoCookies");
        avisoCookies.parentNode.removeChild(avisoCookies);
    }
}

function aceptarCookies() {
    setCookie(COOKIES_NAME, COOKIES_VALUE, null, "/");
    borrarMensajeCookie();
}

function addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
            if (oldonload) {
                oldonload();
            }
            func();
        };
    }
}

addLoadEvent(notificarCookies);
