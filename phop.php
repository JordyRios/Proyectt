<?php
// Configuración de la conexión a la base de datos
$host = "adminuser2.mysql.database.azure.com";
$username = "adminuser@adminuser2";
$password = "Chucha@12*";
$database = "adminuser2";
$port = 3306; // Puerto predeterminado para MySQL

// Inicializar una nueva instancia de conexión mysqli
$con = mysqli_init();

// Configurar la seguridad SSL
mysqli_ssl_set($con, NULL, NULL, "/path/to/your/CA/cert", NULL, NULL);

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
        echo "<h2>Datos insertados correctamente</h2>";
    } else {
        echo "Error al ejecutar la consulta: " . mysqli_error($con);
    }
}

// Cerrar la conexión
mysqli_close($con);
?>
