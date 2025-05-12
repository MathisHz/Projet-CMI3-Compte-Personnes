<?php
include 'config.php'; // Inclusion de la connexion

// Récupérer les données envoyées par l'Arduino via GET
$nb_entree = isset($_GET['entree']) ? intval($_GET['entree']) : 0;
$nb_sortie = isset($_GET['sortie']) ? intval($_GET['sortie']) : 0;

// Calcul du nombre total de personnes déjà dans la salle
$sql = "SELECT SUM(nb_entrée) - SUM(nb_sortie) AS nombre_personnes FROM personnes";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$nombre_personnes = ($row["nombre_personnes"] ?? 0) + $nb_entree - $nb_sortie;

// Insérer les nouvelles données avec le champ `nombre_personnes`
$sql = "INSERT INTO personnes (nb_entrée, nb_sortie, nombre_personnes) 
        VALUES ($nb_entree, $nb_sortie, $nombre_personnes)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Données enregistrées.";
} else {
    echo "❌ Erreur : " . $conn->error;
}

$conn->close();
?>
