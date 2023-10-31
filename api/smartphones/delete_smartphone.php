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
        $smartphoneId = isset($_POST['smartphoneId']) ? $_POST['smartphoneId'] : null;

        if (!$smartphoneId) {
            echo "Invalid smartphone ID";
            exit;
        }

        try {
            $dsn = "mysql:host=$hostname;port=$port;dbname=$database_name";
            $pdo = new PDO($dsn, $username, $password);

            $deleteSmartphoneQuery = "DELETE FROM smartphone WHERE Id_smartphone = ?";

            $stmt = $pdo->prepare($deleteSmartphoneQuery);
            $stmt->bindParam(1, $smartphoneId, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                header("Location: ../../admin.php");
            } else {
                echo "Smartphone not found or could not be deleted";
            }

        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "Invalid request";
    }
?>
