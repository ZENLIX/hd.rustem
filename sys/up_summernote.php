<?php
include_once("../functions.inc.php");
if ($_FILES['file']['name']) {
            if (!$_FILES['file']['error']) {
                $name = md5(time());
                $ext = explode('.', $_FILES['file']['name']);
                $filename = $name . '.' . $ext[1];
                $destination = realpath(dirname(dirname(__FILE__)))."/upload_files/user_content/" . $filename; //change this directory
                $location = $_FILES["file"]["tmp_name"];
                move_uploaded_file($location, $destination);
                echo $CONF['hostname'].'/upload_files/user_content/' . $filename;//change this URL
            }
            else
            {
              echo  $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
            }
        }
        
        ?>