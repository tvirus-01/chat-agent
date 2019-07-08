<?php
$path = '../';
include $path.'modules/db_con.php';
$client = $_COOKIE['client'];

if (!isset($client)) {
	header('Location: '.$path.'index.php');
}
include $path.'header.php';
?>
	<div class="row justify-content-center bg-success">
		<div class="col text-center">
			<h1 class="text-light float-left">wellcome <?php echo $client; ?></h1>
			<a href="<?php echo $path.'index.php'; ?>" class="btn btn-secondary float-right mt-2 ml-3">Back to Dashboard</a>
			<form action="<?php echo $path.'modules/logout.php'; ?>" method="post">
				<button type="submit" name="logout" value="" class="btn btn-danger mt-2 float-right">Logout</button>
			</form>
		</div>
	</div>
	<div class="row mt-5">
		<div class="col text-center">			
			<span class="h4 mb-4">Add New User</span>
		</div>
	</div>
	<div class="row mt-5 justify-content-center">
		<div class="col-5" id="alert">			
			<span id="aletr_text"></span>
		</div>
	</div>
	<div class="row justify-content-center mt-3">
		<div class="col-5 shadow-sm">
			<form action="<?php echo $path.'modules/registrer.php' ?>" id="usubmitfrom">
				<div class="form-group">
					<label>User Name</label>
					<input type="text" name="uname" id="uname" class="form-control">
				</div>
				<div class="form-group">
					<label>User Email</label>
					<input type="text" name="umail" id="umail" class="form-control">
				</div>
				<div class="form-group">
					<label>NMSID</label>
					<input type="text" name="nmsid" id="nmsid" class="form-control">
				</div>
				<div class="form-group">
					<input type="button" name="uform" id="usubmit" value="Add New User" class="btn btn-success">
					<br><br>
					<span class="text-danger" id="err_mssg_up"></span>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript">
		$("#usubmit").click(function(){
			var uname = $("#uname").val();
			var umail = $("#umail").val();
			var nmsid = $("#nmsid").val();

			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
 	 		var emailval = regex.test(umail);
 	 		var action = $("#usubmitfrom").attr('action');

			if (!uname || !umail || !nmsid) {
				$('#err_mssg_up').text('All field is required');
			}else{
				$('#err_mssg_up').text('');
				if (emailval == false) {
					$('#err_mssg_up').text('Email is not valid');
				}else{
					$('#err_mssg_up').text('');
					$('#err_mssg_up').text('');
					$.ajax({
						url: action,
						method: 'POST',
						data: {username:uname, usermail:umail, nmsid:nmsid},
						success: function(mssg){
							$('#usubmitfrom').trigger("reset");
							$("#alert").addClass('alert alert-success');
							$("#aletr_text").fadeIn().text(mssg);
							setTimeOut(function(){
								$("#aletr_text").fadeOut('slow');
								$("#alert").removeClass('alert alert-success');
							}, 3500);
						}
					});
				}
			}
		});
	</script>
<?php
include $path.'footer.php';