<?php
session_start();
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if ($_SESSION['helpdesk_user_id']) {
   include("head.inc.php");
   include("navbar.inc.php");
   
  

?>
<style>
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
padding: 2px;
line-height: 1.428571429;
vertical-align: top;
border-top: 0px solid #DDD;
}
</style>

<div class="container">
<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
	<div class="page-header" style="margin-top: -15px;">
	<div class="row">
	<div class="col-md-9">
<h3><i class="fa fa-book"></i> <?=lang('NOTES_title');?></h3>
	</div>
	<div class="col-md-3"><h3>
	
	
	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?=lang('NOTES_link');?></h4>
      </div>
      <div class="modal-body">
        <form role="form">
  <div class="form-group">
    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="">
  </div>
        </form>
      </div>
    </div>
  </div>
</div>









    <button id="create_new_note" type="submit" class="btn btn-success btn-sm btn-block"><i class="fa fa-file-o"></i> <?=lang('NOTES_create');?></button>
	</h3>
	</div>
	</div>
     </div>
     <div class="row" id="content_notes" style="padding-bottom: 25px;">

<div class="col-md-3">


<div class="panel panel-default">
  <div class="panel-body">

    <div id="table_list" style="margin-bottom: 0px; margin-bottom: 0px;">
  
</div>
	
    
    
  </div>
</div>

	
	
</div>
<div class="col-md-9">
	<div id="summernote">
		                       <div class="jumbotron">
  <p>                <center>
                    <?=lang('NOTES_cr');?>
                </center></p>
  
</div>
	</div>
	<div id="re">
	</div>
	
</div>
</div>
 </div>
        


<?php
 include("footer.inc.php");
?>


<?php
	}
	}
else {
    include 'auth.php';
}
?>