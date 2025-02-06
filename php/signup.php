<?php
// Connexion à la base de données
$host = 'localhost'; // hôte de la base de données
$dbname = 'nom_de_la_base_de_donnees'; // nom de la base de données
$username = 'root'; // utilisateur de la base de données
$password = ''; // mot de passe de la base de données

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['name'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];
    $categorie = $_POST['choice'];
    $checkbox = isset($_POST['checkbox']) ? 1 : 0; // Vérifie si la case a été cochée

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($passwordConf) || $categorie == "0") {
        echo "Tous les champs sont obligatoires.";
    } elseif ($password != $passwordConf) {
        echo "Les mots de passe ne correspondent pas.";
    } elseif ($checkbox != 1) {
        echo "Vous devez accepter la collecte de vos données.";
    } else {
        // Sécuriser le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Préparer la requête d'insertion
        $sql = "INSERT INTO users (nom, prenom, email, password, categorie) VALUES (:nom, :prenom, :email, :password, :categorie)";
        $stmt = $pdo->prepare($sql);

        // Lier les paramètres
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':categorie', $categorie);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Inscription réussie !";
        } else {
            echo "Une erreur est survenue. Veuillez réessayer.";
        }
    }
}
?>