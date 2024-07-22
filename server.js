const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const cors = require('cors');
const mysql = require('mysql');
const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: "http://localhost:3000",
        methods: ["GET", "POST"]
    }
});

// NUEVO - COMENTARIOS
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'pictoteca'
});

db.connect(err => {
    if (err) {
        console.error('Error conectando a la base de datos:', err);
        process.exit(1);
    }
    console.log('Conectado a la base de datos');
});

app.use(cors());

io.on('connection', (socket) => {
    console.log('a user connected');
    
    socket.on('newCommentsBatch', (comments) => {
        if (Array.isArray(comments) && comments.length > 0) {
            const userPromises = comments.map(comment => {
                return new Promise((resolve, reject) => {
                    const sql = "SELECT id_usuario FROM usuario WHERE username = ?";
                    db.query(sql, [comment.username], (err, results) => {
                        if (err) {
                            reject(err);
                        } else if (results.length > 0) {
                            resolve({ ...comment, fk_id_usuario: results[0].id_usuario });
                        } else {
                            resolve({ ...comment, fk_id_usuario: null });
                        }
                    });
                });
            });

            Promise.all(userPromises)
                .then(commentsWithUserId => {
                    const values = commentsWithUserId.map(comment => [
                        comment.comment,
                        comment.fk_id_usuario,
                        comment.imageId
                    ]).filter(comment => comment[1] !== null);

                    if (values.length > 0) {
                        const sql = "INSERT INTO comentario (contenido, fk_id_usuario, fk_id_imagen) VALUES ?";
                        db.query(sql, [values], (err, result) => {
                            if (err) {
                                console.error('Error insertando comentarios:', err);
                            } else {
                                io.emit('newCommentsBatch', commentsWithUserId);
                            }
                        });
                    }
                })
                .catch(err => {
                    console.error('Error obteniendo id_usuario:', err);
                });
        }
    });

    socket.on('disconnect', () => {
        console.log('user disconnected');
    });
});

const PORT = process.env.PORT || 4000;
server.listen(PORT, () => {
    console.log(`Servidor Socket.IO escuchando en el puerto ${PORT}`);
});
