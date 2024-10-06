<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Offres de Stage</title>
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
            align-items: center;
            gap: 15px;
        }
        label {
            display: block;
            text-align: left;
            width: 100%;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="date"], textarea {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
            padding: 20px;
            text-align: center;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        
    </header>

    <nav>
        <ul>
            <li><a href="dashboard_responsable.php">Dashboard</a></li>
        </ul>
    </nav>

    <main>
        <!-- Section pour ajouter une offre de stage -->
        <section>
            <h2>Ajouter une Offre de Stage</h2>
            <form action="/responsable_stage/ajouter_offre" method="post">
                <label for="titre">Titre de l'Offre:</label>
                <input type="text" id="titre" name="titre" required>
                
                <label for="description">Description de l'Offre:</label>
                <textarea id="description" name="description" required></textarea>
                
                <label for="entreprise">Nom de l'Entreprise:</label>
                <input type="text" id="entreprise" name="entreprise" required>
                
                <label for="date_publication">Date de Publication:</label>
                <input type="date" id="date_publication" name="date_publication" required>

                <button type="submit">Ajouter Offre</button>
            </form>
        </section>

        <!-- Section pour modifier une offre de stage -->
        <section>
            <h2>Modifier une Offre de Stage</h2>
            <form action="/responsable_stage/modifier_offre" method="post">
                <label for="offre_id">ID de l'Offre à Modifier:</label>
                <input type="text" id="offre_id" name="offre_id" required>
                
                <label for="titre">Titre de l'Offre:</label>
                <input type="text" id="titre" name="titre" required>
                
                <label for="description">Description de l'Offre:</label>
                <textarea id="description" name="description" required></textarea>
                
                <label for="entreprise">Nom de l'Entreprise:</label>
                <input type="text" id="entreprise" name="entreprise" required>
                
                <label for="date_publication">Date de Publication:</label>
                <input type="date" id="date_publication" name="date_publication" required>

                <button type="submit">Modifier Offre</button>
            </form>
        </section>

        <!-- Section pour supprimer une offre de stage -->
        <section>
            <h2>Supprimer une Offre de Stage</h2>
            <form action="/responsable_stage/supprimer_offre" method="post">
                <label for="offre_id">ID de l'Offre à Supprimer:</label>
                <input type="text" id="offre_id" name="offre_id" required>
                
                <button type="submit">Supprimer Offre</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
</body>
</html>