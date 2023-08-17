let menu=document.querySelector('#menu-icon');
let navbar=document.querySelector('.navbar');

menu.onclick = () =>{
    menu.classList.toggle('bx-x');
    navbar.classList.toggle('open');
}

document.addEventListener("click", function(event) {
    var dropdown = document.getElementById("paymentDropdown");
    var isClickInsideDropdown = dropdown.contains(event.target);
    
    if (!isClickInsideDropdown) {
      var dropdownMenu = dropdown.querySelector(".dropdown-menu");
      dropdownMenu.style.display = "none";
    }
  });