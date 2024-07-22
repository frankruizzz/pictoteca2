document.addEventListener("DOMContentLoaded", function() {
  const urlParams = new URLSearchParams(window.location.search);
  const id_imagen = urlParams.get('id_imagen');

  if (id_imagen) {
      fetch(`/php/datos_imagen.php?id_imagen=${id_imagen}`)
          .then(response => response.json())
          .then(data => {
              if (data.error) {
                  const h1=document.createElement('h1');
                  h1.textContent = "¡Ups! Esta imagen no está disponible.";
                  const h2=document.createElement('h2');
                  h2.textContent = "Prueba a buscar otra imagen.";
                  const a = document.createElement('a');
                  a.setAttribute('href','../index.html');
                  a.textContent = "Regresar a página principal.";
                  document.getElementById('error404').appendChild(h1);
                  document.getElementById('error404').appendChild(h2);
                  document.getElementById('error404').appendChild(a);
                  const imagepage=document.getElementById('image-page');
                  imagepage.style.display = 'none';
              } else {
                  document.getElementById('usernameImg').textContent = data.username;                 

                  const tagsContainer = document.getElementById('tags-container');
                  if (data.etiqueta1) {
                      const tag1 = document.createElement('div');
                      tag1.className = 'tags';
                      tag1.textContent = `#${data.etiqueta1}`;
                      tagsContainer.appendChild(tag1);
                  }
                  if (data.etiqueta2) {
                      const tag2 = document.createElement('div');
                      tag2.className = 'tags';
                      tag2.textContent = `#${data.etiqueta2}`;
                      tagsContainer.appendChild(tag2);
                  }
                  if (data.etiqueta3) {
                      const tag3 = document.createElement('div');
                      tag3.className = 'tags';
                      tag3.textContent = `#${data.etiqueta3}`;
                      tagsContainer.appendChild(tag3);
                  }
                  document.getElementById('description').textContent = data.descripcion;
                  document.getElementById('imagen').src = decodeURIComponent(data.direccion);
              }
          })
          .catch(error => console.error('Error al cargar los datos:', error));
  } else {
      console.error('ID de imagen no especificado');
  }    
});
