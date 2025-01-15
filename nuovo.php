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

    // verifica se il codce e' gia' stato utilizzato
    $sql = "SELECT * FROM articoli WHERE CODICE = ?";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param('s',$codice); // s str, i int, d dbl, b blb bin

    if(!$stmt->execute()){
        $message = "<span class='error'>Errore " . $stmt->error . "</span><br>";
    }

    $result = $stmt->get_result();

    $trovato = ($result->num_rows) ? true : false;

    if($trovato){
        $message = "<span class='warning'>Codice " . $codice . " gia' utilizzato</span><br>";
    } else {

        $sql = "INSERT INTO articoli (CODICE, DESCRIZIONE) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
    
        $stmt->bind_param('ss', $codice, $descrizione);
    
        if(!$stmt->execute()){
            $message = "<span class='error'>Errore " . $stmt->error . "</span><br>";
        }
    
        //$message = 'Articolo ' . $codice . ' ' . $descrizione . ' creato!';
        $message = "<span class='success'>Articolo " . $codice . " " . $descrizione . " creato!</span><br>";
    
    }
    
    $stmt->close();
    $conn->close();
    
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestione articoli area riservata nuovo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Gestione articoli - Area riservata - Nuovo</h1>
    <br>

    <form method="POST">
        <input type="text" name="codice" placeholder="Inserisci codice" maxlength="3" required>
        <input type="text" name="descrizione" placeholder="Inserisci descrizione"required>

        <input type="submit" value="Aggiungi">

    </form>

    <?php if (!empty($message)) echo $message; ?>

    <a href="admin.php">Torna agli Articoli</a>

</body>
</html>