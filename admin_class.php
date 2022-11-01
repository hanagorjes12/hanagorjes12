<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	//login database
	function login()
	{

		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '" . $username . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			if ($_SESSION['login_type'] == 2) {

				return 2;
				exit;
			}
			if ($_SESSION['login_type'] == 3) {

				return 3;
				exit;
			}
			return 1;
		} else {
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			return 3;
		}
	}
	//not have database
	function login2()
	{

		extract($_POST);
		if (isset($email))
			$username = $email;
		$qry = $this->db->query("SELECT * FROM users where username = '" . $username . "' and password = '" . md5($password) . "' ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			if ($_SESSION['login_alumnus_id'] > 0) {
				$bio = $this->db->query("SELECT * FROM alumnus_bio where id = " . $_SESSION['login_alumnus_id']);
				if ($bio->num_rows > 0) {
					foreach ($bio->fetch_array() as $key => $value) {
						if ($key != 'passwors' && !is_numeric($key))
							$_SESSION['bio'][$key] = $value;
					}
				}
			}
			if ($_SESSION['bio']['status'] != 1) {
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				return 2;
				exit;
			}
			return 1;
		} else {
			return 3;
		}
	}
	//log out user
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	//admin page logout
	function AdminPageLogout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:landlordlogin.php");
	}
	//not have
	function logout2()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	//cant function

	function save_user()
	{
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", email = '$email' ";
		$data .= ", no_tel = '$no_tel' ";
		$data .= ", password = '" . md5($password) . "' ";
		$data .= ", type = '$type' ";

		// $chk = $this->db->query("Select * from users where username = '$username'")->num_rows;
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO users set $data");
		} else {
			$save = $this->db->query("UPDATE users set name = '$name', username = '$username', password = '" . md5($password) . "' where id = $id");
		}
		if ($save)
			return 1;
	}
	function delete_user()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM users where id = $id");
		if ($delete)
			return 1;
	}
	function signup()
	{
		extract($_POST);
		$data = " name = '" . $firstname . ' ' . $lastname . "' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '" . md5($password) . "' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}
		$save = $this->db->query("INSERT INTO users set " . $data);
		if ($save) {
			$uid = $this->db->insert_id;
			$data = '';
			foreach ($_POST as $k => $v) {
				if ($k == 'password')
					continue;
				if (empty($data) && !is_numeric($k))
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if ($_FILES['img']['tmp_name'] != '') {
				$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
				$data .= ", avatar = '$fname' ";
			}
			$save_alumni = $this->db->query("INSERT INTO alumnus_bio set $data ");
			if ($data) {
				$aid = $this->db->insert_id;
				$this->db->query("UPDATE users set alumnus_id = $aid where id = $uid ");
				$login = $this->login2();
				if ($login)
					return 1;
			}
		}
	}
	function update_account()
	{
		extract($_POST);
		$data = " name = '" . $firstname . ' ' . $lastname . "' ";
		$data .= ", username = '$email' ";
		if (!empty($password))
			$data .= ", password = '" . md5($password) . "' ";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' and id != '{$_SESSION['login_id']}' ")->num_rows;
		if ($chk > 0) {
			return 2;
			exit;
		}
		$save = $this->db->query("UPDATE users set $data where id = '{$_SESSION['login_id']}' ");
		if ($save) {
			$data = '';
			foreach ($_POST as $k => $v) {
				if ($k == 'password')
					continue;
				if (empty($data) && !is_numeric($k))
					$data = " $k = '$v' ";
				else
					$data .= ", $k = '$v' ";
			}
			if ($_FILES['img']['tmp_name'] != '') {
				$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
				$data .= ", avatar = '$fname' ";
			}
			$save_alumni = $this->db->query("UPDATE alumnus_bio set $data where id = '{$_SESSION['bio']['id']}' ");
			if ($data) {
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				$login = $this->login2();
				if ($login)
					return 1;
			}
		}
	}

	function save_settings()
	{
		extract($_POST);
		$data = " name = '" . str_replace("'", "&#x2019;", $name) . "' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '" . htmlentities(str_replace("'", "&#x2019;", $about)) . "' ";
		if ($_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", cover_img = '$fname' ";
		}

		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if ($chk->num_rows > 0) {
			$save = $this->db->query("UPDATE system_settings set " . $data);
		} else {
			$save = $this->db->query("INSERT INTO system_settings set " . $data);
		}
		if ($save) {
			$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
			foreach ($query as $key => $value) {
				if (!is_numeric($key))
					$_SESSION['system'][$key] = $value;
			}

			return 1;
		}
	}


	function save_category()
	{
		extract($_POST);
		$data = " name = '$name' ";
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO categories set $data");
		} else {
			$save = $this->db->query("UPDATE categories set $data where id = $id");
		}
		if ($save)
			return 1;
	}
	function delete_category()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM categories where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function save_developer()
	{
		extract($_POST);
		$data = " name = '$name' ";
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO developers set $data");
		} else {
			$save = $this->db->query("UPDATE developers set $data where id = $id");
		}
		if ($save)
			return 1;
	}
	function delete_developer()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM developers where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function save_house()
	{
		extract($_POST);
		// print_r($_POST);
		$propertyimage = $_FILES["propertyimage"]["name"];
		$propertyimage2 = $_FILES["propertyimage2"]["name"];
		$propertyimage3 = $_FILES["propertyimage3"]["name"];
		$propertyimage4 = $_FILES["propertyimage4"]["name"];
		$propertyimage5 = $_FILES["propertyimage5"]["name"];

		$data = " house_no = '".mysqli_real_escape_string($this->db, $house_no)."' ";
		$data .= ", description = '".mysqli_real_escape_string($this->db, $description)."' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", price = '$price' ";

		$data .= ", address='".mysqli_real_escape_string($this->db, $address)."'";
		$data .= ", date_in='$date_in'";
		$data .= ", status='$status'";


		if (empty($id)) {
			$data .= ", developer_id= 0";
			$data .= ", developer= '$developer'";
			$data .= ", landlord_id='$landlord_id'";
			$target_dir = "images/";
			$propertyimage = $_FILES['propertyimage']['name'];
			$propertyimage2 = $_FILES['propertyimage2']['name'];
			$propertyimage3 = $_FILES['propertyimage3']['name'];
			$propertyimage4 = $_FILES['propertyimage4']['name'];
			$propertyimage5 = $_FILES['propertyimage5']['name'];
			$targetFilePath = $target_dir . basename($propertyimage);
			$targetFilePath2 = $target_dir . basename($propertyimage2);
			$targetFilePath3 = $target_dir . basename($propertyimage3);
			$targetFilePath4 = $target_dir . basename($propertyimage4);
			$targetFilePath5 = $target_dir . basename($propertyimage5);
			// $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			if (move_uploaded_file($_FILES['propertyimage']['tmp_name'], $targetFilePath) && move_uploaded_file($_FILES['propertyimage2']['tmp_name'], $targetFilePath2) && move_uploaded_file($_FILES['propertyimage3']['tmp_name'], $targetFilePath3) && move_uploaded_file($_FILES['propertyimage4']['tmp_name'], $targetFilePath4) && move_uploaded_file($_FILES['propertyimage5']['tmp_name'], $targetFilePath5)) {




				$data .= ", propertyimage='$propertyimage'";
				$data .= ", propertyimage2='$propertyimage2'";
				$data .= ", propertyimage3='$propertyimage3'";
				$data .= ", propertyimage4='$propertyimage4'";
				$data .= ", propertyimage5='$propertyimage5'";

				$save = $this->db->query("INSERT INTO houses set $data");
				// echo "INSERT INTO houses set $data";
				if ($save)
					return 1;
			}
		} else {
			// $chk = $this->db->query("SELECT * FROM houses where address = '$address' ")->num_rows;
			// if($chk > 0 ){
			// 	return 2;
			// 	exit;
			// }
			$target_dir = "images/";
			if ($developer != "") {
				$data .= ", developer= '$developer'";
			}
			if (!empty($propertyimage)) {
				$data .= ", propertyimage='$propertyimage'";
				$propertyimage = $_FILES['propertyimage']['name'];
				$targetFilePath = $target_dir . basename($propertyimage);
				if (move_uploaded_file($_FILES['propertyimage']['tmp_name'], $targetFilePath)) {


					// $save = $this->db->query("UPDATE houses set $data where id = $id");
				}
			}
			if (!empty($propertyimage2)) {
				$data .= ", propertyimage2='$propertyimage2'";
				$propertyimage2 = $_FILES['propertyimage2']['name'];
				$targetFilePath2 = $target_dir . basename($propertyimage2);
				if (move_uploaded_file($_FILES['propertyimage2']['tmp_name'], $targetFilePath2)) {


					// $save = $this->db->query("UPDATE houses set $data where id = $id");
				}
			}
			if (!empty($propertyimage3)) {
				$data .= ", propertyimage3='$propertyimage3'";
				$propertyimage3 = $_FILES['propertyimage3']['name'];
				$targetFilePath3 = $target_dir . basename($propertyimage3);
				if (move_uploaded_file($_FILES['propertyimage3']['tmp_name'], $targetFilePath3)) {

					// $save = $this->db->query("UPDATE houses set $data where id = $id");
				}
			}
			if (!empty($propertyimage4)) {
				$data .= ", propertyimage4='$propertyimage4'";
				$propertyimage4 = $_FILES['propertyimage4']['name'];
				$targetFilePath4 = $target_dir . basename($propertyimage4);
				if (move_uploaded_file($_FILES['propertyimage4']['tmp_name'], $targetFilePath4)) {

					// $save = $this->db->query("UPDATE houses set $data where id = $id");
				}
			}
			if (!empty($propertyimage5)) {
				$data .= ", propertyimage5='$propertyimage5'";
				$propertyimage5 = $_FILES['propertyimage5']['name'];
				$targetFilePath5 = $target_dir . basename($propertyimage5);
				if (move_uploaded_file($_FILES['propertyimage5']['tmp_name'], $targetFilePath5)) {
				}
			}
			$save = $this->db->query("UPDATE houses set $data where id = $id");
			// echo $data;
			// echo $id;

			if ($save)
				return 1;








			// $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

		}
	}
	function delete_house()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM houses where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function save_tenant()
	{
		extract($_POST);


		$data = " firstname = '$firstname' ";
		$data .= ", lastname = '$lastname' ";
		$data .= ", middlename = '$middlename' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		// $data .= ", date_in = '$date_in' ";
		$data .= ", address = '".mysqli_real_escape_string($this->db, $address)."'";
		$data .= ", tenant_id = '$tenant_id'";
		$data .= ", house_id = '$house_id'";
		$data .= ", rent = '$rent'";
		$data .= ", landlord_id = '." . $_SESSION['login_id'] . "'";
		//$data .= ", date_in = '$date_in'";
		if (empty($id)) {

			$save = $this->db->query("INSERT INTO tenantss set $data");
		} else {
			$save = $this->db->query("UPDATE tenantss set $data where id = $id");
		}
		if ($save)
			return 1;
		else
			print_r($_POST);
	}
	function delete_tenant()
	{
		extract($_POST);
		$delete = $this->db->query("UPDATE tenantss set status = 0 where id = " . $id);
		if ($delete) {
			return 1;
		}
	}

	function save_agent()
	{
		extract($_POST);

		$data = " firstname = '$firstname' ";
		$data .= ", lastname = '$lastname' ";
		$data .= ", middlename = '$middlename' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", house_id = '1' ";
		$data .= ", date_in = '$date_in' ";
		$data .= ", address = '$address'";
		$data .= ", username = '$username'";
		//$data .= ", date_in = '$date_in'";
		$data .= ", password = '$username'";
		$data .= ", company_id = '$company_id'";
		if (empty($id)) {

			$save = $this->db->query("INSERT INTO tenants set $data");
		} else {
			$save = $this->db->query("UPDATE tenants set $data where id = $id");
		}
		if ($save)
			return 1;
	}

	function delete_agent()
	{
		extract($_POST);
		$delete = $this->db->query("UPDATE tenants set status = 0 where id = " . $id);
		if ($delete) {
			return 1;
		}
	}



	function get_tdetails()
	{
		extract($_POST);
		$data = array();
		$tenantss = $this->db->query("SELECT t.*,concat(t.lastname,', ',t.firstname,' ',t.middlename) as name,h.house_no,h.price FROM tenantss t inner join houses h on h.id = t.house_id where t.id = {$id} ");
		foreach ($tenantss->fetch_array() as $k => $v) {
			if (!is_numeric($k)) {
				$$k = $v;
			}
		}
		$months = abs(strtotime(date('Y-m-d') . " 23:59:59") - strtotime($date_in . " 23:59:59"));
		$months = floor(($months) / (30 * 60 * 60 * 24));
		$data['months'] = $months;
		$payable = abs($price * $months);
		$data['payable'] = number_format($payable, 2);
		$paid = $this->db->query("SELECT SUM(amount) as paid FROM payments where id != '$pid' and tenant_id =" . $id);
		$last_payment = $this->db->query("SELECT * FROM payments where id != '$pid' and tenant_id =" . $id . " order by unix_timestamp(date_created) desc limit 1");
		$paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
		$data['paid'] = number_format($paid, 2);
		$data['last_payment'] = $last_payment->num_rows > 0 ? date("M d, Y", strtotime($last_payment->fetch_array()['date_created'])) : 'N/A';
		$data['outstanding'] = number_format($payable - $paid, 2);
		$data['price'] = number_format($price, 2);
		$data['name'] = ucwords($name);
		$data['rent_started'] = date('M d, Y', strtotime($date_in));

		return json_encode($data);
	}

	function save_payment()
	{
		extract($_POST);
		$data = "";
		$data .= "tenant_id = '$tenant_id' ";
		$query_hid = $this->db->query("SELECT * FROM tenantss where id = '$tenant_id'");
		$res = $query_hid->fetch_assoc();
		$house_id = $res['house_id'];
		$data .= ", house_id = '$house_id' ";
		$data .= ", payment = '$payment' ";
		$data .= ", date = '$date' ";
		$data .= ", status = '$status' ";
		if ($_SESSION['login_type'] != "3") {
			$data .= ", landlord_id = '" . $_SESSION['login_id'] . "' ";
		} else {
			$data .= ", landlord_id = '" . $res['landlord_id'] . "' ";
		}


		$target_dir = "paymentProof/";
		$target_file = $target_dir . "p_" . basename($_FILES["proof"]["name"]);

		if (empty($id)) {
			if (move_uploaded_file($_FILES["proof"]["tmp_name"], $target_file)) {
				$data .= ",proof = 'p_" . basename($_FILES["proof"]["name"]) . "'";
			}
			$save = $this->db->query("INSERT INTO payment set $data");
			// $id = $this->db->insert_id;
		} else {
			$save = $this->db->query("UPDATE payment set $data where id = $id");
		}

		if ($save) {
			return 1;
		} else {
			echo $data;
		}
	}
	function delete_payment()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM payment where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function save_quotation()
	{
		extract($_POST);
		// $data = "";
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", house_id = '$house_id' ";
		$data .= ", contact = '$contact' ";
		$data .= ", landlord_id = '$landlord_id' ";
		$data .= ", tenant_id = '$tenant_id' ";

		if (empty($id)) {

			$save = $this->db->query("INSERT INTO quotation set $data");
		} else {
			$save = $this->db->query("UPDATE quotation set $data where id = $id");
		}
		if ($save)
			return 1;
		else
			echo $data;
	}
	function delete_quotation()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM quotation where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function reject_quotation()
	{
		extract($_POST);
		$verify = "Reject";
		if (!empty($id)) {
			$verify = $this->db->query("UPDATE quotation set verify = '$verify' where id = $id");
		}
		if ($verify) {
			return 1;
		}
	}
	function accept_quotation()
	{
		extract($_POST);
		$verify = "Accept";
		if (!empty($id)) {
			$verify = $this->db->query("UPDATE quotation set verify = '$verify' where id = $id");
		}
		if ($verify) {
			return 1;
		}
	}
	function reject_appointment()
	{
		extract($_POST);
		$verify = "Reject";
		if (!empty($id)) {
			$verify = $this->db->query("UPDATE appointment set verify = '$verify' where id = $id");
		}
		if ($verify) {
			return 1;
		}
	}
	function accept_appointment()
	{
		extract($_POST);
		$verify = "Accept";
		if (!empty($id)) {
			$verify = $this->db->query("UPDATE appointment set verify = '$verify' where id = $id");
		}
		if ($verify) {
			return 1;
		}
	}
	function save_appointment()
	{
		extract($_POST);
		// $data = "";
		$data = " name = '$name' ";
		$data .= ", date = '$date' ";
		$data .= ", time = '$time' ";
		$data .= ", email = '$email' ";
		$data .= ", phone = '$phone' ";
		$data .= ", place = '$place' ";
		// $data .= ", status = '$status' ";

		if (empty($id)) {

			$save = $this->db->query("INSERT INTO appointment set $data");
		} else {
			$save = $this->db->query("UPDATE appointment set $data where id = $id");
		}
		if ($save)
			return 1;
	}
	function save_company()
	{
		extract($_POST);
		// $data = "";
		$data = " company_name = '$company_name' ";
		// $data .= ", status = '$status' ";

		if (empty($id)) {

			$save = $this->db->query("INSERT INTO company set $data");
		} else {
			$save = $this->db->query("UPDATE company set $data where id = $id");
		}
		if ($save)
			return 1;
	}
	function delete_appointment()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM appointment where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function delete_company()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM company where id = " . $id);
		if ($delete) {
			return 1;
		}
	}
	function save_agreement()
	{
		extract($_POST);
		$data = "";
		$data .= "landlord_id = '$landlord_id'";
		$data .= ",tenant_id = '$tenant_id'";
		$target_dir = "agreement/";
		$target_file = $target_dir . basename($_FILES["agreement"]["name"]);
		if (move_uploaded_file($_FILES["agreement"]["tmp_name"], $target_file)) {
			$data .= ",agreement = '" . basename($_FILES["agreement"]["name"]) . "'";
			$save = $this->db->query("INSERT INTO agreement set $data");
			if ($save) {
				echo 1;
			}
		} else {
			echo "Something Wrong";
		}
	}
	function save_agreement2()
	{
		extract($_POST);
		$data = "";
		$target_dir = "agreement/";
		$target_file = $target_dir . "t_" . basename($_FILES["agreement"]["name"]);
		if (move_uploaded_file($_FILES["agreement"]["tmp_name"], $target_file)) {
			$data .= "tenant_agreement = 't_" . basename($_FILES["agreement"]["name"]) . "'";
			$save = $this->db->query("UPDATE agreement set $data where id = '$id'");
			if ($save) {
				echo 1;
			}
		} else {
			echo "Something Wrong";
		}
	}
	function update_quotation()
	{
		extract($_POST);
		$data = "";
		$data = "status = 'Done'";

		$get_tenant = $this->db->query("SELECT * FROM quotation where id = $id");
		$row = mysqli_fetch_assoc($get_tenant);
		$tenantName = $row['name'];
		$tenantEmail = $row['email'];
		$tenantContact = $row['contact'];
		$houseId = $row['house_id'];
		$landlordId = $row['landlord_id'];
		$tenantId = $row['tenant_id'];

		$insert = $this->db->query("INSERT INTO tenantss SET firstname = '$tenantName', email = '$tenantEmail', contact='$tenantContact', house_id='$houseId', landlord_id='$landlordId', tenant_id = '$tenantId'");

		if($insert){

			$house = $this->db->query("UPDATE houses SET status='Rented' WHERE id = '$houseId'");
			if($house){
				$save = $this->db->query("UPDATE quotation set $data where id = '$id'");
				if ($save)
					echo 1;
			}
		}
	}
	function verify_payment()
	{
		extract($_POST);
		$save = $this->db->query("UPDATE payment set landlord_verify = 'Verify' where id = '$id'");
		if ($save)
			return 1;
		else
			print_r($_POST);
	}
}
