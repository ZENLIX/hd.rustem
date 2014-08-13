<?php
session_start();
error_reporting(0);
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {

    include("head.inc.php");
    include("navbar.inc.php");



    ?>
    <input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">

    <div class="container">
        <div class="page-header" style="margin-top: -15px;">
            <div class="row">
                <div class="col-md-6"> <h3><i class="fa fa-users"></i> <?=lang('CLIENTS_name');?></h3></div>
                <div class="col-md-6" style="padding-top: 25px;">


                    <?php

                    if ((priv_status($_SESSION['helpdesk_user_id']) == "0")||(priv_status($_SESSION['helpdesk_user_id']) == "2")) {
                        ?>
                        <input type="text" class="form-control input-sm" id="fio_find_admin" autofocus placeholder="<?=lang('NEW_fio');?>">
                    <?php
                    }
                    if ((priv_status($_SESSION['helpdesk_user_id']) == "1")) {

                        ?>
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" id="fio_find" autofocus placeholder="<?=lang('NEW_fio');?>">
      <span class="input-group-btn">
        <button id="do_find" class="btn btn-default btn-sm" type="submit"><i class="fa fa-search"></i> <?=lang('CLIENTS_find');?></button>
      </span>
                        </div><!-- /input-group -->
                    <?php
                    }
                    ?>


                </div>
            </div>
        </div>


        <div class="row">


            <?php
            $o=true;
            if (isset($_GET['add'])) {
                $o=false;
                $_POST['menu']='new';
                include "workers.inc.php";
                ?>

            <?php }  ?>
            <?php if (isset($_GET['edit'])) {
                $o=false;
                $_POST['menu']='edit';
                include "workers.inc.php";
                ?>

            <?php }
            if ($o == true) {
                ?>

<div class="col-md-3">
      <div class="alert alert-info" role="alert">
	     <small> <i class="fa fa-info-circle"></i> 
<?=lang('WORKERS_info');?>
	     </small>
      </div>
      </div>


                <div class="col-md-9" id="content_worker">

                    <?php
                    $user_id=$_SESSION['helpdesk_user_id'];

                    if ((priv_status($user_id) == "0")||(priv_status($user_id) == "2")) {
                        $_POST['menu']='list';
                        $_POST['page']="1";
                        include "workers.inc.php";

                    }
                    else if (priv_status($user_id) == "1") {


                        ?>

                        <div class="jumbotron">
                            <p>                <center>
                                <i class="fa fa-search"></i> <?=lang('CLIENTS_find_me');?>
                            </center></p>

                        </div>
                    <?php } ?>





                </div>

                <?php  if ((priv_status($user_id) == "0") || (priv_status($user_id) == "2")) { ?>
                    <div class="text-center"><ul id="example_workers" class="pagination pagination-sm"></ul></div>
                    <input type="hidden" id="cur_page" value="1">
                    <input type="hidden" id="total_pages" value="<?=get_total_pages_workers(); ?>">
                <?php } ?>

            <?php }  ?>


        </div>





    </div>




    <br>
    </div>
    <?php
    include("footer.inc.php");
    ?>

<?php
}
else {
    include 'auth.php';
}
?>