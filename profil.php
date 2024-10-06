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

// Vérification de la session
if (!isset($_SESSION['user_id'])) {
    echo '<p>Erreur : utilisateur non authentifié.</p>';
    die();
}

$user_id = $_SESSION['user_id'];

// Requête pour récupérer les informations de l'étudiant
$query = "SELECT nom, prenom, email, niveau_etude, filiere, cv, lettre_motivation, ecole 
          FROM Etudiants 
          WHERE etudiant_id = :user_id";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

// Récupérer les résultats
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    die("Étudiant non trouvé.");
}

/// Gestion du téléchargement de fichiers
$errors = [];
$success = '';
$uploadDir = 'uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Gestion du CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
        $cvFileName = uniqid('cv_') . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['cv']['name']));
        $cvPath = $uploadDir . $cvFileName;

        // Vérification de l'extension
        $fileType = pathinfo($cvPath, PATHINFO_EXTENSION);
        if (!in_array($fileType, ['pdf', 'doc', 'docx'])) {
            $errors[] = "Le format du CV doit être PDF, DOC ou DOCX.";
        } else {
            // Déplacer le fichier
            if (move_uploaded_file($_FILES['cv']['tmp_name'], $cvPath)) {
                // Mettre à jour le chemin dans la base de données
                $query = "UPDATE Etudiants SET cv = :cv WHERE etudiant_id = :user_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':cv', $cvPath);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                $success = "CV téléchargé avec succès.";
            } else {
                $errors[] = "Erreur lors du téléchargement du CV.";
            }
        }
    }

    // Gestion de la lettre de motivation
    if (isset($_FILES['lettre_motivation']) && $_FILES['lettre_motivation']['error'] == UPLOAD_ERR_OK) {
        $lettreFileName = uniqid('lettre_') . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['lettre_motivation']['name']));
        $lettrePath = $uploadDir . $lettreFileName;

        // Vérification de l'extension
        $fileType = pathinfo($lettrePath, PATHINFO_EXTENSION);
        if (!in_array($fileType, ['pdf', 'doc', 'docx'])) {
            $errors[] = "Le format de la lettre de motivation doit être PDF, DOC ou DOCX.";
        } else {
            // Déplacer le fichier
            if (move_uploaded_file($_FILES['lettre_motivation']['tmp_name'], $lettrePath)) {
                // Mettre à jour le chemin dans la base de données
                $query = "UPDATE Etudiants SET lettre_motivation = :lettre WHERE etudiant_id = :user_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':lettre', $lettrePath);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                $success = "Lettre de motivation téléchargée avec succès.";
            } else {
                $errors[] = "Erreur lors du téléchargement de la lettre de motivation.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Plateforme de Gestion de Stages</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f9f9f9; color: #333; }
        header { background: linear-gradient(135deg, rgba(0, 191, 174, 0.8), rgba(0, 77, 64, 0.8)); color: #fff; padding: 3em 1em; text-align: center; height: 150px; }
        header h1 { margin: 0; font-size: 2.5em; font-weight: 700; }
        nav { display: flex; justify-content: center; background: #004d40; padding: 10px 0; }
        nav a { color: #fff; padding: 15px 20px; text-decoration: none; font-weight: 600; }
        nav a:hover { background: #00bfae; color: #004d40; }
        main { padding: 60px 20px; text-align: center; }
        section { max-width: 800px; margin: 0 auto; }
        .card { margin-bottom: 20px; }
        .card-header { background-color: #004d40; color: #fff; font-weight: bold; }
        footer { background: #004d40; color: #fff; padding: 20px; text-align: center; }
        .btn-primary { background-color: #004d40; border-color: #004d40; }
        .btn-primary:hover { background-color: #00bfae; border-color: #00bfae; }
    </style>
</head>
<body>
    <header>
        <h1>Mon Profil</h1>
    </header>

    <nav>
        <a href="offres.php">Offres de Stage</a>
        <a href="candidature.php">Suivi des Candidatures</a>
        <a href="../auth/logout.php">Déconnexion</a>
    </nav>

    <main>
        <section>
            <h2>Bienvenue, <?php echo htmlspecialchars($etudiant['prenom']) . ' ' . htmlspecialchars($etudiant['nom']); ?>!</h2>

            <div class="alert-container">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (!empty($success)): ?>
                    <div class="alert alert-success">
                        <p><?php echo htmlspecialchars($success); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card">
                <div class="card-header">Informations du Profil</div>
                <div class="card-body">
                    <p><strong>Nom:</strong> <?php echo htmlspecialchars($etudiant['nom']); ?></p>
                    <p><strong>Prénom:</strong> <?php echo htmlspecialchars($etudiant['prenom']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($etudiant['email']); ?></p>
                    <p><strong>Niveau d'étude:</strong> <?php echo htmlspecialchars($etudiant['niveau_etude']); ?></p>
                    <p><strong>Filière:</strong> <?php echo htmlspecialchars($etudiant['filiere']); ?></p>
                    <p><strong>Ecole:</strong> <?php echo htmlspecialchars($etudiant['ecole']); ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Mettre à jour mes documents</div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="cv">Télécharger un nouveau CV (PDF, DOC, DOCX):</label>
                            <input type="file" id="cv" name="cv" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="lettre_motivation">Télécharger une nouvelle lettre de motivation (PDF, DOC, DOCX):</label>
                            <input type="file" id="lettre_motivation" name="lettre_motivation" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Plateforme de Gestion de Stages. Tous droits réservés.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>