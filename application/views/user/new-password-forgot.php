<div class="center">
    <div class="panel panel-primary width-auth">
        <div class="panel-heading">
            Insert New Yout Password
        </div>

        <form action="" id="update">
            <div class="panel-body">
                <!-- input email yang disembunyikan yang memiliki value -->
                <input type="hidden" name="email" class="form-control" value="<?php echo $this->session->userdata('email_forgot') ?>">

                <!-- input password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <p id="show-password" style="cursor:pointer; color:blue;">Show</p>
                    <input id="password" type="password" class="form-control input-password" name="password">
                </div>

                <!-- button update passwor baru yang lupa -->
                <div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $("#update").submit(function(e) { //ketika form id update di submit
        e.preventDefault(); //mencegah reload halaman

        // informasi
        Swal.fire({
            type: 'success',
            title: 'Wait!',
            text: 'Proccess update data',
            timer: 9000,
            showCancelButton: false,
            showConfirmButton: false
        });

        let email = $('input[name="email"]').val(); //menadapatkan value inpu email yang disembunyikan
        let password = $('input[name="password"]').val(); //mendapatkan velua input password

        $.ajax({
            url: '<?php echo base_url() ?>user/logoutForgot', //url yang di akses
            type: 'post', //tipe method
            data: { //data yang dikirim pada kontroller
                email: email,
                password: password
            },
            success: function(response) { //jika pada controller tidak terjasi kesalahan
                // console.log(response);
                if (response == "success") { //jika hasil dari response yang diberikan conteoller "success"
                    // pemberitahuan berhasil
                    Swal.fire({
                            type: "success",
                            title: "Success !",
                            text: "Please login again using new your password",
                            timer: 2000,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                        .then(function() { //lalu mengalihkan pada url login
                            window.location.href = '<?php echo base_url() ?>login'
                        })
                } else { //jika nilai response tidak bernilai success
                    // pemberitahuan error
                    Swal.fire({
                        type: "error",
                        title: "Sorry !",
                        text: "An error occured on the server"
                    });
                }
            }
        });
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