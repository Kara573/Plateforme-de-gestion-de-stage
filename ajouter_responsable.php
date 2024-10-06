<?php
// ajouter_responsable.php
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

// Traitement du formulaire d'ajout de responsable
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['role']) && $_POST['role'] === 'responsable_stage') {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO ResponsablesStage (nom, prenom, email, mot_de_passe) VALUES (:nom, :prenom, :email, :mot_de_passe)";
        
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':mot_de_passe' => $mot_de_passe
            ]);
            $success = "Responsable ajouté avec succès.";
        } catch (PDOException $e) {
            $error = 'Échec de l\'ajout : ' . $e->getMessage();
        }
    } else {
        $error = "Le rôle n'est pas spécifié.";
    }
}
?>

<section>
    <style>
        /* Styles globaux pour une cohérence avec les autres pages */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 0 15px;
        }

        h2 {
            color: #004d40;
            border-bottom: 2px solid #004d40;
            padding-bottom: 10px;
        }

        .alert {
            margin: 20px 0;
            border-radius: 4px;
            padding: 10px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        form {
            background: #e0f2f1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        button {
            background-color: #004d40;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #00bfae;
            transform: scale(1.05);
        }
    </style>

    <h2>Ajouter un Responsable de Stage</h2>
    <form action="" method="POST">
        <input type="hidden" name="role" value="responsable_stage"> <!-- Champ caché pour le rôle -->
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="mot_de_passe">Mot de Passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        <button type="submit">Ajouter</button>
    </form>

    <?php if ($error): ?>
        <div class='alert alert-danger' role='alert'><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class='alert alert-success' role='alert'><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
</section>