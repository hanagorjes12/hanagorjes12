<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}

if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'AdminPageLogout'){
	$logout = $crud->AdminPageLogout();
	if($logout)
		echo $logout;
}

if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'update_account'){
	$save = $crud->update_account();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_category"){
	$save = $crud->save_category();
	if($save)
		echo $save;
}

if($action == "delete_category"){
	$delete = $crud->delete_category();
	if($delete)
		echo $delete;
}
if($action == "save_developer"){
	$save = $crud->save_developer();
	if($save)
		echo $save;
}

if($action == "delete_developer"){
	$delete = $crud->delete_developer();
	if($delete)
		echo $delete;
}
if($action == "save_house"){
	$save = $crud->save_house();
	if($save)
		echo $save;
}
if($action == "delete_house"){
	$save = $crud->delete_house();
	if($save)
		echo $save;
}

if($action == "save_tenant"){
	$save = $crud->save_tenant();
	if($save)
		echo $save;
}

if($action == "save_agent"){
	$save = $crud->save_agent();
	if($save)
		echo $save;
}

if($action == "delete_tenant"){
	$save = $crud->delete_tenant();
	if($save)
		echo $save;
}

if($action == "delete_agent"){
	$save = $crud->delete_agent();
	if($save)
		echo $save;
}

if($action == "get_tdetails"){
	$get = $crud->get_tdetails();
	if($get)
		echo $get;
}

if($action == "save_payment"){
	$save = $crud->save_payment();
	if($save)
		echo $save;
}
if($action == "delete_payment"){
	$save = $crud->delete_payment();
	if($save)
		echo $save;
}
if($action == "save_quotation"){
	$save = $crud->save_quotation();
	if($save)
		echo $save;
}
if($action == "delete_quotation"){
	$save = $crud->delete_quotation();
	if($save)
		echo $save;
}
if($action == "reject_quotation"){
	$save = $crud->reject_quotation();
	if($save)
		echo $save;
}
if($action == "accept_quotation"){
	$save = $crud->accept_quotation();
	if($save)
		echo $save;
}
if($action == "accept_appointment"){
	$save = $crud->accept_appointment();
	if($save)
		echo $save;
}
if($action == "reject_appointment"){
	$save = $crud->reject_appointment();
	if($save)
		echo $save;
}
if($action == "save_appointment"){
	$save = $crud->save_appointment();
	if($save)
		echo $save;
}
if($action == "delete_appointment"){
	$save = $crud->delete_appointment();
	if($save)
		echo $save;
}
if($action == "save_company"){
	$save = $crud->save_company();
	if($save)
		echo $save;
}
if($action == "delete_company"){
	$save = $crud->delete_company();
	if($save)
		echo $save;
}
if($action == "save_agreement"){
	$save = $crud->save_agreement();
	if($save)
		echo $save;
}
if($action == "save_agreement2"){
	$save = $crud->save_agreement2();
	if($save)
		echo $save;
}
if($action == "update_quotation"){
	$save = $crud->update_quotation();
	if($save)
		echo $save;
}
if($action == "verify_payment"){
	$save = $crud->verify_payment();
	if($save)
	echo $save;
}
// if($action == "save_agreement2"){
// 	$save = $crud->save_agreement2();
// 	if($save)
// 		echo $save;
// }
ob_end_flush();
?>
