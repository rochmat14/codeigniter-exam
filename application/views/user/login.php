<div class="center">
    <div class="panel br-tomato width-auth panel-mobile">
        <div class="panel-heading bg-tomato">
            <!-- card header -->
            <span class="font-panel-head">LOGIN</span>
        </div>

        <div class="panel-body">
            <!-- card body -->
            <form action="" id="form-login">
                <div class="row">

                    <!-- input email -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="text" name="email" class="form-control input-email">
                        </div>
                    </div>

                    <!-- input password -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <p id="show-password" style="cursor:pointer; color:blue;">Show</p>
                            <input id="password" type="password" class="form-control input-password" name="password">
                        </div>
                    </div>

                    <!-- button login -->
                    <div class="col-sm-6">
                        <button id="submit" type="submit" class="btn btn-login btn-primary btn-block mb-3 mar-b">Login</button> <!-- button Login -->
                    </div>

                    <!-- button yang mengarahkan ke halaman register -->
                    <div class="col-sm-6">
                        <a href="<?php echo base_url('/register') ?>" class="btn btn-warning btn-block mar-b">Register</a>
                    </div>

                    <!-- button yang mengarahkan ke halaman forgot password -->
                    <div class="col-sm-12">
                        <a href="<?php echo base_url('forgot-password') ?>" class="text-danger">Forgot Password</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    // proses login menggunakan ajax
    $("#form-login").submit(function(e) { //form id form-login ketika di submit
        e.preventDefault(); //mencegah reload halaman

        var email = $("#email").val(); //menapatkan value pada input id email
        var password = $("#password").val(); //menapatkan value pada input id password

        if (email == "") { //jika email kosong

        } else if (password == "") { //jika password kosong

        } else {

            $.ajax({

                url: "<?php echo base_url() ?>user/checkLogin", //akses ulr
                type: "POST", //tipe method
                data: { //data request yang dikirim
                    "email": email,
                    "password": password
                },

                success: function(response) { //jika pada controller berhasil

                    if (response == "success") { //jika response pada controller "success"
                        // menampilkan pemberitahun berhasil
                        Swal.fire({
                                type: 'success',
                                title: 'Success!',
                                text: 'You will be directed to home page',
                                timer: 1000,
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                            .then(function() { //lalu mengalihkan pada halaman home setelah login berasil
                                window.location.href = "<?php echo base_url() ?>home";
                            });
                    } else {
                        // pesan error jika response bukan "success"
                        Swal.fire({
                            type: 'error',
                            title: 'Opps!',
                            text: 'server error!'
                        });
                    }
                    // console.log(response);
                },
                error: function(response) { //jika terjadei kesalan pada controller
                    // pemberitahuan error
                    Swal.fire({
                        type: 'error',
                        title: 'Sorry !',
                        text: 'An error occured on the server!'
                    });

                    // console.log(response);
                }
            });
        }
    });


    // show password button
    $("#show-password").click(function() { //jika id show-password di klik
        var x = document.getElementById("password"); //menambil elemtn id password
        if (x.type === "password") { //jika id password type password
            x.type = "text"; //maka di klik menjadi text
            $("#show-password").css("color", "red");
        } else {
            x.type = "password";
            $("#show-password").css("color", "blue");
        }
    });
</script>