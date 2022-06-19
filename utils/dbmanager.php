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
                $stmt = $this->conn->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
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
                $stmt = $this->conn->prepare("INSERT INTO `users` (`email`, `password`, `firstname`, `middlename`, `lastname`) VALUES (:email, SHA(:password), :firstname, :middlename, :lastname)");
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

        public function checkCredentials($param_username, $param_password): array
        {
            $result = array(
                'id' => 0,
                'email' => "",
                'firstname' => "",
                'middlename' => "",
                'lastname' => ""
            );

            try {
                $stmt = $this->conn->prepare("SELECT `id`, `email`, `firstname`, `middlename`, `lastname` FROM `users` WHERE `email` = :username AND `password` = SHA(:password)");
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $result = array(
                            'id' => $row["id"]
                        );
                    }
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            return $result;
        }

        public function checkPetOwnership($param_owner_id, $param_pet_id): bool
        {
            $result = false;

            try {
                $stmt = $this->conn->prepare("SELECT `id` FROM `owned_pets` WHERE `user_id` = :user_id AND `pet_id` = :pet_id");
                $stmt->bindParam(":user_id", $param_owner_id, PDO::PARAM_STR);
                $stmt->bindParam(":pet_id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    $result = true;
                }

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            return $result;
        }

        public function addPet(string $param_owner_id, $param_pet_name, string $param_breed, array $param_meal_arr, string $param_restrictions, string $param_medical_history, string $param_relationships)
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

        public function addGroup(string $param_owner_id, array $param_pets, string $param_name, string $param_invite_hash) {
            try {
                $stmt = $this->conn->prepare("INSERT INTO `groups` (`owner_id`, `name`, `invite_hash`) VALUES (:owner_id, :name, SHA1(:invite_hash))");
                $stmt->bindParam(":owner_id", $param_owner_id, PDO::PARAM_STR);
                $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
                $stmt->bindParam(":invite_hash", $param_invite_hash, PDO::PARAM_STR);
                $stmt->execute();

                $group_id = $this->conn->lastInsertId();

                $stmt2 = $this->conn->prepare("INSERT INTO `group_members` (`group_id`, `user_id`) VALUES (:group_id, :user_id)");
                $stmt2->bindParam(":group_id", $group_id, PDO::PARAM_STR);
                $stmt2->bindParam(":user_id", $param_owner_id, PDO::PARAM_STR);
                $stmt2->execute();

                $stmt3 = $this->conn->prepare("INSERT INTO `group_pet` (`group_id`, `pet_id`) VALUES (:group_id, :pet_id)");
                $stmt3->bindParam(":group_id", $group_id, PDO::PARAM_STR);

                for ($i = 0; $i < sizeof($param_pets); $i++) {
                    $stmt3->bindParam(":pet_id", $param_pets[$i], PDO::PARAM_STR);
                    $stmt3->execute();
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function getPetName(string $param_pet_id): string
        {
            $result = "";
            try {
                $stmt = $this->conn->prepare("SELECT `name` FROM `pet_info` WHERE `id` = :id");
                $stmt->bindParam(":id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $result = $row["name"];
                    }
                    
                }

                return $result;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        /* functie Session ...TO DO */

        /* functions to return user details */
        public function returnUserData(string $param_id)
        {
            // create statement to return user's details
            try {
                $stmt = $this->conn->prepare("SELECT `firstname`, `lastname`, `middlename`, `email` FROM `users` WHERE `id` = :id");
                $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $result = array(
                            'email' => $row["email"],
                            'firstname' => $row["firstname"],
                            'middlename' => $row["middlename"],
                            'lastname' => $row["lastname"]
                        );
                    }
                }
                return $result;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function getPets(string $param_id)
        {
            // create statement to return user's pets' id
            try {
                $stmt = $this->conn->prepare("SELECT `pet_id` FROM `owned_pets` WHERE `user_id` = :id");
                $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetchAll();
                return $result;
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
