if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = loginForm.email.value.trim();
        const pass = loginForm.pass.value.trim();

        if (email === 'umsi@umich.edu' && pass === 'php123') {
            alert('Logged in successfully!');
            document.title = 'Login - 79f3577a';
            window.location.href = 'add.html'; // redirige vers add.html
        } else {
            alert('Invalid credentials!');
            return;
        }
    });
}
