<?php
// Configuración de la conexión a la base de datos
$host = "adminuser2.mysql.database.azure.com";
$username = "adminuser@adminuser2";
$password = "Chucha@12*";
$database = "adminuser2";
$port = 3306; // Puerto predeterminado para MySQL

// Ruta al archivo del certificado CA
$ca_cert_path = "/path/to/DigiCertGlobalRootCA.crt.pem"; // Cambia esta ruta al certificado CA correcto

// Inicializar una nueva instancia de conexión mysqli
$con = mysqli_init();

// Configurar la seguridad SSL
mysqli_ssl_set($con, NULL, NULL, $ca_cert_path, NULL, NULL);

// Establecer la conexión a la base de datos utilizando SSL
if (!mysqli_real_connect($con, $host, $username, $password, $database, $port, MYSQLI_CLIENT_SSL)) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y escaparlos para prevenir inyección SQL
    $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Crear la consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO nombre_de_la_tabla (nombre, email) VALUES ('$nombre', '$email')";

    // Ejecutar la consulta y verificar si fue exitosa
    if (mysqli_query($con, $sql)) {
        $message = "Datos insertados correctamente.";
        $messageType = "success";
    } else {
        $message = "Error al ejecutar la consulta: " . mysqli_error($con);
        $messageType = "error";
    }

    // Redirigir de vuelta al formulario con el mensaje
    header("Location: formulario.html?message=" . urlencode($message) . "&type=" . urlencode($messageType));
    exit();
}

// Cerrar la conexión
mysqli_close($con);
?>
