<html>
<head>
    <script src="jquery-3.5.1.min.js"></script>
</head>

<body>
    <div id="loginform">
        <form>
            <label> Username </label>
            <input type="text" id="login_username"><br/>

            <label> Password </label>
            <input type="password" id="login_password"><br/>

            <label> Token </label>
            <input type="text" id="login_token" disabled><br/>

            <button type="button" id="login_submit"> Login </button>
            <button type="button" id="login_logout"> Logout </button>
        </form>

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
                        }
                    })
                } else {
                    alert("Form login incorrect!");
                }
            });
        </script>
    </div>

    <div id="addform">
        <form>
            <label> Nama Film </label>
            <input type="text" id="add_namafilm"><br/>

            <label> Genre Film </label>
            <input type="text" id="add_genrefilm"><br/>

            <label> Harga Tiket </label>
            <input type="number" id="add_hargatiket"><br/>

            <label> Tanggal Tayang </label>
            <input type="date" id="add_tanggaltayang"><br/>

            <label> Row Place </label>
            <input type="text" id="add_rowplace"><br/>

            <label> Seat Place </label>
            <input type="text" id="add_seatplace"><br/>

            <label> Studio </label>
            <input type="text" id="add_studio"><br/>

            <button type="button" id="add_confirm"> Simpan Data </button>
        </form>
    
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
    </div>

    <div id="infoform">
        <button type="button" id="reload_info"> Reload Info</button>
        <table>
            <thead>
                <tr>
                    <td>ID Tiket</td>
                    <td>Nama Film</td>
                    <td>Genre Film</td>
                    <td>Harga Tiket</td>
                    <td>Tanggal Tayang</td>
                    <td>Row Place</td>
                    <td>Seat Place</td>
                    <td>Studio</td>
                </tr>
            </thead>
            <tbody id="info_tiket">
                <tr>
                    <td>lorem ipsum</td>
                    <td>lorem ipsum</td>
                    <td>lorem ipsum</td>
                    <td>lorem ipsum</td>
                    <td>lorem ipsum</td>
                    <td>lorem ipsum</td>
                    <td>lorem ipsum</td>
                    <td>lorem ipsum</td>
                </tr>
            </tbody>
        </table>
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
                            tra += '<td>'+d.id_tiket+'</td>';
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
    </div>

    <div id="deleteform">
        <form>
            <label> Tiket </label>
            <input type="number" id="delete_idtiket"><br/>
            <button type="button" id="delete_confirm"> Delete </button>
        </form>
    
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
    </div>
</body>
</html>