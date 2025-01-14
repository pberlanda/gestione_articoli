<?php
session_start();

require 'db.php';

// devi essere loggato
if(!$_SESSION['loggedin']){
    header('Location: login.php');
    exit;
}

if(isset($_GET['modifica'])){

    $articoloDaModificare = $_GET['modifica'];

    echo 'TEST articolo da modificare ' . $articoloDaModificare . "<br>";
}

// gestione modifica articolo
if($_SERVER['REQUEST_METHOD'] == "POST"){

    $descrizione = $_POST['descrizione'];

    // query di modifica
    $sql = 'UPDATE articoli SET DESCRIZIONE = ? WHERE CODICE = ?';

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('ss', $descrizione, $articoloDaModificare);

    if(!$stmt->execute()){
        echo 'Errore ' . $stmt->error;
    }

    // torna a articolo
    header('Location: admin.php');

    // libera risorse
    $stmt->close();
    $conn->close();
    
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestione articoli area riservata modifica</title>
</head>
<body>
    <h1>Gestione articoli - Area riservata - Modifica</h1>
    <br>

    <?php 

    // leggo gli altri dati da modifica

    $sql = "SELECT DESCRIZIONE FROM articoli WHERE CODICE = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('s', $articoloDaModificare);

    if($stmt->execute()){
        echo 'TEST articolo trovato' . $articoloDaModificare;
    } else {
        echo 'Errore ' . $stmt->error;
    }

    $result = $stmt->get_result();

    $articolo = $result->fetch_assoc();

    ?>

    <form method="POST">
        <input type="text" name="codice" value="<?php echo $articoloDaModificare ?>" disabled>
        <input type="text" name="descrizione" value="<?php echo $articolo['DESCRIZIONE'] ?>" required>

        <input type="submit" value="Modifica" onclick=confirm('Sicuro?')>

    </form>

    <a href="admin.php">Torna agli Articoli</a>

</body>
</html>