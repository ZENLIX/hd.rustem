<?php
function mailtoactivate($login, $mail, $pass) {
global $CONF;
//global $CONF['hostname'];
    $mfrom_name="Система заявок";
    $mfrom_mail=$CONF['mail'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From: =?utf-8?B?".base64_encode($mfrom_name) ."?= <$mfrom_mail>\n";

    'Reply-To: '.$CONF['mail'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $to      = $mail;
    $subject = 'Обліковий запис активовано!';
    $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">Вітаємо Вас в системі заявок!</p>

<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>Дані </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Адреса:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><a href='{$CONF['hostname']}'> {$CONF['hostname']}</a></td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Логін:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$login}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Пароль:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$pass}</td>
  </tr> 
</table>
</center>

</div>
EOBODY;



    mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $message, $headers);
}
function mailtoactivate_admin($login, $mail, $pass) {
global $CONF;
    $mfrom_name="Система заявок";
    $mfrom_mail=$CONF['mail'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From: =?utf-8?B?".base64_encode($mfrom_name) ."?= <$mfrom_mail>\n";
    'Reply-To: '.$CONF['mail'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $to      = $CONF['mail'];
    $subject = 'Обліковий запис активовано користувачу!';
    $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">Вітаємо Вас в системі заявок!</p>

<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>Дані </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Адреса:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><a href='{$CONF['hostname']}'> {$CONF['hostname']}</a></td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Логін:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$login}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Пароль:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$pass}</td>
  </tr> 
</table>
</center>

</div>
EOBODY;



    mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $message, $headers);
}
function send_mail_to($type,$tid) {
global $CONF;
global $dbConnection;
    $mfrom_name="Система заявок";
    $mfrom_mail=$CONF['mail'];
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= "From: =?utf-8?B?".base64_encode($mfrom_name) ."?= <$mfrom_mail>\n";

    'Reply-To: '.$CONF['mail'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();





    if ($type == "new_all") {

/*
        $queryid_ticket="SELECT user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio,last_update FROM tickets where id='$tid'";
        $res1_ticket = mysql_query($queryid_ticket) or die(mysql_error());
        $max_id_ticket= mysql_fetch_assoc( $res1_ticket );
*/
        
        $stmt = $dbConnection->prepare('SELECT user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio,last_update FROM tickets where id=:tid');
        $stmt->execute(array(':tid' => $tid));
        $max_id_ticket = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $unit_id=$max_id_ticket['unit_id'];
        $client_id=$max_id_ticket['user_to_id'];
        $user_init_id=$max_id_ticket['user_init_id'];
        $wclient_id=$max_id_ticket['client_id'];
        $s=$max_id_ticket['subj'];
        $m=$max_id_ticket['msg'];
        $h=$max_id_ticket['hash_name'];


        $prio="Середній прiорiтет";

        if ($max_id_ticket['prio'] == "0") {$prio= "Низький прiорiтет"; }
        else if ($max_id_ticket['prio'] == "2") {$prio= "Високий прiорiтет"; }



        $uin=name_of_user_ret($user_init_id);
        $nou=name_of_client_ret($wclient_id);
        if ($max_id_ticket['user_to_id'] <> 0 ) {
            $to_text="".name_of_user_ret($client_id)."";
        }
        else if ($max_id_ticket['user_to_id'] == 0 ) {
            $to_text="Всім з ".get_unit_name_return($unit_id);
        }
        /*
        
        ЕСТЬ id заявки
        есть список id пользователей
         name  units
        user1  1,2,3
        user2  1
        user3  2
        user4  1,2
        
        select name from users where id 
        like '%" . $unit_id . "%'
        */
       $qstring = "SELECT email, unit FROM users where status='1';";
        $qresult = mysql_query($qstring);//query the database for entries containing the term

                        while ($qrow = mysql_fetch_array($qresult,MYSQL_ASSOC))//loop through the retrieved values
                        {
                        
                        $u=explode(",", $qrow['unit']);
                        
                        foreach ($u as $val) {
                       
							if ($val== $unit_id) {
							//echo $val."==".$unit_id."=".$qrow['email'];
								 if (!is_null($qrow['email'])) {
								 //echo $qrow['email'];
                $to      = $qrow['email'];
                $subject = 'Заявка #'.$tid." (всім)";
                $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">НОВА ЗАЯВКА!</p>
<table width="100%" cellpadding="3" cellspacing="0">
  <tbody>
    <tr id="tr_">
      <td width="15%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Код заявки:</td>
      <td width="36%" align="center" valign="middle" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 19px;"><b>#{$tid}</b></td>
      <td width="49%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><p style="font-family: Arial, Helvetica, sans-serif; font-size:11px; text-align:center;"> <a href='{$CONF['hostname']}/ticket.php?hash={$h}'>Перейти на сторінку заявки</a>.</p></td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>Інформація </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Створив заявку:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$uin}</td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Кому:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$to_text}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Пріорітет:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$prio}</td>
  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Працівник:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$nou}</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; background-color: #f5f5f5;"><center>
      <strong>Повідомлення</strong>
    </center></td>
  </tr>
  <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Тема:</td>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$s}</td>
  </tr>
    <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Текст:</td>
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



                mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $message, $headers);
                
            }

							}

						}

                        
                        
						}

        }
    
    if ($type == "new_coord") {


        $queryid_ticket="SELECT user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio,last_update FROM tickets where id='$tid'";
        $res1_ticket = mysql_query($queryid_ticket) or die(mysql_error());
        $max_id_ticket= mysql_fetch_assoc( $res1_ticket );
        $unit_id=$max_id_ticket['unit_id'];
        $client_id=$max_id_ticket['user_to_id'];
        $user_init_id=$max_id_ticket['user_init_id'];
        $wclient_id=$max_id_ticket['client_id'];
        $s=$max_id_ticket['subj'];
        $m=$max_id_ticket['msg'];
        $h=$max_id_ticket['hash_name'];


        $prio="Середній прiорiтет";

        if ($max_id_ticket['prio'] == "0") {$prio= "Низький прiорiтет"; }
        else if ($max_id_ticket['prio'] == "2") {$prio= "Високий прiорiтет"; }



        $uin=name_of_user_ret($user_init_id);
        $nou=name_of_client_ret($wclient_id);
        if ($max_id_ticket['user_to_id'] <> 0 ) {
            $to_text="".name_of_user_ret($client_id)."";
        }
        else if ($max_id_ticket['user_to_id'] == 0 ) {
            $to_text="Всім з ".get_unit_name_return($unit_id);
        }
/////////////////////////////////
$qstring = "SELECT email, unit,login FROM users where status='1' and (priv='0' || priv='2');";
        $qresult = mysql_query($qstring);//query the database for entries containing the term

                        while ($qrow = mysql_fetch_array($qresult,MYSQL_ASSOC))//loop through the retrieved values
                        {
                        
                        $u=explode(",", $qrow['unit']);
                        
                        foreach ($u as $val) {
                       
							if ($val== $unit_id) {
							//echo $val."==".$unit_id."=".$qrow['email'];
								 if (!is_null($qrow['email'])) {
								 //echo $qrow['login'];
                $to      = $qrow['email'];
                $subject = 'Заявка #'.$tid." (користувачу)";
                $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">НОВА ЗАЯВКА!</p>
<table width="100%" cellpadding="3" cellspacing="0">
  <tbody>
    <tr id="tr_">
      <td width="15%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Код заявки:</td>
      <td width="36%" align="center" valign="middle" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 19px;"><b>#{$tid}</b></td>
      <td width="49%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><p style="font-family: Arial, Helvetica, sans-serif; font-size:11px; text-align:center;"> <a href='{$CONF['hostname']}/ticket.php?hash={$h}'>Перейти на сторінку заявки</a>.</p></td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>Інформація </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Створив заявку:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$uin}</td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Кому:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$to_text}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Пріорітет:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$prio}</td>
  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Працівник:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$nou}</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; background-color: #f5f5f5;"><center>
      <strong>Повідомлення</strong>
    </center></td>
  </tr>
  <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Тема:</td>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$s}</td>
  </tr>
    <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Текст:</td>
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



                mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $message, $headers);
                
            }

							}

						}

                        
                        
						}
						
						
       

    }
    if ($type == "new_user") {


        $queryid_ticket="SELECT user_init_id,user_to_id,date_create,subj,msg, client_id, unit_id, status, hash_name, prio,last_update FROM tickets where id='$tid'";
        $res1_ticket = mysql_query($queryid_ticket) or die(mysql_error());
        $max_id_ticket= mysql_fetch_assoc( $res1_ticket );
        $unit_id=$max_id_ticket['unit_id'];
        $client_id=$max_id_ticket['user_to_id'];
        $user_init_id=$max_id_ticket['user_init_id'];
        $wclient_id=$max_id_ticket['client_id'];
        $s=$max_id_ticket['subj'];
        $m=$max_id_ticket['msg'];
        $h=$max_id_ticket['hash_name'];






        $prio="Середній прiорiтет";

        if ($max_id_ticket['prio'] == "0") {$prio= "Низький прiорiтет"; }
        else if ($max_id_ticket['prio'] == "2") {$prio= "Високий прiорiтет"; }



        $uin=name_of_user_ret($user_init_id);
        $nou=name_of_client_ret($wclient_id);
        if ($max_id_ticket['user_to_id'] <> 0 ) {
            $to_text="".name_of_user_ret($client_id)."";
        }
        else if ($max_id_ticket['user_to_id'] == 0 ) {
            $to_text="Всім з ".get_unit_name_return($unit_id);
        }









        $results = mysql_query("SELECT email from users where id='$client_id' and status='1';");
        while ($row = mysql_fetch_assoc($results)) {
            if (!is_null($row['email'])) {
                $to      = $row['email'];
                $subject = 'Заявка #'.$tid." (персонально)";
                $message =<<<EOBODY
<div style="background: #ffffff; border: 1px solid gray; border-radius: 6px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; margin: 9px 17px 13px 17px; padding: 11px;">
<p style="font-family: Arial, Helvetica, sans-serif; font-size:18px; text-align:center;">НОВА ЗАЯВКА!</p>
<table width="100%" cellpadding="3" cellspacing="0">
  <tbody>
    <tr id="tr_">
      <td width="15%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Код заявки:</td>
      <td width="36%" align="center" valign="middle" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 19px;"><b>#{$tid}</b></td>
      <td width="49%" style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><p style="font-family: Arial, Helvetica, sans-serif; font-size:11px; text-align:center;"><a href='{$CONF['hostname']}/ticket.php?hash={$h}'>Перейти на сторінку заявки</a></p></td>
    </tr>
  </tbody>
</table>
<br />
<table width="100%" cellspacing="0" cellpadding="3" style="">
  <tr style="border: 1px solid #ddd;">
    <td colspan="2" style="border: 1px solid #ddd; background-color: #f5f5f5; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;"><center>
      <strong>Інформація </strong>
    </center></td>


  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Створив заявку:</td>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$uin}</td>
  </tr>
  <tr>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Кому:</td>
    <td  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$to_text}</td>
  </tr>
    <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Пріорітет:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$prio}</td>
  </tr>
  <tr>
    <td style="border: 1px solid #ddd; font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Працівник:</td>
    <td style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$nou}</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; background-color: #f5f5f5;"><center>
      <strong>Повідомлення</strong>
    </center></td>
  </tr>
  <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Тема:</td>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">{$s}</td>
  </tr>
    <tr>
    <td   style="border: 1px solid #ddd;font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;">Текст:</td>
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



                mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $message, $headers);
            }
        }


    }



}
?>