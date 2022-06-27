<div class="center">
    <div class="panel br-tomato width-auth">
        <div class="panel-heading bg-tomato">
            <span class="font-panel-head">User Edit</span>
        </div>

        <form action="" id="form-update">
            <div class="panel-body bg-cornsilk">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <!-- id tersembunyi -->
                            <input hidden type="text" name="id" value="<?php echo $this->session->userData('id') ?>">

                            <!-- input email -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="text" class="form-control input-email">
                                </div>
                            </div>

                            <!-- input name -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control input-name">
                                </div>
                            </div>

                            <!-- input password -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <p id="show-password" style="cursor:pointer; color:blue;">Show</p>
                                    <input id="password" type="password" class="form-control" name="password">
                                    <input type="hidden" name="password-value" class="form-control">
                                </div>
                            </div>

                            <!-- input picture -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="profile_picture">Picture</label>
                                    <input id="profile_picture" type="file" name="profile_picture" class="form-control">
                                    <input type="hidden" name="name-picture" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <!-- image profile -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div id="test" style="text-align: center;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- button update -->
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-danger col-sm-6" style="float: right;">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    user_by_id(); //menjalankan otomatis fungsi "user_by_id"

    function user_by_id() {
        $.ajax({
            url: '<?php echo base_url(); ?>user/dataUserById/' + <?php echo $this->session->userData('id') ?>, //akses url
            type: 'POST', //method posr
            dataType: 'json', // type data yang response
            success: function(response) { //jika pada kontroller tidak terjadi kesalahan
                // console.log(response);
                $("#editModal").modal('show'); //menampilkan modal untuk update data

                $('input[name="id"]').val(response[0].id); //memberikan value input name id dengan "response[0].id"
                $('input[name="email"]').val(response[0].email);
                $('input[name="name"]').val(response[0].name);
                $('input[name="password-value"]').val(response[0].password);
                $('input[name="name-picture"]').val(response[0].profile_picture);
                $('#test').html('<img src="/assets/images/' + response[0].profile_picture + '" width="268px">'); //memberikan id text dengan gambar"
            }
        })
    };

    $("#form-update").submit(function(e) { //melakukan pengupdaten data yang telah di request
        e.preventDefault(); //mencegah reload halaman

        let ext = $("#profile_picture").val().split('.').pop().toLowerCase(); //untuk mendapatkan extensi terakhir pada file

        var fileInput = document.getElementById("profile_picture"); //element yang memiliki attribute id image

        if ($("#profile_picture").val() != "") { //jika profile tidak kosong
            if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) { //jika variabel ext buka estensi png jpg dan jpeg
                // pemberitahuan error
                Swal.fire({
                    type: 'error',
                    title: 'Extention not support !',
                    text: 'Upload photo with extention (png, jpg, jpeg) !'
                });
            } else if (fileInput.files[0].size > 1000000) { //jika ukuran file melebihi 1 mb
                // pemberitahuan error
                Swal.fire({
                    type: 'error',
                    title: 'Big Capacity !',
                    text: 'Capacity photo must be under 1mb !'
                });
            } else if ($('input[name="name"]').val() != "" && $('input[name="email"]').val() != "") { //jika name dan email tidak kosong

                // informasi
                Swal.fire({
                    type: 'success',
                    title: 'Wait!',
                    text: 'Proccess update data',
                    timer: 9000,
                    showCancelButton: false,
                    showConfirmButton: false
                });

                $.ajax({ //melakukan update data meskipun file tidak ada
                    url: '<?php echo base_url(); ?>user/editDataUser', //akses url
                    type: "post", //tipe method
                    data: new FormData(this), //data yang dikirim juga berupa file
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(response) { //jika pada controller tidak terjadi kesalan
                        // console.log(data);

                        if (response == "success") { //jika response pada controller bernilai "success"
                            // auto load fungsi
                            user_by_id();

                            // pemberitahuan success
                            Swal.fire({
                                type: 'success',
                                title: 'Succes !',
                                text: 'Data success updating!'
                            });

                            $('input[name="password"]').val(""); //mengosongkan value input password

                            $('input[name="profile_picture"]').val(""); //mengosongkan value input password

                        } else { //jika response pada controller buka "success"
                            // pemberitahuan error
                            Swal.fire({
                                type: 'error',
                                title: 'Sorry !',
                                text: 'An error occured on the server!'
                            });
                        }
                    }
                });
            }

        } else if ($("#profile_picture").val() == "") { //jika photo tidak di upload atau tidak di ubah

            if ($('input[name="name"]').val() != "" && $('input[name="email"]').val() != "") {

                // informasi
                Swal.fire({
                    type: 'success',
                    title: 'Wait!',
                    text: 'Proccess update data',
                    timer: 9000,
                    showCancelButton: false,
                    showConfirmButton: false
                });

                $.ajax({
                    url: '<?php echo base_url(); ?>user/editDataUser', //akses url
                    type: "post", //tipe method
                    data: new FormData(this), //data yang dikirim juga berupa file
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    success: function(response) { //jika pada controller tidak terjadi kesalan
                        // console.log(data);

                        if (response == "success") { //jika response pada controller bernilai "success"
                            // auto load fungsi
                            user_by_id();

                            // pemberitahuan success
                            Swal.fire({
                                type: 'success',
                                title: 'Succes !',
                                text: 'Data success updating!'
                            });

                            $('input[name="password"]').val(""); //mengosongkan value input password

                            $('input[name="profile_picture"]').val(""); //mengosongkan value input password

                        } else { //jika response pada controller buka "success"
                            // pemberitahuan error
                            Swal.fire({
                                type: 'error',
                                title: 'Sorry !',
                                text: 'An error occured on the server!'
                            });
                        }
                    }
                });
            }

        } else if ($('input[name="name"]').val() == "") { //jika input name kosong

        } else if ($('input[name="email"]').val() == "") { //jika input email kosong

        } else if ($('input[name="password"]').val() == "") { //jika input password kosong

        } else if ($('input[name="profile_picture"]').val() == "") { //jika input profile kosong

        } else { //jika input email dan name tidak kosong
            // informasi
            Swal.fire({
                type: 'success',
                title: 'Wait!',
                text: 'Proccess update data',
                timer: 9000,
                showCancelButton: false,
                showConfirmButton: false
            });

            $.ajax({
                url: '<?php echo base_url(); ?>user/editDataUser', //akses url
                type: "post", //tipe method
                data: new FormData(this), //data yang dikirim juga berupa file
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(response) { //jika pada controller tidak terjadi kesalan
                    // console.log(data);

                    if (response == "success") { //jika response pada controller bernilai "success"
                        // auto load fungsi
                        user_by_id();

                        // pemberitahuan success
                        Swal.fire({
                            type: 'success',
                            title: 'Succes !',
                            text: 'Data success updating!'
                        });

                        $('input[name="password"]').val(""); //mengosongkan value input password

                        $('input[name="profile_picture"]').val(""); //mengosongkan value input password

                    } else { //jika response pada controller buka "success"
                        // pemberitahuan error
                        Swal.fire({
                            type: 'error',
                            title: 'Sorry !',
                            text: 'An error occured on the server!'
                        });
                    }
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