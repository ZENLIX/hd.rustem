<?php
session_start();


include_once("conf.php");


if (isset($CONF_DB)) {
    


    
    
    
    
//include("dbconnect.inc.php");
include("functions.inc.php");




if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION);
    session_unset();
    setcookie('authhash_uid', "");
    setcookie('authhash_code', "");
    unset($_COOKIE['authhash_uid']);
    unset($_COOKIE['authhash_code']);
    session_regenerate_id();
    header("Location: ".$CONF['hostname']);
    //setcookie('id', '', 0, "/");
    //setcookie('ps', '', 0, "/");
    // ТУТ УДАЛИТЬ КУКИ


}



//echo($_COOKIE['authhash_code']);
$rq=0;
if (isset($_POST['login']) && isset($_POST['password']))
{


    $rq=1;
    $req_url=$_POST['req_url'];
    $rm=$_POST['remember_me'];
//echo $rm;
    $login = ($_POST['login']);
    $password = md5($_POST['password']);

    $stmt = $dbConnection->prepare('SELECT id,login,fio from users where login=:login AND pass=:pass AND status=1');
    $stmt->execute(array(':login' => $login, ':pass' => $password));
    
    
    if ($stmt -> rowCount() == 1) {
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);


		//session_regenerate_id();
        $_SESSION['helpdesk_user_id'] = $row['id'];
        $_SESSION['helpdesk_user_login'] = $row['login'];
        $_SESSION['helpdesk_user_fio'] = $row['fio'];

        $_SESSION['code'] = md5($password);
        if ($rm == "1") {
        
            setcookie('authhash_uid', $_SESSION['helpdesk_user_id'], time()+60*60*24*7);
            setcookie('authhash_code', $_SESSION['code'], time()+60*60*24*7);
        }
    }
    else {
        $va='error';
    }
}

//if (isset($_SESSION['code']) ) { 
if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
$url = parse_url($CONF['hostname']);

    if ($rq==1) { header("Location: http://".$url['host'].$req_url);}
    if ($rq==0) {
    
    
    if (!isset($_GET['page'])) {        
    
    	include("inc/head.inc.php");
        include("inc/navbar.inc.php");
        include("inc/dashboard.php");
		include("inc/footer.inc.php");
		}
    
    

		
		
		
		
		if (isset($_GET['page'])) {
		
		
		switch($_GET['page']) {
	case 'create': 	include('inc/new.php');		break;
	case 'list': 	include('inc/list.php');	break;
	case 'stats': 	include('inc/stats.php');	break;
	case 'clients': include('inc/clients.php');	break;
	case 'helper': 	include('inc/helper.php');	break;
	case 'notes': 	include('inc/notes.php');	break;
	case 'profile': include('inc/profile.php');	break;
	case 'help': 	include('inc/help.php');	break;
	case 'users': 	include('inc/users.php');	break;
	case 'deps': 	include('inc/deps.php');	break;
	case 'approve': include('inc/approve.php');	break;
	case 'posada': 	include('inc/posada.php');	break;
	case 'units': 	include('inc/units.php');	break;
	case 'subj': 	include('inc/subj.php');	break;
	case 'ticket': 	include('inc/ticket.php');	break;
	case 'userinfo':include('inc/userinfo.php');break;
	case 'config':	include('inc/perf.php');	break;
	case 'files':	include('inc/files.php');	break;
	case 'main_stats':	include('inc/all_stats.php');	break;
	case 'print_ticket': include('inc/print_ticket.php');	break;
	default: include('404.php');
}	
		}
		
		
		}

}
else {
    include("inc/head.inc.php");
    include 'inc/auth.php';
}
} else {
    include "sys/install.php";
}

?>
