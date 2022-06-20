<?php
require_once "utils/dbmanager.php";
require_once "utils/configuration.php";

/* take pet_id */
$pet_id = $_GET["id"];

/* delete pet from tables */
DBManager::getInstance()->deletePet($pet_id);

/* redirect to mypets.php */ 
header("location: mypets.php");
exit;
