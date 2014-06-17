<?php
session_start();
//include("inc/head.inc.php"); 
//include("dbconnect.inc.php");
include("functions.inc.php");
$title_header=lang('LIST_title')." - система заявок";
if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {

    include("inc/head.inc.php");
    include("inc/navbar.inc.php");

    if (isset($_GET['in'])) {
        $status_in="active";
        $priv_val=priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "1") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "2") {$text=$CONF['name_of_firm'];}
        //$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));

    }
    else if (isset($_GET['out'])) {
        $status_out="active";
        $priv_val=priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "1") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "2") {$text=$CONF['name_of_firm'];}
    }
    else if (isset($_GET['arch'])) {
        $status_arch="active";
        $priv_val=priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "1") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "2") {$text=$CONF['name_of_firm'];}
    }
        else if (isset($_GET['find'])) {
        //$status_find="active";
        $priv_val=priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "1") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "2") {$text=$CONF['name_of_firm'];}
    }
    else {
    $_GET['in']='1';
	    $status_in="active";
        $priv_val=priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "1") {$text=get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));}
        else if ($priv_val == "2") {$text=$CONF['name_of_firm'];}
    }


$newt=get_total_tickets_free();

if ($newt != 0) {
	$newtickets="(".$newt.")";
}
if ($newt == 0) {
	$newtickets="";
}
$outt=get_total_tickets_out_and_success();
if ($outt != 0) {
	$out_tickets="(".$outt.")";
}
if ($outt == 0) {
	$out_tickets="";
}
    ?>

    <input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
    <style>
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
            padding: 3px;
        }
        .bold_for_new {
            font-weight: bold;
        }

        .notyCloseButton {
            position: relative;
            float: right;
        }

    </style>
    <div class="container">
        <div class="page-header" style="margin-top: -15px;">


            <div class="row">
                <div class="col-md-4"><h3><i class="fa fa-list-alt"></i> <?=lang('LIST_title');?></h3><span class="text-muted"><small><em><?=$text;?></em></small></span></div>
                <div class="col-md-3" style="padding-top:20px;">
                    <small class="text-muted"><span class="label label-success">&nbsp;</span> - <?=lang('LIST_ok_t');?> </small><br>
                    <small class="text-muted"><span class="label label-warning">&nbsp;</span> - <?=lang('LIST_lock_t_i');?> </small>
                </div>
                <div class="col-md-2" style="padding-top:20px; ">
                    <small class="text-muted"><span class="label label-default">&nbsp;</span> - <?=lang('LIST_lock_t');?> </small>
                </div>

                <div class="col-md-3" style="padding-top:20px;">
                    <form action="list.php" method="get"><div class="input-group">

                            <input name="t" type="text" class="form-control  input-sm" id="input_find" placeholder="<?=lang('LIST_find_ph');?>">
                            <input name="find" type="hidden">
      <span class="input-group-btn">
        <button class="btn btn-default  btn-sm" type="submit" title="Нажмите для поиска" id=""><?=lang('LIST_find_button');?></button>
      </span>

                        </div>

                    </form></div>
            </div>
        </div>

        <div class="btn-group btn-group-justified">
            <a class="btn btn-default btn-sm <?=$status_in?>" role="button" href="list.php?in"><i class="fa fa-download"></i> <?=lang('LIST_in');?> <span id="label_list_in"><?=$newtickets?></span></a>
            <a class="btn btn-default btn-sm <?=$status_out?>" role="button" id="link_out" href="list.php?out"><i class="fa fa-upload"></i> <?=lang('LIST_out');?> <span id="label_list_out"><?=$out_tickets?></span> </a>
            <a class="btn btn-default btn-sm <?=$status_arch?>" role="button" href="list.php?arch"><i class="fa fa-archive"></i> <?=lang('LIST_arch');?></a>
        </div>
        <br>

        <div id="spinner" class="well well-large well-transparent lead">
            <center>
                <i class="fa fa-spinner fa-spin icon-2x"></i> <?=lang('LIST_loading');?> ...
            </center>
        </div>
        <div id="content">


            <?php


            if (isset($_GET['in'])) {
                //echo "in";
                $_POST['menu']="in";
                $_POST['page']="1";
                //$gtp=get_total_pages('in',$user_id);
                include_once("inc/list_content.inc.php");
                ?>



            <?php
            }

            if (isset($_GET['out'])) {
                //echo "out";
                $_POST['menu']="out";
                $_POST['page']="1";
                //$gtp=get_total_pages('out',$user_id);
                include_once("inc/list_content.inc.php");
            }

            if (isset($_GET['arch'])) {
                //echo "out";
                $_POST['menu']="arch";
                $_POST['page']="1";
                //$gtp=get_total_pages('out',$user_id);
                include_once("inc/list_content.inc.php");
            }


            if (isset($_GET['find'])) {
                $_POST['menu']="find";
                include_once("inc/list_content.inc.php");
            }


            ?>


        </div>

        <div id="alert-content"></div>

        <?php
        $nn=get_last_ticket($_POST['menu'],$user_id);
        if ($nn == 0) {


            ?>
            <input type="hidden" id="curent_page" value="null">
            <input type="hidden" id="page_type" value="<?=$_POST['menu']?>">
        <?php


        }
        if ($nn <> 0) { ?>

            <?php if (isset($_GET['in'])) { $r="in";?>
                <div class="">
                    <div class="text-center"><ul id="example_in" class="pagination pagination-sm"></ul></div>
                </div>
            <?php } ?>
            <?php if (isset($_GET['out'])) { $r="out";?>
                <div class="text-center"><ul id="example_out" class="pagination pagination-sm"></ul></div>
            <?php } ?>
            <?php if (isset($_GET['arch'])) { $r="arch";?>
                <div class="text-center"><ul id="example_arch" class="pagination pagination-sm"></ul></div>
            <?php } ?>






            <input type="hidden" id="page_type" value="<?=$r;?>">
            <input type="hidden" id="curent_page" value="1">
            <input type="hidden" id="cur_page" value="1">


            <input type="hidden" id="total_pages" value="<?php echo get_total_pages($_POST['menu'],$user_id); ?>">
            <input type="hidden" id="last_ticket" value="<?=get_last_ticket($_POST['menu'],$user_id);?>">

        <?php } ?>

        <!--div class="col-md-3">
        <small class="text-muted"><span class="label label-default">&nbsp;</span> - заявка, з якою працюють </small><br>
        <small class="text-muted"><span class="label label-warning">&nbsp;</span> - заявка, з якою Ви працюєте </small>
        </div>
        <div class="col-md-3">
        <small class="text-muted"><span class="label label-danger">&nbsp;</span> - не прочитана заявка </small><br>
        <small class="text-muted"><span class="label label-success">&nbsp;</span> - виконана заявка </small>
        </div-->













        <br>
    </div>
    <?php
    include("inc/footer.inc.php");
    ?>

<?php
}
else {
    include 'auth.php';
}
?>