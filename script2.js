// Enable "Accept" button when the checkbox is checked
const acceptCheckbox = document.getElementById('accept-checkbox');
const acceptButton = document.getElementById('accept-btn');

acceptCheckbox.addEventListener('change', function() {
    if (acceptCheckbox.checked) {
        acceptButton.disabled = false;
    } else {
        acceptButton.disabled = true;
    }
});

// Optional: Handle acceptance (could redirect to another page or show a confirmation)
acceptButton.addEventListener('click', function() {
    if (acceptCheckbox.checked) {
        alert('Thank you for accepting the Terms of Service!');
        // You can redirect the user to another page
        // window.location.href = 'welcome.html';
    }
});
