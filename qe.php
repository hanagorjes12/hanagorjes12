<?php include('db_connect.php'); ?>

<div class="container-fluid">

	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
				<form action="" id="manage-house">
					<div class="card">
						<div class="card-header">
							Properties Form
						</div>
						<div class="card-body">
							<div class="form-group" id="msg"></div>
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">House No</label>
								<input type="text" class="form-control" name="house_no" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Developer</label>
								<input type="text" class="form-control" name="developer" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Category</label>
								<select name="category_id" id="" class="custom-select" required>
									<?php
									$categories = $conn->query("SELECT * FROM categories order by name asc");
									if ($categories->num_rows > 0) :
										while ($row = $categories->fetch_assoc()) :
									?>
											<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
										<?php endwhile; ?>
									<?php else : ?>
										<option selected="" value="" disabled="">Please check the category list.</option>
									<?php endif; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Property Address</label>
								<textarea name="address" id="" cols="20" rows="2" class="form-control" required></textarea>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Description</label>
								<textarea name="description" id="" cols="30" rows="3" class="form-control" required></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Price</label>
								<input type="number" class="form-control text-right" name="price" step="any" required="">
							</div>

							<div class="form-group">
								<label for="" class="control-label">Date in Market</label>
								<input type="date" class="form-control" name="date_in" value="<?php echo date('Y-m-d', abs(strtotime($row['date_in'] . " 23:59:59"))); ?>" required>
							</div>
							<div class="form-group">
								<label for="propertyImage">Insert Image</label>
								<input type="file" class="form-control-file btn" id="propertytimage" name="propertyimage" value="">
								<input type="text" value="" name="filename" id="filename" class="form-control" readonly>

							</div>
							<div class="form-group">
								<label for="status">Status</label>
								<select name="status" id="status">
									<option value="">Select Status</option>
									<option value="On View">On View</option>
									<option value="Rented">Rented</option>
									<option value="Sold">Sold</option>
								</select></br><small><i>Leave this blank if you dont want to add / change the status.</i></small>
								<input type="text" value="" name="statuscheck" id="statuscheck" class="form-control" readonly>
							</div>

						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
									<button class="btn btn-sm btn-default col-sm-3" type="reset"> Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Properties List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">House</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$house = "SELECT h.*,c.name as cname, h.house_no, h.address, h.developer, h.date_in ,h.propertyimage FROM houses h inner join categories c on c.id = h.category_id order by id asc";
								$result = mysqli_query($conn, $house);
								while ($row = mysqli_fetch_assoc($result)) {
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td class="">
											<p>House Number : <b><?php echo $row['house_no'] ?></b></p>
											<p><small>Developer : <b><?php echo $row['developer'] ?></b></small></p>
											<p><small>Category : <b><?php echo $row['cname'] ?></b></small></p>
											<p><small>Description : <b><?php echo $row['description'] ?></b></small></p>
											<p><small>Address : <b><?php echo $row['address'] ?></b></small></p>
											<p><small>Price : <b> RM <?php echo number_format($row['price'], 2) ?></b></small></p>
											<p><small>Date in Market : <b><?php echo date('Y-m-d', abs(strtotime($row['date_in'] . " 23:59:59"))); ?></b></small></p>
											<p><small>Image : <b><?php echo $row['propertyimage'] ?></b></small></p>
											<p><small>Status : <?php if($row['status'] == "Rented"){ echo '<span class="badge badge-primary">Rented</span>';}if($row['status'] == "On View"){ echo '<span class="badge badge-secondary">On View</span>';}if($row['status'] == "Sold"){ echo '<span class="badge badge-danger">Rented</span>';}?></small></p>
										</td>
										<td class="text-center">
											<button class="btn btn-sm btn-primary edit_house" type="button" data-id="<?php echo $row['id'] ?>" data-house_no="<?php echo $row['house_no'] ?>" data-developer="<?php echo $row['developer'] ?>" data-address="<?php echo $row['address'] ?>" data-description="<?php echo $row['description'] ?>" data-category_id="<?php echo $row['category_id'] ?>" data-price="<?php echo $row['price'] ?>" data-date_in="<?php echo $row['date_in'] ?>" data-image="<?php echo $row['propertyimage'] ?>" data-status="<?php echo $row['status'] ?>">Edit</button>
											<button class="btn btn-sm btn-danger delete_house" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
	$('#manage-house').on('reset', function(e) {
		$('#msg').html('')
	})
	$('#manage-house').submit(function(e) {
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url: 'ajax.php?action=save_house',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully saved", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				} else if (resp == 2) {
					$('#msg').html('<div class="alert alert-danger">Please recheck.</div>')
					end_load()
				}
			}
		})
	})
	$('.edit_house').click(function() {

		start_load()
		var cat = $('#manage-house')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='house_no']").val($(this).attr('data-house_no'))
		cat.find("[name='developer']").val($(this).attr('data-developer'))
		cat.find("[name='address']").val($(this).attr('data-address'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id'))
		cat.find("[name='date_in']").val($(this).attr('data-date_in'))
		cat.find("[name='filename']").val($(this).attr('data-image'))
		cat.find("[name='statuscheck']").val($(this).attr('data-status'))
		end_load()
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
	$('table').dataTable()
</script>