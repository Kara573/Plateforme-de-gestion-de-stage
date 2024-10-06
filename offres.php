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

// Initialiser un message
$message = "";

// Vérifiez si l'étudiant est authentifié
$etudiant_id = $_SESSION['user_id'] ?? null; // Utilisez user_id ici



// Récupérer les offres de stage
$sql = "SELECT id, titre, description, date_debut, date_fin, date_publication FROM OffresStage";
$result = $conn->query($sql);

$offres = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $offres[] = $row;
    }
}

// Traitement de la candidature
if (isset($_GET['id']) && $etudiant_id) {
    $offre_id = intval($_GET['id']);
    
    // Insérer la candidature dans la base de données
    $stmt = $conn->prepare("INSERT INTO Candidatures (etudiant_id, offre_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $etudiant_id, $offre_id);
    
    if ($stmt->execute()) {
        $message = "Votre candidature a été soumise avec succès!";
    } else {
        $message = "Erreur lors de la soumission de votre candidature : " . $stmt->error;
    }

    $stmt->close();
} else {
    if (!$etudiant_id) {
        $message = "Vous devez être connecté pour postuler.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres de Stage - Plateforme de Gestion de Stages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
       html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        .header {
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8)), url('assets/images/logo.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            padding: 4em 2em;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 250px;
            position: relative;
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
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
            margin-top: -50px;
        }
        .nav a {
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: background 0.3s ease, color 0.3s ease;
        }
        .nav a:hover {
            background: #00bfae;
            color: #004d40;
        }
        .container {
            padding: 60px 20px;
            flex: 1;
        }
        .container h2 {
            font-size: 2.5em;
            color: #004d40;
            margin-bottom: 20px;
            font-weight: 700;
            text-align: center;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            background-color: #fff;
        }
        .card:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            font-size: 1.5em;
            color: #004d40;
            margin-bottom: 10px;
        }
        .card-text {
            font-size: 1em; /* Réduire légèrement la taille du texte */
            color: #666;
            margin-bottom: 15px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #00bfae, #004d40);
            border: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #004d40, #00bfae);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .footer {
            background: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Offres de Stage</h1>
    </header>

    <nav class="nav">
        <a href="profil.php">Mon Profil</a>
    </nav>

    <main class="container">
        <?php if ($message): ?>
            <div class="alert alert-info text-center"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if (isset($offres) && !empty($offres)): ?>
            <div class="row">
                <?php foreach ($offres as $offre): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($offre['titre']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($offre['description']); ?></p>
                                <p class="card-text"><strong>Date de Début:</strong> <?php echo htmlspecialchars($offre['date_debut']); ?></p>
                                <p class="card-text"><strong>Date de Fin:</strong> <?php echo htmlspecialchars($offre['date_fin']); ?></p>
                                <p class="card-text"><strong>Date de Publication:</strong> <?php echo htmlspecialchars($offre['date_publication']); ?></p>
                                <a href="?id=<?php echo htmlspecialchars($offre['id']); ?>" class="btn btn-primary">Postuler</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Aucune offre de stage disponible pour le moment.</p>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>