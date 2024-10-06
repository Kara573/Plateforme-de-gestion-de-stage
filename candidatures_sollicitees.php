<?php
session_start();

// Vérifiez si le tuteur est connecté
if (!isset($_SESSION['tuteur_id'])) {
    header("Location: login.php"); // Redirigez vers la page de connexion si non connecté
    exit();
}

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

// Récupérer l'ID du tuteur connecté
$tuteur_id = $_SESSION['tuteur_id'];

// Requête pour récupérer les sollicitations du tuteur avec des informations supplémentaires
$sql = "SELECT st.id, e.prenom AS etudiant_prenom, e.nom AS etudiant_nom, 
               e.niveau_etude, e.filiere, e.ecole, st.date_solicitation 
        FROM SollicitationsTuteur st
        JOIN Etudiants e ON st.etudiant_id = e.etudiant_id
        WHERE st.tuteur_id = ?
        ORDER BY st.date_solicitation DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $tuteur_id);
$stmt->execute();
$result = $stmt->get_result();

// Vérification des résultats
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
    <title>Candidatures Sollicitées - Plateforme de Gestion de Stages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
        }
        .header {
            position: relative;
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8)), url('assets/images/logo.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            padding: 4em 2em;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 150px;
        }
        .header h1 {
            margin: 0;
            font-size: 3em;
            font-weight: 700;
            z-index: 1;
            position: relative;
        }
        .nav {
            display: flex;
            justify-content: center;
            background: #004d40;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .nav a {
            color: #fff;
            padding: 15px 20px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease, color 0.3s ease;
        }
        .nav a:hover {
            background: #00bfae;
            color: #004d40;
            transform: scale(1.05);
        }
        .container {
            flex: 1;
            padding: 60px 20px;
            text-align: center;
        }
        .section {
            background: #e0f2f1;
            padding: 40px 20px;
            color: #004d40;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 2.5em;
            color: #004d40;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .footer {
            background: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Candidatures Sollicitées</h1>
    </header>
    <nav class="nav">
        <a href="dashboard_tuteur.php">Dashboard</a>
    </nav>
    <div class="container">
        <div class="section">
            <?php if (!empty($candidatures)): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Niveau d'Étude</th>
                            <th>Filière</th>
                            <th>Ecole</th>
                            <th>Date de Soumission</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($candidatures as $candidature): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($candidature['etudiant_prenom'] . ' ' . $candidature['etudiant_nom']); ?></td>
                                <td><?php echo htmlspecialchars($candidature['niveau_etude']); ?></td>
                                <td><?php echo htmlspecialchars($candidature['filiere']); ?></td>
                                <td><?php echo htmlspecialchars($candidature['ecole']); ?></td>
                                <td><?php echo htmlspecialchars($candidature['date_solicitation']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune candidature sollicitée pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>