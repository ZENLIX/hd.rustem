<?php
include("functions.inc.php");

if (isset($_GET['posada'])) {
    $term = trim(strip_tags(($_GET['term'])));//retrieve the search term that autocomplete sends

    //$qstring = "SELECT id, name FROM posada;";
    //$result = mysql_query($qstring);//query the database for entries containing the term

    //while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    
    		$stmt = $dbConnection->prepare('SELECT id, name FROM posada');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {
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
    $term = trim(strip_tags(($_GET['term'])));//retrieve the search term that autocomplete sends

    /*$qstring = "SELECT id, name FROM units;";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {
    */
    
        		$stmt = $dbConnection->prepare('SELECT id, name FROM units');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {
    
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

    $term = trim(strip_tags(($_GET['term'])));//retrieve the search term that autocomplete sends

    /*$qstring = "SELECT fio as label, id as value FROM users WHERE fio LIKE '%".$term."%' limit 10";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {
    */
    
    
    
        	$stmt = $dbConnection->prepare('SELECT fio as label, id as value FROM users WHERE fio LIKE :term limit 10');
			$stmt->execute(array(':term' => '%'.$term.'%'));
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {
//echo($row['label']);
        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row_set[] = $row;//build an array

    }

    echo json_encode($row_set);//format the array into json data
}




if (isset($_GET['pod'])) {
    $term = trim(strip_tags(($_GET['term'])));//retrieve the search term that autocomplete sends

    /*$qstring = "SELECT name as label, id as value FROM units WHERE name LIKE '%".$term."%' limit 10";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {
    */
            $stmt = $dbConnection->prepare('SELECT name as label, id as value FROM units WHERE name LIKE :term limit 10');
			$stmt->execute(array(':term' => '%'.$term.'%'));
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {
//echo($row['label']);
        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row_set[] = $row;//build an array

    }

    echo json_encode($row_set);//format the array into json data
}

if (isset($_GET['fio'])) {
    $term = trim(strip_tags(($_GET['term'])));//retrieve the search term that autocomplete sends

    /*$qstring = "SELECT fio as label, login as label2, tel as label3, unit_desc as label4, id as value FROM clients WHERE (fio LIKE '%".$term."%') or (login LIKE '%".$term."%') or (tel LIKE '%".$term."%') limit 10";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {*/
    
    
    
    
    
            $stmt = $dbConnection->prepare('SELECT fio as label, login as label2, tel as label3, unit_desc as label4, id as value FROM clients WHERE (fio LIKE :term) or (login LIKE :term2) or (tel LIKE :term3) limit 10');
			$stmt->execute(array(':term' => '%'.$term.'%',':term2' => '%'.$term.'%',':term3' => '%'.$term.'%'));
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {
    
    
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
    $term = trim(strip_tags(($_GET['term'])));//retrieve the search term that autocomplete sends

   /* $qstring = "SELECT login as label, fio as label2, tel as label3, unit_desc as label4, id as value FROM clients WHERE login LIKE '%".$term."%' limit 10";
    $result = mysql_query($qstring);//query the database for entries containing the term

    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
    {*/
    
    
    
    
                $stmt = $dbConnection->prepare('SELECT login as label, fio as label2, tel as label3, unit_desc as label4, id as value FROM clients WHERE login LIKE :term limit 10');
			$stmt->execute(array(':term' => '%'.$term.'%'));
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {
    
    
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