<?php include 'db_connect.php' ?>
<?php

$month_of = isset($_GET['month_of']) ? $_GET['month_of'] : date('Y-m');

?>
<style>
	.on-print {
		display: none;
	}
</style>
<noscript>
	<style>
		.text-center {
			text-align: center;
		}

		.text-right {
			text-align: right;
		}

		table {
			width: 100%;
			border-collapse: collapse
		}

		tr,
		td,
		th {
			border: 1px solid black;
		}
	</style>
</noscript>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="col-md-12">
					<form id="filter-report">
						<div class="row form-group">
							<label class="control-label col-md-2 offset-md-2 text-right">Month of: </label>
							<input type="month" name="month_of" class='from-control col-md-4' value="<?php echo ($month_of) ?>">
							<button class="btn btn-sm btn-block btn-primary col-md-2 ml-1">Filter</button>
						</div>
					</form>
					<hr>
					<div class="row">
						<div class="col-md-12 mb-2">
							<button class="btn btn-sm btn-block btn-success col-md-2 ml-1 float-right" type="button" id="print"><i class="fa fa-print"></i> Print</button>
						</div>
					</div>
					<div id="report">
						<div class="on-print">
							<p>
								<center>Rental Payments Report</center>
							</p>
							<p>
								<center>for the Month of <b><?php echo date('F ,Y', strtotime($month_of . '-1')) ?></b></center>
							</p>
						</div>
						<div class="row">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>Tenant</th>
										<th>House #</th>
										<th>Payment Status</th>
										<th>Verify Status</th>
										<th>Payment</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 1;
									$tamount = 0;
									if (isset($_GET['month_of'])) {
										$payments  = $conn->query("SELECT * FROM payment where landlord_id = " . $_SESSION['login_id'] . " and DATE_FORMAT(date,'%Y-%m') = '" . addslashes($_GET['month_of']) . "'");
									} else {
										$payments  = $conn->query("SELECT * FROM payment where landlord_id = " . $_SESSION['login_id']);
									}
									if ($payments->num_rows > 0) :
										while ($row = $payments->fetch_assoc()) :
											$tamount += $row['payment'];
											$select_house = mysqli_query($conn, "SELECT * FROM tenantss where id = " . $row['tenant_id']);
											$res_h = mysqli_fetch_assoc($select_house);
											$sqlhouse = mysqli_query($conn, "SELECT * FROM houses where id = " . $res_h['house_id']);
											$res = mysqli_fetch_assoc($sqlhouse);
											$tenant_id = $row['tenant_id'];
											$sqlbuyer = mysqli_query($conn, "SELECT * FROM tenantss where id = $tenant_id");
											$resb = mysqli_fetch_assoc($sqlbuyer);
									?>
											<tr>
												<td><?php echo $i++ ?></td>
												<td><?php echo date('M d,Y', strtotime($row['date'])) ?></td>
												<td><?php echo $resb['firstname'] . " " . $resb['middlename'] . " " . $resb['lastname']; ?></td>
												<td><?php echo $res['house_no'] ?></td>
												<td><?php echo $row['status'] ?></td>
												<td><?php echo $row['landlord_verify'] ?></td>
												<td><?php echo "RM " . $row['payment'] ?></td>
											</tr>
										<?php endwhile; ?>
										<tr>
											<td colspan="6"><span style="float:right;"><b>Total</b></span></td>
											<td><?php echo "RM " . $tamount; ?></td>
										</tr>
									<?php else : ?>
										<tr>
											<th colspan="7">
												<center>No Data.</center>
											</th>
										</tr>
									<?php endif; ?>
								</tbody>
								<!-- <tfoot>
									<tr>
										<th colspan="4">Total Payment</th>
										<th ><?php //echo "RM";echo $tamount;
												?></th>
									</tr>
								</tfoot> -->
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#print').click(function() {
		var _style = $('noscript').clone()
		var _content = $('#report').clone()
		var nw = window.open("", "_blank", "width=800,height=700");
		nw.document.write(_style.html())
		nw.document.write(_content.html())
		nw.document.close()
		nw.print()
		setTimeout(function() {
			nw.close()
		}, 500)
	})
	$('#filter-report').submit(function(e) {
		e.preventDefault()
		location.href = 'index.php?page=payment_report&' + $(this).serialize()
	})
</script>