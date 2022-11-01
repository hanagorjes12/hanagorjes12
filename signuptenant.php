<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('db_connect.php');
include('header.php');
/*ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();*/
?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo $_SESSION['system']['name'] ?></title>


    <?php include('./header.php'); ?>
    <?php
    if (isset($_SESSION['login_id']))
        header("location:index.php?page=home");

    ?>

</head>
<style>
    body {
        width: 100%;
        height: calc(100%);
        /*background: #007bff;*/
    }

    main#main {
        width: 100%;
        height: calc(100%);
        background: white;
    }

    #login-right {
        position: absolute;
        right: 0;
        width: 40%;
        height: calc(100%);
        background: white;
        display: flex;
        align-items: center;
    }

    #login-left {
        position: absolute;
        left: 0;
        width: 60%;
        height: calc(100%);
        background: #59b6ec61;
        display: flex;
        align-items: center;
        /*background: url(assets/uploads/blood-cells.jpg);
	    background-repeat: no-repeat;
	    background-size: cover;*/
    }

    #login-right .card {
        margin: auto;
        z-index: 1
    }

    .logo {
        margin: auto;
        font-size: 8rem;
        background: white;
        padding: .5em 0.7em;
        border-radius: 50% 50%;
        color: #000000b3;
        z-index: 10;
    }

    div#login-right::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: calc(100%);
        height: calc(100%);
        /*background: #000000e0;*/
    }
</style>

<body>


    <main id="main" class=" bg-light">
        <div id="login-left" style="background-image: url('BG.jpg');background-size: 130% 100%;">
        </div>

        <div id="login-right" class="bg-dark">
            <div class="w-100">
                <h4 class="text-white text-center"><b><?php echo 'Tenant Signup' //echo $_SESSION['system']['name'] 
                                                        ?></b></h4>
                <br>
                <br>
                <div class="card col-md-8">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div id="msg"></div>

                            <form action="" id="manage-user">
                                <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name'] : '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="username">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($meta['email']) ? $meta['email'] : '' ?>" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="username">No Telephone</label>
                                    <input type="text" name="no_tel" id="no_tel" class="form-control" value="<?php echo isset($meta['no_tel']) ? $meta['no_tel'] : '' ?>" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
                                    <?php if (isset($meta['id'])) : ?>
                                        <small><i>Leave this blank if you dont want to change the password.</i></small>
                                    <?php endif; ?>
                                </div>
                                <input type="hidden" id="type" name="type" value="3" />



                                <div class="form-group">
                                    <center><button class="btn-sm btn-wave col-md-4 btn-primary" type="button" onclick="$('#manage-user').submit()">Signup</button></center>
                                </div>
                            </form>
                            <br />
                            <center><a href='#' onclick="history.back()">Back</a></center>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>


</html>
<script>
    window.start_load = function() {
        $('body').prepend('<di id="preloader2"></di>')
    }
    $('#manage-user').submit(function(e) {
        e.preventDefault();
        // start_load()
        $.ajax({
            url: 'ajax.php?action=save_user',
            method: 'POST',
            type: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                if (resp == 1) {
                    alert("Register Successfully", 'success')
                    setTimeout(function() {
                        // location.reload()
                        window.location.href = "tenantlogin.php";
                    }, 1500)

                }
            }
        })
    })
</script>