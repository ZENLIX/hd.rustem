<?php
session_start();
include_once("functions.inc.php");
$CONF['title_header'] = lang('LIST_title') . " - ".lang('MAIN_TITLE');
if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {

    include("head.inc.php");
    include("navbar.inc.php");

    if (isset($_GET['in'])) {
        $status_in = "active";
        $priv_val = priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "1") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "2") {
            $text = $CONF['name_of_firm'];
        }

    } else if (isset($_GET['out'])) {
        $status_out = "active";
        $priv_val = priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "1") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "2") {
            $text = $CONF['name_of_firm'];
        }
    } else if (isset($_GET['arch'])) {
        $status_arch = "active";
        $priv_val = priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "1") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "2") {
            $text = $CONF['name_of_firm'];
        }
    } else if (isset($_GET['find'])) {
        //$status_find="active";
        $priv_val = priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "1") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "2") {
            $text = $CONF['name_of_firm'];
        }
    } else {
        $_GET['in'] = '1';
        $status_in = "active";
        $priv_val = priv_status($_SESSION['helpdesk_user_id']);
        if ($priv_val == "0") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "1") {
            $text = get_unit_name_return(unit_of_user($_SESSION['helpdesk_user_id']));
        } else if ($priv_val == "2") {
            $text = $CONF['name_of_firm'];
        }
    }


    $newt = get_total_tickets_free();

    if ($newt != 0) {
        $newtickets = "(" . $newt . ")";
    }
    if ($newt == 0) {
        $newtickets = "";
    }
    $outt = get_total_tickets_out_and_success();
    if ($outt != 0) {
        $out_tickets = "(" . $outt . ")";
    }
    if ($outt == 0) {
        $out_tickets = "";
    }
    ?>

    <input type="hidden" id="main_last_new_ticket" value="<?= get_last_ticket_new($_SESSION['helpdesk_user_id']); ?>">

    <div class="container">
        <div class="page-header" style="margin-top: -15px;">


            <div class="row">
                <div class="col-md-3"><h3><i class="fa fa-list-alt"></i> <?= lang('LIST_title'); ?></h3><span
                        class="text-muted">
                        
                        
                        <small>
                        	<em>
                        	<?php if ($priv_val != "2") { ?>
								<span data-toggle="tooltip" data-placement="right" title="<?=view_array($text); ?>"><?=lang('LIST_pin')?>: <?=count($text); ?>
								</span>
								<?php }
								else if ($priv_val == "2") { echo $text; } ?>
							</em>
                        </small>
                        </span></div>
                        
                        
                <div class="col-md-3" style="padding-top:20px;">
                   
                    <small class="text-muted">
                    <span class="label label-success">&nbsp;</span>
                        - <?= lang('LIST_ok_t'); ?> 
                    </small>
                    
                    <br>
                    
                    <small class="text-muted">
                    <span class="label label-warning">&nbsp;</span>
                        - <?= lang('LIST_lock_t_i'); ?> 
                    </small>
                        
                        
                        
                </div>
                <div class="col-md-3" style="padding-top:20px; ">
                    <small class="text-muted"><span class="label label-default">&nbsp;</span>
                        - <?= lang('LIST_lock_t'); ?> </small>
                    <br>
                    &nbsp;#
                    <small class="text-muted"> - <?= lang('LIST_lock_n'); ?> </small>
                </div>
                
                
                
                
                

                <div class="col-md-3" style="padding-top:20px;">
                    <form action="<?=$CONF['hostname'];?>list" method="get">
                        <div class="input-group">

                            <input name="t" type="text" class="form-control  input-sm" id="input_find" data-toggle="tooltip" data-placement="bottom" title="<?= lang('LIST_find_ph'); ?>">
                              <input name="find" type="hidden">
      <span class="input-group-btn">
        <button class="btn btn-default  btn-sm" type="submit" title="Нажмите для поиска"
                id=""><?= lang('LIST_find_button'); ?></button>
      </span>

                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="btn-group btn-group-justified">
            <a class="btn btn-default btn-sm <?= $status_in ?>" role="button" href="?in"><i
                    class="fa fa-download"></i> <?= lang('LIST_in'); ?> <span
                    id="label_list_in"><?= $newtickets ?></span></a>
            <a class="btn btn-default btn-sm <?= $status_out ?>" role="button" id="link_out" href="?out"><i
                    class="fa fa-upload"></i> <?= lang('LIST_out'); ?> <span
                    id="label_list_out"><?= $out_tickets ?></span> </a>
            <a class="btn btn-default btn-sm <?= $status_arch ?>" role="button" href="?arch"><i
                    class="fa fa-archive"></i> <?= lang('LIST_arch'); ?></a>
        </div>
        <br>

        <div id="spinner" class="well well-large well-transparent lead">
            <center>
                <i class="fa fa-spinner fa-spin icon-2x"></i> <?= lang('LIST_loading'); ?> ...
            </center>
        </div>
        <div id="content">


            <?php


            if (isset($_GET['in'])) {
                $_POST['menu'] = "in";
                $_POST['page'] = "1";
                include_once("list_content.inc.php");
                ?>



            <?php
            }

            if (isset($_GET['out'])) {
                $_POST['menu'] = "out";
                $_POST['page'] = "1";
                include_once("list_content.inc.php");
            }

            if (isset($_GET['arch'])) {
                $_POST['menu'] = "arch";
                $_POST['page'] = "1";
                include_once("list_content.inc.php");
            }


            if (isset($_GET['find'])) {
                $_POST['menu'] = "find";
                include_once("list_content.inc.php");
            }


            ?>


        </div>

        <div id="alert-content"></div>

        <?php
        
			
			
			if (isset($_GET['in'])) {
                $r = "in"; 
                
        if (isset($_SESSION['hd.rustem_list_in'])) {
	      
	      
	      switch($_SESSION['hd.rustem_list_in']) {
	case '10': 	$ac['10']="active";		break;
	case '15': 	$ac['15']="active";		break;
	case '20': 	$ac['20']="active";		break;
	default: $ac['10']="active";
}	
        }
        
        if (isset($_SESSION['hd.rustem_sort_in'])) {
	      
	      
	      switch($_SESSION['hd.rustem_sort_in']) {
	case 'ok': 		$button_sort_in['ok']="active";		break;
	case 'free': 	$button_sort_in['free']="active";		break;
	case 'ilock': 	$button_sort_in['ilock']="active";		break;
	case 'lock': 	$button_sort_in['lock']="active";		break;
	default: $button_sort_in['main']="active";
}	
        }

                ?>
                
                
                    <div class="">
                    <div class="pull-left">
                    
<div class="btn-group btn-group-xs">
  
  <button  id="sort_list" value="main" type="button" class="btn btn-primary <?=$button_sort_in['main'];?>" data-toggle="tooltip" data-placement="bottom" title="<?=lang('ticket_sort_def')?>"><i class="fa fa-home"></i> </button>
  
    <button  id="sort_list" value="free" data-toggle="tooltip" data-placement="bottom" title="<?=lang('STATS_t_free')?>" type="button" class="btn btn-info <?=$button_sort_in['free'];?>"><i class="fa fa-circle-thin"></i> </button>
    
  <button  id="sort_list" value="ok" data-toggle="tooltip" data-placement="bottom" title="<?=lang('ticket_sort_ok')?>" type="button" class="btn btn-success <?=$button_sort_in['ok'];?>"><i class="fa fa-check-circle"></i> </button>
  
  <button  id="sort_list" value="ilock" data-toggle="tooltip" data-placement="bottom" title="<?=lang('ticket_sort_ilock')?>" type="button" class="btn btn-warning <?=$button_sort_in['ilock'];?>"><i class="fa fa-gavel"></i> </button>
  
  <button  id="sort_list" value="lock" data-toggle="tooltip" data-placement="bottom" title="<?=lang('ticket_sort_lock')?>" type="button" class="btn btn-default <?=$button_sort_in['lock'];?>"><i class="fa fa-gavel"></i> </button>

</div>
                    
                    
                    
                                        </div>
                    <div class="text-center">
                        
                    
                        
                        <ul id="example_in" class="pagination pagination-sm"></ul>
                        <div class="pull-right">
	                        
	                        <div class="btn-group btn-group-xs">
  <button id="list_set_ticket" type="button" class="btn btn-default <?=$ac['10'];?>">10</button>
  <button id="list_set_ticket" type="button" class="btn btn-default <?=$ac['15'];?>">15</button>
  <button id="list_set_ticket" type="button" class="btn btn-default <?=$ac['20'];?>">20</button>
</div>
	                        
                        </div>
                    </div></div>
                
            <?php } ?>
            <?php if (isset($_GET['out'])) {
                $r = "out"; 
                
                        if (isset($_SESSION['hd.rustem_list_out'])) {
	      
	      
	      switch($_SESSION['hd.rustem_list_out']) {
	case '10': 	$ac['10']="active";		break;
	case '15': 	$ac['15']="active";		break;
	case '20': 	$ac['20']="active";		break;
	default: $ac['10']="active";
}	
        }
                if (isset($_SESSION['hd.rustem_sort_out'])) {
	      
	      
	      switch($_SESSION['hd.rustem_sort_out']) {
	case 'ok': 		$button_sort_out['ok']="active";		break;
	case 'free': 	$button_sort_out['free']="active";		break;
	case 'ilock': 	$button_sort_out['ilock']="active";		break;
	case 'lock': 	$button_sort_out['lock']="active";		break;
	default: $button_sort_out['main']="active";
}	
        }
                ?>
                
                    <div class="pull-left">
                    
<div class="btn-group btn-group-xs">
  
  <button id="sort_list" value="main" type="button" class="btn btn-primary <?=$button_sort_out['main'];?>" data-toggle="tooltip" data-placement="bottom" title="<?=lang('ticket_sort_def')?>"><i class="fa fa-home"></i> </button>
  
        <button  id="sort_list" value="free" data-toggle="tooltip" data-placement="bottom" title="<?=lang('STATS_t_free')?>" type="button" class="btn btn-info <?=$button_sort_out['free'];?>"><i class="fa fa-circle-thin"></i> </button>
        
  <button id="sort_list" value="ok" data-toggle="tooltip" data-placement="bottom" title="<?=lang('ticket_sort_ok')?>" type="button" class="btn btn-success <?=$button_sort_out['ok'];?>"><i class="fa fa-check-circle"></i> </button>
  
  <button id="sort_list" value="ilock" data-toggle="tooltip" data-placement="bottom" title="<?=lang('ticket_sort_ilock')?>" type="button" class="btn btn-warning <?=$button_sort_out['ilock'];?>"><i class="fa fa-gavel"></i> </button>
  
  <button id="sort_list" value="lock" data-toggle="tooltip" data-placement="bottom" title="<?=lang('ticket_sort_lock')?>" type="button" class="btn btn-default <?=$button_sort_out['lock'];?>"><i class="fa fa-gavel"></i> </button>

</div>
                    
                    
                    
                                        </div>
                                        
                                        
                <div class="text-center">
                                                        
                    <ul id="example_out" class="pagination pagination-sm"></ul>
                                            <div class="pull-right">
	                        
	                        <div class="btn-group btn-group-xs">
  <button id="list_set_ticket" type="button" class="btn btn-default <?=$ac['10'];?>">10</button>
  <button id="list_set_ticket" type="button" class="btn btn-default <?=$ac['15'];?>">15</button>
  <button id="list_set_ticket" type="button" class="btn btn-default <?=$ac['20'];?>">20</button>
</div>
	                        
                        </div>
                        
                </div>
            <?php } ?>
            <?php if (isset($_GET['arch'])) {
                $r = "arch"; 
                        if (isset($_SESSION['hd.rustem_list_arch'])) {
	      
	      
	      switch($_SESSION['hd.rustem_list_arch']) {
	case '10': 	$ac['10']="active";		break;
	case '15': 	$ac['15']="active";		break;
	case '20': 	$ac['20']="active";		break;
	default: $ac['10']="active";
}	
        }
                ?>
                
                <div class="text-center">
                                                        <ul id="example_arch" class="pagination pagination-sm"></ul>
                    
                                            <div class="pull-right">
                                            <div class="btn-group btn-group-xs">
  <button id="list_set_ticket" type="button" class="btn btn-default <?=$ac['10'];?>">10</button>
  <button id="list_set_ticket" type="button" class="btn btn-default <?=$ac['15'];?>">15</button>
  <button id="list_set_ticket" type="button" class="btn btn-default <?=$ac['20'];?>">20</button>
</div></div>


                </div>
            <?php } 

$nn = get_last_ticket($_POST['menu'], $user_id);
        
        if ($nn == 0) {


            ?>
            <input type="hidden" id="curent_page" value="null">
            <input type="hidden" id="page_type" value="<?= $_POST['menu'] ?>">
        <?php


        }
        else if ($nn <> 0) {
?>


            <input type="hidden" id="page_type" value="<?= $r; ?>">
            <input type="hidden" id="curent_page" value="1">
            <input type="hidden" id="cur_page" value="1">


            <input type="hidden" id="total_pages" value="<?php echo get_total_pages($_POST['menu'], $user_id); ?>">
            <input type="hidden" id="last_ticket" value="<?= get_last_ticket($_POST['menu'], $user_id); ?>">

        <?php } ?>















        <br>
    </div>
    <?php
    include("footer.inc.php");
    ?>

<?php
} else {
    include 'auth.php';
}
?>
