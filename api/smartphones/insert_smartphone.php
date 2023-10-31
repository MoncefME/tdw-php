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

            $smartphoneName = $_POST["smartphoneName"];

            $insertSmartphoneQuery = "INSERT INTO Smartphone (Name_smartphone) VALUES (?)";
            $stmt = $pdo->prepare($insertSmartphoneQuery);
            $stmt->bindParam(1, $smartphoneName);
            $stmt->execute();

            $smartphoneId = $pdo->lastInsertId();

            $query = "SELECT Name_features, Id_Features FROM features";
            $result = $pdo->query($query);
            $features = $result->fetchAll(PDO::FETCH_ASSOC);

            foreach ($features as $feature) {
                $inputId = str_replace(' ', '', $feature["Name_features"]);
                $value = $_POST[$inputId];


                $insertValueQuery = "INSERT INTO Smartphone_Features (Id_Smartphone, Id_Features, Value_Smartphone_Features)
                    VALUES (?, ?, ?)";

                $stmt = $pdo->prepare($insertValueQuery);
                $stmt->bindParam(1, $smartphoneId);
                $stmt->bindParam(2, $feature["Id_Features"]);
                $stmt->bindParam(3, $value);
                $stmt->execute();
            }

            header("Location: ../../admin.php"); 
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>