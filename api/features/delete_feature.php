<?php
session_start();
if (!isset($_SESSION["userName"])) {
    header("Location: unAuthorized.php");
    exit;
}

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "tdw";
$port = "3307";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $featureId = isset($_POST['featureId']) ? $_POST['featureId'] : null;
    echo $featureId;

    if (!$featureId) {
        header("HTTP/1.1 400 Bad Request");
        echo "Invalid feature ID";
        exit;
    }

    try {
        $dsn = "mysql:host=$hostname;port=$port;dbname=$database_name";
        $pdo = new PDO($dsn, $username, $password);

        $deleteFeatureQuery = "DELETE FROM Features WHERE Id_Features = :featureId";

        $stmt = $pdo->prepare($deleteFeatureQuery);
        $stmt->bindParam(':featureId', $featureId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: ../../admin.php");
        } else {
            echo "Feature not found or could not be deleted";
        }

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>
