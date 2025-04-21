document.getElementById("flipButtonFront").addEventListener("click", function (event) {
    event.preventDefault();
    document.getElementById("card").style.transform = "rotateY(180deg)";
});

document.getElementById("flipButtonBack").addEventListener("click", function (event) {
    event.preventDefault();
    document.getElementById("card").style.transform = "rotateY(0deg)";
});
var loginForm = document.getElementById("loginForm");
var registerForm = document.getElementById("registerForm");
var modalTitle = document.getElementById("LoginRegisterModalLabel");

document.getElementById("flipButtonFront").addEventListener("click", function (event) {
    event.preventDefault();
    loginForm.style.display = "none";
    registerForm.style.display = "block";
    modalTitle.textContent = "Register";
});

document.getElementById("flipButtonBack").addEventListener("click", function (event) {
    event.preventDefault();
    registerForm.style.display = "none";
    loginForm.style.display = "block";
    modalTitle.textContent = "Login";
});

// Get references to the front and back elements
var cardFront = document.querySelector('.card-front');
var cardBack = document.querySelector('.card-back');

// Function to show the front side and hide the back side
function showFront() {
  cardFront.style.display = 'block';
  cardBack.style.display = 'none';
}

// Function to show the back side and hide the front side
function showBack() {
  cardFront.style.display = 'none';
  cardBack.style.display = 'block';
}

// Get references to the flip buttons
var flipButtonFront = document.getElementById('flipButtonFront');
var flipButtonBack = document.getElementById('flipButtonBack');

// Add click event listeners to the flip buttons
flipButtonFront.addEventListener('click', showBack);
flipButtonBack.addEventListener('click', showFront);

// Call showFront() to initially display the front side of the card
showFront();
