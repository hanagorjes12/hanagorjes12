<?php include('db_connect.php');
?>

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
						<b>House List</b>
						<?php if ($_SESSION['login_type'] != '3') { ?>

							<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_properties">
									<i class="fa fa-plus"></i> New House
								</a></span>
						<?php } ?>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">House</th>
									<th class="">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								if($_SESSION['login_type'] != '3'){
								$house = "SELECT * FROM houses where landlord_id = ".$_SESSION['login_id']." order by id asc";
								}else{
									$house = "SELECT * FROM houses order by id asc";
								}
								$result = mysqli_query($conn, $house);
								while ($row = mysqli_fetch_assoc($result)) {
									$category = $row['category_id'];
									$sqlcat = mysqli_query($conn, "SELECT * FROM categories where id = $category");
									$res = mysqli_fetch_array($sqlcat);
									$imageURL = 'images/' . $row["propertyimage"];
									$imageURL2 = 'images/' . $row["propertyimage2"];
									$imageURL3 = 'images/' . $row["propertyimage3"];
									$imageURL4 = 'images/' . $row["propertyimage4"];
									$imageURL5 = 'images/' . $row["propertyimage5"];
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class="">
											<p>House Number : <b><?php echo $row['house_no'] ?></b></p>
											<p><small>Developer : <b><?php echo $row['developer'] ?></b></small></p>
											<p><small>Category : <b><?php echo $res['name'] ?></b></small></p>
											<p><small>Description : <b><?php echo $row['description'] ?></b></small></p>
											<p><small>Address : <b><?php echo $row['address'] ?></b></small></p>
											<p><small>Price : <b> RM <?php echo number_format($row['price'], 2) ?></b></small></p>
											<p><small>Date in Market : <b><?php echo date('Y-m-d', abs(strtotime($row['date_in'] . " 23:59:59"))); ?></b></small></p>
											<!-- <p><small>Image : <b><?php //echo $row['propertyimage'] 
																		?></b></small></p> -->
											<img src="<?php echo $imageURL; ?>" alt="" width="150" height="150" />
											<img src="<?php echo $imageURL2; ?>" alt="" width="150" height="150" />
											<img src="<?php echo $imageURL3; ?>" alt="" width="150" height="150" />
											<img src="<?php echo $imageURL4; ?>" alt="" width="150" height="150" />
											<img src="<?php echo $imageURL5; ?>" alt="" width="150" height="150" />
											<p><small>Status : <?php if ($row['status'] == "On View") {
																	echo '<span class="badge badge-secondary">On View</span>';
																}else{
																	echo '<span class="badge badge-success">Open To Rent</span>';
																} ?></small></p>
										</td>
										<td class="text-center">
											<?php if ($_SESSION['login_type'] != '3') { ?>
												<button class="btn btn-sm btn-outline-primary edit_house" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
												<button class="btn btn-sm btn-outline-danger delete_house" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
												<?php } else {
												if ($row['status'] == "Rented") {
												?>
													<button class="btn btn-outline-danger" disabled>Rented</button>
												<?php } else  { ?>
													<button class="btn btn-outline-success make_quotation" data-id="<?php echo $row['id'] ?>">Book Now</button>
											<?php }
											} ?>
										</td>
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
		margin: unset;
		padding: unset;
		line-height: 1em;
	}
</style>
<script>
	// $('#manage-house').on('reset', function(e) {
	// 	$('#msg').html('')
	// })
	$('#new_properties').click(function() {
		uni_modal3("New properties", "manage_houses.php", "mid-large")

	})
	$('.edit_house').click(function() {
		uni_modal3("Manage house Details", "manage_houses.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.make_quotation').click(function() {
		uni_modal("Make Quotation Of the House", "quotation.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_house').click(function() {
		_conf("Are you sure to delete this house?", "delete_house", [$(this).attr('data-id')])
	})

	function delete_house($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_house',
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
	// $('table').dataTable()
</script>