<?php
//session_start();
include("../functions.inc.php");


   include("head.inc.php");
   //include("inc/navbar.inc.php");
   
  if (isset($_GET['h'])) {
$h=($_GET['h']);


//$query="select hashname, message from notes where hashname='$h';";
//$res = mysql_query($query) or die(mysql_error());


		$stmt = $dbConnection->prepare('select hashname, message from notes where hashname=:h');
		$stmt->execute(array(':h'=>$h));
		$res1 = $stmt->fetchAll();                 
        

        if (empty($res1)) {
        
        //echo "no";
        
        }
        else if (!empty($res1)) {
        //while ($row = mysql_fetch_assoc($res)) {
			foreach($res1 as $row) {
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
        <a class="navbar-brand" href="<?=$CONF['hostname']?>index.php"> <img src="<?=$CONF['hostname']?>/img/logo.png"> <?=$CONF['name_of_firm']?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav"></ul>




        










    </div><!-- /.navbar-collapse -->
</nav>


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
 include("footer.inc.php");
?>
