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

// Vérifier les informations de connexion
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['mot_de_passe'];

    // Vérification dans la table Etudiants
    $query = "SELECT etudiant_id, mot_de_passe FROM Etudiants WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe pour les étudiants
    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['etudiant_id'];
        $_SESSION['user_type'] = 'etudiant'; 
        header('Location: ../etudiant/profil.php');
        exit();
    }

    // Vérification dans la table Admins
    $query = "SELECT admin_id, mot_de_passe FROM Admins WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe pour l'administrateur
    if ($admin && password_verify($password, $admin['mot_de_passe'])) {
        $_SESSION['user_id'] = $admin['admin_id'];
        $_SESSION['user_type'] = 'admin'; 
        header('Location: ../admin/dashboard_admin.php');
        exit();
    }

    // Vérification dans la table Tuteurs
    $query = "SELECT tuteur_id, mot_de_passe FROM Tuteurs WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $tuteur = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe pour les tuteurs
    if ($tuteur && password_verify($password, $tuteur['mot_de_passe'])) {
        $_SESSION['tuteur_id'] = $tuteur['tuteur_id'];
        $_SESSION['user_type'] = 'tuteur'; 
        header('Location: ../tuteur/dashboard_tuteur.php');
        exit();
    }

    // Vérification dans la table ResponsablesStage
    $query = "SELECT responsable_id, mot_de_passe FROM ResponsablesStage WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $responsable = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification du mot de passe pour les responsables
    if ($responsable && password_verify($password, $responsable['mot_de_passe'])) {
        $_SESSION['responsable_id'] = $responsable['responsable_id']; 
        header('Location: ../responsable_stage/dashboard_responsable.php');
        exit();
    } else {
        $error = 'Aucun utilisateur trouvé avec cet email ou mot de passe incorrect.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Plateforme de Gestion de Stages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f7;
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .header h1 {
            font-size: 2.5em;
            font-weight: 700;
            margin: 0;
        }
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            padding: 40px 20px;
            max-width: 400px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
            width: 100%;
        }
        .container h2 {
            font-size: 2em;
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
        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 15px;
        }
        .forgot-password a {
            color: #004d40;
            text-decoration: none;
            font-weight: 600;
        }
        .forgot-password a:hover {
            text-decoration: underline;
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
        <h1>Connexion</h1>
    </header>
    <div class="main-content">
        <div class="container">
            <h2>Se connecter</h2>
            <?php if ($error): ?>
                <div class='alert alert-danger' role='alert'><?php echo htmlspecialchars($error); ?></div>
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
                <button type="submit" class="button">Se connecter</button>
                <div class="forgot-password">
                    <a href="forgot-password.php">Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
</body>
</html>