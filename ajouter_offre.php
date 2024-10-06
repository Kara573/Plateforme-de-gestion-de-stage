<?php
session_start();

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Récupérez les données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $responsable_id = $_SESSION['responsable_id']; // ID du responsable connecté

    // Préparez et liez
    $stmt = $conn->prepare("INSERT INTO OffresStage (titre, description, date_debut, date_fin, responsable_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $titre, $description, $date_debut, $date_fin, $responsable_id);

    // Exécutez la requête
    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Offre ajoutée avec succès !';
    } else {
        $_SESSION['error_message'] = 'Erreur: ' . $stmt->error;
    }

    // Fermez la connexion
    $stmt->close();
    $conn->close();
}

// Pour afficher le message de succès ou d'erreur
$message = '';
if (isset($_SESSION['success_message'])) {
    $message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Efface le message après l'affichage
} elseif (isset($_SESSION['error_message'])) {
    $message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Efface le message après l'affichage
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Offre de Stage</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styles globaux pour une cohérence avec les autres pages */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8)), url('/assets/images/logo.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            padding: 3em 1em;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 150px;
        }
        header h1 {
            margin: 0;
            font-size: 2.5em;
            font-weight: 700;
        }
        nav {
            background-color: #004d40;
            padding: 15px;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover {
            background-color: #00bfae;
        }
        main {
            flex: 1;
            padding: 60px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        form {
            background: #e0f2f1;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        button {
            background-color: #004d40;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #00bfae;
        }
        footer {
            background: #004d40;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
            position: relative;
        }
    </style>
</head>
<body>
    <header>
        <h1>Ajouter une Offre de Stage</h1>
    </header>

    <!-- Barre de navigation -->
    <nav>
        <ul>
            <li><a href="dashboard_responsable.php">Dashboard</a></li>
        </ul>
    </nav>

    <main>
        <form action="" method="post">
            <?php if ($message): ?>
                <div class="alert alert-success" role="alert"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <label for="titre">Titre de l'Offre:</label>
            <input type="text" id="titre" name="titre" required>

            <label for="description">Description de l'Offre:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="date_debut">Date de Début:</label>
            <input type="date" id="date_debut" name="date_debut" required>

            <label for="date_fin">Date de Fin:</label>
            <input type="date" id="date_fin" name="date_fin" required>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Ajouter Offre</button>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Projet Gestion de Stages</p>
    </footer>
</body>
</html>