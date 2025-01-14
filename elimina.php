<?php
session_start();

require 'db.php';

// devi essere loggato
if(!$_SESSION['loggedin']){
    header('Location: login.php');
    exit;
}

if(isset($_GET['elimina'])){

    $articoloDaEliminare = $_GET['elimina'];

    echo 'TEST articolo da modificare ' . $articoloDaEliminare . "<br>";
}

// gestione eliminazione articolo
if($_SERVER['REQUEST_METHOD'] == "POST"){

    // query di eliminazione
    $sql = 'DELETE FROM articoli WHERE CODICE = ?';

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('s', $articoloDaEliminare);

    if(!$stmt->execute()){
        echo 'Errore ' . $stmt->error;
    }

    // torna a articoli
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
    <title>gestione articoli area riservata elimina</title>
</head>
<body>
    <h1>Gestione articoli - Area riservata - Elimina</h1>
    <br>

    <?php 

    // leggo gli altri dati

    $sql = "SELECT DESCRIZIONE FROM articoli WHERE CODICE = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param('s', $articoloDaEliminare);

    if($stmt->execute()){
        echo 'TEST articolo trovato' . $articoloDaEliminare;
    } else {
        echo 'Errore ' . $stmt->error;
    }

    $result = $stmt->get_result();

    $articolo = $result->fetch_assoc();

    ?>

    <form method="POST">
        <input type="text" name="codice" value="<?php echo $articoloDaEliminare ?>" disabled>
        <input type="text" name="descrizione" value="<?php echo $articolo['DESCRIZIONE'] ?>" required>

        <input type="submit" value="Elimina" onclick=confirm("Sicuro?")>

    </form>

    <a href="admin.php">Torna agli Articoli</a>

</body>
</html>