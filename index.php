<?php
session_start();

//include("dbconnect.inc.php");
include("functions.inc.php");
include("inc/head.inc.php");
?>



<?php



//echo($_COOKIE['authhash_code']);
$rq=0;
if (isset($_POST['login']) && isset($_POST['password']))
{
    $rq=1;
    $req_url=$_POST['req_url'];
    $rm=$_POST['remember_me'];
//echo $rm;
    $login = $_POST['login'];
    $password = md5($_POST['password']);
    $query = "	SELECT `id`, `login`, `fio`
    			FROM `users`
            	WHERE `login`='{$login}' AND `pass`='{$password}' and `status`='1'
            	LIMIT 1";
    $sql = mysql_query($query) or die(mysql_error());
    if (mysql_num_rows($sql) == 1) {
        $row = mysql_fetch_assoc($sql);



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




if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION);
    session_unset();
    setcookie('authhash_uid', "");
    setcookie('authhash_code', "");
    unset($_COOKIE['authhash_uid']);
    unset($_COOKIE['authhash_code']);
    header("Location: ".$CONF['hostname']);
    //setcookie('id', '', 0, "/");
    //setcookie('ps', '', 0, "/");
    // ТУТ УДАЛИТЬ КУКИ


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
    include 'auth.php';
}
?>