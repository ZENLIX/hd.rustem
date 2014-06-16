<?php
session_start();
include("functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
    if (validate_admin($_SESSION['helpdesk_user_id'])) {
        include("inc/head.inc.php");
        include("inc/navbar.inc.php");


        if (isset($_GET['create'])) {
            $status_create="active";
        }
        if (isset($_GET['list'])) {
            $status_list="active";
        }

        ?>
        <style>
            .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
                padding: 3px;
            }
        </style>


        <div class="container">
            <div class="page-header" style="margin-top: -15px;">
                <div class="row">
                    <div class="col-md-6"> <h3><i class="fa fa-check-square-o"></i> <?=lang('APPROVE_title');?></h3></div>

                </div>
            </div>


            <div class="row" id="content_worker">




                <?php

                $results = mysql_query("select id, fio, tel, login, unit_desc, adr, email, posada, user_from, date_app, client_id from
								approved_info;");
                while ($row = mysql_fetch_assoc($results)) {

                    $tmp_id=$row['client_id'];
                    $results2 = mysql_query("select fio, tel, login, unit_desc, adr, email, posada from clients where id='$tmp_id';");
                    $info= mysql_fetch_assoc( $results2 );


                    ?>



                    <table class="table table-bordered table-hover" style=" font-size: 14px; " id="table_<?=$row['id'];?>">
                        <thead>
                        <tr>
                            <th><center><?=lang('APPROVE_info');?></center></th>

                            <th><center><?=lang('APPROVE_fio');?></center></th>
                            <th><center><?=lang('APPROVE_login');?></center></th>
                            <th><center><?=lang('APPROVE_posada');?></center></th>
                            <th><center><?=lang('APPROVE_unit');?></center></th>
                            <th><center><?=lang('APPROVE_tel');?></center></th>
                            <th><center><?=lang('APPROVE_adr');?></center></th>
                            <th><center><?=lang('APPROVE_mail');?></center></th>
                            <th><center><?=lang('APPROVE_app');?></center></th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td><small><?=lang('APPROVE_orig');?></small></td>

                            <td><small><?=$info['fio'];?></small></td>
                            <td><small><?=$info['login'];?></small></td>
                            <td><small><?=$info['posada'];?></small></td>
                            <td><small><?=$info['unit_desc'];?></small></td>
                            <td><small><?=$info['tel']." ".$info['tel_ext'];?></small></td>
                            <td><small><?=$info['adr'];?></small></td>
                            <td><small><?=$info['email'];?></small></td>
                            <td rowspan="2">
                                <center>
                                    <div class="btn-group-vertical">
                                        <button id="action_aprove_yes" type="button" class="btn btn-success btn-xs" value="<?=$row['id'];?>"><?=lang('APPROVE_yes');?></button>
                                        <button id="action_aprove_no" type="button" class="btn btn-danger btn-xs" value="<?=$row['id'];?>"><?=lang('APPROVE_no');?></button>
                                    </div>
                                </center>

                            </td>
                        </tr>
                        <tr>
                            <td><small><em><?=name_of_user($row['user_from']);?></em> <?=lang('APPROVE_want');?></small></td>

                            <td><small><?=$row['fio'];?></small></td>
                            <td><small><?=$row['login'];?></small></td>
                            <td><small><?=$row['posada'];?></small></td>
                            <td><small><?=$row['unit_desc'];?></small></td>
                            <td><small><?=$row['tel'];?></small></td>
                            <td><small><?=$row['adr'];?></small></td>
                            <td><small><?=$row['email'];?></small></td>

                        </tr>



                        </tbody>
                    </table>
                    <br>
                <?php
                }
                ?>



            </div>




            <br>
        </div>
        <?php
        include("inc/footer.inc.php");
        ?>

    <?php
    }
}
else {
    include 'auth.php';
}
?>