<?php
session_start();

require 'db.php';

// devi essere loggato
if(!$_SESSION['loggedin']){
    header('Location: login.php');
    exit;
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestione articoli area riservata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Gestione articoli - Area riservata</h1>
    <br>
    <ul>
    <li><a href="nuovo.php">Nuovo articolo</li>
    <li><a href="logout.php">Logout</li>
    </ul>

    <table>
        <tr>
            <th>codice</th>
            <th>descrizione</th>
            <th></th>
            <th></th>
        </tr>

        <?php 
        
        $sql = "SELECT * FROM articoli WHERE 1 ORDER BY CODICE ASC";

        $stmt = $conn->prepare($sql);
        //$stmt->bind_param(); s string i int d double, b blob/binary
        
        if(!$stmt->execute()){
            echo 'Errore ' . $stmt->error;
        }

        $result = $stmt->get_result();

        while($articolo = $result->fetch_assoc()){
            echo '<tr>';
            echo "<td>" . $articolo['CODICE'] . "</td>";
            echo "<td>" . $articolo['DESCRIZIONE'] . "</td>";
            echo "<td><a href='modifica.php?modifica=" . $articolo['CODICE'] ."'>Modifica</a></td>";
            echo "<td><a href='elimina.php?elimina=" . $articolo['CODICE'] ."'>Elimina</a></td>";
            echo '</tr>';
        }

        $stmt->close();
        $conn->close();
        
        ?>

    </table>

</body>
</html>