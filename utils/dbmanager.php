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
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public static function getInstance(): DBManager
        {
            if (self::$instance === null) {
                self::$instance = new DBManager();
            }
            return self::$instance;
        }

        public function getFeedingTime(int $userId): array
        {
            $stmt = $this->connection->prepare("SELECT
              pm.id,
              pm.pet_id,
              pm.feed_time,
              pi.name
            FROM
              owned_pets AS op
              JOIN pet_info AS pi ON op.pet_id = pi.id
              AND op.user_id = :user_id
              JOIN pet_meals AS pm ON pm.pet_id = pi.id
            ORDER BY
              pi.name");
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        }

        public function getPetMedia(int $userId): array
        {
            $stmt = $this->connection->prepare("SELECT
              pm.pet_id,
              pm.filename,
              pm.description,
              pi.name
            FROM
              pet_info AS pi
              JOIN owned_pets AS op ON op.pet_id = pi.id
              AND op.user_id = :user_id
              JOIN pet_media AS pm ON pm.pet_id = pi.id
            ORDER BY pi.id");
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;
        }

        private function petMediaExists(int $petId, string $filename): bool
        {
            $stmt = $this->connection->prepare("SELECT
              COUNT(*) as \"count\"
            FROM
              pet_media
            WHERE
              pet_id = :petId
              AND filename = :filename");
            $stmt->bindParam(":petId", $petId, PDO::PARAM_INT);
            $stmt->bindParam(":filename", $filename, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll();

            return $result[0]["count"] !== 0;
        }

        public function insertPetMedia(int $petId, string $filename, string $description): void
        {
            if (self::petMediaExists($petId, $filename)) {
                echo "File already uploaded!";
                return;
            }
            $stmt = $this->connection->prepare("INSERT into
              pet_media (pet_id, filename, description)
            values
              (:petId, :filename, :description)");
            $stmt->bindParam(":petId", $petId, PDO::PARAM_INT);
            $stmt->bindParam(":filename", $filename, PDO::PARAM_STR);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            $stmt->execute();
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

        public function registerUser(string $param_email, string $param_password, string $param_fname, string $param_mname, string $param_lname): void
        {
            try {
                $stmt = $this->connection->prepare("INSERT INTO `users` (`email`, `password`, `firstname`, `middlename`, `lastname`) 
                VALUES (:email, SHA(:password), :firstname, :middlename, :lastname)");
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

        public function checkCredentials(string $param_username, string $param_password): array
        {
            $result = array(
                'id' => 0,
                'email' => "",
                'firstname' => "",
                'middlename' => "",
                'lastname' => ""
            );

            try {
                $stmt = $this->connection->prepare("SELECT `id`, `email`, `firstname`, `middlename`, `lastname`
                FROM `users`
                WHERE `email` = :username AND `password` = SHA(:password)");
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $result = array(
                            'id' => $row["id"],
                            'email' => $row["email"],
                            'firstname' => $row["firstname"],
                            'middlename' => $row["middlename"],
                            'lastname' => $row["lastname"]
                        );
                    }
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            return $result;
        }

        public function addPet(string $param_owner_id, $param_pet_name, string $param_breed, array $param_meal_arr, string $param_restrictions, string $param_medical_history, string $param_relationships): void
        {
            try {
                $stmt = $this->conn->prepare("INSERT INTO `pet_info` (`name`, `breed`, `restrictions`, `medical_history`, `relationships`) VALUES (:name, :breed, :restrictions, :medical_history, :relationships)");
                $stmt->bindParam(":name", $param_pet_name, PDO::PARAM_STR);
                $stmt->bindParam(":breed", $param_breed, PDO::PARAM_STR);
                $stmt->bindParam(":restrictions", $param_restrictions, PDO::PARAM_STR);
                $stmt->bindParam(":medical_history", $param_medical_history, PDO::PARAM_STR);
                $stmt->bindParam(":relationships", $param_relationships, PDO::PARAM_STR);
                $stmt->execute();

                $pet_id = $this->conn->lastInsertId();

                $stmt2 = $this->conn->prepare("INSERT INTO `owned_pets` (`pet_id`, `user_id`) VALUES (:pet_id, :user_id)");
                $stmt2->bindParam(":pet_id", $pet_id, PDO::PARAM_STR);
                $stmt2->bindParam(":user_id", $param_owner_id, PDO::PARAM_STR);
                $stmt2->execute();

                $stmt3 = $this->conn->prepare("INSERT INTO `pet_meals` (`pet_id`, `feed_time`) VALUES (:pet_id, :feed_time)");
                $stmt3->bindParam(":pet_id", $pet_id, PDO::PARAM_STR);
                for ($i = 0; $i < sizeof($param_meal_arr); $i++) {
                    if ($param_meal_arr[$i] != "") {
                        $stmt3->bindParam(":feed_time", $param_meal_arr[$i], PDO::PARAM_STR);
                        $stmt3->execute();
                    }
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        private static ?DBManager $instance = null;
        private ?PDO $connection = null;
        private string $username;
        private string $host;
        private string $password;
        private string $dbName;
    }
    ?>
