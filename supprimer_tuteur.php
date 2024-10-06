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

// Traitement du formulaire de suppression de tuteur
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Vérification si l'email existe
    $query = "SELECT COUNT(*) FROM Tuteurs WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $exists = $stmt->fetchColumn();

    if (!$exists) {
        $error = "Aucun tuteur trouvé avec cet email.";
    } else {
        // Suppression du tuteur
        $query = "DELETE FROM Tuteurs WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        
        if ($stmt->execute()) {
            $success = "Tuteur supprimé avec succès !";
        } else {
            $error = "Une erreur est survenue lors de la suppression du tuteur.";
        }
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

        input[type="email"] {
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

    <h2>Retirer un Tuteur</h2>
    <form action="" method="POST">
        <label for="email_retirer">Email:</label>
        <input type="email" id="email_retirer" name="email" required>
        <button type="submit">Retirer</button>
    </form>

    <?php if ($error): ?>
        <div class='alert alert-danger' role='alert'><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class='alert alert-success' role='alert'><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
</section>