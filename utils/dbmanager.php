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
              pi.name, pm.feed_time");
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
            try {
                $stmt->execute();
                $result = $stmt->fetchAll();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return ["id" => "-1", "pet_id" => "-1", "feed_time" => "00:00:00"];
            }
            return $result;
        }

        public function updateFeedingTime(int $id, int $petId, string $feedingTime): void
        {
            $stmt = $this->connection->prepare("UPDATE
              pet_meals as pm
            set
              pm.feed_time = :feedingTime
            where
              pm.id = :id
              and pm.pet_id = :petId");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->bindParam(":petId", $petId, PDO::PARAM_INT);
            try {
                $stmt->bindParam(":feedingTime", $feedingTime, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
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

        public function getFirstPetMedia(int $petId): array
        {
            $stmt = $this->connection->prepare("SELECT
              `filename`
            FROM
              pet_media AS pm
            WHERE
              pm.pet_id =:pet_id
            LIMIT
              1");
            $stmt->bindParam(":pet_id", $petId, PDO::PARAM_INT);
            try {
                $stmt->execute();
                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo "Error $e->getMessage()";
            }
            return [];
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
            try {
                $stmt->bindParam(":filename", $filename, PDO::PARAM_STR);
                $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
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

        public function getUsername(int $userId): string
        {
            $stmt = $this->connection->prepare("SELECT concat(firstname, lastname) as name FROM `users` WHERE `id` = :userId");
            try {
                $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetch()["name"];
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return "";
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
                            'id' => $row["id"]
                        );
                    }
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            return $result;
        }

        public function checkPetOwnership(int $param_owner_id, int $param_pet_id): bool
        {
            $result = false;

            try {
                $stmt = $this->connection->prepare("SELECT `id` FROM `owned_pets` WHERE `user_id` = :user_id AND `pet_id` = :pet_id");
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

        public function addPet(string $param_owner_id, $param_pet_name, string $param_breed, array $param_meal_arr, string $param_restrictions, string $param_medical_history, string $param_relationships): void
        {
            try {
                $stmt = $this->connection->prepare("INSERT INTO `pet_info` (`name`, `breed`, `restrictions`, `medical_history`, `relationships`) VALUES (:name, :breed, :restrictions, :medical_history, :relationships)");
                $stmt->bindParam(":name", $param_pet_name, PDO::PARAM_STR);
                $stmt->bindParam(":breed", $param_breed, PDO::PARAM_STR);
                $stmt->bindParam(":restrictions", $param_restrictions, PDO::PARAM_STR);
                $stmt->bindParam(":medical_history", $param_medical_history, PDO::PARAM_STR);
                $stmt->bindParam(":relationships", $param_relationships, PDO::PARAM_STR);
                $stmt->execute();

                $pet_id = $this->connection->lastInsertId();

                $stmt2 = $this->connection->prepare("INSERT INTO `owned_pets` (`pet_id`, `user_id`) VALUES (:pet_id, :user_id)");
                $stmt2->bindParam(":pet_id", $pet_id, PDO::PARAM_STR);
                $stmt2->bindParam(":user_id", $param_owner_id, PDO::PARAM_STR);
                $stmt2->execute();

                $stmt3 = $this->connection->prepare("INSERT INTO `pet_meals` (`pet_id`, `feed_time`) VALUES (:pet_id, :feed_time)");
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

        public function addGroup(string $param_owner_id, array $param_pets, string $param_name, string $param_invite_hash): void
        {
            try {
                $stmt = $this->connection->prepare("INSERT INTO `groups` (`owner_id`, `name`, `invite_hash`) VALUES (:owner_id, :name, SHA1(:invite_hash))");
                $stmt->bindParam(":owner_id", $param_owner_id, PDO::PARAM_STR);
                $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
                $stmt->bindParam(":invite_hash", $param_invite_hash, PDO::PARAM_STR);
                $stmt->execute();

                $group_id = $this->connection->lastInsertId();

                $stmt2 = $this->connection->prepare("INSERT INTO `group_members` (`group_id`, `user_id`) VALUES (:group_id, :user_id)");
                $stmt2->bindParam(":group_id", $group_id, PDO::PARAM_STR);
                $stmt2->bindParam(":user_id", $param_owner_id, PDO::PARAM_STR);
                $stmt2->execute();

                $stmt3 = $this->connection->prepare("INSERT INTO `group_pet` (`group_id`, `pet_id`) VALUES (:group_id, :pet_id)");
                $stmt3->bindParam(":group_id", $group_id, PDO::PARAM_STR);

                for ($i = 0; $i < sizeof($param_pets); $i++) {
                    $stmt3->bindParam(":pet_id", $param_pets[$i], PDO::PARAM_STR);
                    $stmt3->execute();
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function addUserToGroup(int $userId, string $groupHash): void
        {
            if (self::isUserInGroup($userId, $groupHash)) {
                return;
            }
            $stmt = $this->connection->prepare("INSERT INTO
              group_members (group_id, user_id)
            VALUES
              (
                (
                  SELECT
                    id AS group_id
                  FROM
                    `groups` AS g
                  where
                    g.invite_hash = :group_hash
                ),
                :user_id
              )");
            try {
                $stmt->bindParam(":group_hash", $groupHash, PDO::PARAM_STR);
                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        private function isUserInGroup(int $userId, string $grouphash): bool
        {
            $stmt = $this->connection->prepare("SELECT
              *
            FROM
              group_members AS gm
            WHERE
              gm.group_id = (
                SELECT
                  id AS group_id
                FROM
                  `groups` AS g
                WHERE
                  g.invite_hash = :group_hash
              )
              AND gm.user_id = :user_id");
            try {
                $stmt->bindParam(":group_hash", $grouphash, PDO::PARAM_STR);
                $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
                $stmt->execute();
                return sizeof($stmt->fetchAll()) > 0;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            return false;
        }

        public function getPetName(string $param_pet_id): string
        {
            $result = "";
            try {
                $stmt = $this->connection->prepare("SELECT `name` FROM `pet_info` WHERE `id` = :id");
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

        public function getPetsNameAndMeals(int $userId): array
        {
            $stmt = $this->connection->prepare("SELECT
              pi.name,
              pi.breed,
              pi.restrictions,
              pi.medical_history,
              pi.relationships,
              pm.feed_time
            FROM
              pet_info AS pi
              JOIN owned_pets AS op ON op.pet_id = pi.id
              JOIN pet_meals as pm on pm.pet_id = pi.id
              AND op.user_id = :user_id
            GROUP BY
              pm.feed_time
            ORDER BY
              pm.feed_time");
            $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
            try {
                $stmt->execute();
                $result = $stmt->fetchAll();
            } catch (PDOException $e) {
                echo "Error $e->getMessage()";
                return [];
            }
            return $result;
        }


        /* Sofron */
        /*pets*/
        /* function to return user details */
        public function returnUserData(string $param_id): array
        {
            $result = array(
                'email' => "",
                'firstname' => "",
                'middlename' => "",
                'lastname' => ""
            );
            // create statement to return user's details
            try {
                $stmt = $this->connection->prepare("SELECT `firstname`, `lastname`, `middlename`, `email` FROM `users` WHERE `id` = :id");
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

        /* function to return user's pets' id - used in mypets.php*/
        public function getPets(string $param_id): array
        {
            // create statement to return user's pets' id
            try {
                $stmt = $this->connection->prepare("SELECT `pet_id`, `name` 
                FROM `owned_pets` AS `op` 
                JOIN `pet_info` AS `pi` 
                ON pi.id = op.pet_id and user_id = :id");
                $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function getFriendsPets(string $param_id): array
        {
            try {
                $stmt = $this->connection->prepare("SELECT
                  g.id,
                  g.name,
                  gp.pet_id,
                  pi.name,
                  pi.breed
                FROM
                  group_members AS gm
                  JOIN `groups` AS g ON gm.user_id = :id
                  AND g.id = gm.group_id
                  JOIN group_pet AS gp ON g.id = gp.group_id
                  JOIN pet_info AS pi ON pi.id = gp.pet_id");
                $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        /* function to return pet's name & breed for card - used in mypets.php*/
        public function getPetNameAndBreed(string $param_pet_id): array
        {
            $result = array(
                'name' => "",
                'breed' => ""
            );
            try {
                $stmt = $this->connection->prepare("SELECT `name`, `breed` FROM `pet_info` WHERE `id` = :id");
                $stmt->bindParam(":id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $result["name"] = $row["name"];
                        $result["breed"] = $row["breed"];
                    }
                }

                return $result;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            return $result;
        }

        /* function to return pet's no of meals for card */
        public function getPetNoOfMeals(string $param_pet_id): int
        {
            try {
                $stmt = $this->connection->prepare("SELECT `id` FROM `pet_meals` WHERE `pet_id` = :id");
                $stmt->bindParam(":id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetchAll();
                return sizeof($result);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        /* function to return pet's full data (wihtout no of meals) - used in petdetails.php */
        public function getPetData(string $param_pet_id): array
        {
            $result = array(
                'name' => "",
                'breed' => "",
                'restrictions' => "",
                'medical_history' => "",
                'relationships' => ""
            );
            try {
                $stmt = $this->connection->prepare("SELECT `name`, `breed`, `restrictions`, `medical_history`, `relationships` FROM `pet_info` WHERE `id` = :id");
                $stmt->bindParam(":id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $result["name"] = $row["name"];
                        $result["breed"] = $row["breed"];
                        $result["restrictions"] = $row["restrictions"];
                        $result["medical_history"] = $row["medical_history"];
                        $result["relationships"] = $row["relationships"];
                    }
                }
                return $result;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        /* function to delete pet from every database */
        public function deletePet(string $param_pet_id)
        {
            try {
                /* delete from owned_pets database */
                $stmt = $this->connection->prepare("DELETE FROM `owned_pets` WHERE `pet_id` = :id");
                $stmt->bindParam(":id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            try {
                /* delete from pet_info database */
                $stmt = $this->connection->prepare("DELETE FROM `pet_info` WHERE `pet_id` = :id");
                $stmt->bindParam(":id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            try {
                /* delete from pet_meals database */
                $stmt = $this->connection->prepare("DELETE FROM `pet_meals` WHERE `pet_id` = :id");
                $stmt->bindParam(":id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            try {
                /* delete from pet_media database*/
                $stmt = $this->connection->prepare("DELETE FROM `pet_media` WHERE `pet_id` = :id");
                $stmt->bindParam(":id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            try {
                /* delete from group_pet database */
                $stmt = $this->connection->prepare("DELETE FROM `group_pet` WHERE `pet_id` = :id");
                $stmt->bindParam(":id", $param_pet_id, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }


        /*groups*/
        /* function to return user's groups as admin - used in mygroups.php */
        public function getGroups(string $param_id): array
        {
            // create statement to return user's groups' id
            try {
                $stmt = $this->connection->prepare("SELECT
                  g.id,
                  `invite_hash`,
                  g.name
                FROM
                  `group_members` AS gm
                  JOIN `groups` AS g ON gm.group_id = g.id
                  AND `user_id` = :id");
                $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
                $stmt->execute();

                $result = $stmt->fetchAll();
                return $result;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function getGroupName(string $param_id): string
        {
            $result = "";
            // create statement to return a group name
            try {
                $stmt = $this->connection->prepare("SELECT `name` FROM `groups` WHERE `owner_id` = :id");
                $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
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

        public function getGroupKey(string $param_id): string
        {
            $result = "";
            // create statement to return a group key
            try {
                $stmt = $this->connection->prepare("SELECT `invite_hash` FROM `groups` WHERE `owner_id` = :id");
                $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $result = $row["invite_hash"];
                    }
                }

                return $result;
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
