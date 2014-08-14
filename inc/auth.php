<?php
include_once("head.inc.php");
//include("dbconnect.inc.php");
?>

<style type="text/css">
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        max-width: 360px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
        box-shadow: 0 1px 2px rgba(0,0,0,.05);
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin .checkbox {
        font-weight: normal;
    }
    .form-signin .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

</head><body>

<div class="container" id='main_login'>
    <?php //echo $_SERVER['REQUEST_URI']; ?>
    <form class="form-signin" action="<?=$CONF['hostname']?>index.php" method="POST" autocomplete="off">
        <center><img src="<?=$CONF['hostname']?>img/help-desk-icon.png" width="128"><h2 class="text-muted"><?=lang('MAIN_TITLE');?></h2><small class="text-muted"><?=lang('AUTH_USER');?></small></center><br>
        <input type="text" name="login" autocomplete="off" class="form-control" placeholder="<?=lang('login');?>">
        <input type="password" name="password" class="form-control" placeholder="<?=lang('pass');?>">
        <div style="padding-left:75px;">
            <div class="checkbox">
                <label>
                    <input id="mc" name="remember_me" value="1" type="checkbox"> <?=lang('remember_me');?>
                </label>
            </div>
        </div>
        <?php if ($va == 'error') { ?>
            <div class="alert alert-danger">
                <center><?=lang('error_auth');?></center>
            </div> <?php } ?>
        <input type="hidden" name="req_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <button class="btn btn-lg btn-primary btn-block"> <i class="fa fa-sign-in"></i>  <?=lang('log_in');?></button>

        <!hr style=" margin: 10px; ">
        <?php
       
         if ($CONF['first_login'] == "true") { ?>
        <small>
            <center style=" margin-bottom: -20px; "><br><a href="#" id="show_activate_form"><?=lang('first_in_auth');?>.</a>
            </center>
        </small>
		<?php } ?>
    </form>

<?php if(ini_get('short_open_tag') == false) { ?>
<div class="alert alert-danger" role="alert">PHP-error: <em>short_open_tag</em> must be enable in your php configuration. <br> Details: <a href="http://php.net//manual/ru/language.basic-syntax.phptags.php">http://php.net//manual/ru/language.basic-syntax.phptags.php</a></div>
	<?php } ?>
	

<?php
    $filename=realpath(dirname(dirname(__FILE__)))."/.htaccess";
    if (!file_exists($filename)) { ?>
    <div class="alert alert-danger" role="alert">.htaccess error: <em><?=$filename?></em> file not exist</div>
    <?php
    }
    // "mod_rewrite module is not enabled";
?>
<?php
    $filename=realpath(dirname(dirname(__FILE__)))."/upload_files/";
    if (!is_writable($filename)) { ?>
    <div class="alert alert-danger" role="alert">Permission-error: <em><?=$filename?></em> is not writable. <br> Add access to write.</a></div>
    <?php
    }
    // "mod_rewrite module is not enabled";
?>
</div>
<script src="<?=$CONF['hostname']?>js/jquery-1.11.0.min.js"></script>
<script src="<?=$CONF['hostname']?>js/bootstrap/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $("#main_login").hide().fadeIn(500);
        $('body').on('click', 'a#show_activate_form', function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?=$CONF['hostname']?>actions.php",
                data: "mode=activate_login_form",
                success: function(html){
                    //alert(html);
                    $(".form-signin").hide().html(html).fadeIn(500);



                    $('body').on('click', 'button#do_activate', function(event) {
                        event.preventDefault();
                        var m=$("#mailadress").val();
                        $.ajax({
                            type: "POST",
                            url: "<?=$CONF['hostname']?>actions.php",
                            data: "mode=activate_login"+
                                "&mailadress="+m,
                            success: function(html){
                                //alert(html);
                                $(".form-signin").hide().html(html).fadeIn(500);
                            }
                        });





                    });




                }
            });



        });



    });
</script>
