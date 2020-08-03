<?php

class findEmptyFolders {
    private $foldersArray = array();

    function __construct($dir) {
        $array = $this->loop_dir($dir);
        $this->foldersArray = $this->multidimensionalArrayToSingleArray($array);
    }

    private function myscandir($dir) {
        $scandir = scandir($dir);
        foreach ($scandir AS $key => $value) {
            if ($value === "." || $value === "..") {
                unset($scandir[$key]);
            }
        }
        return $scandir;
    }

    private function loop_dir($dir) {
        $scandir = $this->myscandir($dir);
    
        $return = array();
        foreach ($scandir AS $item) {
            if (is_file($dir . "/" . $item)) {
                continue;
            }
            
            if (empty( $this->myscandir($dir . "/" . $item) )) {
                $new_dir = $dir . "/" . $item;
            }
            else {
                $new_dir = $this->loop_dir($dir . "/" . $item);
            }
    
            if (is_string($new_dir) || (is_array($new_dir) && !empty($new_dir))) {
                $return[] = $new_dir;
            }
        }
    
        return $return;
    }

    private $multidimensionalArrayToSingleArray_return = array();
    private function multidimensionalArrayToSingleArray($array = array()) {
        if (is_array($array)) {
            foreach ($array AS $value) {
                if (is_array($value)) {
                    $this->multidimensionalArrayToSingleArray($value);
                }
                else {
                    $this->multidimensionalArrayToSingleArray_return[] = $value;
                }
            }
    
            return $this->multidimensionalArrayToSingleArray_return;
        }
        else {
            return $array;
        }
    }

    public function arrayToHtml($before, $after) {
        foreach ($this->foldersArray AS $value) {
            echo $before . $value . $after;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Find empty folders</title>
        <style>
            p {
                margin: 0;
            }
            h1 {
                margin: 0;
            }
            hr {
                border: 2px solid black;
                margin-top: 30px;
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        
        <?php
            $class = new findEmptyFolders(__DIR__);
            $class->arrayToHtml("<h1>", "</h1>");
            /*$class = new findEmptyFolders(__DIR__ . "/build-cms-dev");
            $class->arrayToHtml("<h1>", "</h1>");
        ?>
        <hr>
        <?php
            $hi = new findEmptyFolders(__DIR__);
            $hi->arrayToHtml("<p>", "</p>");*/
        ?>

    </body>
</html>
