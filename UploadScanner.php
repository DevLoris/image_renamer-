<?php
class UploadScanner
{
    var $path = "";
    var $server_path = "";
    var $accentList  = array();

    function __construct()
    {
        $this->path = wp_upload_dir()['basedir'];
        $this->server_path = wp_upload_dir()['baseurl'];
        $this->accentList = new AccentList();
    }

    function getFolderList() {
        $list = "";
        foreach (glob($this->path."/*/*/") as $file)
            $list[] = $file;
        return $list;
    }

    function reduceName($file_path) {
        $e = explode('/', $file_path);
        return $e[count($e) - 3] ."-".$e[count($e) - 2];
    }
    function fullName($file_path) {
        $e = explode('-', $file_path);
        foreach ($this->getFolderList() as $list) {
            if(preg_match("{".$e[0]."/".$e[1]."}",$list))
                return $list;
        }
        return null;
    }

    function count($f) {
        return count(glob($f . "*"));
    }
    function brokens($f) {
        $broken = array();
        foreach (glob($f . "*") as $file) {
            if($this->accentList->isBugged($file))
                $broken[]= $file;
        }
        return $broken;
    }

    function execute() {

    }
}