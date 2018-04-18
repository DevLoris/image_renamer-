<?php
class AccentList
{
    var $accents = array("à" => "Ã ",
        "â" => "Ã¢",
        "é" => "Ã©",
        "è" => "Ã¨",
        "ê" => "Ãª",
        "ë" => "Ã«",
        "î" => "Ã®",
        "ï" => "Ã¯",
        "ô" => "Ã´",
        "ö" => "Ã¶",
        "ù" => "Ã¹",
        "û" => "Ã»",
        "ü" => "Ã¼",
        "ç" => "Ã§",
        "œ" => "Å",
        "€" => "â¬",
        "°" => "Â°",
        "À" => "Ã",
        "Â" => "Ã",
        "É" => "Ã",
        "È" => "Ã",
        "Ê" => "Ã",
        "Ë" => "Ã",
        "Î" => "Ã",
        "Ï" => "Ã",
        "Ô" => "Ã",
        "Ö" => "Ã",
        "Ù" => "Ã",
        "Û" => "Ã",
        "Ü" => "Ã",
        "Ç" => "Ã",
        "Œ" => "Å");

    function getBuggedList() {
        return array_values($this->accents);
    }
    function getList() {
        return array_keys($this->accents);
    }
    function getRowBuggedList() {
        return join("|", $this->getBuggedList());
    }
    function isBugged($file_path) {
        $file_name = end(explode("/", $file_path));
        return (preg_match("{(".$this->getRowBuggedList().")}", $file_name));
    }
    function newName($file_path) {
        $file_name = end(explode("/", $file_path));

        foreach ($this->accents as $new => $broken)
            $file_name = str_replace($broken, $new, $file_name);

        return $file_name;
    }
    function rename($file_path) {
        $renamed = explode("/", $file_path);
        array_pop($renamed);

        $renamed[] = $this->newName($file_path);

        rename($file_path, join("/",$renamed));
        return join("/",$renamed);
    }
}