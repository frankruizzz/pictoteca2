document.addEventListener("DOMContentLoaded", function() {
    fetch('/php/user_data.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                document.getElementById('usernamee').innerText = data.username;
                document.getElementById('full_name').innerText = data.nombres;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
