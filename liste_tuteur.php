<?php
session_start();

// Connexion à la base de données
$host = 'localhost';
$dbname = 'gestion_stages_sodecoton';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupération des tuteurs
$tuteurs = [];

try {
    $stmt = $pdo->query("SELECT nom, prenom, email FROM Tuteurs");
    $tuteurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tuteurs</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Styles globaux pour une cohérence avec le tableau de bord */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        nav ul li a {
            color: #fff;
            padding: 15px 20px;
            text-decoration: none;
        }
        main {
            flex: 1;
            padding: 60px 20px;
            text-align: center;
        }
        section {
            background: #e0f2f1;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #004d40;
            color: #fff;
        }
        footer {
            background: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Liste des Tuteurs</h1>
    </header>

    <nav>
        <ul>
            <li><a href="dashboard_admin.php">Tableau de Bord</a></li>
        </ul>
    </nav>

    <main>
        <section>
            <h2>Tuteurs</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tuteurs as $tuteur): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tuteur['nom']); ?></td>
                            <td><?php echo htmlspecialchars($tuteur['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($tuteur['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>