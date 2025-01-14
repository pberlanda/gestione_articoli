<?php 
$server="localhost";
$username="root";
$password="";
$dbname="gestione_articoli";

$conn = new Mysqli($server,$username,$password,$dbname);

if($conn->connect_error){
    die('Errore ' . $conn->connect_error);
}

?>