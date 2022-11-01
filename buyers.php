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
						<b>List of Tenants</b>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_tenant">
					<i class="fa fa-plus"></i> New Tenant
				</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<!-- <th class=""> Buyer ID</th> -->
									<th class="">House No</th>
									<th class="">Name</th>
									<th class="">Phone Number</th>
									<th class="">Email</th>
									<!-- <th class="">Address</th> -->
									<!-- <th class="">Username</th> -->
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$tenant = $conn->query("SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name, t.id, t.email, t.address, t.username, t.password, h.house_no,h.price FROM tenantss t inner join houses h on h.id = t.house_id where t.status = 1 and t.landlord_id = ".$_SESSION['login_id']." order by h.house_no desc ");
								while ($row = $tenant->fetch_assoc()) :
										?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<!-- <td>
										<?php //echo ucwords($row['id']) 
										?>
									</td> -->
										<td class="">
											<p> <b><?php echo $row['house_no'] ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $row['firstname'] ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $row['contact'] ?></b></p>
										</td>
										<td class="">
											<p> <b><?php echo $row['email'] ?></b></p>
										</td>
										<!-- <td class="">
											<p> <b><?php echo $row['address'] ?></b></p>
										</td> -->
										<!-- <td class="">
										 <p> <b><?php //echo $row['username'] 
												?></b></p>
									</td> -->
										<td class="text-center">
											<button class="btn btn-sm btn-outline-primary edit_tenant" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
											<button class="btn btn-sm btn-outline-danger delete_tenant" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										</td>
									</tr>
								<?php endwhile; ?>
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

	$('#new_tenant').click(function() {
		uni_modal("New Tenant", "manage_tenant.php", "mid-large")

	})


	$('.edit_tenant').click(function() {
		uni_modal("Manage landlord Details", "manage_tenant.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_tenant').click(function() {
		_conf("Are you sure to delete this landlord?", "delete_tenant", [$(this).attr('data-id')])
	})

	function delete_tenant($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_tenant',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>