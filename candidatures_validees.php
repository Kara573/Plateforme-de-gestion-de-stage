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

// Récupérer les candidatures rejetées
$sql = "SELECT c.id, o.titre AS titre_offre, CONCAT(e.prenom, ' ', e.nom) AS nom_candidat, 
               c.date_soumission  
        FROM Candidatures c 
        JOIN OffresStage o ON c.offre_id = o.id 
        JOIN Etudiants e ON c.etudiant_id = e.etudiant_id 
        WHERE c.statut = 'Accepter'";
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
    <title>Candidatures Validées - Plateforme de Gestion de Stages</title>
    <!-- Liens vers des bibliothèques CSS modernes pour un rendu attrayant -->
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
            background-size: contain; 
            background-position: center;
            background-repeat: no-repeat; 
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
        .container h2 {
            font-size: 2.5em;
            color: #004d40;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .container p {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 16px;
            color: #fff;
            background: linear-gradient(135deg, #00bfae, #004d40);
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .button:hover {
            background: linear-gradient(135deg, #004d40, #00bfae);
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
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
            font-size: 2em;
            color: #004d40;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .section ul {
            list-style: none;
            padding: 0;
        }
        .section ul li {
            background: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        .section ul li h3 {
            margin-top: 0;
            color: #004d40;
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
        <h1>Candidatures Validées</h1>
    </header>
    <nav class="nav">
        <a href="dashboard_tuteur.php">Dashboard</a>
    </nav>
    <div class="container">
        <div class="section">
            <h2>Liste des Candidatures Validées</h2>
            <?php if (isset($candidatures) && !empty($candidatures)): ?>
                <ul>
                    <?php foreach ($candidatures as $candidature): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($candidature['titre_offre']); ?></h3>
                            <p><strong>Candidat:</strong> <?php echo htmlspecialchars($candidature['nom_candidat']); ?></p>
                            <p><strong>Date de Candidature:</strong> <?php echo htmlspecialchars($candidature['date_soumission']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune candidature validée pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
    <!-- Liens vers les bibliothèques JavaScript modernes -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
