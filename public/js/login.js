document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const errorMessage = document.getElementById('error-message');

    if (error==='contrasena') {
        errorMessage.textContent = 'La contraseña ingresada no es correcta.';
        errorMessage.style.display = 'block';
        setTimeout(() => {
        errorMessage.style.display = 'none';
    }, 10000);
    }
    else if (error === 'no_usuario'){
        errorMessage.textContent = 'Usuario no encontrado.';
        errorMessage.style.display = 'block';
        setTimeout(() => {
        errorMessage.style.display = 'none';
    }, 10000);
    }
    else if (error === 'consulta'){
        errorMessage.textContent = 'Error en la consulta.';
        errorMessage.style.display = 'block';
        setTimeout(() => {
        errorMessage.style.display = 'none';
    }, 10000);
    }
    else if (error === 'errorbd'){
        errorMessage.textContent = 'Error de conexión a la base de datos.';
        errorMessage.style.display = 'block';
        setTimeout(() => {
        errorMessage.style.display = 'none';
    }, 10000);
    }
});