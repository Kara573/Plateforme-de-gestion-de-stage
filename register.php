<?php
// Inclure le fichier de connexion à la base de données
require '../../config/database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez et assainissez les données du formulaire
    $nom = filter_var(trim($_POST['nom']), FILTER_SANITIZE_STRING);
    $prenom = filter_var(trim($_POST['prenom']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $niveau_etude = filter_var(trim($_POST['niveau_etude']), FILTER_SANITIZE_STRING);
    $filiere = filter_var(trim($_POST['filiere']), FILTER_SANITIZE_STRING);
    $ecole = filter_var(trim($_POST['ecole']), FILTER_SANITIZE_STRING); 
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $confirm_mot_de_passe = trim($_POST['confirm_mot_de_passe']);
    
    // Validation des champs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse email invalide.");
    }
    if ($mot_de_passe !== $confirm_mot_de_passe) {
        die("Les mots de passe ne correspondent pas.");
    }
    if (empty($nom) || empty($prenom) || empty($niveau_etude) || empty($filiere) || empty($ecole)) {
        die("Tous les champs sont requis.");
    }

    // Vérifiez si l'email existe déjà dans la table des étudiants
    $sql_check_email = "SELECT COUNT(*) FROM Etudiants WHERE email = :email";
    $stmt_check = $pdo->prepare($sql_check_email);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->execute();
    $email_exists = $stmt_check->fetchColumn();
    
    if ($email_exists) {
        die("Cette adresse email est déjà utilisée. Veuillez en choisir une autre.");
    }
    
    // Hash le mot de passe
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);
    
    // Préparer la requête d'insertion pour la table Etudiants avec les nouveaux champs
    $sql = "INSERT INTO Etudiants (nom, prenom, email, mot_de_passe, niveau_etude, filiere, ecole) 
            VALUES (:nom, :prenom, :email, :mot_de_passe, :niveau_etude, :filiere, :ecole)";
    
    // Préparer la déclaration
    $stmt = $pdo->prepare($sql);
    
    // Lier les paramètres
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mot_de_passe', $mot_de_passe_hash);
    $stmt->bindParam(':niveau_etude', $niveau_etude);
    $stmt->bindParam(':filiere', $filiere);
    $stmt->bindParam(':ecole', $ecole);
    
    // Exécuter la déclaration
    if ($stmt->execute()) {
        // Rediriger vers la page de connexion après une inscription réussie
        header("Location: ../auth/login.php");
        exit(); // Assurez-vous de terminer le script après la redirection
    } else {
        echo "<div class='alert alert-danger' role='alert'>
                Une erreur est survenue lors de l'inscription. Veuillez réessayer.
              </div>";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Plateforme de Gestion de Stages</title>
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
            height: 150px; /* Ajuste la hauteur du header pour mieux afficher l'image */
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
            padding: 10px 0;
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
        .form-container {
            background: #fff;
            padding: 40px;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            font-size: 2em;
            color: #004d40;
            margin-bottom: 20px;
        }
        .form-container label {
            font-size: 1.2em;
            margin-bottom: 8px;
            color: #333;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
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
        .form-container button:hover {
            background: linear-gradient(135deg, #004d40, #00bfae);
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
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
        <h1>Inscription</h1>
    </header>
    <div class="container">
        <div class="form-container">
            <h2>Inscription</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="niveau_etude">Niveau d'étude</label>
                    <input type="text" id="niveau_etude" name="niveau_etude" required>
                </div>
                <div class="form-group">
                    <label for="filiere">Filière</label>
                    <input type="text" id="filiere" name="filiere" required>
                </div>
                <div class="form-group">
                    <label for="ecole">Ecole</label>
                    <input type="text" id="ecole" name="ecole" required>
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                </div>
                <div class="form-group">
                    <label for="confirm_mot_de_passe">Confirmer le mot de passe</label>
                    <input type="password" id="confirm_mot_de_passe" name="confirm_mot_de_passe" required>
                </div>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Plateforme de Gestion de Stages - Tous droits réservés</p>
    </footer>
</body>
</html>
