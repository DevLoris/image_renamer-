<?php
class Renamer {
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu') );
    }

    public function add_admin_menu()
    {
            add_menu_page('Image Renamer', 'Image Renamer', 'update_core',
                'image_renamer', array($this, 'menu_html'), null);


        add_submenu_page(
            'image_renamer',
            'Image Renamer',
            'Image Renamer',
            'update_core',
            'image_renamer',
            array($this, 'menu_html')
        );
    }

    public function menu_html() {
        global $UploadScanner;

        if(!empty($_GET['folder'])) {
            $folder =  $UploadScanner->fullName($_GET['folder']);
            if($folder == null) {

            }
            else {
                echo "<div id='page'>";
                echo "<div class='wrapper-area'>";
                echo "<header><h2>Liste des fichiers corrompus dans $_GET[folder]</h2></header>";
                echo "<article>";

                echo "<table class='widefat'>";

                echo "<thead><tr><th></th><th>Fichiers</th></tr></thead>";


                foreach ($UploadScanner->brokens($folder) as $file) {
                    $imgUrl = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
                    echo "<tr>";
                    echo "<td></td>";
                    echo "<td>";
                    echo "<a href='".get_site_url()."$imgUrl'>".$file."</a>";
                    echo "<br><small> >> ".$UploadScanner->accentList->newName($file)."</small>";
                    echo "<br>";
                    echo "</td>";
                    echo "</tr>";
                }

                echo "</table>";

                echo "</article>";
                echo "</div>";
                echo "</div>";
            }
        }
        else {
            if(isset($_POST['start']) && isset($_POST['image_folder'])) {
                foreach ($_POST['image_folder'] as $ufolder) {
                    $folder =  $UploadScanner->fullName($ufolder);
                    foreach ($UploadScanner->brokens($folder) as $file) {
                        $UploadScanner->accentList->rename($file);
                    }
                    echo '<div class="loimportant">Les fichiers du dossier '.$ufolder.' ont été renommés</div>';
                }
            }


            echo '<form method="post" action="">';
            echo "<div id='page'>";
            echo "<div class='wrapper-area'>";
            echo "<header><h2>Liste des dossiers</h2></header>";
            echo "<article>";

            echo "<table class='widefat'>";

            echo "<thead><tr><th style='text-align: left'><input type=\"checkbox\" onClick=\"toggle(this)\" /></th><th>Dossiers</th></tr></thead>";

            foreach ($UploadScanner->getFolderList() as $file) {
                $re = $UploadScanner->reduceName($file);
                $broken = count($UploadScanner->brokens($file));
                if($broken >= 1) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='image_folder[]' id='folder_$re' value='" . $re . "'></td>";
                    echo "<td>";
                    echo "<label for='folder_$re'><a href='?page=image_renamer&folder=$re'>" . $file . "</a>";
                    echo "<br>";
                    echo "<small>" . $UploadScanner->count($file) . " fichiers dans le dossier</small><br>";
                    echo "<small>" . $broken . " fichiers cassés dans le dossier</small></label>";
                    echo "</td>";
                    echo "</tr>";
                }
            }

            echo "</table>";

            echo "<button class='valid' type='submit' name='start'>Lancer le renommage</button>";

            echo "</article>";
            echo "</div>";
            echo "</div>";

            echo "<script>function toggle(source) {
              checkboxes = document.getElementsByName('image_folder[]');
              for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
              }
            }</script>";
            echo "</form>";
        }

    }
}