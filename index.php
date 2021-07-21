<?php
	ob_start();
	session_start();
	
	
function _token(){
	$randomToken = base64_encode(openssl_random_pseudo_bytes(32))."open ssl<br>"; 
	$_SESSION['token'] = $randomToken;
	
	return $_SESSION['token'];
}

function validate_token($requestToken){
	if( isset($_SESSION['token']) && $requestToken === $_SESSION['token'] ){ 
		unset($_SESSION['token']);
		return true;
	}
	return false; 
}

$input ="";

if( isset($_POST['btn-hashme'],$_POST['token']) ) {	
		if ( validate_token($_POST['token']) ) {
		
		$input = trim($_POST['input_string']);
		$input = strip_tags($input);
		$input = htmlspecialchars($input);
		
		if(empty($input)){
			header("Location: index.php");
			exit();
		}
		
		$function_name = $_POST['hash_function'];
		$output  =hash($function_name,$input);
		 
	}
}

?>
<!DOCTYPE >
<html>
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="icon" href="indept-assets/icon.png" >
	<title>Hash Me - Online hashing Application </title>
	<script>
		function myCopy(){
			var copyText = document.getElementById("idfield");
			copyText.select();
			copyText.setSelectionRange(0, 99999)
			document.execCommand("copy");
			alert("Link Copied !!!");
		}
	</script>
</head>
<body>
<div class="row">
<div class="container">
<nav class="navbar navbar-default navbar-fixed-top " style="background: #0d2f79">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
<a class="navbar-brand" href="#" style="color: #ffffff;font: Times New Roman"><h4><b>HASH ME - Online Hashing Application</b></h4></a> 
    </div>
    <div class="collapse navbar-collapse" id="myNavbar" >
      <ul class="nav navbar-nav navbar-right" >
      <li><a href="#" style="color: #fff"><button class="btn btn-lg btn-inverse" style="border: 2px solid black;background: #0d2f79" ><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp; Contact Us</button></a></li>
      </ul>
    </div>
  </div>
</nav>
<br/><br/><br/>
<hr>
		<div class="col-sm-9">
			<h4><b>&nbsp;&nbsp;HASH &nbsp;&nbsp;</b></h4>
				<hr style="border: 3px solid #0d2f79" />
				<?php
				if(isset($function_name)){
				?>
			<div class="alert alert-info">
				&nbsp;&nbsp;<span class="glyphicon glyphicon-info"></span>&nbsp;&nbsp;Now your using <span  class="text-danger"><b><?php echo $function_name; ?></b></span>  Hashing function !
			</div>
			<?php
				}
			?>
			<div class="row">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
			<div class="col-sm-12"> 
			<div class="form-group">
	<div class="form-group">
		<textarea class="col-sm-12" style="background-image: linear-gradient(#c6c6c6, #ffffff);height: 150px;border: 0.7px solid #000000" style="width: 250px;" align="justify" name="input_string" id="input_string"><?php echo $input;?></textarea>
			</div> 
	</div>
	<DIV class="form-group"><br/>
	<select name="hash_function" style="height: 25px;margin-top: 15px;" class="col-sm-12 alert-lg-success text-primary " required >
	<option value="" > SELECT ANY HASHING FUNCTION </option>
		<?php
			$array_hash_funct = hash_algos();
			foreach($array_hash_funct as $ser){ ?>
				<option value="<?php echo $ser; ?>"><?php echo $ser; ?></option>
		<?php	}
			 ?>
		</select>
		</div>
		
		 <input type="hidden" name="token" value="<?php echo _token(); ?>"> 
			<br />
				<center>
					<button class="btn btn-primary" name="btn-hashme" style="margin: 10px">HASH</button>
				</center>
			<br />
			</DIV>
			</form>
			</div>
	<?php
		if(isset($output)){	
	?>
			<div class="form-group">
		<textarea class="col-sm-12" style="background-image: linear-gradient(#c6c6c6, #ffffff);height: 150px;border: 0.7px solid #000000" style="width: 250px;" align="justify" id="idfield"><?php echo $output;?></textarea>
			</div> 
			<div class="form-group">
			<center><button class="btn btn-sm btn-info" onclick="myCopy()" style="margin: 10px;">&nbsp;<span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;&nbsp;COPY</button></center>
			</div>
	<?php } ?>
		</div>
		<div class="col-sm-3">
			<h4><b>&nbsp;&nbsp;HASH FUNCTIONS&nbsp;&nbsp;</b></h4>
				<hr style="border: 3px solid #0d2f79" />
			<?php
			$array_hash_funct = hash_algos();
			foreach($array_hash_funct as $ser){
				echo "$ser<br>";
			}
			 ?>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<hr style="border: 3px solid #0d2f79" />
	<p align="center">
		Designed by <b>Happy Chandru Raju</b>
	</p>
</div>
</body>
</html>
<?php ob_end_flush(); ?>