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

function toggleMenu() {
    const menu = document.getElementById('menu');
    menu.classList.toggle('show');
}