<?php include('db_connect.php'); ?>

<div class="container-fluid">

	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">

			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Appointment List</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_appointment">
								<i class="fa fa-plus"></i> New Appointment
							</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Name</th>
									<th class="">Date</th>
									<th class="">Time</th>
									<th class="">Email</th>
									<th class="">Phone No</th>
									<th>Place To Meet</th>
									<th>Validation</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$query = "SELECT * FROM appointment";
								$tenant = mysqli_query($conn, $query);
								while ($row = mysqli_fetch_assoc($tenant)) {
									$date =	date("d-m-Y", strtotime($row['date']));
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class="">
											<p> <b><?php echo $row['name'] ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $date ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $row['time'] ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $row['email'] ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $row['phone'] ?></b></p>
										</td>
										<td>
											<p> <b><?php echo $row['place'] ?></b></p>
										</td>
										<td class="text-center">
											<button class="btn btn-sm btn-outline-primary edit_appointment" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
											<button class="btn btn-sm btn-outline-danger delete_appointment" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										</td>
										<?php if ($row['verify'] == "Reject") { ?>
											<td class="text-center">
												<p><b>Quotation Rejected</b></p>
											</td>
									</tr>
								<?php }
										if ($row['verify'] == "Accept") { ?>
									<td class="text-center">
										<p><b>Quotation Accepted</b></p>
									</td>
									</tr>
								<?php }
										if ($row['verify'] == "") { ?>
									<td class="text-center">
										<button class="btn btn-sm btn-outline-primary accept_appointment" type="button" data-id="<?php echo $row['id'] ?>">Accept</button>
										<button class="btn btn-sm btn-outline-danger reject_appointment" type="button" data-id="<?php echo $row['id'] ?>">Reject</button>
									</td>
									</tr>
								<?php } ?>
								</tr>


							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset
	}

	img {
		max-width: 100px;
		max-height: 150px;
	}
</style>
<script>
	$(document).ready(function() {
		$('table').dataTable()
	})

	$('#new_appointment').click(function() {
		uni_modal("New Appointment", "manage_appointment.php", "mid-large")

	})

	$('.edit_appointment').click(function() {
		uni_modal("Manage Appointment Details", "manage_appointment.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_appointment').click(function() {
		_conf("Delete Appointment?", "delete_appointment", [$(this).attr('data-id')])
	})

	function delete_appointment($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_appointment',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Appointment Deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}

	$('.accept_appointment').click(function() {
		_conf("Accept Appointment?", "accept_appointment", [$(this).attr('data-id')])

	})
	$('.reject_appointment').click(function() {
		_conf("Reject Appointment?", "reject_appointment", [$(this).attr('data-id')])
	})

	function reject_appointment($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=reject_appointment',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Appointment Rejected", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}

	function accept_appointment($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=accept_appointment',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Appointment Accepted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>