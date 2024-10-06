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

// Récupérer les offres publiées avec le nom du responsable
$sql = "SELECT os.id, os.titre, os.description, os.date_debut, os.date_fin, 
               os.date_publication, r.nom AS responsable_nom 
        FROM OffresStage os
        LEFT JOIN ResponsablesStage r ON os.responsable_id = r.responsable_id"; // Assurez-vous que la relation est correcte

$result = $conn->query($sql);

$offres = [];
if ($result->num_rows > 0) {
    // Stocker les résultats dans un tableau
    while ($row = $result->fetch_assoc()) {
        $offres[] = $row;
    }
}

// Fermez la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offres Publiées - Plateforme de Gestion de Stages</title>
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
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8)), url('/assets/images/logo.jpg') no-repeat center center;
            background-size: contain;
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
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .nav a:hover {
            background: #00bfae;
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
        }
        .footer {
            background: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #004d40;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Offres Publiées</h1>
    </header>

    <nav class="nav">
        <a href="dashboard_responsable.php">Dashboard</a>
    </nav>

    <div class="container">
        <h2>Liste des Offres Publiées</h2>
        <?php if (isset($offres) && !empty($offres)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Id de l'offre</th>
                        <th>Nom Responsable</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date Début</th>
                        <th>Date Fin</th>
                        <th>Date de Publication</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($offres as $offre): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($offre['id']); ?></td>
                            <td><?php echo htmlspecialchars($offre['responsable_nom']); ?></td>
                            <td><?php echo htmlspecialchars($offre['titre']); ?></td>
                            <td><?php echo htmlspecialchars($offre['description']); ?></td>
                            <td><?php echo htmlspecialchars($offre['date_debut']); ?></td>
                            <td><?php echo htmlspecialchars($offre['date_fin']); ?></td>
                            <td><?php echo htmlspecialchars($offre['date_publication']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune offre publiée pour le moment.</p>
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