<?php
include_once("../functions.inc.php");
$rkeys=array_keys($_GET);
$hn=$rkeys[0];
//echo $hn;


    $stmt = $dbConnection->prepare('SELECT original_name,file_type,file_ext, file_size from files where file_hash=:file_hash LIMIT 1');
    $stmt->execute(array(':file_hash' => $hn));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $original_name=$row['original_name'];
    $file_type=$row['file_type'];
    $file_ext=$row['file_ext'];
    $file_size=$row['file_size'];
    //echo($original_name." ".$file_type);
    
    
    
    //echo $original_name;
    if (file_exists("../upload_files/".$hn.".".$file_ext)) {
      header("Content-Type: ".$file_type);
      header("Content-Disposition:  attachment; filename=\"" . $original_name . "\";" );
      header("Content-Transfer-Encoding:  binary");

      header('Content-Length: ' . $file_size);
      ob_clean();
      flush();
      readfile("../upload_files/".$hn.".".$file_ext);
      exit;
          }

?>