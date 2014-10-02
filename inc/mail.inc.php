<?php
include_once('sys/class.phpmailer.php');


function send_mail($to,$subj,$msg) {
	global $CONF, $CONF_MAIL, $dbConnection;
	
	
	if (get_conf_param('mail_type') == "sendmail") {
	
	$mail = new PHPMailer();
	$mail->CharSet 	  = 'UTF-8';
	$mail->IsSendmail();

  $mail->AddReplyTo($CONF_MAIL['from'], $CONF['name_of_firm']);
  $mail->AddAddress($to, $to);
  $mail->SetFrom($CONF_MAIL['from'], $CONF['name_of_firm']);
  $mail->Subject = $subj;
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; 
  $mail->MsgHTML($msg);
  $mail->Send();

}
else if (get_conf_param('mail_type') == "SMTP") {
	
	
	$mail = new PHPMailer();
	$mail->CharSet 	  = 'UTF-8';
	$mail->IsSMTP();
  $mail->SMTPAuth   = $CONF_MAIL['auth'];                  // enable SMTP authentication
if (get_conf_param('mail_auth_type') != "none") 
	{	
		$mail->SMTPSecure = $CONF_MAIL['auth_type'];
	}
$mail->Host       = $CONF_MAIL['host']; 
$mail->Port       = $CONF_MAIL['port'];                  
$mail->Username   = $CONF_MAIL['username'];
$mail->Password   = $CONF_MAIL['password'];   


  $mail->AddReplyTo($CONF_MAIL['from'], $CONF['name_of_firm']);
  $mail->AddAddress($to, $to);
  $mail->SetFrom($CONF_MAIL['from'], $CONF['name_of_firm']);
  $mail->Subject = $subj;
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML($msg);
  $mail->Send();


	
	
}
}



function mailtoactivate($login, $mails, $pass) {
global $CONF, $CONF_MAIL, $dbConnection;
//global $CONF['hostname'];
    $mfrom_name=lang('MAIL_name');
    $mfrom_mail=$CONF_MAIL['from'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From: =?utf-8?B?".base64_encode($mfrom_name) ."?= <$mfrom_mail>\n";

    'Reply-To: '.$CONF_MAIL['from'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $to      = $mails;
    $subject = lang('MAIL_active');
    
    $MAIL_cong=lang('MAIL_cong');
    $MAIL_data=lang('MAIL_data');
    $MAIL_adr=lang('MAIL_adr');
    $MAIL_login=lang('login');
    $MAIL_pass=lang('pass');
    
    $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">{$MAIL_cong}</p>

<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>{$MAIL_data} </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_adr}:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><a href='{$CONF['hostname']}'> {$CONF['hostname']}</a></td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_login}:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$login}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_pass}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$pass}</td>
  </tr> 
</table>
</center>

</div>
EOBODY;





send_mail($to,$subject,$message);


}
function mailtoactivate_admin($login, $mail, $pass) {
global $CONF, $CONF_MAIL, $dbConnection;
    /*$subject = lang('MAIL_active');
    
    
    $MAIL_data=lang('MAIL_data');
    $MAIL_adr=lang('MAIL_adr');
    $MAIL_login=lang('login');
    $MAIL_pass=lang('pass');
    */
    $MAIL_cong=lang('MAIL_cong');
    $MAIL_data=lang('MAIL_data');
    $MAIL_adr=lang('MAIL_adr');
    $MAIL_login=lang('login');
    $MAIL_pass=lang('pass');
    $mfrom_name=lang('MAIL_name');
    $mfrom_mail=$CONF_MAIL['from'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From: =?utf-8?B?".base64_encode($mfrom_name) ."?= <$mfrom_mail>\n";
    'Reply-To: '.$CONF_MAIL['from'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $to      = $CONF['mail'];
    $subject = lang('MAIL_active');
    $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">{$MAIL_cong}</p>

<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>{$MAIL_data} </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_adr}:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><a href='{$CONF['hostname']}'> {$CONF['hostname']}</a></td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_login}:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$login}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_pass}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$pass}</td>
  </tr> 
</table>
</center>

</div>
EOBODY;






send_mail($to,$subject,$message);



}
function send_mail_to($type,$tid) {
global $CONF, $CONF_MAIL, $dbConnection;


    $MAIL_login=lang('login');
    $MAIL_pass=lang('pass');
	$MAIL_new=lang('MAIL_new');
	$MAIL_code=lang('MAIL_code');
	$MAIL_2link=lang('MAIL_2link');
	$MAIL_info=lang('MAIL_info');
	$MAIL_created=lang('MAIL_created');
	$MAIL_to=lang('MAIL_to');
	$MAIL_prio=lang('MAIL_prio');
	$MAIL_worker=lang('MAIL_worker');
	$MAIL_msg=lang('MAIL_msg');
	$MAIL_subj=lang('MAIL_subj');
	$MAIL_text=lang('MAIL_text');
	
    $mfrom_name=lang('MAIL_name');
    $mfrom_mail=$CONF_MAIL['from'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From: =?utf-8?B?".base64_encode($mfrom_name) ."?= <$mfrom_mail>\n";

    'Reply-To: '.$CONF_MAIL['from'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();





    if ($type == "new_all") {

        
        $stmt = $dbConnection->prepare('SELECT user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio,last_update FROM tickets where id=:tid');
        $stmt->execute(array(':tid' => $tid));
        $max_id_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        
        
        
        
        $unit_id=$max_id_ticket['unit_id'];
        $client_id=$max_id_ticket['user_to_id'];
        $user_init_id=$max_id_ticket['user_init_id'];
        $wclient_id=$max_id_ticket['client_id'];
        $s=$max_id_ticket['subj'];
        $m=$max_id_ticket['msg'];
        $h=$max_id_ticket['hash_name'];


        $prio=lang('t_list_a_p_norm');

        if ($max_id_ticket['prio'] == "0") {$prio= lang('t_list_a_p_low'); }
        else if ($max_id_ticket['prio'] == "2") {$prio= lang('t_list_a_p_high'); }



        $uin=name_of_user_ret($user_init_id);
        $nou=name_of_client_ret($wclient_id);
        if ($max_id_ticket['user_to_id'] <> 0 ) {
            $to_text="".name_of_user_ret($client_id)."";
        }
        else if ($max_id_ticket['user_to_id'] == 0 ) {
            $to_text=lang('t_list_a_all')." ".view_array(get_unit_name_return($unit_id));
        }

                        
                        
        $stmt = $dbConnection->prepare('SELECT email, unit, login FROM users where status=:n');
		$stmt->execute(array(':n'=>'1'));
		$res1 = $stmt->fetchAll();                 
        foreach($res1 as $qrow) {                
                        
                        
                        
                        
                        $u=explode(",", $qrow['unit']);
                        
                        foreach ($u as $val) {
                       
							if ($val== $unit_id) {
							//echo $val."==".$unit_id."=".$qrow['email'];
								 if (!is_null($qrow['email'])) {
								 //echo $qrow['email'];
                $to      = $qrow['email'];
                $tl      = $qrow['login'];
                $subject = lang('TICKET_name').' #'.$tid." (".lang('t_list_a_all').") ";
                $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">{$MAIL_new}!</p>
<table width="100%" cellpadding="3" cellspacing="0">
  <tbody>
    <tr id="tr_">
      <td width="15%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_code}:</td>
      <td width="36%" align="center" valign="middle" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 19px;"><b>#{$tid}</b></td>
      <td width="49%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><p style="font-family: Arial, Helvetica, sans-serif; font-size:11px; text-align:center;"> <a href='{$CONF['hostname']}ticket?{$h}'>{$MAIL_2link}</a>.</p></td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>{$MAIL_info} </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_created}:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$uin}</td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_to}:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$to_text}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_prio}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$prio}</td>
  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_worker}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$nou}</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; background-color: #f5f5f5;"><center>
      <strong>{$MAIL_msg}</strong>
    </center></td>
  </tr>
  <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_subj}:</td>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$s}</td>
  </tr>
    <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_text}:</td>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$m}</td>
  </tr>
    <tr>
    <td colspan="5">&nbsp;</td>
  </tr>  
 
</table>
</center>

</div>
EOBODY;









send_mail($to,$subject,$message);


                
            }

							}

						}

                        
                        
						}

        }
    
    if ($type == "new_coord") {

        
		$stmt = $dbConnection->prepare('SELECT user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio,last_update FROM tickets where id=:tid');
	$stmt->execute(array(':tid' => $tid));
	$max_id_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        
        
        
        
        $unit_id=$max_id_ticket['unit_id'];
        $client_id=$max_id_ticket['user_to_id'];
        $user_init_id=$max_id_ticket['user_init_id'];
        $wclient_id=$max_id_ticket['client_id'];
        $s=$max_id_ticket['subj'];
        $m=$max_id_ticket['msg'];
        $h=$max_id_ticket['hash_name'];


        $prio=lang('t_list_a_p_norm');
        if ($max_id_ticket['prio'] == "0") {$prio= lang('t_list_a_p_low'); }
        else if ($max_id_ticket['prio'] == "2") {$prio= lang('t_list_a_p_high'); }


        $uin=name_of_user_ret($user_init_id);
        $nou=name_of_client_ret($wclient_id);
        if ($max_id_ticket['user_to_id'] <> 0 ) {
            $to_text="".name_of_user_ret($client_id)."";
        }
        else if ($max_id_ticket['user_to_id'] == 0 ) {
            $to_text=lang('t_list_a_all')." ".view_array(get_unit_name_return($unit_id));
        }
/////////////////////////////////
/*$qstring = "SELECT email, unit,login FROM users where status='1' and (priv='0' || priv='2');";
$qresult = mysql_query($qstring);//query the database for entries containing the term
while ($qrow = mysql_fetch_array($qresult,MYSQL_ASSOC)) {
*/
                        
        $stmt = $dbConnection->prepare('SELECT email, unit,login FROM users where status=:n and (priv=:n1 || priv=:n2)');
        
		$stmt->execute(array(':n'=>'1',':n1'=>'0',':n2'=>'2'));
		$res1 = $stmt->fetchAll();                 
        foreach($res1 as $qrow) {                         
                        
                        
                        
                        $u=explode(",", $qrow['unit']);
                        
                        foreach ($u as $val) {
                       
							if ($val== $unit_id) {
							//echo $val."==".$unit_id."=".$qrow['email'];
								 if (!is_null($qrow['email'])) {
								 //echo $qrow['login'];
                $to      = $qrow['email'];
                $tl      = $qrow['login'];
                $subject = lang('TICKET_name').' #'.$tid." (".lang('t_LIST_worker_to').")";
                $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">{$MAIL_new}!</p>
<table width="100%" cellpadding="3" cellspacing="0">
  <tbody>
    <tr id="tr_">
      <td width="15%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_code}:</td>
      <td width="36%" align="center" valign="middle" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 19px;"><b>#{$tid}</b></td>
      <td width="49%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><p style="font-family: Arial, Helvetica, sans-serif; font-size:11px; text-align:center;"> <a href='{$CONF['hostname']}ticket?{$h}'>{$MAIL_2link}</a>.</p></td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>{$MAIL_info} </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_created}:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$uin}</td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_to}:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$to_text}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_prio}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$prio}</td>
  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_worker}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$nou}</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; background-color: #f5f5f5;"><center>
      <strong>{$MAIL_msg}</strong>
    </center></td>
  </tr>
  <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_subj}:</td>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$s}</td>
  </tr>
    <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_text}:</td>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$m}</td>
  </tr>
    <tr>
    <td colspan="5">&nbsp;</td>
  </tr>  
 
</table>
</center>

</div>
EOBODY;











send_mail($to,$subject,$message);
            }

							}

						}

                        
                        
						}
						
						
       

    }
    if ($type == "new_user") {


        /*$queryid_ticket="SELECT user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio,last_update FROM tickets where id='$tid'";
        $res1_ticket = mysql_query($queryid_ticket) or die(mysql_error());
        $max_id_ticket= mysql_fetch_assoc( $res1_ticket );
        */
        
        
        
        $stmt = $dbConnection->prepare('SELECT user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio,last_update FROM tickets where id=:tid');
		$stmt->execute(array(':tid'=>$tid));
		$max_id_ticket = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        
        $unit_id=$max_id_ticket['unit_id'];
        $client_id=$max_id_ticket['user_to_id'];
        $user_init_id=$max_id_ticket['user_init_id'];
        $wclient_id=$max_id_ticket['client_id'];
        $s=$max_id_ticket['subj'];
        $m=$max_id_ticket['msg'];
        $h=$max_id_ticket['hash_name'];






        $prio=lang('t_list_a_p_norm');
        if ($max_id_ticket['prio'] == "0") {$prio= lang('t_list_a_p_low'); }
        else if ($max_id_ticket['prio'] == "2") {$prio= lang('t_list_a_p_high'); }



        $uin=name_of_user_ret($user_init_id);
        $nou=name_of_client_ret($wclient_id);
        if ($max_id_ticket['user_to_id'] <> 0 ) {
            $to_text="".name_of_user_ret($client_id)."";
        }
        else if ($max_id_ticket['user_to_id'] == 0 ) {
            $to_text=lang('t_list_a_all')." ".view_array(get_unit_name_return($unit_id));
        }









        //$results = mysql_query("SELECT email from users where id='$client_id' and status='1';");
        //while ($row = mysql_fetch_assoc($results)) {
            
        $stmt = $dbConnection->prepare('SELECT email,login from users where id=:client_id and status=:n and priv=:n1');
		$stmt->execute(array(':n'=>'1',':client_id'=>$client_id,':n1'=>'2'));
		$res1 = $stmt->fetchAll();                 
        foreach($res1 as $row) {     
            
            
            
            
            if (!is_null($row['email'])) {
            
            
            
            
            
                $to      = $row['email'];
                $tl      = $row['login'];
                $subject = lang('TICKET_name').' #'.$tid." (".lang('t_LIST_person').")";
                $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">{$MAIL_new}!</p>
<table width="100%" cellpadding="3" cellspacing="0">
  <tbody>
    <tr id="tr_">
      <td width="15%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_code}:</td>
      <td width="36%" align="center" valign="middle" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 19px;"><b>#{$tid}</b></td>
      <td width="49%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><p style="font-family: Arial, Helvetica, sans-serif; font-size:11px; text-align:center;"><a href='{$CONF['hostname']}ticket?{$h}'>{$MAIL_2link}</a></p></td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>{$MAIL_info} </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_created}:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$uin}</td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_to}:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$to_text}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_prio}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$prio}</td>
  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_worker}:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$nou}</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; background-color: #f5f5f5;"><center>
      <strong>{$MAIL_msg}</strong>
    </center></td>
  </tr>
  <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_subj}:</td>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$s}</td>
  </tr>
    <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$MAIL_text}:</td>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$m}</td>
  </tr>
    <tr>
    <td colspan="5">&nbsp;</td>
  </tr>  
 
</table>
</center>

</div>
EOBODY;



    

send_mail($to,$subject,$message);

        }
        }


    
    
    //echo "dd";
    }



}
?>
