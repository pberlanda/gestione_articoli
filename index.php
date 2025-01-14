<?php 
require 'db.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gestione articoli</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Gestione articoli</h1>
    <br>
    <ul>
        <li><a href="admin.php">Area riservata</li>
    </ul>

    <table>
        <tr>
            <th>codice</th>
            <th>descrizione</th>
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
            echo '</tr>';
        }

        $stmt->close();
        $conn->close();
        
        ?>

    </table>

</body>
</html>