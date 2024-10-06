<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stages_sodecoton";

// Créez la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

// Vérifier si un ID d'offre a été fourni
if (isset($_GET['id'])) {
    $offre_id = intval($_GET['id']);
    
    // Vérifiez si l'étudiant est connecté
    if (isset($_SESSION['etudiant_id'])) {
        $etudiant_id = $_SESSION['etudiant_id']; // ID de l'étudiant connecté

        // Insérer la candidature dans la base de données
        $sql = "INSERT INTO Candidatures (etudiant_id, offre_id, date_soumission) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ii", $etudiant_id, $offre_id);

            if ($stmt->execute()) {
                // Rediriger vers une page de succès après une soumission réussie
                header("Location: success.php"); // Mettre ici la page de succès
                exit();
            } else {
                // Afficher une erreur si l'exécution échoue
                echo "Erreur lors de la soumission de la candidature : " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erreur dans la préparation de la requête : " . $conn->error;
        }
    } else {
        // Rediriger vers la page de connexion si l'étudiant n'est pas connecté
        header("Location: ../../login.php");
        exit();
    }
} else {
    // Rediriger si aucune ID d'offre n'est fournie
    header("Location: ../../index.php");
    exit();
}

// Fermez la connexion
$conn->close();
?>