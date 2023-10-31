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
        
            $smartphoneId = $_POST["smartphoneId"];
            $smartphoneName = $_POST["smartphoneName"];

            $querySmartphoneName = "UPDATE smartphone SET Name_smartphone=? WHERE Id_smartphone=?;";
            $stmt = $pdo->prepare($querySmartphoneName);
            $stmt->bindParam(1, $smartphoneName);
            $stmt->bindParam(2, $smartphoneId);
            $stmt->execute();


            $query = "SELECT Name_features, Id_Features FROM features";
            $result = $pdo->query($query);
            $features = $result->fetchAll(PDO::FETCH_ASSOC);

            foreach ($features as $feature) {
                $featureName = str_replace(' ', '', $feature["Name_features"]);
                $value = $_POST[$featureName];
                echo $value;
                
                $updateValueQuery = "UPDATE Smartphone_Features SET Value_Smartphone_Features=? WHERE Id_Smartphone=? AND Id_Features=?;";

                $stmt = $pdo->prepare($updateValueQuery);
                $stmt->bindParam(1, $value);
                $stmt->bindParam(2 , $smartphoneId);
                $stmt->bindParam(3, $feature["Id_Features"]);
                $stmt->execute();
            }

        header("Location: ../../admin.php"); 
        
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>