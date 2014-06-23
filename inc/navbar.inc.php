<?php
function echoActiveClassIfRequestMatches($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
    $file = $_SERVER['REQUEST_URI'];
    $file = explode("?", basename($file));
    $current_file_name=$file[0];

//$file = $_SERVER['REQUEST_URI'];
//$file = explode("?", basename($file));

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}


$newt=get_total_tickets_free();

if ($newt != 0) {
	$newtickets="<span class=\"badge\">".$newt."</span>";
}
if ($newt == 0) {
	$newtickets="";
}


?>
<style>
    .dropdown-submenu{position:relative;}
    .dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
    .dropdown-submenu:hover>.dropdown-menu{display:block;}
    .dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
    .dropdown-submenu:hover>a:after{border-left-color:#ffffff;}
    .dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}
</style>

<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><img src="<?=$CONF['hostname']?>/img/logo.png"> система заявок</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tags"></i> <?=lang('NAVBAR_tickets');?> <?=$newtickets?><b class="caret"></b></a>
                <ul class="dropdown-menu">

            <li <?=echoActiveClassIfRequestMatches("new.php")?>><a href="<?=$CONF['hostname']?>new.php"><i class="fa fa-tag"></i> <?=lang('NAVBAR_create_ticket');?></a></li>
            <li <?=echoActiveClassIfRequestMatches("list.php")?>><a href="<?=$CONF['hostname']?>list.php?in"><i class="fa fa-list-alt"></i> <?=lang('NAVBAR_list_ticket');?> <?=$newtickets?></a></li>
                </ul></li>
            <!--li <?=echoActiveClassIfRequestMatches("message.php")?>><a href=""><i class="fa fa-comments-o"></i> Повідомлення <span class="badge">2</span></a></li>
	  <li <?=echoActiveClassIfRequestMatches("reports.php")?>><a href=""><i class="fa fa-bar-chart-o"></i> Звіти</a></li-->


            <li <?=echoActiveClassIfRequestMatches("clients.php")?>><a href="<?=$CONF['hostname']?>clients.php"><i class="fa fa-users"></i> <?=lang('NAVBAR_workers');?></a></li>
            
            <li <?=echoActiveClassIfRequestMatches("helper.php")?>><a href="<?=$CONF['hostname']?>helper.php"><i class="fa fa-globe"></i> <?=lang('NAVBAR_helper');?></a></li>
            
                        <li <?=echoActiveClassIfRequestMatches("notes.php")?>><a href="<?=$CONF['hostname']?>notes.php"><i class="fa fa-book"></i> <?=lang('NAVBAR_notes');?></a></li>



            <?php  if (validate_admin($_SESSION['helpdesk_user_id'])) { ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-shield"></i> <?=lang('NAVBAR_admin');?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <!--li <?=echoActiveClassIfRequestMatches("clients.php")?> ><a href="clients.php"><i class="fa fa-users"></i> Клієнти</a></li-->
                    <li <?=echoActiveClassIfRequestMatches("users.php")?>><a href="<?=$CONF['hostname']?>users.php?list"><i class="fa fa-users"></i> <?=lang('NAVBAR_users');?></a></li>
                    <li <?=echoActiveClassIfRequestMatches("deps.php")?>><a href="<?=$CONF['hostname']?>inc/deps.php"><i class="fa fa-sitemap"></i> <?=lang('NAVBAR_deps');?></a></li>
                    <li <?=echoActiveClassIfRequestMatches("approve.php")?>><a href="<?=$CONF['hostname']?>approve.php"><i class="fa fa-check-square-o"></i> <?=lang('NAVBAR_approve');?></a></li>
                    
                    <li class="divider"></li>
                                        <li class="dropdown-submenu">
                        <a tabindex="-1" href="#"><i class="fa fa-book"></i> <?=lang('NAVBAR_db');?></a>
                        <ul class="dropdown-menu">
                            <li <?=echoActiveClassIfRequestMatches("posada.php")?> ><a href="<?=$CONF['hostname']?>inc/posada.php"><i class="fa fa-male"></i> <?=lang('NAVBAR_posads');?></a></li>
                            <li <?=echoActiveClassIfRequestMatches("units.php")?>><a href="<?=$CONF['hostname']?>inc/units.php"><i class="fa fa-building-o"></i> <?=lang('NAVBAR_units');?></a></li>
                            <li <?=echoActiveClassIfRequestMatches("subj.php")?>><a href="<?=$CONF['hostname']?>inc/subj.php"><i class="fa fa-tags"></i> <?=lang('NAVBAR_subjs');?></a></li>
                        </ul>
                    </li>

            </li>


        </ul>
        </li>







        <?php } ?>
        </ul>




        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=nameshort(name_of_user_ret($_SESSION['helpdesk_user_id']));?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <!--li <?=echoActiveClassIfRequestMatches("clients.php")?> ><a href="clients.php"><i class="fa fa-users"></i> Клієнти</a></li-->
                    <li <?=echoActiveClassIfRequestMatches("profile.php")?>><a href="<?=$CONF['hostname']?>profile.php"><i class="fa fa-cogs"></i> <?=lang('NAVBAR_profile');?></a></li>
                    <li <?=echoActiveClassIfRequestMatches("help.php")?>><a href="<?=$CONF['hostname']?>help.php"><i class="fa fa-question-circle"></i> <?=lang('NAVBAR_help');?></a></li>
                    <li><a href="<?=$CONF['hostname']?>index.php?logout"><i class="fa fa-sign-out"></i> <?=lang('NAVBAR_logout');?></a></li>
                </ul>
            </li>











        </ul>










    </div><!-- /.navbar-collapse -->
</nav>
