const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const app = express();
const port = process.env.PORT || 3000;

app.use(bodyParser.json());

// Configuración de la conexión a la base de datos MySQL
const db = mysql.createConnection({
    host: 'adminuser2.mysql.database.azure.com',
    user: 'adminuser2',
    password: 'Chucha@12*', // reemplaza con tu contraseña de administrador
    database: 'adminuser2', // reemplaza con el nombre de tu base de datos
    ssl: {
        rejectUnauthorized: false
    }
});

// Conexión a la base de datos
db.connect(err => {
    if (err) {
        console.error('Error conectando a la base de datos: ', err);
        return;
    }
    console.log('Conexión a la base de datos exitosa');
});

// Ruta para manejar el POST de los datos del formulario
app.post('/api/person', (req, res) => {
    const { nombre, email, telefono, mensaje } = req.body;

    if (!nombre || !email) {
        return res.status(400).send({ error: true, message: 'Nombre y correo electrónico son requeridos' });
    }

    const query = 'INSERT INTO Person (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)';
    db.query(query, [nombre, email, telefono, mensaje], (err, results) => {
        if (err) {
            console.error('Error ejecutando la consulta: ', err);
            return res.status(500).send({ error: true, message: 'Error al insertar los datos' });
        }

        res.send({ error: false, message: 'Datos insertados correctamente', id: results.insertId });
    });
});

app.listen(port, () => {
    console.log(`Servidor escuchando en http://localhost:${port}`);
});
