document.addEventListener('DOMContentLoaded', () => {
    fetch('/php/user_image.php')
        .then(response => response.json())
        .then(data => {
            if (data.session) {
                document.getElementById('session_info').innerHTML = data.session;
            }
        })
        .catch(error => console.error('Error:', error));

    fetch('/php/user_image.php?getImages=true')
        .then(response => response.json())
        .then(data => {
            if (data.gallery) {
                document.getElementById('galeriauser').innerHTML = data.gallery;
            }
        })
        .catch(error => console.error('Error:', error));
});

function irADetalle(id_imagen) {
    window.location.href = 'detalle_imagen.html?id_imagen=' + id_imagen;
}
