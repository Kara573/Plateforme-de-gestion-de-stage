<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Administrateur</title>
    <!-- Liens vers des bibliothèques CSS modernes pour un rendu attrayant -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        main {
            flex: 1;
            padding: 60px 20px;
            text-align: center;
        }
        .dashboard-section {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .dashboard-item {
            background: #e0f2f1;
            padding: 30px;
            border-radius: 8px;
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            text-align: center;
        }
        .dashboard-item:hover {
            transform: scale(1.05);
        }
        .dashboard-item a {
            text-decoration: none;
            font-weight: 600;
            color: #004d40;
            display: block;
            margin-top: 10px;
        }
        .dashboard-item i {
            font-size: 2em;
            color: #004d40;
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
        <h1>Tableau de Bord - Administrateur</h1>
    </header>

    <main>
        <div class="dashboard-section">
            <div class="dashboard-item">
                <i class="fas fa-user-plus"></i>
                <a href="ajouter_tuteur.php">Ajouter un Tuteur</a>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-user-minus"></i>
                <a href="supprimer_tuteur.php">Supprimer un Tuteur</a>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-user-plus"></i>
                <a href="ajouter_responsable.php">Ajouter un Responsable</a>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-user-minus"></i>
                <a href="supprimer_responsable.php">Supprimer un Responsable</a>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-users"></i>
                <a href="liste_responsable.php">Liste des Responsables</a>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-users"></i>
                <a href="liste_tuteur.php">Liste des Tuteurs</a>
            </div>
            <div class="dashboard-item">
                <i class="fas fa-sign-out-alt"></i>
                <a href="../auth/logout.php">Déconnexion</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
</body>
</html>