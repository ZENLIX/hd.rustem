<?php
session_start();
include("../functions.inc.php");

if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if (validate_admin($_SESSION['helpdesk_user_id'])) {
   include("head.inc.php");
   include("navbar.inc.php");
   
  

?>


<div class="container">
<div class="page-header" style="margin-top: -15px;">
<div class="row">
         <div class="col-md-6"> <h3><i class="fa fa-cog"></i>  <?=lang('CONF_title');?></h3></div><div class="col-md-6"> 
         
</div>
         
</div>
 </div>
        

<div class="row" >
<div class="col-md-3">
      <div class="alert alert-info" role="alert">
      <small>
      <i class="fa fa-info-circle"></i> 
	      
<?=lang('CONF_info');?>
      </small>
      </div>
      
      <div class="alert alert-warning" role="alert">
      <small>
      Coding by
      Y.Snisar (c) 2014<br>
      <a class="alert-link" href="https://github.com/rustem-art/hd.rustem"><i class="fa fa-github"></i> Rustem-Art on github</a><br>
      <i class="fa fa-envelope"></i> info[at]rustem[dot]com[dot]ua<br>
      <i class="fa fa-skype"></i> rustem_ck (only for $)
      </ul>
      </small>
      </div>
      
      
      </div>

      <div class="col-md-9" id="content_info">
      
      
 
      <div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-cog"></i> <?=lang('CONF_mains');?></div>
  <div class="panel-body">
    
    <form class="form-horizontal" role="form">
    <div class="form-group">
    <label for="name_of_firm" class="col-sm-4 control-label"><small><?=lang('CONF_name');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="name_of_firm" placeholder="<?=lang('CONF_name');?>" value="<?=get_conf_param('name_of_firm');?>">
    </div>
  </div>  
  
    <div class="form-group">
    <label for="mail" class="col-sm-4 control-label"><small><?=lang('CONF_mail');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="mail" placeholder="<?=lang('CONF_mail');?>" value="<?=get_conf_param('mail');?>">
    </div>
  </div>
  
  
  
  <div class="form-group">
    <label for="title_header" class="col-sm-4 control-label"><small><?=lang('CONF_title_org');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="title_header" placeholder="<?=lang('CONF_title_org');?>" value="<?=get_conf_param('title_header');?>">
    </div>
  </div>
  <div class="form-group">
    <label for="hostname" class="col-sm-4 control-label"><small><?=lang('CONF_url');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="hostname" placeholder="<?php 
      $pos = strrpos($_SERVER['REQUEST_URI'], '/');
      echo "http://".$_SERVER['HTTP_HOST'].substr($_SERVER['REQUEST_URI'], 0, $pos + 1);?>" value="<?=get_conf_param('hostname'); ?>">
    </div>
  </div>
  
    <div class="form-group">
    <label for="days2arch" class="col-sm-4 control-label"><small><?=lang('CONF_2arch');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="days2arch" placeholder="<?=lang('CONF_2arch');?>" value="<?=get_conf_param('days2arch');?>">
      <p class="help-block"><small><?=lang('CONF_2arch_info');?> <br>
      
      5 0 * * * /usr/bin/php5 -f <?=realpath(dirname(dirname(__FILE__)))."/sys/4cron.php"?> > <?=realpath(dirname(dirname(__FILE__)))."/4cron.log"?> 2>&1</small></p>
    </div>
  </div>
  

  
      <div class="form-group">
    <label for="first_login" class="col-sm-4 control-label"><small><?=lang('CONF_f_login');?></small></label>
    <div class="col-sm-8">
  <select class="form-control input-sm" id="first_login">
  <option value="true" <?php if (get_conf_param('first_login') == "true") {echo "selected";} ?>><?=lang('CONF_f_login_opt_true');?></option>
  <option value="false" <?php if (get_conf_param('first_login') == "false") {echo "selected";} ?>><?=lang('CONF_false');?></option>
</select>   
<p class="help-block"><small>
<?=lang('CONF_f_login_info');?>
</small></p>
 </div>
  </div>
  
  
        <div class="form-group">
    <label for="fix_subj" class="col-sm-4 control-label"><small><?=lang('CONF_subj');?></small></label>
    <div class="col-sm-8">
  <select class="form-control input-sm" id="fix_subj">
  <option value="true" <?php if (get_conf_param('fix_subj') == "true") {echo "selected";} ?>><?=lang('CONF_fix_list');?></option>
  <option value="false" <?php if (get_conf_param('fix_subj') == "false") {echo "selected";} ?>><?=lang('CONF_subj_text');?></option>
</select>    
<p class="help-block"><small>
<?=lang('CONF_subj_info');?>
</small></p>
</div>
  </div>
  
          <div class="form-group">
    <label for="file_uploads" class="col-sm-4 control-label"><small><?=lang('CONF_fup');?></small></label>
    <div class="col-sm-8">
  <select class="form-control input-sm" id="file_uploads">
  <option value="true" <?php if (get_conf_param('file_uploads') == "true") {echo "selected";} ?>><?=lang('CONF_true');?></option>
  <option value="false" <?php if (get_conf_param('file_uploads') == "false") {echo "selected";} ?>><?=lang('CONF_false');?></option>
</select>    
<p class="help-block"><small>
<?=lang('CONF_fup_info');?>
</small></p>
</div>
  </div>
  
  
  
  <div class="form-group">
    <label for="file_types" class="col-sm-4 control-label"><small><?=lang('CONF_file_types');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="file_types" placeholder="gif,jpe?g,png,doc,xls,rtf,pdf,zip,rar,bmp,docx,xlsx" value="<?php 
      $bodytag = str_replace("|", ",", get_conf_param('file_types'));
      echo $bodytag;
	      
      ?>">

    </div>
  </div>
  
    <div class="form-group">
    <label for="file_size" class="col-sm-4 control-label"><small><?=lang('CONF_file_size');?></small></label>
    <div class="col-sm-8">
    <div class="input-group">
      <input type="text" class="form-control input-sm" id="file_size" placeholder="5" value="<?=round(get_conf_param('file_size')/1024/1024);?>">
<span class="input-group-addon">Mb</span>
    </div>
    </div>
  </div>
  
  
  <div class="col-md-offset-3 col-md-6">
<center>
    <button type="submit" id="conf_edit_main" class="btn btn-success"><i class="fa fa-pencil"></i> <?=lang('CONF_act_edit');?></button>
    
</center>

</div>
  
    </form>
  
  <div class="col-md-12" id="conf_edit_main_res"></div>
  
    
  </div>
</div>
            <div class="panel panel-default">
  <div class="panel-heading"><i class="fa fa-bell"></i> <?=lang('CONF_mail_name');?></div>
  <div class="panel-body">
    
    
    <form class="form-horizontal" role="form">
    
    <div class="form-group">
    <label for="mail_active" class="col-sm-4 control-label"><small><?=lang('CONF_mail_status');?></small></label>
    <div class="col-sm-8">
  <select class="form-control input-sm" id="mail_active">
  <option value="true" <?php if (get_conf_param('mail_active') == "true") {echo "selected";} ?>><?=lang('CONF_true');?></option>
  <option value="false" <?php if (get_conf_param('mail_active') == "false") {echo "selected";} ?>><?=lang('CONF_false');?></option>
</select>    </div>
  </div>
  
  <div class="form-group">
    <label for="from" class="col-sm-4 control-label"><small><?=lang('CONF_mail_from');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="from" placeholder="<?=lang('CONF_mail_from');?>" value="<?=get_conf_param('mail_from')?>">
    </div>
  </div>
      <div class="form-group">
    <label for="mail_type" class="col-sm-4 control-label"><small><?=lang('CONF_mail_type');?></small></label>
    <div class="col-sm-8">
  <select class="form-control input-sm" id="mail_type">
  <option value="sendmail" <?php if (get_conf_param('mail_type') == "sendmail") {echo "selected";} ?>>sendmail</option>
  <option value="SMTP" <?php if (get_conf_param('mail_type') == "SMTP") {echo "selected";} ?>>SMTP</option>
</select>    </div>
  </div>
  
  <div id="smtp_div">

    <div class="form-group">
    <label for="host" class="col-sm-4 control-label"><small><?=lang('CONF_mail_host');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="host" placeholder="<?=lang('CONF_mail_host');?>" value="<?=get_conf_param('mail_host')?>">
    </div>
  </div>

    <div class="form-group">
    <label for="port" class="col-sm-4 control-label"><small><?=lang('CONF_mail_port');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="port" placeholder="<?=lang('CONF_mail_port');?>" value="<?=get_conf_param('mail_port')?>">
    </div>
  </div>
  
  <div class="form-group">
    <label for="auth" class="col-sm-4 control-label"><small><?=lang('CONF_mail_auth');?></small></label>
    <div class="col-sm-8">
  <select class="form-control input-sm" id="auth">
  <option value="true" <?php if (get_conf_param('mail_auth') == "true") {echo "selected";} ?>><?=lang('CONF_true');?></option>
  <option value="false" <?php if (get_conf_param('mail_auth') == "false") {echo "selected";} ?>><?=lang('CONF_false');?></option>
</select>    </div>
  </div>
  
  <div class="form-group">
    <label for="auth_type" class="col-sm-4 control-label"><small><?=lang('CONF_mail_type');?></small></label>
    <div class="col-sm-8">
  <select class="form-control input-sm" id="auth_type">
  <option value="none" <?php if (get_conf_param('mail_auth_type') == "none") {echo "selected";} ?>>no</option>
  <option value="ssl" <?php if (get_conf_param('mail_auth_type') == "ssl") {echo "selected";} ?>>SSL</option>
  <option value="tls" <?php if (get_conf_param('mail_auth_type') == "tls") {echo "selected";} ?>>TLS</option>
</select>    </div>
  </div>
  
      <div class="form-group">
    <label for="username" class="col-sm-4 control-label"><small><?=lang('CONF_mail_login');?></small></label>
    <div class="col-sm-8">
      <input type="text" class="form-control input-sm" id="username" placeholder="<?=lang('CONF_mail_login');?>" value="<?=get_conf_param('mail_username')?>">
    </div>
  </div>
  
      <div class="form-group">
    <label for="password" class="col-sm-4 control-label"><small><?=lang('CONF_mail_pass');?></small></label>
    <div class="col-sm-8">
      <input type="password" class="form-control input-sm" id="password" placeholder="<?=lang('CONF_mail_pass');?>" value="<?=get_conf_param('mail_password')?>">
    </div>
  </div>
  
  </div>
  

    <div class="col-md-offset-3 col-md-6">
<center>
    <button type="submit" id="conf_edit_mail" class="btn btn-success"><i class="fa fa-pencil"></i> <?=lang('CONF_act_edit');?></button>

</center>
</div>
    </form>
    <button type="submit" id="conf_test_mail" class="btn btn-default btn-sm pull-right"> test</button>
      <div class="col-md-12" id="conf_edit_mail_res"></div>
      <div class="col-md-12" id="conf_test_mail_res"></div>
  </div>
</div>



      
      </div>
            <br>
      <?php
      
       ?>
     
      
      
</div>
      
      
      
      
<br>
</div>
<?php
 include("footer.inc.php");
?>

<?php
	}
	}
else {
    include '../auth.php';
}
?>