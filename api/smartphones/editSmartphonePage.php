<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Smartphone</title>
        <link rel="stylesheet" href="../../styles/style.css">
    </head>
    <body>
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
                $smartphoneId = isset($_POST['smartphoneId']);

                try {
                    $dsn = "mysql:host=$hostname;port=$port;dbname=$database_name";
                    $pdo = new PDO($dsn, $username, $password);

                    $getSmartphoneQuery = "SELECT sf.Id_features, f.Name_features, sf.Value_Smartphone_Features, s.Name_smartphone , s.Id_smartphone
                                           FROM smartphone_features sf
                                           JOIN features f ON sf.Id_features = f.Id_Features
                                           JOIN smartphone s ON sf.Id_smartphone = s.Id_smartphone
                                           WHERE sf.Id_smartphone = ?";

                    $stmt = $pdo->prepare($getSmartphoneQuery);
                    $stmt->bindParam(1, $smartphoneId, PDO::PARAM_INT);
                    $stmt->execute();
                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                } catch (PDOException $e) {
                    echo "Database error: " . $e->getMessage();
                }
            } else {
                echo "Invalid request";
            }
        ?>

        <form class="editSmartphoneForm" action="./edit_smartphone.php" method="post">
            <?php    
                $smartphoneName = $data[0]["Name_smartphone"]; 
                $smartphoneId = $data[0]["Id_smartphone"]; 

                echo "<div>";
                echo "   <label for='smartphoneName' style='color:blue;'>Smartphone Name</label>";
                echo "   <input type='text' id='smartphoneName' name='smartphoneName' value='$smartphoneName'/>";
                echo "   <input type='hidden' name='smartphoneId' value='$smartphoneId'/>";
                echo "</div>";

                foreach ($data as $row) {
                    $feature_name = str_replace(' ', '',$row["Name_features"]);
                    $feature_value = $row["Value_Smartphone_Features"];
                    $feature_Id = $row["Id_features"];

                    echo '<div>';
                    echo '   <label for="' . $feature_name . '">' . $feature_name . '</label>';
                    echo '   <input type="text" id="' . $feature_Id . '" name="' . $feature_name . '" value="' . $feature_value . '" />';
                    echo '</div>';
                }
            ?>
            <button type="submit" id="EditSmartphoneBtn">Edit SmartPhone</button>
        </form>
    </body>
</html>