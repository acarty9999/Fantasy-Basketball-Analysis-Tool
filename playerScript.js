// Function to toggle the form on the page
function toggleForm() {
    var formContainer = document.querySelector('.form-container');
    if (formContainer.style.display === 'hidden' || formContainer.style.display === '') {
        formContainer.style.display = 'visible';
    } else {
        formContainer.style.display = 'visible';
    }
}


// Function to close the popup form
function closePopupForm() {
    document.getElementById('popupForm').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

// Handle submissions for direct form
function submitPlayerNameDirect(event) {
    event.preventDefault();
    var playerName = document.getElementById('playerNameDirect').value;
    alert('Player\'s Name: ' + playerName);
    // Add any server interaction or further processing here
}

// Handle submissions for popup form
function submitPlayerNamePopup(event) {
    event.preventDefault();
    var playerName = document.getElementById('playerNamePopup').value;
    alert('Player\'s Name: ' + playerName);
    closePopupForm();
}
