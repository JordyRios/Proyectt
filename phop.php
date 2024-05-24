<?php
// Configuración de la conexión a la base de datos
$host = "adminuser2.mysql.database.azure.com";
$username = "adminuser@adminuser2";
$password = "Chucha@12*";
$database = "adminuser2";
$port = 3306; // Puerto predeterminado para MySQL

// Realizar la conexión a la base de datos
$con = mysqli_connect($host, $username, $password, $database, $port);

// Verificar si la conexión fue exitosa
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y escaparlos para prevenir inyección SQL
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $telefono = mysqli_real_escape_string($con, $_POST['telefono']);
    $mensaje = mysqli_real_escape_string($con, $_POST['mensaje']);

    // Crear la consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO nombre_de_la_tabla (nombre, email, telefono, mensaje) VALUES ('$nombre', '$email', '$telefono', '$mensaje')";

    // Ejecutar la consulta y verificar si fue exitosa
    if (mysqli_query($con, $sql)) {
        $message = "Datos insertados correctamente.";
        $messageType = "success";
    } else {
        $message = "Error al ejecutar la consulta: " . mysqli_error($con);
        $messageType = "error";
    }
}

// Cerrar la conexión
mysqli_close($con);
?>
