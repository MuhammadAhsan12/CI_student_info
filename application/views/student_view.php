<?php $this->load->view('inc/datatable');?> 

    <div class = "row">
      <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add New Student</button>
      <!-- <button class="btn btn-success" onclick="add_parent()"><i class="glyphicon glyphicon-plus"></i> Add New Parent</button> -->
      
      <br />
      <br />

      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Std ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <!-- <th>Gender</th>
            <th>Address</th>
            <th>Date of Birth</th>
            <th>Subject</th>
            <th>Campus</th> -->
            <th style="width:189px;">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>

        
      </table>
    </div>
  </div>

  <script type="text/javascript">
    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#table').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
          "url": "<?php echo site_url('Student/ajax_list')?>",
          "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
    });

    function add_person()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add New Student'); // Set Title to Bootstrap modal title
    }

    function edit_person(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('Student/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
         
          $('[name="id"]').val(data.id);
          $('[name="stdid"]').val(data.stdid);
          $('[name="firstName"]').val(data.firstName);
          $('[name="lastName"]').val(data.lastName);
          $('[name="email"]').val(data.email);
          $('[name="phone"]').val(data.phone);
          $('[name="gender"]').val(data.gender);
          $('[name="address"]').val(data.address);
          $('[name="dob"]').val(data.dob);
          $('[name="subject"]').val(data.subject);
          $('[name="campus"]').val(data.campus);

          $('[name="parentfirstName"]').val(data.parentfirstName);
          $('[name="parentlastName"]').val(data.parentlastName);
          $('[name="parentemail"]').val(data.parentemail);
          $('[name="parentphone"]').val(data.parentphone);
          $('[name="parentgender"]').val(data.parentgender);

          $('[name="contactfirstName"]').val(data.contactfirstName);
          $('[name="contactlastName"]').val(data.contactlastName);
          $('[name="contactemail"]').val(data.contactemail);
          $('[name="contactphone"]').val(data.contactphone);
          $('[name="contactgender"]').val(data.contactgender);
          
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Student'); // Set title to Bootstrap modal title
            
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get data from ajax');
          }
        });
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function save()
    {
      var url;
      if(save_method == 'add') 
      {
        url = "<?php echo site_url('Student/ajax_add')?>";
      }
      else
      {
        url = "<?php echo site_url('Student/ajax_update')?>";
      }

       // ajax adding data to database
       $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
               //if success close modal and reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
               swal(
                'Good job!',
                'Data has been save!',
                'success'
                )
                // add_parent();
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          });
     }

     function delete_person(id)
     {

      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnConfirm: false
      }).then(function(isConfirm) {
        if (isConfirm) {

     // ajax delete data to database
     $.ajax({
      url : "<?php echo site_url('Student/ajax_delete')?>/"+id,
      type: "POST",
      dataType: "JSON",
      success: function(data)
      {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
               swal(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                );
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          });

     
      }
    })
          
    }

    function view_person(id)
    {
          $.ajax({
            url : "<?php echo site_url('Student/list_by_id')?>/" + id,
            type: "GET",
            success: function(result)
            {
                $('#haha').empty().html(result).fadeIn('slow');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {

            }
        });
      }


     //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    function readURL(input) {
    if (input.files && input.files[0]) {
    
      var reader = new FileReader();
      reader.onload = function (e) { 
        document.querySelector("#img").setAttribute("src",e.target.result);
      };

      reader.readAsDataURL(input.files[0]); 
    }
  }


  </script>

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Student Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
            <div class="form-group">
                <label class="control-label col-md-3">Student Image</label>
                <div class="col-md-9">
                  <img src="" alt="No Image" id="img" style='height:150px;'>
                  <input type="file" name="image" id="image" accept='image/*'  onchange="readURL(this)" ></p>
                </div>
              </div>
            <div class="form-group">
                <label class="control-label col-md-3">Student Id</label>
                <div class="col-md-9">
                  <input name="stdid" placeholder="Student Id" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">First Name</label>
                <div class="col-md-9">
                  <input name="firstName" placeholder="First Name" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Last Name</label>
                <div class="col-md-9">
                  <input name="lastName" placeholder="Last Name" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Email Address</label>
                <div class="col-md-9">
                  <input name="email" placeholder="Email address" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Phone num</label>
                <div class="col-md-9">
                  <input name="phone" placeholder="Phone num" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Gender</label>
                <div class="col-md-9">
                  <select name="gender" class="form-control">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Address</label>
                <div class="col-md-9">
                  <textarea name="address" placeholder="Address"class="form-control"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Date of Birth</label>
                <div class="col-md-9">
                  <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Subject</label>
                <div class="col-md-9">
                  <input name="subject" placeholder="Subject" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Campus</label>
                <div class="col-md-9">
                  <input name="campus" placeholder="Campus" class="form-control" type="text">
                </div>
              </div>
              <hr>
              <h4 style="text-align: center;">Parent Details</h4>
              <div class="form-group">
                <label class="control-label col-md-3">Parent First Name</label>
                <div class="col-md-9">
                  <input name="parentfirstName" placeholder="Parent First Name" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Parent Last Name</label>
                <div class="col-md-9">
                  <input name="parentlastName" placeholder="Parent Last Name" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Parent Email</label>
                <div class="col-md-9">
                  <input name="parentemail" placeholder="Parent Email" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Parent Phone num</label>
                <div class="col-md-9">
                  <input name="parentphone" placeholder="Parent Phone num" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Parent Gender</label>
                <div class="col-md-9">
                  <select name="parentgender" class="form-control">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
              </div>
              <hr>
              <h4 style="text-align: center;">Emergency Contact</h4>
              <div class="form-group">
                <label class="control-label col-md-3">Contact First Name</label>
                <div class="col-md-9">
                  <input name="contactfirstName" placeholder="Contact First Name" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Contact Last Name</label>
                <div class="col-md-9">
                  <input name="contactlastName" placeholder="Contact Last Name" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Contact Email</label>
                <div class="col-md-9">
                  <input name="contactemail" placeholder="Contact Email" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Contact Phone num</label>
                <div class="col-md-9">
                  <input name="contactphone" placeholder="Contact Phone num" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Contact Gender</label>
                <div class="col-md-9">
                  <select name="contactgender" class="form-control">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->

</body>
</html>