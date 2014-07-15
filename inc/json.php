<?php
include("../functions.inc.php");

if (isset($_GET['posada'])) {
    $term = trim(strip_tags(($_GET['term'])));
    
    
    		$stmt = $dbConnection->prepare('SELECT id, name FROM posada');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {

        $data[] = array(
            'value' => (int)$row['id'],
            'text'  => $row['name']
        );
        
    }

    echo json_encode($data);
}



if (isset($_GET['units'])) {
    $term = trim(strip_tags(($_GET['term'])));

    
    
        		$stmt = $dbConnection->prepare('SELECT id, name FROM units');
			$stmt->execute();
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {
    

        $data[] = array(
            'value' => (int)$row['id'],
            'text'  => $row['name']
        );
        
    }

    echo json_encode($data);
}






if (isset($_GET['users_do'])) {

    $term = trim(strip_tags(($_GET['term'])));    
        	$stmt = $dbConnection->prepare('SELECT fio as label, id as value FROM users WHERE fio LIKE :term limit 10');
			$stmt->execute(array(':term' => '%'.$term.'%'));
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {

        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row_set[] = $row;

    }

    echo json_encode($row_set);
}




if (isset($_GET['pod'])) {
    $term = trim(strip_tags(($_GET['term'])));
            $stmt = $dbConnection->prepare('SELECT name as label, id as value FROM units WHERE name LIKE :term limit 10');
			$stmt->execute(array(':term' => '%'.$term.'%'));
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {

        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row_set[] = $row;

    }

    echo json_encode($row_set);
}

if (isset($_GET['fio'])) {
    $term = trim(strip_tags(($_GET['term'])));

        
            $stmt = $dbConnection->prepare('SELECT fio as label, login as label2, tel as label3, unit_desc as label4, id as value FROM clients WHERE (fio LIKE :term) or (login LIKE :term2) or (tel LIKE :term3) limit 10');
			$stmt->execute(array(':term' => '%'.$term.'%',':term2' => '%'.$term.'%',':term3' => '%'.$term.'%'));
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {
    
    

        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row['label2']=$row['label2'];
        $row['label3']=$row['label3'];
        $row['label4']=$row['label4'];
        $row_set[] = $row;

    }

    echo json_encode($row_set);
}


if (isset($_GET['login'])) {
    $term = trim(strip_tags(($_GET['term'])));    
    
                $stmt = $dbConnection->prepare('SELECT login as label, fio as label2, tel as label3, unit_desc as label4, id as value FROM clients WHERE login LIKE :term limit 10');
			$stmt->execute(array(':term' => '%'.$term.'%'));
			$res1 = $stmt->fetchAll();
			foreach($res1 as $row) {
    
    

        $row['label']=$row['label'];
        $row['value']=(int)$row['value'];
        $row['label2']=$row['label2'];
        $row['label3']=$row['label3'];
        $row['label4']=$row['label4'];
        $row_set[] = $row;

    }

    echo json_encode($row_set);
}

?>