document.addEventListener('DOMContentLoaded', () => {
    fetch('/php/ver_crear.php')
        .then(response => response.json())
        .then(data => {
            if (data.session) {
                document.getElementById('crea-div').innerHTML = data.session;
            }
        })
        .catch(error => console.error('Error:', error));

});
