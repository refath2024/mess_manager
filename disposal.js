document.addEventListener('DOMContentLoaded', () => {
    const disposalSelect = document.getElementById('disposal');
    const disposalOptions = document.getElementById('disposal-options');

    disposalSelect.addEventListener('change', () => {
        if (disposalSelect.value === 'yes') {
            disposalOptions.style.display = 'block';
        } else {
            disposalOptions.style.display = 'none';
        }
    });
});
