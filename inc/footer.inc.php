<div id="footer" style=" padding-bottom: 70px; ">
    <div class="container" style=" padding: 20px; ">
        <div class="col-md-8">
            <p class="text-muted credit"><small>Designed by <a href="mailto:info@rustem.com.ua">Y.Snisar</a> (с) 2014.</p>
            </small>
        </div>
        <?php


        if (priv_status($_SESSION['helpdesk_user_id']) == "0") {$pri="куратор";}
        if (priv_status($_SESSION['helpdesk_user_id']) == "1") {$pri="користувач";}
        ?>
        <div class="col-md-4">

        </div>
    </div>
</div>
<?php if ($lang == "ua") {$lang = "uk"; }?>
<script type="text/javascript">
    var MyHOSTNAME = "<?php echo $CONF['hostname']; ?>";
    var MyLANG = "<?php echo $lang; ?>";
</script>
<script src="<?=$CONF['hostname']?>js/jquery-1.11.0.min.js"></script>
<script src="<?=$CONF['hostname']?>js/bootstrap/js/bootstrap.min.js"></script>

<script src="<?=$CONF['hostname']?>js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.ui.autocomplete.js"></script>
<script src="<?=$CONF['hostname']?>js/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="<?=$CONF['hostname']?>js/chosen.jquery.min.js"></script>
<script src="<?=$CONF['hostname']?>js/s2/select2.min.js"></script>
<script src="<?=$CONF['hostname']?>js/bootstrap-paginator.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.autosize.min.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.noty.packaged.min.js"></script>
<script src="<?=$CONF['hostname']?>js/ion.sound.min.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.multi-select.js"></script>
<script src="<?=$CONF['hostname']?>js/moment.min.js"></script>
<script src="<?=$CONF['hostname']?>js/daterangepicker.js"></script>
<script src="<?=$CONF['hostname']?>js/summernote.min.js"></script>
<script src="<?=$CONF['hostname']?>js/summernote-lang.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.titlealert.js"></script>
<script src="<?=$CONF['hostname']?>js/highcharts.js"></script>
<script src="<?=$CONF['hostname']?>js/bootbox.min.js"></script>
<script src="<?=$CONF['hostname']?>js/moment-with-langs.js"></script>


<!-- FOR UPLOADER -->
<?php if ($CONF['file_uploads'] == "true") { ?>
<script src="<?=$CONF['hostname']?>js/tmpl.min.js"></script>
<script src="<?=$CONF['hostname']?>js/load-image.min.js"></script>
<script src="<?=$CONF['hostname']?>js/canvas-to-blob.min.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.fileupload.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.fileupload-ui.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.fileupload-process.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.fileupload-image.js"></script>
<script src="<?=$CONF['hostname']?>js/jquery.fileupload-validate.js"></script>
<?php } ?>
<!-- FOR UPLOADER -->

<script src="<?=$CONF['hostname']?>/js/core.js"></script>



</body>
</html>
