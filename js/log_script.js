let currentForm = 'login';

function toggleForm(form) {
    currentForm = form;
    if (form === 'login') {
        document.getElementById('login-form').style.display = 'block';
        document.getElementById('register-form').style.display = 'none';
    } else {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'block';
    }
}

function login() {
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    fetch('login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    }).then(response => response.json())
        .then(data => alert(data.message))
        .catch(err => console.error(err));
}

function register() {
    let username = document.getElementById('username').value;
    let email = document.getElementById('register-email').value;
    let password = document.getElementById('password').value;
    let code = document.getElementById('register-code').value;

    fetch('register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, email, password, code })
    }).then(response => response.json())
        .then(data => alert(data.message))
        .catch(err => console.error(err));
}

function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('show');
}