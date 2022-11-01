<style>
	.collapse a {
		text-indent: 10px;
	}

	nav#sidebar {
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark'>

	<div class="sidebar-list">
		<?php if ($_SESSION['login_type'] == 1) : ?>
			<a href="index.php?page=adminhome" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
			<a href="index.php?page=buyers" class="nav-item nav-buyers"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Tenant</a>
			<a href="index.php?page=tenants" class="nav-item nav-tenants"><span class='icon-field'><i class="fa fa-user-friends "></i></span>Landlords</a>
			<a href="index.php?page=reports" class="nav-item nav-reports"><span class='icon-field'><i class="fa fa-folder-open "></i></span> Reports</a>
			<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users "></i></span> Users</a>
			<a href="index.php?page=company" class="nav-item nav-company"><span class='icon-field'><i class="fa fa-building "></i></span> Company</a>
			<!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs text-danger"></i></span> System Settings</a> -->
		<?php endif; ?>
		<?php if ($_SESSION['login_type'] == 2) : ?>
			<a href="index.php?page=agenthome" class="nav-item nav-agenthome"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
			<a href="index.php?page=houses" class="nav-item nav-houses"><span class='icon-field'><i class="fa fa-home "></i></span> Properties</a>
			<a href="index.php?page=buyers" class="nav-item nav-buyers"><span class='icon-field'><i class="fa fa-user-friends "></i></span> Tenant</a>
			<a href="index.php?page=payments" class="nav-item nav-payments"><span class='icon-field'><i class="fa fa-file-invoice "></i></span> Payments</a>
			<a href="index.php?page=agreement" class="nav-item nav-agreement"><span class='icon-field'><i class="fa fa-file-contract "></i></span> Agreement</a>
			<a href="index.php?page=quotation_list" class="nav-item nav-quotation_list"><span class='icon-field'><i class="fa fa-fquestion-circle "></i></span> Quotation</a>
			<a href="index.php?page=email_notification" class="nav-item nav-email_notification"><span class='icon-field'><i class="fa fa-envelope "></i></span> Send Mail Notification</a>
			<a href="index.php?page=reports" class="nav-item nav-reports"><span class='icon-field'><i class="fa fa-folder-open "></i></span> Reports</a>

		<?php endif; ?>
		<?php if ($_SESSION['login_type'] == 3) : ?>
			<!-- <a href="index.php?page=tenanthome" class="nav-item nav-tenanthome"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a> -->
			<a href="index.php?page=houses" class="nav-item nav-houses"><span class='icon-field'><i class="fa fa-home "></i></span> Properties</a>
			<!-- <a href="index.php?page=tenantrent" class="nav-item nav-tenantrent"><span class='icon-field'><i class="fa fa-home "></i></span> Tenant Rent And Payment</a> -->
			<a href="index.php?page=agreement" class="nav-item nav-agreement"><span class='icon-field'><i class="fa fa-file-contract "></i></span> Agreement</a>
			<a href="index.php?page=tenanthouse" class="nav-item nav-tenanthouse"><span class='icon-field'><i class="fa fa-home "></i></span> Tenant Rented House</a>
			<a href="index.php?page=tenant_notification" class="nav-item nav-tenant_notification"><span class='icon-field'><i class="fa fa-envelope "></i></span> Mail Notification</a>
		<?php endif; ?>
	</div>

</nav>
<script>
	$('.nav_collapse').click(function() {
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>