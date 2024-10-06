<?php
require_once '../../config/database.php';

class AuthController {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function authenticate($email, $motDePasse) {
        $result = ['success' => false, 'role' => '', 'message' => ''];

        // Vérifier dans la table Etudiants
        $stmt = $this->pdo->prepare("SELECT 'etudiant' AS role, email, mot_de_passe FROM Etudiants WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            // Vérifier dans la table Tuteurs
            $stmt = $this->pdo->prepare("SELECT 'tuteur' AS role, email, mot_de_passe FROM Tuteurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
        }

        if (!$user) {
            // Vérifier dans la table ResponsablesStage
            $stmt = $this->pdo->prepare("SELECT 'responsable' AS role, email, mot_de_passe FROM ResponsablesStage WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
        }

        if ($user) {
            // Vérifier le mot de passe
            if (password_verify($motDePasse, $user['mot_de_passe'])) {
                $result['success'] = true;
                $result['role'] = $user['role'];
            } else {
                $result['message'] = "Email ou mot de passe incorrect.";
            }
        } else {
            $result['message'] = "Email ou mot de passe incorrect.";
        }

        return $result;
    }
}
?>
