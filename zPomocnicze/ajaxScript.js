
function getXMLHttpRequest()
{
    var request = false;
    try { // Firefox 2, Opera 9, IE 7
        request = new XMLHttpRequest();
    } catch(err1) {
        try { // IE 6
            request = new ActiveXObject('Msxml2.XMLHTTP');
        } catch(err2) {
            try { //IE 5
                request = new ActiveXObject('Microsoft.XMLHTTP');
            } catch(err3) {
                request = false;
            }
        }
    }
    return request;
}



/*function checkUser(name) {
    if (name == "") { // jesli nic nie wpisal jeszcze
        document.getElementById("login2").innerHTML = "";
        return;
    } else {
        xmlhttp = getXMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("login2").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","checkLogin.php?q="+name,true); // flaga true asynchronicznie
        xmlhttp.send();
    }
}*/










