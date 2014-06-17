<?php
include("functions.inc.php");

if (isset($_GET['posada'])) {
    $term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

    $qstring = "SELECT id, name FROM posada;";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {
//echo($row['label']);
        $data[] = array(
            'value' => (int)$row['id'],
            'text'  => $row['name']
        );
        /*
		$row['label']=$row['label'];
		$row['value']=(int)$row['value'];
		$row['label2']=$row['label2'];
		$row['label3']=$row['label3'];
		$row['label4']=$row['label4'];
		$row_set[] = $row;//build an array
		*/
    }

    echo json_encode($data);//format the array into json data
}



if (isset($_GET['units'])) {
    $term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

    $qstring = "SELECT id, name FROM units;";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {
//echo($row['label']);
        $data[] = array(
            'value' => (int)$row['id'],
            'text'  => $row['name']
        );
        /*
		$row['label']=$row['label'];
		$row['value']=(int)$row['value'];
		$row['label2']=$row['label2'];
		$row['label3']=$row['label3'];
		$row['label4']=$row['label4'];
		$row_set[] = $row;//build an array
		*/
    }

    echo json_encode($data);//format the array into json data
}






if (isset($_GET['users_do'])) {

    $term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

    $qstring = "SELECT fio as label, id as value FROM users WHERE fio LIKE '%".$term."%' limit 10";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {
//echo($row['label']);
        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row_set[] = $row;//build an array

    }

    echo json_encode($row_set);//format the array into json data
}




if (isset($_GET['pod'])) {
    $term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

    $qstring = "SELECT name as label, id as value FROM units WHERE name LIKE '%".$term."%' limit 10";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {
//echo($row['label']);
        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row_set[] = $row;//build an array

    }

    echo json_encode($row_set);//format the array into json data
}

if (isset($_GET['fio'])) {
    $term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

    $qstring = "SELECT fio as label, login as label2, tel as label3, unit_desc as label4, id as value FROM clients WHERE (fio LIKE '%".$term."%') or (login LIKE '%".$term."%') or (tel LIKE '%".$term."%') limit 10";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {
//echo($row['label']);
        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row['label2']=$row['label2'];
        $row['label3']=$row['label3'];
        $row['label4']=$row['label4'];
        $row_set[] = $row;//build an array

    }

    echo json_encode($row_set);//format the array into json data
}


if (isset($_GET['login'])) {
    $term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

    $qstring = "SELECT login as label, fio as label2, tel as label3, unit_desc as label4, id as value FROM clients WHERE login LIKE '%".$term."%' limit 10";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {
//echo($row['label']);
        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row['label2']=$row['label2'];
        $row['label3']=$row['label3'];
        $row['label4']=$row['label4'];
        $row_set[] = $row;//build an array

    }

    echo json_encode($row_set);//format the array into json data
}

?>