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

// Récupérer les candidatures rejetées avec des informations supplémentaires
$sql = "SELECT c.id, o.titre AS titre_offre, CONCAT(e.prenom, ' ', e.nom) AS nom_candidat, 
               e.niveau_etude, e.filiere, e.ecole, c.date_soumission  
        FROM Candidatures c 
        JOIN OffresStage o ON c.offre_id = o.id 
        JOIN Etudiants e ON c.etudiant_id = e.etudiant_id 
        WHERE c.statut = 'Rejeter'";
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
    <title>Candidatures Rejetées</title>
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
        header {
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8));
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
            background: #004d40;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0;
        }
        nav ul li a {
            color: #fff;
            padding: 15px 20px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: background 0.3s ease, transform 0.3s ease, color 0.3s ease;
        }
        nav ul li a:hover {
            background: #00bfae;
            color: #004d40;
            transform: scale(1.05);
        }
        main {
            flex: 1;
            padding: 60px 20px;
            text-align: center;
        }
        section {
            background: #e0f2f1;
            padding: 40px 20px;
            color: #004d40;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        section h2 {
            font-size: 2em;
            color: #004d40;
            margin-bottom: 20px;
            font-weight: 700;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #004d40;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background: #004d40;
            color: #fff;
        }
        footer {
            background: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <h1>Candidatures Rejetées</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard_responsable.php">Dashboard</a></li>
        </ul>
    </nav>

    <main>
        <section>
            <?php if (isset($candidatures) && !empty($candidatures)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titre de l'Offre</th>
                            <th>Candidat</th>
                            <th>Niveau d'Étude</th>
                            <th>Filière</th>
                            <th>Ecole</th>
                            <th>Date de Soumission</th>
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune candidature rejetée pour le moment.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
</body>
</html>