<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Plateforme de Gestion de Stages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        .header {
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8));
            padding: 60px 20px;
            color: #fff;
            text-align: center;
        }
        .header h1 {
            font-size: 3em;
            font-weight: 700;
        }
        .nav {
            display: flex;
            justify-content: center;
            background-color: #004d40;
            padding: 15px 0;
        }
        .nav a {
            color: #fff;
            padding: 15px 20px;
            text-decoration: none;
            font-weight: 600;
        }
        .nav a:hover {
            background-color: #00bfae;
            color: #004d40;
        }
        .container {
            padding: 40px 20px;
            max-width: 800px;
            margin: auto;
        }
        .container h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #004d40;
            font-weight: 700;
        }
        .form-group label {
            font-weight: 600;
        }
        .form-control {
            margin-bottom: 20px;
        }
        .button {
            padding: 12px 25px;
            font-size: 16px;
            color: #fff;
            background-color: #004d40;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
        }
        .button:hover {
            background-color: #00bfae;
        }
        .footer {
            background-color: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Nous Contacter</h1>
    </header>
    <nav class="nav">
        <a href="../../index.php">Accueil</a>
    </nav>
    <div class="container">
        <h2>Envoyez-nous un message</h2>
        <form action="/contact_submit.php" method="POST">
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="6" class="form-control" required></textarea>
            </div>
            <button type="submit" class="button">Envoyer</button>
        </form>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
</body>
</html>
