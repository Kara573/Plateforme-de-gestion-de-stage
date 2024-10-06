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

// Requête pour récupérer les stagiaires
$query = "SELECT etudiant_id, nom, prenom, filiere, ecole, niveau_etude, cv, lettre_motivation FROM Etudiants";
$result = $conn->query($query);

$stagiaires = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stagiaires[] = $row;
    }
}

// Initialiser la variable pour le message de succès
$success_message = "";

// Récupérer l'ID du tuteur depuis la session
$tuteur_id = $_SESSION['tuteur_id']; 

// Traitement de la demande de sollicitation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['stagiaire_id'])) {
        $stagiaire_id = $_POST['stagiaire_id'];

        // Insertion dans la table SollicitationsTuteur
        $stmt = $conn->prepare("INSERT INTO SollicitationsTuteur (tuteur_id, etudiant_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $tuteur_id, $stagiaire_id);

        if ($stmt->execute()) {
            $success_message = "Demande de sollicitation envoyée avec succès.";
        } else {
            $success_message = "Erreur lors de l'envoi de la demande : " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter les Stagiaires - Plateforme de Gestion de Stages</title>
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
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8));
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
            font-weight: 600;
        }
        .nav a:hover {
            background: #00bfae;
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
        }
        .card {
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .footer {
            background: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        /* Nouvelle classe pour le bouton */
        .btn-solliciter {
            background-color: #00bfae; /* Couleur verte */
            color: #fff;
            border: none;
        }
        .btn-solliciter:hover {
            background-color: #009688; /* Couleur plus foncée au survol */
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Consulter les Stagiaires</h1>
    </header>

    <nav class="nav">
        <a href="dashboard_tuteur.php">Dashboard</a>
    </nav>

    <div class="container">
        <?php if (!empty($stagiaires)): ?>
            <div class="row">
                <?php foreach ($stagiaires as $stagiaire): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($stagiaire['nom']) . ' ' . htmlspecialchars($stagiaire['prenom']); ?></h5>
                                <p class="card-text"><strong>Filière:</strong> <?php echo htmlspecialchars($stagiaire['filiere']); ?></p>
                                <p class="card-text"><strong>Niveau d'Étude:</strong> <?php echo htmlspecialchars($stagiaire['niveau_etude']); ?></p>
                                <p class="card-text"><strong>Ecole:</strong> <?php echo htmlspecialchars($stagiaire['ecole']); ?></p>
                                <p class="card-text"><strong>CV:</strong> <a href="../../views/etudiant/<?php echo htmlspecialchars($stagiaire['cv']); ?>" target="_blank">Voir le CV</a></p>
                                <p class="card-text"><strong>Lettre de Motivation:</strong> <a href="../../views/etudiant/<?php echo htmlspecialchars($stagiaire['lettre_motivation']); ?>" target="_blank">Voir la Lettre</a></p>
                                <form action="" method="post">
                                    <input type="hidden" name="stagiaire_id" value="<?php echo htmlspecialchars($stagiaire['etudiant_id']); ?>">
                                    <button type="submit" class="btn btn-solliciter">Solliciter ce Stagiaire</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun stagiaire disponible.</p>
        <?php endif; ?>

        <!-- Afficher le message de succès ici -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success mt-4">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
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