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

// Traitement du formulaire d'inscription
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mot_de_passe_clair = $_POST['mot_de_passe'];
    $mot_de_passe_hache = password_hash($mot_de_passe_clair, PASSWORD_DEFAULT);

    // Vérification si l'email existe déjà
    $query = "SELECT COUNT(*) FROM Admins WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $exists = $stmt->fetchColumn();

    if ($exists) {
        $error = "L'email est déjà utilisé.";
    } else {
        // Insertion de l'administrateur dans la base de données
        $query = "INSERT INTO Admins (email, mot_de_passe) VALUES (:email, :mot_de_passe)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe_hache);
        
        if ($stmt->execute()) {
            $success = "Administrateur ajouté avec succès !";
            // Rediriger vers la page de connexion après une inscription réussie
            header('Location: login.php'); // Changez 'login.php' selon le nom de votre page de connexion
            exit();
        } else {
            $error = "Une erreur est survenue lors de l'ajout de l'administrateur.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Administrateur - Plateforme de Gestion de Stages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header {
            background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8));
            padding: 40px 20px;
            color: #fff;
            text-align: center;
        }
        .header h1 {
            font-size: 3em;
            font-weight: 700;
        }
        .main-content {
            flex: 1;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            padding: 40px 20px;
            max-width: 600px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 100%;
        }
        .container h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #004d40;
            font-weight: 700;
            text-align: center;
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
            width: 100%;
            text-align: center;
        }
        .button:hover {
            background-color: #00bfae;
        }
        footer {
            background-color: #004d40;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Inscription Administrateur</h1>
    </header>
    <div class="main-content">
        <div class="container">
            <h2>Créer un compte</h2>
            <?php if ($error): ?>
                <div class='alert alert-danger' role='alert'><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class='alert alert-success' role='alert'><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de Passe:</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required>
                </div>
                <button type="submit" class="button">S'inscrire</button>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
</body>
</html>