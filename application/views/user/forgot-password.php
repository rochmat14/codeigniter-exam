<div class="center">
    <div class="panel br-tomato width-auth">
        <div class="panel-heading bg-tomato">
            <span class="font-panel-head">Forgot Password</span>
        </div>

        <form action="" id="form-forgot">
            <div class="panel-body">
                <div class="row">

                    <!-- input email -->
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="text" name="email" class="form-control input-email">
                        </div>
                    </div>

                    <!-- button send forgot password -->
                    <div class="col-sm-6">
                        <button type="submit" id=forgot-password class="btn btn-danger btn-block mar-b">Send</button>
                    </div>

                    <!-- button link ke halaman login -->
                    <div class="col-sm-6">
                        <a href='<?php echo base_url('/login') ?>' class="btn btn-warning btn-block">Login</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    // proses forgot password menggunakan ajax
    $('#form-forgot').on('submit', function(e) { //form id forgo-password di klik
        e.preventDefault(); //agar tidak terjadi reload halaman

        let email = $('#email').val(); //mendapatkan value input id email

        if (email == '') { //jika email kosong tidak ada aksi

        } else {  //jika email memiliki nilai
            Swal.fire({
                type: 'success',
                title: 'Wait!',
                text: 'Proccess send email',
                timer:9000,
                showCancelButton: false,
                showConfirmButton: false
            });
            
            $.ajax({
                url: "<?php echo base_url() ?>user/sendForgotPassword", // url untuk melakukan pengelolahan data
                type: "POST",  //type method
                data: {     //request yang dikirim pada controller
                    "email": email
                },
                
                success: function(response) { //konsidi berhasil 
                    console.log(response);
                    if (response == 'success') {  //jika nilai pada response controller bernilai "success"
                        // pemberitahun berhasil
                        Swal.fire({
                            type: 'success',
                            title: 'Success!',
                            text: 'Forgot password is Success',
                        });
                    } else { //jika tidak bernilai "success"
                        // pemberitahuan gagal
                        Swal.fire({
                            type: "error",
                            title: "Sorry!",
                            text: "Email is not found"
                        })
                    }
                },
                error: function(response) { //jika error pada controller
                    // console.log(response);
                    // pemberitahuan error
                    Swal.fire({
                        type: 'error',
                        title: 'Sorry !',
                        text: 'An error occured on the server!'
                    });
                }
            });
        }

    });
</script>