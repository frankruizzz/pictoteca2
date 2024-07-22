document.addEventListener("DOMContentLoaded", function() {
    const socket = io('http://localhost:4000');
    let username = 'Anónimo';
    let commentsBuffer = [];
    const BATCH_INTERVAL = 5000;

    fetch('/php/username.php')
        .then(response => response.json())
        .then(data => {
            if (data.username) {
                username = data.username;
            }
        })
        .catch(error => console.error('Error obteniendo el username:', error));

    const commentForm = document.getElementById('commentForm');
    const commentInput = document.getElementById('commentInput');
    const commentsContainer = document.getElementById('comentarios');

    const urlParams = new URLSearchParams(window.location.search);
    const imageId = urlParams.get('id_imagen');

    fetch(`/php/comments.php?imageId=${imageId}`)
        .then(response => response.json())
        .then(data => {
            if (data.comments) {
                data.comments.forEach(comment => {
                    const commentElement = document.createElement('p');
                    commentElement.innerHTML = `<strong>${comment.username}:</strong> ${comment.comentario}`;
                    commentsContainer.appendChild(commentElement);
                });
            }
        })
        .catch(error => console.error('Error obteniendo los comentarios:', error));

    commentForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const comment = commentInput.value.trim();
        if (comment !== '') {
            commentsBuffer.push({ username: username, comment: comment, imageId: imageId });
            commentInput.value = '';
        }
    });

    setInterval(() => {
        if (commentsBuffer.length > 0) {
            const commentsToSend = commentsBuffer.splice(0, commentsBuffer.length);
            socket.emit('newCommentsBatch', commentsToSend);
        }
    }, BATCH_INTERVAL);

    socket.on('newComment', (data) => {
        const commentElement = document.createElement('p');
        commentElement.innerHTML = `<strong>${data.username}:</strong> ${data.comment}`;
        commentsContainer.appendChild(commentElement);
    });

    socket.on('newCommentsBatch', (comments) => {
        comments.forEach(data => {
            const commentElement = document.createElement('p');
            commentElement.innerHTML = `<strong>${data.username}:</strong> ${data.comment}`;
            commentsContainer.appendChild(commentElement);
        });
    });
});
