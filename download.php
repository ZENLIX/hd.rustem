<?php
$filename = $_GET['filename'];
//$cleanFilename = $_GET['cleanname'];
 // нужен для Internet Explorer, иначе Content-Disposition игнорируется
if(ini_get('zlib.output_compression'))
  ini_set('zlib.output_compression', 'Off');
.
$file_extension = strtolower(substr(strrchr($filename,"."),1));
$cleanFilename = strtolower(substr(strrchr($filename,"-"),1));
if( $filename == "" )
{
          echo "ОШИБКА: не указано имя файла.";
          exit;
} elseif ( ! file_exists( $filename ) ) // проверяем существует ли указанный файл
{
          echo "ОШИБКА: данного файла не существует.";
          exit;
};
switch( $file_extension )
{
          case "pdf": $ctype="application/pdf"; break;
          case "zip": $ctype="application/zip"; break;
          case "doc": $ctype="application/msword"; break;
          case "xls": $ctype="application/vnd.ms-excel"; break;
          case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
          case ".docx": $ctype="application/vnd.openxmlformats-officedocument.wordprocessingml.document"; break;
          case ".pptx": $ctype="application/vnd.openxmlformats-officedocument.presentationml.presentation"; break;
          case ".xlsx": $ctype="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"; break;
          case "mp3": $ctype="audio/mp3"; break;
          case "gif": $ctype="image/gif"; break;
          case "png": $ctype="image/png"; break;..
          case "jpeg":
          case "jpg": $ctype="image/jpg"; break;
          default: $ctype="application/force-download";
}
header("Pragma: public");.
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // нужен для некоторых браузеров
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename=\"".basename($cleanFilename)."\";" );
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filename)); // необходимо доделать подсчет размера файла по абсолютному пути
readfile("$filename");
exit();
?>
