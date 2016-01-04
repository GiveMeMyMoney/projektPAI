/**
 * Created by Marcin on 2015-12-29.
 */
function create_cookie(name, value, days2expire, path) {
    var date = new Date();
    date.setTime(date.getTime() + (days2expire * 24 * 60 * 60 * 1000));
    var expires = date.toUTCString();
    document.cookie = name + '=' + value + ';' +
        'expires=' + expires + ';' +
        'path=' + path + ';';
}

function retrieve_cookie(name) {
    var cookie_value = "",
        current_cookie = "",
        name_expr = name + "=",
        all_cookies = document.cookie.split(';'),
        n = all_cookies.length;

    for(var i = 0; i < n; i++) {
        current_cookie = all_cookies[i].trim();
        if(current_cookie.indexOf(name_expr) == 0) {
            cookie_value = current_cookie.substring(name_expr.length, current_cookie.length);
            break;
        }
    }
    return cookie_value;
}

function delete_cookie(name) {
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}

/**
 * Sprawdzam czy ktos ma wlaczony cookies w przegladarce
 * @returns {jesli nie wchodzi do showCookieFail()}
 */
function checkCookie(){
    check_cookies_accept();
    var cookieEnabled=(navigator.cookieEnabled)? true : false;
    if (typeof navigator.cookieEnabled=="undefined" && !cookieEnabled){
        document.cookie="testcookie";
        cookieEnabled=(document.cookie.indexOf("testcookie") != -1) ? true : false;
    }
    return (cookieEnabled) ? true:showCookieFail();
}

/**
 * Funkcja wyswietla alert jesli ktos nie ma wlaczonych cookiesow
 */
function showCookieFail(){
    alert("Twoja przeglądarka nie obsługuje cookies! Nasz serwis będzie działał nie prawidłowo!");
}

window.onload = check_cookies_accept;

/**
 * Sprawdzam czy ktos zaakceptowal cookiesy
 */
function check_cookies_accept() {
    if(retrieve_cookie('cookies_accepted') != 'T') {
        var message_container = document.createElement('div');
        message_container.id = 'cookies-message-container';
        var html_code = '<div id="cookies-message" style="padding: 10px 0px; font-size: 14px; line-height: 22px; border-bottom: 1px solid #D3D0D0; text-align: center; position: fixed; top: 0px; background-color: #EFEFEF; width: 100%; z-index: 999;">Ta strona używa ciasteczek (cookies), dzięki którym nasz serwis może działać lepiej. ' +
            '<a href="http://wszystkoociasteczkach.pl" target="_blank">Dowiedz się więcej</a><a href="javascript:close_cookies_window();" id="accept-cookies-checkbox" name="accept-cookies" style="background-color: #00AFBF; padding: 5px 10px; color: #FFF; border-radius: 4px; -moz-border-radius: 4px; -webkit-border-radius: 4px; display: inline-block; margin-left: 10px; text-decoration: none; cursor: pointer;">Rozumiem</a></div>';
        message_container.innerHTML = html_code;
        document.body.appendChild(message_container);
    }
}

/**
 * Utworzenie cookiesa sprawdzajacego i zamkniecie okna.
 */
function close_cookies_window() {
    create_cookie('cookies_accepted', 'T', 30, "/");
    document.getElementById('cookies-message-container').removeChild(document.getElementById('cookies-message'));
}