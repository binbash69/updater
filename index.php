<?php

require_once("Updater.php");

define ("_TMP_DIR_", "/var/www/tmp/");



file_put_contents("tmp/to_be_update.zip", fopen("http://development.joins.ch/updater-test/update_012.zip", 'r'));

$zip = new ZipArchive;
$res = $zip->open('tmp/to_be_update.zip');
if ($res === TRUE) {
  $zip->extractTo('tmp/extract_path/');
  $zip->close();
  
  $startPath = "tmp/extract_path/";
  $rootDir = dirname(__FILE__) . "/";
  

  $updater = Updater::getInstance($startPath);

  echo var_dump($updater->index);

  foreach($updater->index as $file){

    $newfile = str_replace($startPath, $rootDir, $file);
    echo "Aggiornamento " . $file . "<br>";

    copy($file, $newfile);


  }


  die("---");


  
  $files1 = scandir("tmp/extract_path/");
  print_r($files1);


} else {
  echo 'doh!';
}

?>