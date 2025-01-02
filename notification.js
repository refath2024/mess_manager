// Function to show the notification
function showNotification() {
    const notification = document.getElementById('notification');
    notification.classList.add('show');

    // Hide the notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

// Add event listener to the submit button
document.querySelector('button[type="submit"]').addEventListener('click', function (e) {
    e.preventDefault(); // Prevent the form from submitting normally
    showNotification(); // Show the notification
});
