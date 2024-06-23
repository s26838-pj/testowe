document.addEventListener('DOMContentLoaded', function() {
    // Przykładowa funkcja walidacji formularza
    const registerForm = document.querySelector('form[action="/register"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            const password = registerForm.querySelector('input[name="password"]').value;
            if (password.length < 6) {
                event.preventDefault();
                alert('Password must be at least 6 characters long');
            }
        });
    }
});
