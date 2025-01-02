document.addEventListener('DOMContentLoaded', function() {
    const leftLogo = document.getElementById('left-logo');
    const dropdownMenu = document.getElementById('dropdown-menu');

    // Toggle the dropdown menu when the left logo is clicked
    leftLogo.addEventListener('click', function(event) {
        event.stopPropagation(); // Prevent the click event from bubbling up to the document
        dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
    });

    // Close the dropdown menu if clicked outside
    window.addEventListener('click', function(event) {
        if (!leftLogo.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = 'none';
        }
    });

    // Logout action (for demonstration)
    document.getElementById('logout').addEventListener('click', function() {
        alert('Logged out');
        // Add your logout logic here, e.g., redirect to login page
    });
});
