<br><br>
<h4 class="text-center text-body">First of all you must login then see portal</h4>
<br><br>

	<div class="container my-3 bg-light">
		<div class="col-md-12 text-center">
            <button type="button ms-3 center" id="btnlogin" onclick="login()" class="btn btn-primary">Login</button>
            <button type="button ms-3 center" id="btnregester" onclick="regester()" class="btn btn-primary">Regester</button>
		</div>
	</div>

    <!-- Bootstrap modal -->
  <div class="modal fade" id="regester" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Person Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-9">
                  <input name="name" placeholder="Mame" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Email</label>
                <div class="col-md-9">
                  <input name="eamil" placeholder="Email" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Password</label>
                <div class="col-md-9">
                  <input name="password" placeholder="Password" class="form-control" type="text">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="regesterfunc()" class="btn btn-primary">Regester</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->


   <!-- Bootstrap modal -->
   <div class="modal fade" id="login" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Person Form</h3>
        </div>
        <div class="modal-body form">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body">
              <div class="form-group">
                <label class="control-label col-md-3">Email</label>
                <div class="col-md-9">
                  <input name="eamil" placeholder="Email" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Password</label>
                <div class="col-md-9">
                  <input name="password" placeholder="Password" class="form-control" type="text">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" onclick="loginfunc()" class="btn btn-primary">Login</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Bootstrap modal -->


    <script type="text/javascript">

    function login()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#login').modal('show'); // show bootstrap modal
      $('.modal-title').text('Login'); // Set Title to Bootstrap modal title
    }

    function regester()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#regester').modal('show'); // show bootstrap modal
      $('.modal-title').text('Regester'); // Set Title to Bootstrap modal title
    }

    function regesterfunc()
    {
      var url;
      if(save_method == 'add') 
      {
        url = "<?php echo site_url('welcome/add_user')?>";
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
             },
             error: function (jqXHR, textStatus, errorThrown)
             {
              alert('Error adding / update data');
            }
          });
     }

    </script>

    
  
    