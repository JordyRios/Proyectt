const mysql = require('mysql2/promise');

module.exports = async function (context, req) {
    const connectionString = process.env.DATABASE_CONNECTION_STRING;

    const connection = await mysql.createConnection(connectionString);

    try {
        const { nombre, email, telefono, mensaje } = req.body;

        const query = `INSERT INTO Person (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)`;
        const values = [nombre, email, telefono, mensaje];

        await connection.execute(query, values);

        context.res = {
            status: 200,
            body: { message: 'Datos enviados con éxito' }
        };
    } catch (error) {
        context.res = {
            status: 500,
            body: { message: 'Error al enviar los datos: ' + error.message }
        };
    } finally {
        await connection.end();
    }
};
