<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil - Plateforme de Gestion de Stages</title>
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
            background-size: contain; /* Ajuste l'image pour la rendre visible tout en gardant sa proportion */
            background-position: center; /* Centre l'image dans le conteneur */
            background-repeat: no-repeat; /* Évite que l'image se répète */
            color: #fff;
            padding: 4em 2em;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 300px; /* Ajuste la hauteur du header pour mieux afficher l'image */
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
            padding: 15px 0;
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
        .about {
            background: #e0f2f1;
            padding: 40px 20px;
            text-align: center;
            color: #004d40;
        }
        .about h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .about p {
            font-size: 1.2em;
            margin-bottom: 20px;
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
        <h1>Bienvenue sur la Plateforme de Gestion de Stages</h1>
    </header>
    <nav class="nav">
        <a href="views/auth/login.php">Connexion</a>
        <a href="views/auth/register.php">Inscription</a>
        <a href="views/auth/contact.php">Contact</a>
        <a href="views/auth/privacy.php">Confidentialité</a>
    </nav>
    <div class="container">
        <h2>Découvrez nos services</h2>
        <p>Consultez les offres de stages, postulez et gérez vos candidatures facilement.</p>
        <a href="views/auth/register.php" class="button">S'inscrire</a>
    </div>
    <!-- Nouvelle section "À propos de la plateforme" -->
    <div class="about">
        <h2>À propos de la plateforme</h2>
        <p>Notre plateforme de gestion de stages est conçue pour faciliter la recherche, la gestion et le suivi des opportunités de stage. Elle permet aux étudiants de trouver des offres de stage adaptées à leurs besoins, de postuler en ligne et de suivre l'état de leurs candidatures. Pour les tuteurs et responsables de stage, elle offre des outils pratiques pour gérer les candidatures, publier des offres et suivre les processus de sélection. Découvrez une solution moderne, intuitive et efficace pour optimiser la gestion des stages.</p>
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
