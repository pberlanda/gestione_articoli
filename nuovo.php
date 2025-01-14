<?php
session_start();

require 'db.php';

// devi essere loggato
if(!$_SESSION['loggedin']){
    header('Location: login.php');
    exit;
}

// gestione inserimento nuovo articolo
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $codice = $_POST['codice'];
    $descrizione = $_POST['descrizione'];

    // verifica se gia esistente da implementare per poco tempo

    $sql = "INSERT INTO articoli (CODICE, DESCRIZIONE) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('ss', $codice, $descrizione);

    if(!$stmt->execute()){
        echo 'Errore ' . $stmt->error;
    }

    echo 'Articolo ' . $codice . ' ' . $descrizione . ' creato!';
    
    $stmt->close();
    $conn->close();
    
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestione articoli area riservata nuovo</title>
</head>
<body>
    <h1>Gestione articoli - Area riservata - Nuovo</h1>
    <br>

    <form method="POST">
        <input type="text" name="codice" placeholder="Inserisci codice" maxlength="3" required>
        <input type="text" name="descrizione" placeholder="Inserisci descrizione"required>

        <input type="submit" value="Aggiungi">

    </form>

    <a href="admin.php">Torna agli Articoli</a>

</body>
</html>