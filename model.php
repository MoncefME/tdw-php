<?php
require_once("controller.php");

class tdw_model
{
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $database_name = "tdw";
    private $port = "3307";

    private function connect($hostname, $username, $password, $database_name, $port)
    {
        $dsn = "mysql:host=$hostname;port=$port;dbname=$database_name";
        try {
            $c = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
        return $c;
    }

    private function disconnect(&$c)
    {
        $c = null;
    }

    private function requrest($c, $r)
    {
        return $c->query($r);
    }

    public function get_smartphone_table_data()
    {
        $c = $this->connect($this->hostname, $this->username, $this->password, $this->database_name, $this->port);
        $query = "SELECT sf.Value_Smartphone_Features, s.Name_smartphone, f.Name_Features,f.Id_Features,s.Id_smartphone
                  FROM Smartphone_Features sf
                  JOIN Smartphone s ON sf.Id_Smartphone = s.Id_smartphone
                  JOIN Features f ON sf.Id_Features = f.Id_Features";
        $result = $this->requrest($c, $query);
        $this->disconnect($c);
        return $result;
    }
}
