<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database_name = 'banking_system';

// Tentative de connexion
$con = @mysqli_connect($server, $username, $password, $database_name);

// Vérification de la connexion
if (!$con) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
echo "Connexion réussie à la base de données !";

// Vérification des tables
$tables = mysqli_query($con, "SHOW TABLES");
echo "<br>Tables trouvées : <br>";
while ($table = mysqli_fetch_array($tables)) {
    echo $table[0] . "<br>";
}

mysqli_close($con);
?>
