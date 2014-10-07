<?php
session_start();
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if ($_SESSION['helpdesk_user_id']) {
   include("head.inc.php");
   include("navbar.inc.php");
   
  
?>
	





<div class="container">
<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
	<div class="page-header" style="margin-top: -15px;">
	<div class="row">
	<div class="col-md-12">
<h3><i class="fa fa-bar-chart-o"></i>  <?=lang('STATS_TITLE');?></h3>
	</div>

	</div>
     </div>
     <div class="row" id="content_notes" style="padding-bottom: 25px;">


<div class="col-md-12" id="">
	
	<table class="table table-bordered">
<tr>
<td colspan="3" style="width:50%"><strong><center><?=lang('STATS_in');?></center></strong></td>
<td colspan="4"><strong><center><?=lang('STATS_out');?></center></strong></td>
</tr>
<tr>
<td><center><?=lang('STATS_new');?>			</center></td>
<td><center><?=lang('STATS_lock');?>  </center></td>
<td><center><?=lang('STATS_ok');?>	</center></td>
<td><center><?=lang('STATS_nook');?>			</center></td>  
<td><center><?=lang('STATS_create');?>	</center></td>
<td><center><?=lang('STATS_lock_o');?>		</center></td>
<td><center><?=lang('STATS_ok_o');?>		</center></td>
</tr>
<tr>
<td><center><span class="text-danger"> <h4><?=get_total_tickets_free();?>			</h4></span>	</center></td>
<td><center><span class="text-warning"><h4><?=get_total_tickets_lock();?>			</h4></span>	</center></td>
<td><center><span class="text-success"><h4><?=get_total_tickets_ok();?>				</h4></span></center></td>  
<td><center><span class="text-danger"> <h4><?=get_total_tickets_out_and_success();?></h4></span>	</center></td>
<td><center><span class="">			   <h4><?=get_total_tickets_out();?>			</h4></span>	</center></td>
<td><center><span class="text-warning"><h4><?=get_total_tickets_out_and_lock();?>	</h4></span>	</center></td>
<td><center><span class="text-success"><h4><?=get_total_tickets_out_and_ok();?>		</h4></span></center></td>
</tr>
<tr>
<td colspan="3"><center><div class="col-md-12" id="chart_in">
</div></center></td>
<td colspan="4"><div class="col-md-12" id="chart_out">
</div></td></tr>
<tr>
<td colspan="3"><small>
<ul>
	<?=lang('STATS_help1');?>
</ul>
</small></td>
<td colspan="4">
	
	<small>
<ul>
	<?=lang('STATS_help2');?>
</ul>
</small>
	
</td>
</tr>
</table>




</div>
 </div>
        
</div>

<?php

 include("footer.inc.php");
?>

<script>
	$(function () {
	$('#chart_in').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '<?=lang('STATS_in_now');?>'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: '<?=lang('STATS_t');?>',
            data: [
                {
                    name: '<?=lang('STATS_lock');?>',
                    y: <?=get_total_tickets_lock();?>,
                    color: '#F0AD4E'
                },
                {
                    name: '<?=lang('STATS_t_ok');?>',
                    y: <?=get_total_tickets_ok();?>,
                    color: '#aaff99'
                },
                {
                    name: '<?=lang('STATS_t_free');?>',
                    y: <?=get_total_tickets_free();?>,
                    color: '#FF2D46'
                }
            ]
        }]
    });





$('#chart_out').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: '<?=lang('STATS_out_all');?>'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.y}</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: '<?=lang('STATS_t');?>',
            data: [
                {
                    name: '<?=lang('STATS_t_lock');?>',
                    y: <?=get_total_tickets_out_and_lock();?>,
                    color: '#F0AD4E'
                },
                {
                    name: '<?=lang('STATS_t_ok');?>',
                    y: <?=get_total_tickets_out_and_ok();?>,
                    color: '#aaff99'
                },
                {
                    name: '<?=lang('STATS_t_free');?>',
                    y: <?=get_total_tickets_out_and_success();?>,
                    color: '#FF2D46'
                }
            ]
        }]
    });

	});
</script>
<?php
	
	}
else {
    include 'auth.php';
}
}
?>