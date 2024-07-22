document.addEventListener('DOMContentLoaded', () => {
    buscarImagen();

    document.getElementById('searchButton').addEventListener('click', () => {
        const tag = document.getElementById('searchInput').value;
        buscarImagen(tag);
    });
});

function buscarImagen(tag = '') {
    let url = '/php/busca_etiqueta.php';
    if (tag) {
        url += `?tag=${encodeURIComponent(tag)}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.session) {
                document.getElementById('session_info').innerHTML = data.session;
            }
            if (data.gallery) {
                document.getElementById('galeria').innerHTML = data.gallery;
            }
        })
        .catch(error => console.error('Error:', error));
}

function irADetalle(id_imagen) {
    window.location.href = 'detalle_imagen.html?id_imagen=' + id_imagen;
}
