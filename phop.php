<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $mensaje = $_POST['mensaje'];

    // Configuración de la conexión a la base de datos
    $host = 'nombre_servidor.mysql.database.azure.com';
    $username = 'nombre_usuario@nombre_servidor';
    $password = 'tu_contraseña';
    $dbname = 'nombre_base_datos';

    // Crear conexión
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Preparar consulta SQL
    $sql = "INSERT INTO Person (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $telefono, $mensaje);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $message = "Datos enviados con éxito";
    } else {
        $message = "Error al enviar los datos: " . $conn->error;
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Captura</title>
    <!-- Estilos CSS -->
</head>
<body>
    <div class="container">
        <h2>Ingresa los datos</h2>
        <?php if (isset($message)): ?>
        <div id="message" class="message <?php echo ($message == 'Datos enviados con éxito') ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>
        <form id="dataForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono">
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" rows="4"></textarea>
            <input type="submit" value="Suscribirse">
        </form>
    </div>
</body>
</html>
