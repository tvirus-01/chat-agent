<?php
$path = '../../../';
include $path.'modules/db_con.php';
$client = $_COOKIE['client'];
$client_type = $_COOKIE['client_type'];

$admin = $conn->query("SELECT * FROM tbl_admin WHERE admin_name = '{$client}'");
$admin_row = mysqli_num_rows($admin);

if (!isset($client) || !isset($client_type)) {
	header('Location: '.$path.'index.php');
}elseif ($client_type != 'admin') {
	header('Location: '.$path.'index.php');
}elseif ($admin_row != '1') {
	header('Location: '.$path.'index.php');
}
$sq = '';
if (isset($_GET['sq'])) {
	$sq = $_GET['sq'];
	$users = $conn->query("SELECT * FROM tbl_agent WHERE user_name LIKE '%{$sq}%' OR user_email LIKE '%{$sq}%' OR nmsid LIKE '%{$sq}%'");
	$num_of_row = mysqli_num_rows($users);
}else{
	$users = $conn->query("SELECT * FROM tbl_agent");
	$num_of_row = mysqli_num_rows($users);
}

include $path.'header.php';
?>
	<div class="row justify-content-center bg-success">
		<div class="col text-center">
			<h1 class="text-light float-left">wellcome <?php echo $client; ?></h1>
			<form action="<?php echo $path.'modules/logout.php'; ?>" method="post">
				<button type="submit" name="logout" value="" class="btn btn-danger mt-2 float-right">Logout</button>
			</form>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col">
			<form class="search">
				<?php
					if (isset($_GET['sq'])) {
						echo '<a href="'.$path.'index.php" class="btn btn-link float-right">Clear</a>';
					}
				?>
				<button type="submit" class="btn btn-primary float-right" style="border-radius: 0 0.5rem 0.5rem 0;">search</button>
				<input type="text" required name="sq" placeholder="search by name, NMSID" value="<?php echo $sq; ?>" style="border-radius: 0.5rem 0 0 0.5rem;" class="form-control col-3 float-right">
			</form>
		</div>
	</div>
	<div class="row mt-2">
		<div class="col">
			<div class="row mb-2">
				<div class="col">
					<h3 class="float-left">Agent Table</h3>
					<a class="btn btn-info float-right" href="<?php echo $path.'templates/signup.php'; ?>">Add Agent</a>
				</div>
			</div>
			<?php
				if ($num_of_row > 0) {
			?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col" class="text-center">NMS_ID</th>
						<th scope="col" class="text-center">User Name</th>
						<th scope="col" class="text-center">User Email</th>
						<th scope="col" class="text-center" colspan="2">
							Total
							<br> Mssg || Rate
						</th>
						<th scope="col" class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$tot_mssg = 0;
						$tot_rate = 0;
						foreach ($users as $user) {
							$userid = $user['id'];
							$username = $user['user_name'];
							$useremail = $user['user_email'];
							$nmsid = $user['nmsid'];
							$totals = $conn->query("SELECT * FROM tbl_daily_production WHERE userid = {$userid}");
							$total_mssg = 0;
							$total_rate = 0;
							foreach ($totals as $key) {
								$mssg = $key['num_of_mssg'];
								$rate = $key['rate'];
								$total_mssg += $mssg; 
								$total_rate += $rate;
							}
					?>
						<tr>
							<td><a href="daily-production.php?uid=<?php echo $userid; ?>" class="btn btn-link"><?php echo $nmsid; ?></a></td>
							<td><?php echo $username; ?></td>
							<td><?php echo $useremail; ?></td>
							<td><?php echo $total_mssg; ?></td>
							<td><?php echo '$'.$total_rate; ?></td>
							<td class="text-center">
								<button class="btn btn-danger btn-sm mr-3 dlt_btn" meta-data="<?php echo $userid; ?>" data-toggle="modal" data-target="#dlt_modal">X</button>
								<button class="btn btn-info btn-sm edt_btn" meta-uname="<?php echo $username; ?>" meta-email="<?php echo $useremail; ?>" meta-nmsid="<?php echo $nmsid; ?>" data-toggle="modal" meta-data="<?php echo $userid; ?>" data-target="#edt_modal"><img src="<?php echo $path.'assets/img/icon/pencil.png' ?>"></button>
							</td>
						</tr>
					<?php
						$tot_mssg += $total_mssg;
						$tot_rate += $total_rate;
						}
					?>
					<tr>
						<td class="font-weight-bold">Total</td>
						<td></td>
						<td></td>
						<td><?php echo $tot_mssg; ?></td>
						<td><?php echo $tot_rate; ?></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<div class="modal fade" id="dlt_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header bg-danger">
			        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Delete</h5>
			        <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<span>Are you sure you want to delete this user?</span>
			      	<br>
			      	<span class="text-warning"></span>
			      	<input type="hidden" class="meta" value="">
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" onclick="window.location.reload()" data-dismiss="modal">Cancle</button>
			        <button type="button" class="btn btn-danger dlt_con">Delete</button>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="modal fade" id="edt_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header bg-primary">
			        <h5 class="modal-title text-light" id="exampleModalLongTitle">Edit User Info</h5>
			        <button type="button" class="close" data-dismiss="modal" onclick="window.location.reload()" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div class="form-group">
			      		<label>User Name</label>
			      		<input type="text" class="form-control uname">
			      		<input type="hidden" class="metaid" value="">	
			      	</div>
			      	<div class="form-group">
			      		<label>User Email</label>
			      		<input type="text" class="form-control umail">	
			      	</div>
			      	<div class="form-group">
			      		<label>NMS ID</label>
			      		<input type="text" class="form-control nmsid">	
			      	</div>
			      	<br>
			      	<span class="text-success text-edit"></span>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" onclick="window.location.reload()" data-dismiss="modal">Cancle</button>
			        <button type="button" class="btn btn-primary edt_con">Save Changes</button>
			      </div>
			    </div>
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
			 ?>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo $path.'assets/js/bootstrap.min.js';?>"></script>
	<script type="text/javascript">
		$('.dlt_btn').click(function() {
			var userid = $(this).attr('meta-data');
			$(".meta").val(userid);
		});
		$('.dlt_con').click(function() {
			var userid = $('.meta').val();
			$.ajax({
				url: '../../../modules/delete_user.php',
				method: 'POST',
				data: {uid: userid},
				success: function(mssg) {
					$('.text-warning').text(mssg);
					setTimeout(function(){
						window.location.reload();
					}, 500);
				}
			});
		});

		$('.edt_btn').click(function(){
			var username = $(this).attr('meta-uname');
			var useremail = $(this).attr('meta-email');
			var nmsid = $(this).attr('meta-nmsid');
			var userid = $(this).attr('meta-data');
			$('.uname').val(username);
			$('.umail').val(useremail);
			$('.nmsid').val(nmsid);
			$('.metaid').val(userid);
		});

		$('.edt_con').click(function() {
			var uname = $('.uname').val();
			var umail = $('.umail').val();
			var nmsid = $('.nmsid').val();
			var metaid = $('.metaid').val();
			$.ajax({
				url: '../../../modules/edit_user.php',
				method: 'POST',
				data: {uid: metaid, uname: uname, umail: umail, nmsid: nmsid},
				success: function(mssg) {
					$('.text-edit').text(mssg);
					setTimeout(function(){
						window.location.reload();
					}, 500);
				}
			})
		});

	</script>
<?php
include $path.'footer.php';