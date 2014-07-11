<?php
include_once("functions.inc.php");
$output_dir = "upload_files/";

$hn=$_POST['hashname'];
$maxsize    = 2097152;





if(isset($_FILES["myfile"]))
{
	$ret = array();

	$error =$_FILES["myfile"]["error"];
	$flag  = false;
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
 	 	$fileName = $_FILES["myfile"]["name"];
 	 	
 	if($_FILES["myfile"]["size"]>$maxsize)
	{
	$flag=true;	
	}
if ((!in_array($_FILES["myfile"]["type"], $acceptable)) && (!empty($_FILES["myfile"]["type"]))) {
    $flag=true;
}
 	 	
 	 	if($flag == false) {
 	 	$fileName1 = $hn."-".$_FILES["myfile"]["name"];
 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName1);
 		
 		//sql insert
 		//$query="insert into files (name, h_name) values ('$fileName1','$hn');";
        //mysql_query($query)or die(mysql_error());
 		$stmt = $dbConnection->prepare('insert into files (name, h_name) values (:fileName1,:hn)');
		$stmt->execute(array(':fileName1'=>$fileName1, ':hn'=>$hn));
 		}
    	$ret[]= $fileName;
	}

    echo json_encode($ret);
 }
 ?>