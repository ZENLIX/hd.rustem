<?php
session_start();
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
//if (validate_admin($_SESSION['helpdesk_user_id'])) {
    include("head.inc.php");
    include("navbar.inc.php");



    ?>
    <div class="container">
        <div class="page-header" style="margin-top: -15px;">
            <h3 ><center><?=lang('HELP_title');?></center></h3>
        </div>


        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="panel ">
                    <div class="panel-body">
                        <center>
                            <img src="img/dc766da5c9e883da26471ca989a4245e.jpg" class="img-responsive img-thumbnail">
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-md-offset-1 col-md-10">













                <ul class="nav nav-tabs">
                    <li class="active"><a href="#home" data-toggle="tab">1. <?=lang('HELP_new');?></a></li>
                    <li><a href="#profile" data-toggle="tab">2. <?=lang('HELP_review');?></a></li>
                    <li><a href="#messages" data-toggle="tab">3. <?=lang('HELP_edit_user');?></a></li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="home"><div class="panel panel-default">
                            
                            <div class="panel-body">

                                <img src="img/75e07fbdbf9d19760d4f365b9a2fe2b6.gif" class="img-responsive img-thumbnail"><br>
                                <?=lang('HELP_new_text');?>

                            </div>

                        </div></div>
                    <div class="tab-pane" id="profile"><div class="panel panel-default">
                            
                            <div class="panel-body">








                                <img src="img/t.png" class="img-responsive img-thumbnail">
                                <br>
                                <?=lang('HELP_review_text');?>

                            </div>
                        </div></div>
                    <div class="tab-pane" id="messages"><div class="panel panel-default">
                            <div class="panel-heading"><?=lang('HELP_edit_user');?></div>
                            <div class="panel-body">
                                <?=lang('HELP_edit_user_text');?>
                            </div></div></div>
                </div>
            </div>




        </div>




        <br>



    </div>
    <?php
    include("inc/footer.inc.php");
    ?>

    <?php
    //}
}
else {
    include 'auth.php';
}
?>
