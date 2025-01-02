document.addEventListener('DOMContentLoaded', function() {
    const billingLink = document.getElementById('billing-link');
    const billingPage = document.getElementById('billing-page');

    billingLink.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default link behavior
        billingPage.style.display = 'block'; // Show the billing content
    });
});
