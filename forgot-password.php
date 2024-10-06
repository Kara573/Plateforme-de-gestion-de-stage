<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de Passe Oublié</title>
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
        header {
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8)), url('/assets/images/logo.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            padding: 3em 1em;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 250px;
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
            margin-bottom: 20px;
            max-width: 600px;
            margin: auto;
        }
        section h2 {
            font-size: 2em;
            color: #004d40;
            margin-bottom: 20px;
            font-weight: 700;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 1em;
            font-weight: 600;
            color: #004d40;
            margin-bottom: 5px;
            text-align: left;
        }
        input[type="email"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #004d40;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        button:hover {
            background: #00bfae;
            transform: scale(1.05);
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
        <h1>Mot de Passe Oublié</h1>
    </header>

    <nav>
        <ul>
            <li><a href="/">Accueil</a></li>
            <li><a href="/auth/login">Connexion</a></li>
            <li><a href="/auth/register">Inscription</a></li>
        </ul>
    </nav>

    <main>
        <section>
            <h2>Réinitialiser votre mot de passe</h2>
            <form action="/auth/forgot-password" method="POST">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Envoyer le lien de réinitialisation</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Projet Gestion de Stages</p>
    </footer>
</body>
</html>
