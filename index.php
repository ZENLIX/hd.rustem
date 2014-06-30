<?php
session_start();

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
    //session_regenerate_id();
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
    $rm=mysql_real_escape_string($_POST['remember_me']);
//echo $rm;
    $login = mysql_real_escape_string($_POST['login']);
    $password = md5($_POST['password']);
    /*
    $query = "	SELECT `id`, `login`, `fio`
    			FROM `users`
            	WHERE `login`='{$login}' AND `pass`='{$password}' and `status`='1'
            	LIMIT 1";
    $sql = mysql_query($query) or die(mysql_error());
    */
    $stmt = $dbConnection->prepare('SELECT id,login,fio from users where login=:login AND pass=:pass AND status=1');
    $stmt->execute(array(':login' => $login, ':pass' => $password));
    
    
    if ($stmt -> rowCount() == 1) {
    	$row = $stmt->fetch(PDO::FETCH_ASSOC);



        $_SESSION['helpdesk_user_id'] = $row['id'];
        $_SESSION['helpdesk_user_login'] = $row['login'];
        $_SESSION['helpdesk_user_fio'] = $row['fio'];
        /*
        $_SESSION['helpdesk_sort_prio'] = "none";
        $_SESSION['helpdesk_sort_id'] = "none";
        $_SESSION['helpdesk_sort_subj'] = "none";
        $_SESSION['helpdesk_sort_clientid'] = "none";
        $_SESSION['helpdesk_sort_userinitid'] = "none";
        */

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
        include("inc/head.inc.php");
        include("inc/navbar.inc.php");
        include("dashboard.php");

        include("inc/footer.inc.php");}

}
else {
    include("inc/head.inc.php");
    include 'auth.php';
}
?>
