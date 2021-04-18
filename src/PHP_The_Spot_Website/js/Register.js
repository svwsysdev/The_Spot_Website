function loginClick()
{
    document.getElementById("loginbtn").onclick = location.href = "Login_Page.html";
}
function validatePassword()
{
var password = document.getElementById("passwordId"); 
var confirm_password = document.getElementById("cpasswordId");
  if(password.value != confirm_password.value) 
  {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } 
  else 
  {
    confirm_password.setCustomValidity('');
  }
}