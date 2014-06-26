<?php
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
if (isset($_POST['get_client_info'])) {

    $client_id=mysql_real_escape_string($_POST['get_client_info']);



    include("functions.inc.php");
    get_client_info($client_id);



}
if (isset($_POST['new_client_info'])) {
    $fio=mysql_real_escape_string($_POST['new_client_info']);
    $u_l=mysql_real_escape_string($_POST['new_client_login']);
    include("functions.inc.php");
    ?>


    <div id="" class="alert alert-warning alert-dismissable" style="padding: 5px; margin-bottom: 10px;">
        <button style="right: 0px;" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <small>
            <?=lang('msg_creted_new_user');?> <br></small>
    </div>
    <div class="panel panel-success" id="user_info" style="display: block;">
        <div class="panel-body">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="fa fa-user"></i> <?=lang('WORKER_TITLE');?></h4>
            </div>
            <div class="panel-body">




                <table class="table  ">
                    <tbody>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_fio');?>:</small></td>
                        <td><small>
                                <a href="#" id="username" data-type="text" data-pk="1" data-title="Enter username"><?=$fio?></a>
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_login');?>:</small></td>
                        <td><small><a href="#" id="new_login" data-type="text"  data-pk="1" data-title="Enter username"><?=$u_l?></a></small></td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_posada');?>:</small></td>
                        <td><small><a href="#" id="new_posada"  data-type="select" data-source="<?=$CONF['hostname'];?>/json.php?posada" data-pk="1" data-title="<?=lang('WORKER_posada');?>"></a></small></td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_unit');?>:</small></td>
                        <td><small><a href="#" id="new_unit" data-type="select" data-source="<?=$CONF['hostname'];?>/json.php?units" data-pk="1" data-title="<?=lang('NEW_unit');?>"></a></small></td>
                    </tr>

                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_tel');?>:</small></td>
                        <td><small><a href="#" id="new_tel" data-type="text" data-pk="1" data-title="Enter username"></a></small></td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_room');?>:</small></td>
                        <td><small><a href="#" id="new_adr" data-type="text" data-pk="1" data-title="Enter username"></a></small></td>
                    </tr>
                    <tr>
                        <td style=" width: 30px; "><small><?=lang('WORKER_mail');?>:</small></td>
                        <td><small><a href="#" id="new_mail" data-type="text" data-pk="1" data-title="Enter username"></a></small></td>
                    </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
<?php
}
?>