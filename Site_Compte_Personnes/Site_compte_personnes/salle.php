<?php include ('header.php') ;?>
<?php
// Connexion à MySQL
require_once('config.php');

// Vérifier si un ID de salle a été fourni
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $salle_id = $_GET['id'];

    // Récupérer les détails de la salle
    $sql = "SELECT * FROM salle WHERE id = $salle_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $salle = $result->fetch_assoc();
    } else {
        die("Salle non trouvée.");
    }
    // Récupérer le nombre de personnes actuellement présentes dans cette salle
    $sql_personnes = "SELECT SUM(nb_entrée) - SUM(nb_sortie) AS nombre_personnes FROM personnes WHERE salle_id = $salle_id";
    $result_personnes = $conn->query($sql_personnes);
    $nombre_personnes = 0; // Valeur par défaut si aucune donnée

    if ($result_personnes->num_rows > 0) {
        $row_personnes = $result_personnes->fetch_assoc();
        $nombre_personnes = $row_personnes["nombre_personnes"];
    }
} else {
    die("ID de salle invalide.");
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Détails de la salle</title>
</head>
<body>
    <br> <br>
    <h1>Détails de la salle : <?php echo htmlspecialchars($salle['nom']); ?></h1>

    <!-- Ajouter ici des détails sur la salle -->
    <p>Capacité : <?php echo htmlspecialchars($salle['capacite']); ?> personnes</p>
    <p>Nombre de personnes présents : <?php echo htmlspecialchars((string) $nombre_personnes); ?></p>
    <h3>Présence en temps réel</h3>
<canvas id="graph" width="800" height="400"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    fetch('graph.php?id=<?= $salle_id ?>')
        .then(response => response.json())
        .then(json => {
            const ctx = document.getElementById('graph').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: json.labels,
                    datasets: [{
                        label: 'Présences dans la salle',
                        data: json.data,
                        fill: true,
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Personnes présentes'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Heure'
                            }
                        }
                    }
                }
            });
        });
</script>

   <a href="index.php" class="btn btn-secondary">Retour à la liste</a>
</body>
</html>

<?php $conn->close(); ?>
