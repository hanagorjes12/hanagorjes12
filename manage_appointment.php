<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM appointment where id= ".$_GET['id']);

foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
}
?>

<div class="container-fluid">
	<form action="" id="manage-appointment">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="row form-group">
			<div class="col-md-4">
				<label for="" class="control-label">Name</label>
				<input type="text" class="form-control" name="name"  value="<?php echo isset($name) ? $name :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Date</label>
				<input type="date" data-date="" data-date-format="dd/mm/yyyy" class="form-control" name="date"  value="<?php echo isset($date) ? $date :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">time</label>
				<input type="time" class="form-control" name="time"  value="<?php echo isset($time) ? $time :'' ?>">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-4">
				<label for="" class="control-label">Email</label>
				<input type="email" class="form-control" name="email"  value="<?php echo isset($email) ? $email :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Phone Number</label>
				<input type="text" class="form-control" name="phone"  value="<?php echo isset($phone) ? $phone :'' ?>" required>
			</div>
			<div class="col-md-4">
				<label for="" class="control-label">Place To Meet</label>
				<input type="text" class="form-control" name="place"  value="<?php echo isset($place) ? $place :'' ?>" required>
			</div>
			
			
		</div>
		<div class="form-group row">
		
	</form>
</div>
<script>

	$('#manage-appointment').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_appointment',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved.",'success')
						setTimeout(function(){
							location.reload()
						},1000)
				}
			}
		})
	})
</script>