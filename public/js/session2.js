document.addEventListener('DOMContentLoaded', () => {
    fetch('/php/index2.php')
        .then(response => response.json())
        .then(data => {
            if (data.session) {
                document.getElementById('session_info').innerHTML = data.session;
            }
        })
        .catch(error => console.error('Error:', error));

    fetch('/php/index2.php?getImages=true')
        .then(response => response.json())
        .then(data => {
            if (data.gallery) {
                document.getElementById('galeria').innerHTML = data.gallery;
            }
        })
        .catch(error => console.error('Error:', error));
});

function irADetalle(id_imagen) {
    window.location.href = 'public/detalle_imagen.html?id_imagen=' + id_imagen;
}
