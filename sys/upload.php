<?php
include_once("../functions.inc.php");
$output_dir = "../upload_files/";

$hn=$_POST['hashname'];
$maxsize    = 30097152;





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
 	 	$filetype = $_FILES["myfile"]["type"];
 	 	$filesize = $_FILES["myfile"]["size"];
 	if($_FILES["myfile"]["size"]>$maxsize)
	{
	$flag=true;	
	}
if ((!in_array($_FILES["myfile"]["type"], $acceptable)) && (!empty($_FILES["myfile"]["type"]))) {
    $flag=true;
}
 	 	
 	 	if($flag == false) {
 	 	
 	 	
 	 	$fhash=randomhash();
 	 	$ext = pathinfo($fileName, PATHINFO_EXTENSION);
 	 	$fileName_norm = $fhash.".".$ext;
 	 	
 	 	
 		move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName_norm);
 		
 		
 		$stmt = $dbConnection->prepare('insert into files 
 		(ticket_hash, original_name, file_hash, file_type, file_size, file_ext) values 
 		(:ticket_hash, :original_name, :file_hash, :file_type, :file_size, :file_ext)');
		$stmt->execute(array(
		':ticket_hash'=>$hn, 
		':original_name'=>$fileName,
		':file_hash'=>$fhash,
		':file_type'=>$filetype,
		':file_size'=>$filesize,
		':file_ext'=>$ext
		));
 		}
    	$ret[]= $fileName_norm;
	}

    echo json_encode($ret);
 }
 ?>