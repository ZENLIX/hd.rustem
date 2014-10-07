<?php
session_start();
include("../functions.inc.php");
$rkeys=array_keys($_GET);

$CONF['title_header']=lang('TICKET_name')." #".get_ticket_id_by_hash($rkeys[1])." - ".$CONF['name_of_firm'];

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
    
    include("head.inc.php");
    
    $hn=$rkeys[1];
    $stmt = $dbConnection->prepare('SELECT
                           id, user_init_id, user_to_id, date_create, subj, msg, client_id, unit_id, status, hash_name, comment, last_edit, is_read, lock_by, ok_by, arch, ok_date, prio, last_update
                            from tickets
                            where hash_name=:hn');
    $stmt->execute(array(':hn'=>$hn));
    $res1 = $stmt->fetchAll();
    if (!empty($res1)) {
    foreach($res1 as $row) {
            $to_text = name_of_user_ret($row['user_to_id']);
            $date_today = date("d.m.Y");

            ?>
      <script>
    //window.print();
    </script>

   <div style="padding-top:100px;margin-right:50px;text-align:right;">
   <?=lang('TICKET_t_from');?>: <?=name_of_user($row['user_init_id'])?><br>
   <?=lang('TICKET_t_to');?>: <?=$to_text;?>
   </div>
    <div style="margin-left:50px;margin-right:50px;padding-top:100px;">
    <center><h3><?=lang('TICKET_name');?></h3></center>

                <table>
                    <tbody>
                    <tr>
                        <td style=" padding: 20px; " colspan="2"><?=$row['msg']?></td>
                    </tr>
                    </tbody>
                </table>
    <div style="padding-top:50px;margin-right:50px;text-align:right;">
    <?=$date_today?>
    </div>
    <div style="padding-top:50px;margin-right:50px;text-align:right;">
    <?=name_of_user($row['user_init_id'])?>  / __________________________
   </div>
        <?php
    }
    
    }
    else {
        ?>
        <div class="well well-large well-transparent lead">
            <center><?=lang('TICKET_t_no');?></center>
        </div>
    <?php
    }

    ?>

<?php
}
else {
    include 'auth.php';
}
?>
