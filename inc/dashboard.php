

<input type="hidden" id="main_last_new_ticket" value="<?= get_last_ticket_new($_SESSION['helpdesk_user_id']); ?>">

<div class="container">
    <div class="page-header" style="margin-top: -15px;">
        <h3><i class="fa fa-tachometer"></i> <?= lang('DASHBOARD_TITLE'); ?></h3>
    </div>
    
    
    <div class="row">
<div class="col-md-12">
		<div class="col-md-6">

            <div class="alert alert-info alert-dismissable">

                <?= make_html(get_myname() . get_dashboard_msg()); ?>

            </div>

        </div>
		<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="stats"><i class="fa fa-bar-chart-o"></i> <?= lang('DASHBOARD_ticket_stats'); ?></a></div>
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-4 col-xs-4"><center>    <strong class="text-danger"  style="font-weight: bold; font-style: normal; font-variant: normal; font-size: 20px;" data-toggle="tooltip" data-placement="top" title="<?= lang('DASHBOARD_ticket_in_desc'); ?>">
                                    <a class="text-danger" href="list?in" id="d_label_1"><?= get_total_tickets_free(); ?></a>
                                </strong><br><small><i class="fa fa-download"></i> <?= lang('DASHBOARD_ticket_in'); ?>	</small>	</center></div>

                        <div class="col-md-4 col-xs-4"><center>	<strong class="text-warning" style="font-weight: bold; font-style: normal; font-variant: normal; font-size: 20px;" data-toggle="tooltip" data-placement="top" title="<?= lang('DASHBOARD_ticket_lock_desc'); ?>" id="d_label_2"><?= get_total_tickets_lock(); ?></strong><br><small><i class='fa fa-lock'></i> <?= lang('DASHBOARD_ticket_lock'); ?> </small>	</center></div>

                        <div class="col-md-4 col-xs-4"><center>	<strong class="text-primary" style="font-weight: bold; font-style: normal; font-variant: normal; font-size: 20px;" data-toggle="tooltip" data-placement="top" title="<?= lang('DASHBOARD_ticket_out_desc'); ?>"><a class="text-primary" href="list?out" id="d_label_3"><?= get_total_tickets_out_and_success(); ?></a></strong><br><small><i class="fa fa-upload"></i>  <?= lang('DASHBOARD_ticket_out'); ?></small>	</center></div>

                    </div>
                </div>
            </div>
        </div>
    	
    	
</div>


<div class="col-md-12">
    
    
    
    
    <div class="col-md-6">
			
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-bullhorn"></i> <?= lang('DASHBOARD_last_news'); ?></div>
                <div class="panel-body">



                    <div id="last_news" style="max-height: 135px;
scroll-behavior: initial;
overflow-y: scroll;"></div>



                </div>
            </div>
        </div>
    <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<a href="helper"><i class="fa fa-globe"></i> <?= lang('DASHBOARD_last_help'); ?></a>
                </div>
                <div class="panel-body">
                    <?php get_helper(); ?>                
                </div>
            </div>
        </div>
   
</div>
    </div>
    
    

    
    
    
    

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="list?in"><i class="fa fa-list-alt"></i> <?= lang('DASHBOARD_last_in'); ?></a><span class="pull-right">
                <div class="btn-group btn-group-xs">
  <button id="dashboard_set_ticket" type="button" class="btn btn-default">5</button>
  <button id="dashboard_set_ticket" type="button" class="btn btn-default">10</button>
  <button id="dashboard_set_ticket" type="button" class="btn btn-default">15</button>
</div>

                </span></div>
                <div class="panel-body">

                    <div id="spinner" class="well well-large well-transparent lead">
                        <center><i class="fa fa-spinner fa-spin icon-2x"></i> <?= lang('LIST_loading'); ?> ...</center>
                    </div>

                    <div id="dashboard_t"></div>


                </div>
            </div>
        </div>

</div>
        

