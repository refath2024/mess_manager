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
                // Clear session storage (or localStorage) when logging out
                localStorage.removeItem('isLoggedIn');  // If using localStorage for session
                localStorage.removeItem('userName');
                alert('Logged out');
                
                // Redirect to login page (officers_portal.html)
                window.location.href = 'officers_portal.html';
            });
    });
