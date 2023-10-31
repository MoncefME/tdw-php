<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartPhone Page</title>
    <link rel="stylesheet" href="./styles/style.css">
  </head>

  <body>
    <h1>Welcome to the smartphone comparator website</h1>
    <a href="auth/logout.php" class="logout">Logout</a>

    <?php
      session_start();

      if (!isset($_SESSION["userName"])) {
        header("Location: auth/unAuthorized.php");
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

        $query = "SELECT sf.Value_Smartphone_Features, s.Name_smartphone, f.Name_Features,f.Id_Features,s.Id_smartphone
                  FROM Smartphone_Features sf
                  JOIN Smartphone s ON sf.Id_Smartphone = s.Id_smartphone
                  JOIN Features f ON sf.Id_Features = f.Id_Features";

        $result = $pdo->query($query);
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        $tableData = [];
        $featureIds = [];
        $smartphoneIds = [];
        foreach ($data as $row) {
          $tableData[$row['Name_Features']][$row['Name_smartphone']] = $row['Value_Smartphone_Features'];
          $featureIds[$row['Name_Features']] = $row['Id_Features'];
          $smartphoneIds[$row['Name_smartphone']] = $row['Id_smartphone'];
        }
        echo '<table border="1" id="phoneTable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Features</th>';
        foreach (array_keys(reset($tableData)) as $smartphoneName) {
          $smartphoneId = $smartphoneIds[$smartphoneName];
          $deleteSmartphoneForm = "<form class='deleteSmartphoneFormH' type='hidden' action='./api/smartphones/delete_smartphone.php' method='post'>
          <input type='hidden' name='smartphoneId' value='$smartphoneId'/>
          <button type='submit' class='delete-button'>Delete</button>
          </form>";
          $editSmartphoneForm = "<form class='editSmartphoneFormH' type='hidden' action='./api/smartphones/editSmartphonePage.php' method='post'>
          <input type='hidden' name='smartphoneId' value='$smartphoneId'/>
          <button type='submit' class='edit-button'>Edit</button>
          </form>";
          echo "<th>$smartphoneName $deleteSmartphoneForm $editSmartphoneForm</th>";
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
      
        foreach ($tableData as $feature => $smartphones) {
          $featureId = $featureIds[$feature];
          $deleteFeatureForm = "<form class='deleteFeatureFormH'type='hidden' action='./api/features/delete_feature.php' method='post'>
          <input type='hidden' name='featureId' value='$featureId'/>
          <button type='submit' class='delete-button'>Delete</button>
          </form>";
          echo '<tr>';
          echo "<th>$feature $deleteFeatureForm </th>";
          foreach ($smartphones as $value) {
            echo "<td>$value</td>";
          } 
          echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    ?>
    <div style="display:flex;">
      <!-- Form to add a feature -->
      <form class="featureForm" action="./api/features/insert_feature.php" method="post">
        <div>
          <label for="featureName" style="color:red;">Feature Name</label>
          <input type="text" id="featureName" name="featureName" />
        </div>

        <?php
        $query = "SELECT Name_smartphone FROM Smartphone";
        $result = $pdo->query($query);
        $smartphones = $result->fetchAll(PDO::FETCH_COLUMN);

        foreach ($smartphones as $smartphone) {
          $inputId = str_replace(' ', '', $smartphone);
          echo '<div>';
          echo '<label for="' . $inputId . '">' . $smartphone . '</label>';
          echo '<input type="text" id="' . $inputId . '" name="' . $inputId . '" />';
          echo '</div>';
        }
        ?>
        <button type="submit" id="addFeatureBtn">Add Feature</button>
      </form>

      <br><br>

      <!-- form to add a smartphone -->
      <form class="smartphoneForm" action="./api/smartphones/insert_smartphone.php" method="post">
        <div>
          <label for="smartphoneName" style="color:blue;">Smartphone Name</label>
          <input type="text" id="smartphoneName" name="smartphoneName" />
        </div>

        <?php
        $query = "SELECT Name_features FROM features";
        $result = $pdo->query($query);
        $features = $result->fetchAll(PDO::FETCH_COLUMN);

        foreach ($features as $feature) {
          $inputId = str_replace(' ', '', $feature);
          echo '<div>';
          echo '<label for="' . $inputId . '">' . $feature . '</label>';
          echo '<input type="text" id="' . $inputId . '" name="' . $inputId . '" />';
          echo '</div>';
        }
        ?>
        <button type="submit" id="addSmartphoneBtn">Add SmartPhone</button>
      </form>
  </body>
</html>