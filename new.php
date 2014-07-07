<?php
session_start();
include("functions.inc.php");
$title_header=lang('NEW_title')." - ".$CONF['name_of_firm'];
if (validate_user($_SESSION['helpdesk_user_id'], $_SESSION['code'])) {
if ($_SESSION['helpdesk_user_id']) {
   include("inc/head.inc.php");
   include("inc/navbar.inc.php");
   
  

?>

<div class="container" id="form_add">
<input type="hidden" id="main_last_new_ticket" value="<?=get_last_ticket_new($_SESSION['helpdesk_user_id']);?>">
<link rel="stylesheet" href="css/jquery.fileupload.css">
<style>

    .animated {
        -webkit-transition: height 0.2s;
        -moz-transition: height 0.2s;
        transition: height 0.2s;
    }


    .popover
    {
        min-width: 300px ! important;
    }
    
</style>

<div class="row" style="padding-bottom:20px;">

    <div class="col-md-8"> <center><h3><i class="fa fa-tag"></i> <?=lang('NEW_title');?></h3></center></div>


</div>

<div class="row" style="padding-bottom:20px;">



<div class="col-md-1"></div>
<div class="col-md-7" id="div_new">
<?php
if (isset($_GET['ok'])) {
    if (isset($_GET['h'])) {$h=$_GET['h'];}

    ?>
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong><i class="fa fa-check"></i> <?=lang('NEW_ok');?></strong> <?=lang('NEW_ok_1');?> <a class="alert-link" href="ticket.php?hash=<?=$h;?>"><?=lang('NEW_ok_2');?></a> <?=lang('NEW_ok_3');?>.
    </div>
<?php

}
?>
<div class="panel panel-success" style="padding:20px;">
<div class="panel-body">

<form class="form-horizontal" id="main_form" novalidate="" action="" method="post">


<div class="control-group">
    <div class="controls">
        <div class="form-group" id="for_fio">

            <label for="fio" class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="<?=lang('NEW_from_desc');?>"><small><?=lang('NEW_from');?>: </small></label>

            <div class="col-sm-10">


                <input  type="text" name="fio" class="form-control input-sm" id="fio" placeholder="<?=lang('NEW_fio');?>" autofocus data-toggle="popover" data-trigger="manual" data-html="true" data-placement="right" data-content="<small><?=lang('NEW_fio_desc');?></small>">



            </div>



        </div></div>

    <hr>
    <div class="form-group" id="for_to" data-toggle="popover" data-html="true" data-trigger="manual" data-placement="right" data-content="<small>Вкажіть відділ призначення або працівника</small>">
        <label for="to" class="col-md-2 control-label" data-toggle="tooltip" data-placement="top" title="<?=lang('NEW_to_desc');?>"><small><?=lang('NEW_to');?>: </small></label>
        <div class="col-md-6">
            <select data-placeholder="<?=lang('NEW_to_unit');?>" class="chosen-select form-control" id="to" name="unit_id">
                <option value="0"></option>
                <?php
                        $qstring = "SELECT name as label, id as value FROM deps where id !='0' ;";
                        $result = mysql_query($qstring);//query the database for entries containing the term

                        while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
                        {
//echo($row['label']);
                            $row['label']=$row['label'];
                            $row['value']=(int)$row['value'];


                            ?>

                            <option value="<?=$row['value']?>"><?=$row['label']?></option>

                        <?php


                        }

                        ?>

            </select>
        </div>




        <div class="col-md-4" style="" id="dsd" data-toggle="popover" data-html="true" data-trigger="manual" data-placement="right" data-content="<small><?=lang('NEW_to_unit_desc');?></small>">

            <select data-placeholder="<?=lang('NEW_to_user');?>" class="chosen-select form-control input-sm" id="users_do" name="unit_id">
                <option value="0"></option>
                <?php
                $qstring = "SELECT fio as label, id as value FROM users where status='1' and login !='system' order by fio ASC;";
                $result = mysql_query($qstring);//query the database for entries containing the term

                while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
                {
//echo($row['label']);
                    $row['label']=$row['label'];
                    $row['value']=(int)$row['value'];


                    ?>

                    <option value="<?=$row['value']?>"><?=$row['label']?></option>

                <?php


                }

                ?>

            </select>


        </div>

    </div>




</div>




<div class="control-group" id="for_prio">
    <div class="controls">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><small><?=lang('NEW_prio');?>: </small></label>
            <div class="col-sm-10" style=" padding-top: 5px; ">

                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-xs" id="prio_low"><i id="lprio_low" class=""></i><?=lang('NEW_prio_low');?></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-xs active" id="prio_normal"><i id="lprio_norm" class="fa fa-check"></i> <?=lang('NEW_prio_norm');?></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="<?=lang('NEW_prio_high_desc');?>" id="prio_high"><i id="lprio_high" class=""></i><?=lang('NEW_prio_high');?></button>
                    </div>
                </div>
            </div></div></div></div>
<?php
/*





*/


if ($CONF['fix_ticket_subj'] == false) {
?>

<div class="control-group" id="for_subj">
    	<div class="controls">
          <div class="form-group">
    <label for="subj" class="col-sm-2 control-label"><small>Тема: </small></label>
    <div class="col-sm-10">
      <input type="text" class="form-control input-sm" name="subj" id="subj" placeholder="Тема" data-toggle="popover" data-html="true" data-trigger="manual" data-placement="right" data-content="<small>Вкажіть тему заявки</small>">
    </div>
  </div></div></div>
<?php } 
	else if ($CONF['fix_ticket_subj'] == true) {
?>



<div class="control-group" id="for_subj" data-toggle="popover" data-html="true" data-trigger="manual" data-placement="right" data-content="<small><?=lang('NEW_subj_msg');?></small>">
    <div class="controls">
        <div class="form-group">
            <label for="subj" class="col-sm-2 control-label"><small><?=lang('NEW_subj');?>: </small></label>
            <div class="col-sm-10" style="">
                <select data-placeholder="<?=lang('NEW_subj_det');?>" class="chosen-select form-control input-sm" id="subj" name="subj">
                    <option value="0"></option>
                    <?php
                    $qstring = "SELECT name FROM subj order by name COLLATE utf8_unicode_ci ASC";
                    $result = mysql_query($qstring);//query the database for entries containing the term

                    while ($row = mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
                    {
                        ?>

                        <option value="<?=$row['name']?>"><?=$row['name']?></option>

                    <?php


                    }

                    ?>

                </select>
            </div>
        </div>

    </div>
</div>


<?php } ?>







<div class="control-group">
    <div class="controls">
        <div class="form-group" id="for_msg">
            <label for="msg" class="col-sm-2 control-label"><small><?=lang('NEW_MSG');?>:</small></label>
            <div class="col-sm-10">
                <textarea data-toggle="popover" data-html="true" data-trigger="manual" data-placement="right" data-content="<small><?=lang('NEW_MSG_msg');?></small>" placeholder="<?=lang('NEW_MSG_ph');?>" class="form-control input-sm animated" name="msg" id="msg" rows="3" required="" data-validation-required-message="Укажите сообщение" aria-invalid="false"></textarea>
            </div>
        </div>
        <div class="help-block"></div></div></div>


<?php if ($CONF['file_uploads'] == true) { ?>
<div class="control-group">
    <div class="controls">
    <div class="form-group">
    
    <label for="" class="col-sm-2 control-label"><small>Добавить файл:</small></label>

    <div class="col-sm-10">
        <div id="fileuploader">Upload</div>
    </div>
    </div>
</div>
</div>
<?php } ?>

<div class="col-md-2"></div>
<div class="col-md-10">
    <div class="btn-group btn-group-justified">
        <div class="btn-group">
            <button id="enter_ticket" class="btn btn-success" type="button"><i class="fa fa-check-circle-o"></i> <?=lang('NEW_button_create');?></button>
        </div>
        <div class="btn-group">
            <a id="reset_ticket" class="btn btn-default" type="submit" href="new.php"><i class="fa fa-eraser"></i> <?=lang('NEW_button_reset');?></a>
        </div>
    </div>
	<input type="hidden" id="file_array" value="">
    <input type="hidden" id="client_id_param" value="">
    <input type="hidden" id="hashname" value="<?=md5(time());?>">
    <input type="hidden" id="status_action" value="">
    <input type="hidden" id="prio" value="1">
    <input type="hidden" value="<?php echo $_SESSION['helpdesk_user_id']; ?>" id="user_init_id">




</div>


</form>
</div>
</div>
<br>
</div>
<div class="col-md-4">
    <style>
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
            padding: 5px;}
        .panel-body {
            padding: 5px;
        }
        .table {
            width: 100%;
            margin-bottom: 0px;
        }
    </style>
    <div class="panel panel-success" id="user_info" style="display: block;">






    </div>
    <div id="alert_add">
    </div>



</div>



</div>





</div>

</div>
<?php
 include("inc/footer.inc.php");
?>
<!--script src="js/vendor/jquery.ui.widget.js"></script-->
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<!--script src="js/jquery.iframe-transport.js"></script-->
<!-- The basic File Upload plugin -->
<!--script src="js/load-image.min.js"></script-->
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<!--script src="js/canvas-to-blob.min.js"></script-->

<!--script src="js/jquery.fileupload.js"></script-->
<!-- The File Upload processing plugin -->
<!--script src="js/jquery.fileupload-process.js"></script-->
<!-- The File Upload image preview & resize plugin -->
<!--script src="js/jquery.fileupload-image.js"></script-->
<!--script src="js/jquery.fileupload-validate.js"></script-->

<!--script>

$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
//var filestoupload=0;
    $('#fileupload').fileupload({
        url: 'server/php/',
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|zip|rar|gz|docx|pdf|txt|xls|doc|xlsx)$/i,
        maxFileSize: 20000000, // 20 MB
        //maxNumberOfFiles: 1,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
        
        
        
    }).on('fileuploadadd', function (e, data) {
//data.context = $('<div/>').appendTo('#files_list');
//var vOutput="<input type='button' class='fileCancel' value='cancel'> ";
                
                //filestoupload++;
                
                
                
                
        $.each(data.files, function (index, file) {
                    var newFileDiv = $("<div class='uploadBox' id='fileDiv_" + file.name + "'><div class='panel panel-default leftEle col-md-6'><center>" + file.name + " <br><a href='#' id='link_" + index + "' class='btn btn-danger btn-xs removeFile'>видалити</a></center></div></div>");
                    $('#files_list').append(newFileDiv);

                    newFileDiv.find('a').on('click', { filename: file.name, files: data.files }, function (event) {                        
                        event.preventDefault();
                        var uploadFilesBox = $("#files_list");
                        var remDiv = $(document.getElementById("fileDiv_" + event.data.filename));
                        remDiv.remove();                        
                        data.files.length = 0;    //zero out the files array                                     
                    });

                    data.context = newFileDiv;
                });
        
        
        $(".fileCancel").eq(-1).on("click",function(){
                  $(this).parent().parent().remove();
        });
             
             
        $("button#enter_ticket").on("click",function(event){
        event.preventDefault();
        if (data.files.length > 0) {
        //if (filestoupload < 6) {
        data.submit();
        //}
        //alert(filestoupload);
        //else if (filestoupload > 5) {
        //alert('many'); 
        //}
        }
        //else if (data.files.length == 0) {
        alert('d');
        //}
        });
        
        
        
        
        
        
        
    }).on('fileuploadstop', function (e){
	    //alert('ok');
	    
        //event.preventDefault();
        var z=$("#username").text();
        var s=$("#subj").val();
        var to=$("select#to").val();
        var m=$("#msg").val().length;
        //alert(to);




        var error_code=0;

        //if ($('#fio').val().length == 0 && $('#user_login').val().length == 0){
        if ($('#fio').val().length == 0){
            error_code=1;
            //alert('no');
            //$('#fio').popover('show');
            $('#fio').popover('show');
            $('#for_fio').addClass('has-error');
        }

        if (to == '0') {
            error_code=1;
            //alert('no');
            //$('#for_to').popover('show');
            $('#dsd').popover('show');
            $('#for_to').addClass('has-error');

        }

        if (s == 0) {
            error_code=1;
            $("#for_subj").popover('show');
            $("#for_subj").addClass('has-error');

        }
        if (m == 0) {
            error_code=1;
            $("#msg").popover('show');
            $("#for_msg").addClass('has-error');

        }







        if (error_code == 0) {

            var status_action=$("#status_action").val();
            if (status_action == 'edit') {

            }
            if (status_action =='add') {





                $.ajax({
                    type: "POST",
                    url: "actions.php",
                    data: "mode=add_ticket"+
                        "&type_add=add"+
                        "&fio="+$("#username").text()+
                        "&tel="+$("#new_tel").text()+
                        "&login="+$("#new_login").text()+
                        "&pod="+$("#new_unit").text()+
                        "&adr="+$("#new_adr").text()+
                        "&tel="+$("#new_tel").text()+
                        "&mail="+$("#new_mail").text()+
                        "&posada="+$("#new_posada").text()+
                        "&user_init_id="+$("#user_init_id").val()+
                        "&user_do="+$("#users_do").val()+
                        "&subj="+$("#subj").val()+
                        "&msg="+$("#msg").val().replace(/\r\n|\r|\n/g,"<br />").replace(/'/g, '\'')+
                        "&unit_id="+$("#to").val()+
                        "&prio="+$("#prio").val()+
                        "&hashname="+$("#hashname").val(),
                    success: function(html) {
                        //alert(html);
                        window.location = "new.php?ok&h="+html;

                    }
                });




            }


            if (status_action =='edit') {
                $.ajax({
                    type: "POST",
                    url: "actions.php",
                    data: "mode=add_ticket"+
                        "&type_add=edit"+
                        "&client_id_param="+$("#client_id_param").val()+
                        "&tel="+$("#edit_tel").text()+
                        "&login="+$("#edit_login").text()+
                        "&pod="+$("#edit_unit").text()+
                        "&adr="+$("#edit_adr").text()+
                        "&tel="+$("#edit_tel").text()+
                        "&mail="+$("#edit_mail").text()+
                        "&posada="+$("#edit_posada").text()+
                        "&user_init_id="+$("#user_init_id").val()+
                        "&user_do="+$("#users_do").val()+
                        "&subj="+$("#subj").val()+
                        "&msg="+$("#msg").val().replace(/\r\n|\r|\n/g,"<br />").replace(/'/g, '\'')+
                        "&unit_id="+$("#to").val()+
                        "&prio="+$("#prio").val()+
                        "&hashname="+$("#hashname").val(),
                    success: function(html) {
                        //alert(html);
                        window.location = "new.php?ok&h="+html;
                        //alert(html);
                    }
                });




            }


        }

    
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
        
    }).on('fileuploaddone', function (e, data) {
    
        $.each(data.result.files, function (index, file) {
	        //alert (file.name);
	        /*
	        insert into files
	        */
	        
	        $.ajax({
                    type: "POST",
					async: false,
                    url: "actions.php",
                    
                    data: "mode=upload_file"+
                    "&name="+file.name+
                    "&hn="+$("#hashname").val(),
                    success: function(html) {
                        //alert(html);
                        //window.location = "new.php?ok&h="+html;

                    }
                    });
        });
        
        
        
        
        //event.preventDefault();
        

    
        
        
        
    });});
</script-->

<?php
	}
	}
else {
    include 'auth.php';
}
?>