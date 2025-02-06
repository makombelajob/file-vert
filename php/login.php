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

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];
    $categorie = $_POST['choice'];
    $checkbox = isset($_POST['checkbox']) ? 1 : 0; // Vérifie si la case a été cochée

    // Validation des champs
    if (empty($email) || empty($password) || $categorie == "0") {
        echo "Tous les champs sont obligatoires.";
    } elseif ($checkbox != 1) {
        echo "Vous devez accepter la collecte de vos données.";
    } else {
        // Rechercher l'utilisateur par email
        $sql = "SELECT * FROM users WHERE email = :email AND categorie = :categorie";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':categorie', $categorie);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            echo "Connexion réussie !";
            // Rediriger l'utilisateur vers une page protégée
            // header('Location: dashboard.php');
            header('Location : dashboard.php ');
            exit;
        } else {
            echo "Identifiants incorrects. Veuillez vérifier votre email et votre mot de passe.";
        }
    }
}
?>