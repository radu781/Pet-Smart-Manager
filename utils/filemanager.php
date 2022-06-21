<?php
include "utils/dbmanager.php";
class FileManager
{
    public function __construct()
    {
        $this->filename = self::formatDate();
    }

    public function exportCSV()
    {
        $this->filename .= ".csv";
        $myfile = fopen($this->filename, "w") or die("Unable to open file!");
        $result = DBManager::getInstance()->getPetsNameAndMeals($_SESSION["id"]);
        $columns = "name,breed,restrictions,medical_history,relationships,feed_time\n";
        fwrite($myfile, $columns);
        foreach ($result as $key) {
            $currentLine = $key["name"] . "," . $key["breed"] . "," . $key["restrictions"] . ",";
            $currentLine .= $key["medical_history"] . "," . $key["relationships"] . "," . $key["feed_time"] . "\n";
            fwrite($myfile, $currentLine);
        }
        fclose($myfile);
        self::setHeaders("/$this->filename");
    }

    public function exportPretty(): string
    {
        $this->filename .= ".pretty";
        $myfile = fopen($this->filename, "w") or die("Unable to open file!");
        $result = DBManager::getInstance()->getPetsNameAndMeals($_SESSION["id"]);
        $columns = "name\tbreed\trestrictions\tmedical_history\trelationships\tfeed_time\n";
        fwrite($myfile, $columns);
        if (sizeof($result) === 0) {
            return "";
        }
        $prevResult = $result[0];
        $currentLine = $prevResult["name"] . "\t" . $prevResult["breed"] . "\t" . $prevResult["restrictions"] . "\t";
        $currentLine .= $prevResult["medical_history"] . "\t" . $prevResult["relationships"] . "\t";
        $currentLine .= $prevResult["feed_time"] . "\n";
        fwrite($myfile, $currentLine);

        for ($i = 1; $i < sizeof($result); $i++) {
            $currentResult = $result[$i];
            if ($prevResult["name"] === $currentResult["name"]) {
                $currentLine = "\t\t\t\t\t\t\t\t\t\t" . $currentResult["feed_time"] . "\n";
            } else {
                $currentLine = $prevResult["name"] . "\t" . $prevResult["breed"] . "\t" . $prevResult["restrictions"] . "\t";
                $currentLine .= $prevResult["medical_history"] . "\t" . $prevResult["relationships"] . "\t";
                $currentLine .= $prevResult["feed_time"] . "\n";
            }

            fwrite($myfile, $currentLine);
            $prevResult = $currentResult;
        }
        fclose($myfile);
        self::setHeaders("/$this->filename");
    }

    private function setHeaders(string $fileUrl): void
    {
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($fileUrl) . "\"");
        header("Location: $this->filename");
        ob_clean();
        flush();
    }

    private function formatDate(): string
    {
        $date = getdate();
        $filename =  DBManager::getInstance()->getUsername($_SESSION["id"]) . "_" . $date["year"] . "-";
        $filename .= $date["mon"] . "-" . $date["mday"] . "_" . $date["hours"] . "-" . $date["minutes"] . "-";
        $filename .= $date["seconds"];
        return $filename;
    }

    private string $filename;
}
