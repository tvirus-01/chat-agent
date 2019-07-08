<?php
$path = '../../../';
include $path.'modules/db_con.php';
$client = $_COOKIE['client'];
$client_type = $_COOKIE['client_type'];

if (!isset($client) || !isset($client_type)) {
	header('Location: '.$path.'index.php');
}elseif ($client_type != 'agent') {
 	header('Location: '.$path.'index.php');
 }
 
include $path.'header.php';
?>
	<div class="row justify-content-center bg-warning">
		<div class="col text-center">
			<h1 class="text-light float-left">wellcome <?php echo $client; ?></h1>
			<form action="<?php echo $path.'modules/logout.php'; ?>" method="post">
				<button type="submit" name="logout" value="" class="btn btn-danger mt-2 float-right">Logout</button>
			</form>
		</div>
	</div>

<?php
include $path.'footer.php';	