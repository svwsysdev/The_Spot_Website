
function throw401Error() 
{
    const params = new URLSearchParams(window.location.search);
    params.print();
    if (getUrlParameter('emailsent') == "true") 
    {
        document.getElementById("emailpassword").style.visibility = "hidden";
        document.getElementById("emailsent").style.visibility = "hidden";
        document.getElementById("passwordchange").style.visibility = "visible";
    }
}