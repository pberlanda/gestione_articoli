<?php 

session_start();

require 'db.php';

// gestione login
if($_SERVER['REQUEST_METHOD']=="POST"){

    $username = $_POST['username'];
    $password = $_POST['password'];

    // controlli sui dati immessi da implementare per poco tempo

    // devo verificare se l'utente esiste

    $sql = "SELECT * FROM utenti WHERE USERNAME = ?";

    // eseguo query in sicurezza
    $stmt = $conn->prepare($sql);

    $stmt->bind_param('s', $username);

    if($stmt->execute()){
        echo 'TEST Query Ok';
    } else {
        echo 'Errore ' . $stmt->error;
    }

    $result = $stmt->get_result();

    $utente = $result->fetch_assoc();

    if($username == $utente['USERNAME']){

        echo 'TEST utente trovato';
        if (password_verify($password, $utente['PASSWORD'])){

            $_SESSION['loggedin'] = true;
            header('Location: admin.php');
            exit;

        }
    } else {
        echo "Username o password errati!";
    }

    // libera
    $stmt->close();
    $conn->close();

}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestione articoli login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">

        <h1>Gestione articoli - Login</h1>

        <form class="container" method="POST">
            <input type="text" name="username" placeholder="Inserisci username" required>
            <input type="password" name="password" placeholder="Inserisci password"required>

            <input type="submit" value="Login">

        </form>

        <h2>Nuovo utente? <a href="registrazione.php">Registrati</a></h2>
        
        <a href="index.php">Torna a home</a>

    </div>
</body>
</html>