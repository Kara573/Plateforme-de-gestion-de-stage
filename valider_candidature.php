<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_stages_sodecoton";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

// Traitement de la candidature
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidature_id = intval($_POST['candidature_id']);
    $action = $_POST['action'];

    if ($action === 'valider') {
        $sql = "UPDATE Candidatures SET statut = 'Accepter' WHERE id = ?";
    } elseif ($action === 'rejeter') {
        $sql = "UPDATE Candidatures SET statut = 'Rejeter' WHERE id = ?";
    }

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $candidature_id);
        $stmt->execute();
        
        // Vérification de l'exécution de la requête
        if ($stmt->affected_rows > 0) {
            echo "<div class='alert alert-success'>Candidature mise à jour avec succès.</div>";
        } else {
            echo "<div class='alert alert-warning'>Aucune modification apportée.</div>";
        }
        
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Erreur dans la préparation de la requête.</div>";
    }
}

// Récupérer les candidatures à valider avec des informations supplémentaires
$sql = "SELECT c.id, o.titre AS titre_offre, c.statut, c.date_soumission, 
               CONCAT(e.prenom, ' ', e.nom) AS nom_candidat, 
               e.niveau_etude, e.filiere, e.ecole, e.cv, e.lettre_motivation 
        FROM Candidatures c 
        JOIN OffresStage o ON c.offre_id = o.id 
        JOIN Etudiants e ON c.etudiant_id = e.etudiant_id 
        WHERE c.statut = 'EnAttente'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$candidatures = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $candidatures[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valider Candidature - Plateforme de Gestion de Stages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header {
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8));
            color: #fff;
            padding: 3em 1em;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .nav {
            display: flex;
            justify-content: center;
            background: #004d40;
            padding: 15px 0;
        }
        .nav a {
            color: #fff;
            padding: 15px 20px;
            text-decoration: none;
            font-weight: 600;
        }
        .container {
            flex: 1;
            margin-top: 30px;
        }
        .container table {
            width: 100%;
            border-collapse: collapse;
            max-height: 600px; 
            overflow-y: auto; 
        }
        .container table th, .container table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            white-space: nowrap; 
        }
        .container table th {
            background-color: #004d40;
            color: white;
        }
        .footer {
            background: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Valider les Candidatures</h1>
    </header>

    <nav class="nav">
        <a href="dashboard_responsable.php">Dashboard</a>
    </nav>

    <div class="container">
        <?php if (isset($candidatures) && !empty($candidatures)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Offre</th>
                        <th>Candidat</th>
                        <th>Niveau d'Étude</th>
                        <th>Filière</th>
                        <th>Ecole</th>
                        <th>Date de Soumission</th>
                        <th>CV</th>
                        <th>Lettre de Motivation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatures as $candidature): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($candidature['titre_offre']); ?></td>
                            <td><?php echo htmlspecialchars($candidature['nom_candidat']); ?></td>
                            <td><?php echo htmlspecialchars($candidature['niveau_etude']); ?></td>
                            <td><?php echo htmlspecialchars($candidature['filiere']); ?></td>
                            <td><?php echo htmlspecialchars($candidature['ecole']); ?></td>
                            <td><?php echo htmlspecialchars($candidature['date_soumission']); ?></td>
                            <td><a href="../../views/etudiant/<?php echo htmlspecialchars($candidature['cv']); ?>" target="_blank">Voir le CV</a></td>
                            <td><a href="../../views/etudiant/<?php echo htmlspecialchars($candidature['lettre_motivation']); ?>" target="_blank">Voir la Lettre</a></td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="candidature_id" value="<?php echo htmlspecialchars($candidature['id']); ?>">
                                    <button type="submit" name="action" value="valider" class="btn btn-success">Valider</button>
                                    <button type="submit" name="action" value="rejeter" class="btn btn-danger">Rejeter</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune candidature en attente de validation.</p>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>