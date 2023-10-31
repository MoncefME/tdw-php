<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="./styles/style.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <script src="./scripts/ajax.js"></script>
      <title>Home Page</title>
  </head>
  <body>
    <?php
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

        echo '<div id="table-refresh"><table border="1" id="phoneTable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Features</th>';
        foreach (array_keys(reset($tableData)) as $smartphoneName) {
          $smartphoneId = $smartphoneIds[$smartphoneName];
          echo "<th>$smartphoneName</th>";
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($tableData as $feature => $smartphones) {
          $featureId = $featureIds[$feature];
          echo "<th>$feature </th>";
          foreach ($smartphones as $value) {
            echo "<td>$value</td>";
          }
          echo '</tr>';
        }

        echo '</tbody>';
        echo '</table></div>';
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
    ?> 
  </body>
</html>