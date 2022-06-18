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
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
            $stmt = $this->conn->prepare("SELECT pmeal.id, pmeal.pet_id, pmeal.feed_time, pinfo.name
            FROM pet_meals AS pmeal
            JOIN pet_info AS pinfo 
            ON pmeal.pet_id = pinfo.id 
            ORDER BY pinfo.name");
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        }

        public function getPetMeals(): array
        {
            $stmt = $this->conn->prepare("SELECT pmedia.pet_id, pmedia.filename, pmedia.description, pinfo.name
            FROM pet_media AS pmedia
            JOIN pet_info AS pinfo 
            ON pmedia.pet_id = pinfo.id 
            ORDER BY pinfo.id");
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        }

        public function checkExistingUser(string $param_email): bool
        {
            try {
                $stmt = $this->connection->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    return true;
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            return false;
        }

        public function registerUser(string $param_email, string $param_password, string $param_fname, string $param_mname, $param_lname)
        {
            try {
                $stmt = $this->conn->prepare("INSERT INTO `users` (`email`, `password`, `firstname`, `middlename`, `lastname`) VALUES (:email, :password, :firstname, :middlename, :lastname)");
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->bindParam(":firstname", $param_fname, PDO::PARAM_STR);
                $stmt->bindParam(":middlename", $param_mname, PDO::PARAM_STR);
                $stmt->bindParam(":lastname", $param_lname, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        private static ?DBManager $instance = null;
        private ?PDO $conn = null;
        private string $username;
        private string $host;
        private string $password;
        private string $dbName;
    }
    ?>
