 <?php
include 'config.php';

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "ID salle manquant"]);
    exit;
}

$salle_id = intval($_GET['id']);

$req = $conn->prepare("SELECT * FROM personnes WHERE salle_id = ? ORDER BY heure ASC");
$req->bind_param("i", $salle_id);
$req->execute();
$result = $req->get_result();

$labels = [];
$data = [];
$compteur = 0;

while ($row = $result->fetch_assoc()) {
    $compteur += (int)$row['nb_entrée'] - (int)$row['nb_sortie'];
    $compteur = max(0, $compteur);
    $labels[] = date('H:i:s', strtotime($row['heure']));
    $data[] = $compteur;
}

echo json_encode([
    "labels" => $labels,
    "data" => $data
]);
?>

