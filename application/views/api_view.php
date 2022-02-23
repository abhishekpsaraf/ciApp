<html>
<head>
    <title>CRUD REST API in Codeigniter</title>
    
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body><div class="container">
        <br />
        <h3 align="center">TinyList</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">TinyList</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Add</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<div id="itemModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="item_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Item</h4>
                </div>
                <div class="modal-body">
                    <label>Enter Item Name</label>
                    <input type="text" name="item_name" id="item_name" class="form-control" />
                    <span id="item_name_error" class="text-danger"></span>
                    <label>Item Completed</label>
                    <input class="form-check-input" type="checkbox" value="1" name="item_completed" id="item_completed">
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="item_id" id="item_id" />
                    <input type="hidden" name="data_action" id="data_action" value="Insert" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    
    function fetch_data()
    {
         $.ajax({
            url:"<?php echo base_url(); ?>index.php/test_api/action",
            method:"POST",
            data:{data_action:'fetch_all'},
            success:function(data)
            {
                $('tbody').html(data);
            }
        });
    }

    fetch_data();

    $('#add_button').click(function(){
        $('#item_form')[0].reset();
        $('.modal-title').text("Add Item");
        $('#action').val('Add');
        $('#data_action').val("Insert");
        $('#itemModal').modal('show');
    });

    $(document).on('submit', '#item_form', function(event){
        event.preventDefault();
        $.ajax({
            url:"<?php echo base_url() . 'index.php/test_api/action' ?>",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                if(data.success)
                {
                    $('#item_form')[0].reset();
                    $('#itemModal').modal('hide');
                    fetch_data();
                    if($('#data_action').val() == "Insert")
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Inserted</div>');
                    }
                    if($('#data_action').val() == "Edit")
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Updated</div>');
                    }
                }

                if(data.error)
                {
                    $('#item_name_error').html(data.item_name_error);
                }
            }
        })
    });

   $(document).on('click', '.edit', function(){
        var item_id = $(this).attr('id');
        $.ajax({
            url:"<?php echo base_url(); ?>index.php/test_api/action",
            method:"POST",
            data:{item_id:item_id, data_action:'fetch_single'},
            dataType:"json",
            success:function(data)
            {   
               
                $('#itemModal').modal('show');
                $('#item_name').val(data.item_name);
                if(data.item_status == 1) {
                    $("#item_completed").prop("checked", true);
                } else {
                    $("#item_completed").prop("checked", false);
                }             
                $('.modal-title').text('Edit Item');
                $('#item_id').val(item_id);
                $('#action').val('Edit');
                $('#data_action').val('Edit');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var item_id = $(this).attr('id');
        if(confirm("Are you sure you want to delete this?"))
        {
            $.ajax({
                url:"<?php echo base_url(); ?>index.php/test_api/action",
                method:"POST",
                data:{item_id:item_id, data_action:'Delete'},
                dataType:"JSON",
                success:function(data)
                {
                    if(data.success)
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Deleted</div>');
                        fetch_data();
                    }
                }
            })
        }
    });


});
    </script>