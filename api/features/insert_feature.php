<?php
    session_start();
    if (!isset($_SESSION["userName"])) {
        header("Location: ../../auth/unAuthorized.php"); 
        exit;
    }
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database_name = "tdw";
    $port = "3307";

    try {
        $dsn = "mysql:host=$hostname;port=$port;dbname=$database_name";
        $pdo = new PDO($dsn, $username, $password);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $featureName = $_POST["featureName"];

            $insertFeatureQuery = "INSERT INTO Features (Name_Features) VALUES (?)";
            $stmt = $pdo->prepare($insertFeatureQuery);
            $stmt->bindParam(1, $featureName);
            $stmt->execute();

            $featureId = $pdo->lastInsertId();
            $query = "SELECT Name_smartphone FROM Smartphone";
            $result = $pdo->query($query);
            $smartphones = $result->fetchAll(PDO::FETCH_COLUMN);

            foreach ($smartphones as $smartphone) {
                $inputId = str_replace(' ', '', $smartphone);
                $value = $_POST[$inputId];

                $insertValueQuery = "INSERT INTO Smartphone_Features (Id_Smartphone, Id_Features, Value_Smartphone_Features)
                    VALUES ((SELECT Id_smartphone FROM Smartphone WHERE Name_smartphone = :smartphone), :featureId, :value)";

                $stmt = $pdo->prepare($insertValueQuery);
                $stmt->bindParam(':smartphone', $smartphone);
                $stmt->bindParam(':featureId', $featureId);
                $stmt->bindParam(':value', $value);
                $stmt->execute();
            }

            header("Location: ../../admin.php");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>