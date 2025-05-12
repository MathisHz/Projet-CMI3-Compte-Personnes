 <?php
include('header.php');
require_once('config.php');

$erreur = '';
$salles = [];

if (isset($_GET['nom_salle']) && !empty(trim($_GET['nom_salle']))) {
    $nom_salle = strtolower(trim($_GET['nom_salle']));

    // Préparer une requête LIKE pour une recherche partielle et insensible à la casse
    $sql = "SELECT * FROM salle WHERE LOWER(nom) LIKE ?";
    $stmt = $conn->prepare($sql);

    // Ajouter les jokers % pour recherche partielle
    $param = '%' . $nom_salle . '%';
    $stmt->bind_param("s", $param);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $salles = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $erreur = "❌ Aucune salle trouvée pour « " . htmlspecialchars($_GET['nom_salle']) . " ».";
    }
} else {
    $erreur = "⚠️ Veuillez entrer un nom de salle.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat de la recherche</title>
    <link rel="stylesheet" href="style.css"> <!-- ou Bootstrap si tu veux -->
</head>
<body>

<?php if (!empty($salles)): ?>
    <br>
    <h1>Résultats de recherche :</h1>
<br>
    <?php foreach ($salles as $salle): ?>
        <?php
        $nombre_personnes = 0;
        $salle_id = $salle['id'];

        // Requête pour calculer le nombre de personnes présentes
        $sql_p = "SELECT SUM(nb_entrée) - SUM(nb_sortie) AS nombre_personnes FROM personnes WHERE salle_id = ?";
        $stmt_p = $conn->prepare($sql_p);
        $stmt_p->bind_param("i", $salle_id);
        $stmt_p->execute();
        $result_p = $stmt_p->get_result();
        if ($result_p && $row = $result_p->fetch_assoc()) {
            $nombre_personnes = $row['nombre_personnes'] ?? 0;
        }
        ?>
        <div class="card p-3 mb-3" style="border: 1px solid #ccc; border-radius: 8px;">
            <h2><?php echo htmlspecialchars($salle['nom']); ?></h2>
            <p>Capacité : <?php echo htmlspecialchars($salle['capacite']); ?> personnes</p>
            <p>Nombre de personnes présentes : <?php echo $nombre_personnes; ?></p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p><?php echo $erreur; ?></p>
<?php endif; ?>
<footer>
	<a href="index.php" class="btn btn-secondary">Retour à la liste</a>
</footer>
</body>
</html>
