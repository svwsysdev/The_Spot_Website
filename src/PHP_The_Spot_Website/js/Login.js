function registerClick() 
{
    document.getElementById("registerbtn").onclick = location.href = "Register_Page.html";
}
function throw401Error() 
{
    const params = new URLSearchParams(window.location.search);
    if (getUrlParameter('return') == "401") 
    {
        document.getElementById("returnLBL").style.visibility = "visible";
        document.getElementById("returnLBL").innerHTML = "Your Password was incorrect! or your Account does not exist!";
    }
    else if(getUrlParameter('return') == "403")
    {
        document.getElementById("returnLBL").style.visibility = "visible";
        document.getElementById("returnLBL").innerHTML = "Your Account already exists! Please login.";

    }
    else if(getUrlParameter('return') == "400")
    {
        document.getElementById("returnLBL").style.visibility = "visible";
        document.getElementById("returnLBL").innerHTML = "You are not logged in to your account!";

    }
    else if(getUrlParameter('return') == "399")
    {
        document.getElementById("returnLBL").style.visibility = "visible";
        document.getElementById("returnLBL").innerHTML = "This account does not exist!!!";

    }    
    else if(getUrlParameter('return') == "200")
    {
        document.getElementById("returnLBL").style.visibility = "visible";
        document.getElementById("returnLBL").innerHTML = "Password has been reset succesfully!!!";
    }
    else if(getUrlParameter('return') == "250")
    {
        document.getElementById("returnLBL").style.visibility = "visible";
        document.getElementById("returnLBL").innerHTML = "You have logged out!!!";
    }
}

function getUrlParameter(name) 
{
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};