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
            $statement = "SELECT * FROM pet_meals AS pmeal
            JOIN pet_info AS pinfo 
            ON pmeal.pet_id = pinfo.id 
            ORDER BY pinfo.name";
            $result = $this->conn->query($statement);

            while ($row = $result->fetch_assoc()) {
                $currentLine = [
                    "id" => $row["id"],
                    "pet_id" => $row["pet_id"],
                    "feed_time" => $row["feed_time"],
                    "name" => $row["name"]
                ];
                array_push($out, $currentLine);
            }
            return $out;
        }

        public function getPetMeals(): array
        {
            $out = [];
            $statement = "SELECT * FROM pet_media AS pmedia
            JOIN pet_info AS pinfo 
            ON pmedia.pet_id = pinfo.id 
            ORDER BY pinfo.id";
            $result = $this->conn->query($statement);

            while ($row = $result->fetch_assoc()) {
                $currentLine = [
                    "id" => $row["id"],
                    "pet_id" => $row["pet_id"],
                    "filename" => $row["filename"],
                    "name" => $row["name"],
                    "description" => $row["description"]
                ];
                array_push($out, $currentLine);
            }
            return $out;
        }

        public function checkExistingUser($param_email) {
            $answer = false;

            try {
                $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $pdo->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $stmt->execute();

                if($stmt->rowCount() == 1) {
                    $answer = true;
                }
              } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
              }
              $conn = null;

            return $answer;
        }

        public function registerUser($param_email, $param_password, $param_fname, $param_mname, $param_lname) {
            try {
                $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $pdo->prepare("INSERT INTO `users` (`email`, `password`, `firstname`, `middlename`, `lastname`) VALUES (:email, :password, :firstname, :middlename, :lastname)");
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->bindParam(":firstname", $param_fname, PDO::PARAM_STR);
                $stmt->bindParam(":middlename", $param_mname, PDO::PARAM_STR);
                $stmt->bindParam(":lastname", $param_lname, PDO::PARAM_STR);
                $stmt->execute();
              } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
              }
              $conn = null;
        }

        private static ?DBManager $instance = null;
        private ?mysqli $conn = null;
        private string $username;
        private string $host;
        private string $password;
        private string $dbName;
    }
    ?>
