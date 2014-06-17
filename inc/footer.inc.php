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
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/bootstrap/js/bootstrap.min.js"></script>

<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script src="js/jquery.ui.autocomplete.js"></script>
<script src="js/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="js/chosen.jquery.min.js"></script>
<script src="js/bootstrap-paginator.js"></script>
<script src="js/jquery.autosize.min.js"></script>
<script src="js/jquery.noty.packaged.min.js"></script>
<script src="js/ion.sound.min.js"></script>
<script src="js/jquery.multi-select.js"></script>

<script src="js/moment.min.js"></script>
<script src="js/daterangepicker.js"></script>
<script src="editor/redactor/redactor.min.js"></script>
<script src="js/summernote.min.js"></script>
<script src="js/summernote-uk-UA.js"></script>
<script src="js/jquery.titlealert.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/bootbox.min.js"></script>
<script src="js/core.js"></script>

<?php $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
if ( $current_file_name == 'admin' ) { ?>

    <script src="js/core_admin.js"></script>

<?php } ?>
</body>
</html>