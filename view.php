<?php
require_once("controller.php");
class tdw_view
{
    public function show_website()
    {
        echo "<html>";
        $this->show_page_HEAD();
        $this->show_page_BODY();
        echo "</html>";
    }

    private function show_page_HEAD()
    {
        echo '<head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="style.css">
                <title>Home Page</title>
            </head>';
    }
    private function show_page_BODY()
    {
        echo "<body>";
        $this->show_page_Title();
        $this->show_table();
        $this->show_page_Footer();
        echo "</body>";
    }

    private function show_page_Title()
    {
        echo "<h1>Welcome to the Smarthphone comparater website</h1>";
    }
    private function show_page_Footer()
    {
        echo "<p id='footer'>SIL1 TDW TP-MVC 2023/2024 ESI-Alger</p>";
    }
    private function show_table()
    {
        $ctrl = new  tdw_controller();
        $data = $ctrl->get_smartphone_table();

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
    }
}
