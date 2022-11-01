<?php include 'db_connect.php';
session_start();
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM houses where id= " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>
<div class="container-fluid">
    <form action="" id="manage-house" enctype="multipart/form-data">
        <div class="form-group" id="msg"></div>
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>" />
        <div class="form-group">
            <label class="control-label">House No</label>
            <input type="text" class="form-control" name="house_no" required="" value="<?php echo isset($house_no) ? $house_no : '' ?>" />
        </div>
        <div class="form-group">
            <label class="control-label">Developer</label>
            <!-- <input type="text" class="form-control" name="developer" required="" value="<?php //echo isset($developer) ? $developer : '' 
                                                                                                ?>"> -->

            <?php if (isset($developer)) { ?>
                <select name="developer" id="" class="custom-select" required>
                    <option value="">Select</option>
                    <option value="Gamuda Land" <?php echo $developer=='Gamuda Land' ? ' selected' : '' ?>>Gamuda Land</option>
                    <option value="IOI Properties" <?php echo $developer=='IOI Properties' ? ' selected' : '' ?>>IOI Properties</option>
                    <option value="Eco World Development Group" <?php echo $developer=='Eco World Development Group' ? ' selected' : '' ?>>Eco World Development Group</option>
                    <option value="Mah Sing Group" <?php echo $developer=='Mah Sing Group' ? ' selected' : '' ?>>Mah Sing Group</option>
                    <option value="Self Property" <?php echo $developer=='Self Property' ? ' selected' : '' ?>>Self Property</option>
                </select>
                <i>* Please Select to change the developer else please let it as empty</i>
            <?php } else { ?>
                <!-- <option value="">Select</option> -->
                <select name="developer" id="" class="custom-select" required>
                    <option value="Gamuda Land">Gamuda Land</option>
                    <option value="IOI Properties">IOI Properties</option>
                    <option value="Eco World Development Group">Eco World Development Group</option>
                    <option value="Mah Sing Group">Mah Sing Group</option>
                    <option value="Self Property">Self Property</option>
                </select>
            <?php } ?>


        </div>
        <div class="form-group">
            <label class="control-label">Category</label>
            <?php if (isset($category_id)) { ?>
                <select name="category_id" id="" class="custom-select" required>
                    <?php $categories = $conn->query("SELECT * FROM categories where id = $category_id");
                    $res = $categories->fetch_assoc() ?>
                    <option value="<?php echo $res['id'] ?>" selected><?php echo $res['name'] ?></option>
                    <?php

                    $categories = $conn->query("SELECT * FROM categories where id != $category_id order by name asc");
                    if ($categories->num_rows > 0) :
                        while ($row = $categories->fetch_assoc()) :
                    ?>
                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <option selected="" value="" disabled="">Please check the category list.</option>
                    <?php endif; ?>
                </select>
            <?php } else { ?>
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
            <?php } ?>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Property Address</label>
            <textarea name="address" id="" cols="20" rows="2" class="form-control" required><?php echo isset($address) ? $address : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Description</label>
            <textarea name="description" id="" cols="30" rows="3" class="form-control" required><?php echo isset($description) ? $description : '' ?></textarea>
        </div>
        <div class="form-group">
            <label class="control-label">Price</label>
            <input type="number" class="form-control text-right" name="price" step="any" value="<?php echo isset($price) ? $price : '' ?>" required />
        </div>

        <div class="form-group">
            <label for="" class="control-label">Date in Market</label>
            <input type="date" class="form-control" name="date_in" value="<?php echo isset($date_in) ? $date_in : '' ?>" required />
        </div>

        <div class="form-group">

            <label for="status">Status</label></br>
            <?php
            if (!isset($_GET['id']) || !isset($status)) {
            ?>
                <select name="status" id="status">
                    <option value="On View" selected="">On View</option>
                    <option value="Rented">Rented</option>
                </select></br><small><i>Leave this blank if you dont want to add the status.</i></small>
            <?php } else {
                if ($status == "On View") {
                    echo "<select name='status' id='status'><option value='On View'>On View</option><option value='Pending'>Pending</option><option value='Rented'>Rented</option><option value='Sold'>Sold</option></select>";
                    echo "</br><small><i>Leave this blank if you dont want to add the status.</i></small>";
                }
                if ($status == "Rented") {
                    echo "<select name='status' id='status'><option value='Rented'>Rented</option><option value='Pending'>Pending</option><option value='On View'>On View</option><option value='Sold'>Sold</option></select>";
                    echo "</br><small><i>Leave this blank if you dont want to add the status.</i></small>";
                }
            } ?>


        </div>

        <div class="form-group">
            <label>Insert Image 1</label>
            <input type="file" class="form-control-file btn" id="propertyimage" name="propertyimage" value="" <?php echo !isset($propertyimage) ? 'required' : '' ?> />
            </select></br><small><i>Leave this blank if you dont want to add / change the image.</i></small>
            <input type="text" value="<?php echo isset($propertyimage) ? $propertyimage : '' ?>" name="filename" id="filename" class="form-control" readonly>

        </div>

        <div class="form-group">
            <label>Insert Image 2</label>
            <input type="file" class="form-control-file btn" id="propertyimage2" name="propertyimage2" value="" <?php echo !isset($propertyimage2) ? 'required' : '' ?> />
            </select></br><small><i>Leave this blank if you dont want to add / change the image.</i></small>
            <input type="text" value="<?php echo isset($propertyimage2) ? $propertyimage2 : '' ?>" name="filename1" id="filename" class="form-control" readonly>

        </div>

        <div class="form-group">
            <label>Insert Image 3</label>
            <input type="file" class="form-control-file btn" id="propertyimage3" name="propertyimage3" value="" <?php echo !isset($propertyimage3) ? 'required' : '' ?> />
            </select></br><small><i>Leave this blank if you dont want to add / change the image.</i></small>
            <input type="text" value="<?php echo isset($propertyimage3) ? $propertyimage3 : '' ?>" name="filename2" id="filename" class="form-control" readonly>

        </div>

        <div class="form-group">
            <label>Insert Image 4</label>
            <input type="file" class="form-control-file btn" id="propertyimage4" name="propertyimage4" value="" <?php echo !isset($propertyimage4) ? 'required' : '' ?> />
            </select></br><small><i>Leave this blank if you dont want to add / change the image.</i></small>
            <input type="text" value="<?php echo isset($propertyimage4) ? $propertyimage4 : '' ?>" name="filename3" id="filename" class="form-control" readonly>

        </div>

        <div class="form-group">
            <label>Insert Image 5</label>
            <input type="file" class="form-control-file btn" id="propertyimage5" name="propertyimage5" value="" <?php echo !isset($propertyimage5) ? 'required' : '' ?> />
            </select></br><small><i>Leave this blank if you dont want to add / change the image.</i></small>
            <input type="text" value="<?php echo isset($propertyimage5) ? $propertyimage5 : '' ?>" name="filename4" id="filename" class="form-control" readonly>

        </div>
        <input type="hidden" name="landlord_id" value="<?php echo $_SESSION['login_id'] ?>" />
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
</div>
</div>

</form>
<script>
    $('.select2').select2({
        placeholder: "Please Select Here",
        width: "100%"
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
                } else {
                    console.log(resp);
                    end_load()
                }
            }
        })
    })
</script>