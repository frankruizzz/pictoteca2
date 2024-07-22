document.addEventListener('DOMContentLoaded', () => {
    let actual = '';
    const urlParams = new URLSearchParams(window.location.search);
    const imageId = urlParams.get('id_imagen');

    fetch('/php/username.php')
        .then(response => response.json())
        .then(data => {
            if (data.username) {
                actual = data.username;
                checaUser();
            }else{
                document.getElementById('commentInput').disabled=true;
                document.getElementById('buttonComment').disabled=true;
            }
        })
        .catch(error => console.error('Error obteniendo el username:', error));

    function checaUser() {
        const usernameImg = document.getElementById('usernameImg').textContent;

        if (actual === usernameImg) {
            mostrarBotones();
        }
    }

    function mostrarBotones() {
        const imageContainer = document.getElementById('image-container');
        const editar = document.createElement('a');
        const borrar = document.createElement('a');

        editar.textContent = '✏️ Editar imagen';
        borrar.textContent = '🗑️ Eliminar imagen';

        editar.setAttribute('href',`editar.html?id_imagen=${imageId}`);
        borrar.setAttribute('href','#');
        borrar.addEventListener('click', (event) => {
            event.preventDefault();
            if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
                fetch(`/php/eliminar.php`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ imageId: imageId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Imagen eliminada exitosamente.');
                        window.location.href = '../index.html';
                    } else {
                        alert('Error al eliminar la imagen: ' + data.message);
                    }
                })
                .catch(error => console.error('Error en la solicitud:', error));
            }
        });
        imageContainer.appendChild(editar);
        imageContainer.appendChild(borrar);
    }
});
