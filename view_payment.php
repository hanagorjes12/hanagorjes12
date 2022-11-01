<?php include 'db_connect.php' ?>

<?php
$id = $_GET['id'];
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<large><b>Payment List</b></large>
			<hr>
			<table class="table table-condensed table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Landlord</th>
						<th>House No #</th>
						<th>Buyer / Tenant</th>
						<th>Amount</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$payments = $conn->query("SELECT * FROM payment where id = $id");
					$row = $payments->fetch_assoc();
					$house_id = $row['house_id'];
					$sqlhouse = mysqli_query($conn, "SELECT * FROM houses where id = $house_id");
					$res = mysqli_fetch_assoc($sqlhouse);
					$tenant_id = $row['tenant_id'];
					$query_tenant = mysqli_query($conn, "SELECT * FROM tenantss where id = $tenant_id");
					$resb = mysqli_fetch_assoc($query_tenant);
					?>
					<tr>
						<td><?php echo date("M d, Y", strtotime($row['date'])) ?></td>
						<td><?php echo $row['tenant_id'] ?></td>
						<td class='text-left'><?php echo $res['house_no'] ?></td>
						<td><?php echo $resb['firstname']." ".$resb['middlename']." ".$resb['lastname']; ?></td>
						<td><?php echo "RM";
							echo number_format($row['payment'], 2) ?></td>
						<td class='text-left'><?php echo $row['status'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	#details p {
		margin: unset;
		padding: unset;
		line-height: 1.3em;
	}

	td,
	th {
		padding: 3px !important;
	}
</style>