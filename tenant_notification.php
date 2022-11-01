<?php
include('db_connect.php');
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
                        <b>Email Notification From Landlord</b>
                    </div>
                        <div class="card-body">
                            <table class="table table-condensed table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="30%">Subject</th>
                                        <th width="55%">Message</th>
                                        <th width="10%">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $count=1;
                                $noti = mysqli_query($conn, "SELECT * FROM notification WHERE tenant_id = ".$_SESSION['login_id']);
                                while($res = mysqli_fetch_assoc($noti)){
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $res["subject"]; ?></td>
                                    <td>
                                    	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#msg" onclick="viewMsg(<?php echo $res["id"]; ?>)">View</button>
                                    	<div id="getMsg<?php echo $res["id"]; ?>" style="display: none;"><?php echo $res["message"]; ?></div>
                                    </td>
                                    <td><?php echo date("d-m-Y", strtotime($res["noti_date"])); ?></td>
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

<!-- Modal -->
<div class="modal fade" id="msg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span id="msgContent"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	function viewMsg(id){
		var msg = document.getElementById("getMsg"+id).textContent;
		
		document.getElementById("msgContent").innerHTML = msg;
	}
</script>
