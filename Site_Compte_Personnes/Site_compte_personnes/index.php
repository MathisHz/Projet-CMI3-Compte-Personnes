<?php include('header.php'); ?> 

<div class="container mt-4">
    <h1 style="font-size: 2.0em;">Les salles : </h1>
    
    <div class="row">
        <?php  
        require_once('config.php');  
        
        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

        // Exécution de la requête SQL
        $query = "SELECT * FROM salle";  
        $result = $conn->query($query);

        // Vérifier s'il y a des salles
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {  
                echo '<div class="col-md-4">';
                echo '  <div class="card mb-4">';
                echo '      <div class="card-body">';
                echo '          <h5 class="card-title">' . htmlspecialchars($row['nom']) . '</h5>';
                echo '          <a href="salle.php?id=' . $row['id'] . '" class="btn btn-primary" style=" background-color: #123b75 ">Voir la salle</a>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<p>Aucune salle disponible.</p>';
        }

        $conn->close();
        ?>
	   <script>
  function rafraichirCompteur() {
    fetch('get_compteur.php') // Ce fichier PHP renvoie la valeur depuis la BDD
      .then(response => response.text())
      .then(data => {
        document.getElementById("compteur").innerText = data;
      })
      .catch(error => {
        console.error("Erreur lors du rafraîchissement :", error);
        document.getElementById("compteur").innerText = "Erreur...";
      });
  }

  // Appel immédiat + toutes les 10 secondes
  rafraichirCompteur();
  setInterval(rafraichirCompteur, 10000);
</script>
    </div>
</div>
