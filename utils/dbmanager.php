 <?php
    class DBManager
    {
        private function __construct()
        {
            $settings = parse_ini_file("config/database.ini");
            $this->username = $settings["username"];
            $this->host = $settings["host"];
            $this->password = $settings["password"];
            $this->dbName = $settings["schema"];
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbName);
        }

        public static function getInstance(): DBManager
        {
            if (self::$instance === null) {
                self::$instance = new DBManager();
            }
            return self::$instance;
        }

        public function getFeedingTime(): array
        {
            $out = [];
            $statement = "SELECT * FROM pet_meals";
            $result = $this->conn->query($statement);

            while ($row = $result->fetch_assoc()) {
                $currentLine = ["id" => $row["id"], "pet_id" => $row["pet_id"], "feed_time" => $row["feed_time"]];
                array_push($out, $currentLine);
            }
            return $out;
        }

        private static ?DBManager $instance = null;
        private ?mysqli $conn = null;
        private string $username;
        private string $host;
        private string $password;
        private string $dbName;
    }
    ?>
