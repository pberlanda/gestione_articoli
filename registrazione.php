<?php 
require 'db.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // controllo se utente gia esistente
    // da implementare per motivi di tempo

    // crea hash della pwd
    $hashed_password = password_hash($password,PASSWORD_DEFAULT);

    // crea cmd SQL. Uso misure di sicurezza per prevenire SQL injection
    $sql = ("INSERT INTO utenti (USERNAME, PASSWORD) VALUES(?,?)");

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('ss', $username, $hashed_password); // s str, i int, d dbl, b blb bin

    if(!$stmt->execute()){
        echo 'Errore ' . $stmt->error;
    }

    echo 'Utente ' . $username . ' creato! Verrai mandato al login tra 3 secondi';

    // utente creato!
    // vado a login
    header('Refresh: 3; url=login.php');

    // libero risorse
    $stmt->close();
    $conn->close();

}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestione articoli registrazione</title>
</head>
<body>
    <h1>Gestione articoli - Registrazione</h1>

    <form method="POST">
        <input type="text" name="username" placeholder="Inserisci username" required>
        <input type="password" name="password" placeholder="Inserisci password"required>

        <input type="submit" value="Registrati">

    </form>

    <a href="index.php">Torna a home</a>

</body>
</html>