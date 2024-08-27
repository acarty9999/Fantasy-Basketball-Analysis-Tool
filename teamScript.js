// Open team popup form
function openTeamPopupForm() {
    document.getElementById('teamPopupForm').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

// Close team popup form
function closeTeamPopupForm() {
    document.getElementById('teamPopupForm').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

// Handle team name submission
function submitTeamName(event) {
    event.preventDefault();

    var teamName = document.getElementById('teamName').value;
    alert('Team\'s Name: ' + teamName);

    closeTeamPopupForm(); // Close form after submission
}
