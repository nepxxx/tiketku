<!DOCTYPE html>
<!-- by @anandabaskara from Visual Studio Code with ❤️ -->
<html lang="en">

<head>

  <!-- css and bs initialization -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>TiketKu Panel</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/simple-sidebar.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading">TiketKu Main Menu</div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-light" id="menulogin">Login</a>
        <a href="#" class="loginmenu list-group-item list-group-item-action bg-light" id="menutambah">Add Tiket</a>
        <a href="#" class="loginmenu list-group-item list-group-item-action bg-light" id="menulaporan">List Tiket</a>
        <a href="#" class="loginmenu list-group-item list-group-item-action bg-light" id="menuhapus">Delete Tiket</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle">Hide</button>
      </nav>

      <div class="container-fluid" id="clogin">
        <h1 class="mt-4">Login Form</h1>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" id="login_username" placeholder="Enter your username">
              <small class="form-text text-muted">Please input your username.</small>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="login_password" placeholder="Password">
            </div>
              <input type="hidden" id="login_token" disabled>
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-block btn-primary" id="login_submit"> Login </button>
            <button type="button" class="btn btn-block btn-secondary" id="login_logout"> Logout </button>
          </div>
        </div>
        <!-- script login start -->
        <script>
          $("#login_submit").click(function(){
              if ($('#login_username').val() && $('#login_password').val()){
                  var datapost = {
                      "username": $('#login_username').val(),
                      "password": $('#login_password').val(),
                  };
                  $.post("/login", datapost)
                  .done(function(response){
                      if (response.status == false) {
                          alert("Login gagal");
                          $('#login_token').val('');
                      } else {
                          $('#login_token').val(response.token);
                          alert("Login berhasil");
                          $('#login_username').attr('disabled', 'disabled');
                          $('#login_password').attr('disabled', 'disabled');
                          $('.loginmenu').show();
                      }
                  })
              } else {
                  alert("Form login incorrect!");
              }
          });
          $("#login_logout").click(function(){
            $('#login_username').removeAttr('disabled').val('');
            $('#login_password').removeAttr('disabled').val('');
            $('#login_token').val('');
            $('.loginmenu').hide();
          });
      </script>
      <!-- script login end -->
      </div>

      <div class="container-fluid" id="ctambah">
        <h1 class="mt-4">Add Tiket</h1>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label>Nama Film</label>
              <input type="text" class="form-control" id="add_namafilm" placeholder="Masukkan nama film">
            </div>
            <div class="form-group">
              <label>Genre Film</label>
              <input type="text" class="form-control" id="add_genrefilm" placeholder="Masukkan genre film">
            </div>
            <div class="form-group">
              <label>Harga Tiket</label>
              <input type="number" class="form-control" id="add_hargatiket" placeholder="Masukkan harga tiket">
            </div>
            <div class="form-group">
              <label>Tanggal Tayang</label>
              <input type="date" class="form-control" id="add_tanggaltayang" placeholder="Masukkan tanggal tayang film">
            </div>
            <div class="form-group">
              <label>Row Place</label>
              <input type="text" class="form-control" id="add_rowplace" placeholder="Masukkan baris kursi">
            </div>
            <div class="form-group">
              <label>Seat Place</label>
              <input type="text" class="form-control" id="add_seatplace" placeholder="Masukkan nomor kursi">
            </div>
            <div class="form-group">
              <label>Studio</label>
              <input type="text" class="form-control" id="add_studio" placeholder="Masukkan nama studio">
            </div>
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-block btn-primary" id="add_confirm"> Tambah Data </button>
          </div>
        </div>
        <!-- script add start -->
        <script>
          $("#add_confirm").click(function(){
              if (
                  ($("#login_token").val().length == 0) ||
                  ($("#add_namafilm").val().length == 0) ||
                  ($("#add_genrefilm").val().length == 0) ||
                  ($("#add_hargatiket").val().length == 0) ||
                  ($("#add_tanggaltayang").val().length == 0) ||
                  ($("#add_rowplace").val().length == 0) ||
                  ($("#add_seatplace").val().length == 0) ||
                  ($("#add_studio").val().length == 0)
              ){
                  alert("Error processing request, please login first and then fill the missing field.");
                  return;
              }
              datapost = {
                  "token" : $("#login_token").val(),
                  "namafilm" : $("#add_namafilm").val(),
                  "genrefilm" : $("#add_genrefilm").val(),
                  "hargatiket" : $("#add_hargatiket").val(),
                  "tanggaltayang" : $("#add_tanggaltayang").val(),
                  "rowplace" : $("#add_rowplace").val(),
                  "seatplace" : $("#add_seatplace").val(),
                  "studio" : $("#add_studio").val(),
              };

              $.post("/add", datapost)
              .done(function(response){
                  if (response.status == true) {
                      $("#add_namafilm").val('');
                      $("#add_genrefilm").val('');
                      $("#add_hargatiket").val('');
                      $("#add_tanggaltayang").val('');
                      $("#add_rowplace").val('');
                      $("#add_seatplace").val('');
                      $("#add_studio").val('');
                  } else {
                      alert(response.informasi);
                  }
              })
            });
      </script>
      <!-- script add end -->
      </div>

      <div class="container-fluid" id="claporan">
        <h1 class="mt-4">List Tiket</h1>
        <button type="button" id="reload_info" class="btn btn-primary"> Reload Data </button>
        <div class="row">
          <div class="col-12">
          <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">ID Tiket</th>
                  <th scope="col">Nama Film</th>
                  <th scope="col">Genre Film</th>
                  <th scope="col">Harga Tiket</th>
                  <th scope="col">Tanggal Tayang</th>
                  <th scope="col">Row Place</th>
                  <th scope="col">Seat Place</th>
                  <th scope="col">Studio</th>
                </tr>
              </thead>
              <tbody id="info_tiket">
                <tr>
                  <td colspan="5">Please reload to see the data</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- script info start -->
        <script>
          $("#reload_info").click(function(){
              if (
                  ($("#login_token").val().length == 0)
              ) {
                  alert("Error processing request, please login first.");
                  return;
              }
              
              datapost = {
                  "token" : $("#login_token").val(),
              };

              $.post("/info", datapost)
              .done(function(response){
                  if (response.status == true) {
                      data = response.data;
                      $('#info_tiket').html('');

                      $.each(data, function(i, d) {
                          tra = '<tr>';
                          tra += '<td scope="row">'+d.id_tiket+'</td>';
                          tra += '<td>'+d.nama_film+'</td>';
                          tra += '<td>'+d.genre_film+'</td>';
                          tra += '<td>'+d.harga_tiket+'</td>';
                          tra += '<td>'+d.tanggal_tayang+'</td>';
                          tra += '<td>'+d.row_place+'</td>';
                          tra += '<td>'+d.seat_place+'</td>';
                          tra += '<td>'+d.studio+'</td>';
                          tra += '</tr>';

                          $('#info_tiket').append(tra);
                      });
                  } else {
                      alert(response.informasi);
                  }
              })
            });
      </script>
      <!-- script info end -->
      </div>

      <div class="container-fluid" id="chapus">
        <h1 class="mt-4">Delete Tiket</h1>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label>ID Tiket</label>
              <input type="number" class="form-control" id="delete_idtiket" placeholder="Masukkan id tiket yang ingin dihapus">
            </div>
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-block btn-danger" id="delete_confirm"> Hapus Data </button>
          </div>
        </div>
        <!-- script delete start -->
        <script>
          $("#delete_confirm").click(function(){
              if (
                  ($("#login_token").val().length == 0) ||
                  ($("#delete_idtiket").val().length == 0)
              ){
                  alert("Error processing request, please login first and then input id for the book.");
                  return;
              }
              datapost = {
                  "token" : $("#login_token").val(),
                  "idtiket" : $("#delete_idtiket").val(),
              };

              $.post("/delete", datapost)
              .done(function(response){
                  if (response.status == true) {
                      $("#delete_idtiket").val('');
                      alert(response.informasi);
                  } else {
                      alert(response.informasi);
                  }
              })
            });
      </script>
      <!-- script delete end -->
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    /* hide u kent see mi *jiiiii* *stare at your soul* */
    $(document).ready(function(){
      $('.loginmenu').hide();
      $('.container-fluid').hide();
      $('#clogin').show();

      $('#menulogin').click(function(){
        $('.container-fluid').hide();
        $('#clogin').show();
      });
      $('#menutambah').click(function(){
        $('.container-fluid').hide();
        $('#ctambah').show();
      });
      $('#menulaporan').click(function(){
        $('.container-fluid').hide();
        $('#claporan').show();
      });
      $('#menuhapus').click(function(){
        $('.container-fluid').hide();
        $('#chapus').show();
      });
    });

  </script>

</body>

</html>