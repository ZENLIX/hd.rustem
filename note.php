<?php
//session_start();
include("functions.inc.php");


   include("inc/head.inc.php");
   //include("inc/navbar.inc.php");
   
  if (isset($_GET['h'])) {
$h=$_GET['h'];


$query="select hashname, message from notes where hashname='$h';";
        //mysql_query($query);
        
        $res = mysql_query($query) or die(mysql_error());
        if (mysql_num_rows($res) == 0) {
        
        //echo "no";
        
        }
        if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {

        $msg= $row['message'];
        }
        }



?>
<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"> <img src="img/logo.png"> система заявок</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav"></ul>




        










    </div><!-- /.navbar-collapse -->
</nav>


	    <style>
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
            padding: 3px;
        }
    </style>
<div class="container">
	<div class="page-header" style="margin-top: -15px;">
	<div class="row">	
	</div>
</div>


<div class="row">
<div class="col-md-10 col-md-offset-1" style="padding-bottom:20px;">
<?=$msg;?>
</div>
</div>
 </div>
        


<?php
}
 include("inc/footer.inc.php");
?>
