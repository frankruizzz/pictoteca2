document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const imageId = urlParams.get('id_imagen');
    console.log(imageId);
    fetch(`/php/obtener_editar.php?imageId=${imageId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(imageId);
                document.getElementById('descripcion').value = data.image;
                document.getElementById('etiqueta1').value = data.etiquetas[0] || '';
                document.getElementById('etiqueta2').value = data.etiquetas[1] || '';
                document.getElementById('etiqueta3').value = data.etiquetas[2] || '';
                document.getElementById('imagen').src = decodeURIComponent(data.direccion);
            } else {
                console.error('Error obteniendo los datos de la imagen:', data.message);
            }
        })
        .catch(error => console.error('Error en la solicitud:', error));

    const editarForm = document.getElementById('editarForm');
    editarForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const descripcion = document.getElementById('descripcion').value.trim();
        const etiqueta1 = document.getElementById('etiqueta1').value.trim();
        const etiqueta2 = document.getElementById('etiqueta2').value.trim();
        const etiqueta3 = document.getElementById('etiqueta3').value.trim();

        fetch(`/php/actualizar.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ imageId, descripcion, etiquetas: [etiqueta1, etiqueta2, etiqueta3] })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Imagen actualizada exitosamente.');
            } else {
                alert('Error actualizando la imagen: ' + data.message);
            }
        })
        .catch(error => console.error('Error en la solicitud:', error));
    });
});