    <div class="center">
        <div class="panel br-tomato width-auth">

            <!-- card heder -->
            <div class="panel-heading bg-tomato">
                <span class="font-panel-head">Register</span>
            </div>

            <!-- card body -->
            <div class="panel-body">
                <form action="" id="form-register">
                    <div class="row">

                        <!-- input email -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control input-email" name="email">
                            </div>
                        </div>

                        <!-- input name -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control input-name" name="name">
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

                        <!-- input file image -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="profile_picture">Image</label>
                                <input type="file" id="image" class="form-control input-profile_picture" name="profile_picture">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <!-- button register -->
                            <button class="btn btn-success btn-block mar-b" id="btn_upload" type="submit">Register</button>
                        </div>

                        <!-- button login -->
                        <div class="col-sm-6">
                            <a href="<?php echo base_url('/') ?>" class="btn btn-danger btn-block">Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // prosesse registrasi menggunakan ajax
        $('#form-register').submit(function(e) { //form id form-register ketika di submit
            e.preventDefault(); //mencegah reload halaman

            let ext = $("#image").val().split('.').pop().toLowerCase();  //untuk mendapatkan extensi terakhir pada file

            var fileInput = document.getElementById("image");   //element yang memiliki attribute id image

            if ($('input[name="email"]').val() == "") {  //jika input email kosong

            } else if ($('input[name="name"]').val() == "") {  //jika input name kosong

            } else if ($('input[name="password"]').val() == "") {   //jika input password kosong

            } else if ($('input[name="profile_picture"]').val() == "") {   //jika input profile kosong

            } else if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {   //jika variabel ext buka estensi png jpg dan jpeg
                // pemberitahuan error
                Swal.fire({
                    type: 'error',
                    title: 'Extention not support !',
                    text: 'Upload photo with extention (png, jpg, jpeg) !'
                });
            } else if (fileInput.files[0].size > 1000000) {
                // pemberitahuan error
                Swal.fire({
                    type: 'error',
                    title: 'Big Capacity !',
                    text: 'Capacity photo must be under 1mb !'
                });
            } else {

                Swal.fire({
                    type: "success",
                    title: "Proccess !",
                    text: "Please wait a moment because a little long.",
                    timer: 2000,
                    showCancelButton: false,
                    showConfirmButton: false
                });
                
                $.ajax({
                    url: '<?php echo base_url(); ?>user/insertRegister', //akses url 
                    type: "post", //tipe method
                    data: new FormData(this), //jenis file yang juga di upload
                    processData: false,
                    contentType: false,
                    // cache: false,
                    // async: false,
                    success: function(response) { //jika pada controller tidak terjadi kesalan
                        console.log(response);

                        if (response == "success") { //jika response pada controller bernilai "success"
                            // menmpilkan pemberitahan berhasil
                            Swal.fire({
                                type: "success",
                                title: "Success",
                                text: "Please login with akun which already registered",
                                timer: 1000,
                                showCancelButton: false,
                                showConfirmButton: false
                            })
                            .then(function() { //lalu mengalihkan pada halaman home setelah login berasil
                                window.location.href = "<?php echo base_url() ?>login";
                            });
                        } else if ("exist") { //jika pada response controller tidak bernilai "success"
                            // pembertahuan error
                            Swal.fire({
                                type: "error",
                                title: "Sorry !",
                                text: "Email already used"
                            })
                        } else {
                            // pembertahuan error
                            Swal.fire({
                                type: "error",
                                title: "Sorry !",
                                text: "An error occured on the server!"
                            });
                        }
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