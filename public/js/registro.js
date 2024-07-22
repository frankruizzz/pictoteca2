document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const errorMessage = document.getElementById('error-message');

    if (error === 'yaexiste') {
        errorMessage.textContent = 'Ya existe ese nombre de usuario. Elige otro.';
        errorMessage.style.display = 'block';
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 10000);
    } else if (error === 'contrasenas') {
        errorMessage.textContent = 'Las contraseñas no coinciden. Asegúrate de escribir la misma contraseña.';
        errorMessage.style.display = 'block';
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 10000);
    } else if (error === 'noinserto'){
        errorMessage.textContent = 'Algo salió mal al intentar registrarte. Inténtalo de nuevo más tarde.';
        errorMessage.style.display = 'block';
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 10000);
    }
    else if (error === 'camposvacios'){
        errorMessage.textContent = 'Algunos campos parecen estar vacíos. Completa toda la información de registro.';
        errorMessage.style.display = 'block';
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 10000);
    }
});