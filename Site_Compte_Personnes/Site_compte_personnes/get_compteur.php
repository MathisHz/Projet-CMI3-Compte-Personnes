<?php
include 'config.php'; // Inclusion de la connexion

$salle_id = 1; // Tu peux le rendre dynamique plus tard via GET

$query = "SELECT nombre_personnes FROM personnes WHERE salle_id = ? ORDER BY heure DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $salle_id);
$stmt->execute();
$stmt->bind_result($nombre);
$stmt->fetch();

echo $nombre ?? 0;

$stmt->close();
$conn->close();
?>
