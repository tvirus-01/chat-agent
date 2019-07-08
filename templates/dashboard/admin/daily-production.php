<?php
$path = '../../../';
include $path.'modules/db_con.php';
$client = $_COOKIE['client'];
$client_type = $_COOKIE['client_type'];

if (!isset($client) || !isset($client_type)) {
	header('Location: '.$path.'index.php');
}elseif ($client_type != 'admin') {
	header('Location: '.$path.'index.php');
}elseif (!isset($_GET['uid'])) {
	header('Location: '.$path.'index.php');
}else{
	$userid = $_GET['uid'];

	$users = $conn->query("SELECT * FROM tbl_agent WHERE id = {$userid}");
	$users_count = mysqli_num_rows($users);
	$user = $users->fetch_assoc();
}

$current_month = date('m');
$current_year = date('Y');

if ($current_month == '01' || $current_month == '03' || $current_month == '05' || $current_month == '07' || $current_month == '08' || $current_month == '10' || $current_month == '12') {
	$days = '31';
}elseif ($current_month == '02') {
	$days = '28';
}else{
	$days = '30';
}
$date = $current_year.'-'.$current_month.'-1';
//echo $date;

$sql = "SELECT * FROM `tbl_daily_production` WHERE userid = {$userid} AND `date` = '".$date."'";
$result = $conn->query($sql);
$result_count = mysqli_num_rows($result);

if ($result_count == 0) {
	for ($i=1; $i <= $days; $i++) { 
		$date = $current_year.'-'.$current_month.'-'.$i;
		$conn->query("INSERT INTO `tbl_daily_production` (`id`, `date`, `userid`, `num_of_mssg`, `rate`) VALUES (NULL, '".$date."', '".$userid."', '0', '0')");
	}
	header("Refresh:0");
}else{
	$sql = "SELECT * FROM `tbl_daily_production` WHERE userid = {$userid}";
	$result = $conn->query($sql);
	$result_count = mysqli_num_rows($result);
}

include $path.'header.php';
?>
	<div class="row justify-content-center bg-success">
		<div class="col text-center">
			<h1 class="text-light float-left">Daily Production</h1>
			<a href="<?php echo $path.'index.php'; ?>" class="btn btn-secondary float-right mt-2 ml-3">Back to Dashboard</a>
			<form action="<?php echo $path.'modules/logout.php'; ?>" method="post">
				<button type="submit" name="logout" value="" class="btn btn-danger mt-2 float-right">Logout</button>
			</form>
		</div>
	</div>
	<?php
		if ($users_count == 1) {	
		echo '<div class="row mt-3">
				<div class="col">
					<h4 class="float-left">Agent Name: '.$user['user_name'].'</h4>
					<span class="float-right h6">NMSID: '.$user['nmsid'].'</span>
				</div>
			</div>';	

		if ($result_count > 0) {
	?>
		<div class="row mt-2 justify-content-center">
			<div class="col">
				<table class="table table-bordered" action="<?php echo $path.'modules/add_entry.php' ?>">
					<thead>
						<tr>
							<th>Date (yyyy/mm/dd)</th>
							<th>Number Of Message </th>
							<th>Rate</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$total_mssg = 0;
							$total_rate = 0;
							foreach ($result as $key) {
								$mssg = $key['num_of_mssg'];
								$rate = $key['rate'];
								$id = $key['id'];
								$total_mssg += $mssg; 
								$total_rate += $rate; 
						?>
							<tr>
								<td width="30%"><?php echo $key['date']; ?></td>
								<td width="30%"><?php echo '<input data-number="'.$id.'" type="text" class="form-control col-3 num_of_mssg" value="'.$mssg.'" ><span class="text-danger" id="err_'.$id.'"></span>';  ?></td>
								<td width="30%"><?php echo '$'.$rate; ?></td>
							</tr>
						<?php
							}
						?>
						<tr>
							<td class="text-success font-weight-bold">Total</td>
							<td class="text-success font-weight-bold"><?php echo $total_mssg; ?></td>
							<td class="text-success font-weight-bold"><?php echo '$'.$total_rate; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	<?php	
	}else{
		echo '<div class="row mt-3">';
		echo	'<div class="col text-center">';

				echo '<h1>NO DATA FOUND</h4>';

		echo	'</div>
			</div>';
	}		
		}else{
			echo '<div class="row mt-3">';
		echo	'<div class="col text-center">';

				echo '<h1>NO DATA FOUND</h4>';

		echo	'</div>
			</div>';
		}
		?>

	<script type="text/javascript" src="<?php echo $path.'assets/js/bootstrap.min.js';?>"></script>
	<script type="text/javascript">
		Date.prototype.toDateInputValue = (function() {
		    var local = new Date(this);
		    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
		    return local.toJSON().slice(0,10);
		});
		//document.getElementById('date').value = new Date().toDateInputValue();

		$(".num_of_mssg").change(function() {
			var num_of_mssg = $(this).val();
			var id_num = $(this).attr('data-number');
 	 		var action = $(".table").attr('action');
 	 		var err_mssg = '#err_'+id_num;
 	 		console.log(err_mssg);
 	 		if (!$.isNumeric(num_of_mssg)) {
 	 			$(err_mssg).text('Insert a numeric value');
 	 		}else{
 	 			$(err_mssg).text('');
 	 			$.ajax({
 	 				url: action,
 	 				method: 'POST',
 	 				data: {id:id_num, num_of_mssg:num_of_mssg},
 	 				success: function(mssg) {
 	 					$(err_mssg).addClass('text-success');
 	 					$(err_mssg).removeClass('text-danger');
 	 					$(err_mssg).text(mssg);
 	 					setTimeout(function(){
 	 						window.location.reload();
 	 					}, 500);
 	 				}
 	 			});
 	 		}		
		});
	</script>

<?php
include $path.'footer.php';