<div class="panel br-tomato">
    <div class="panel-heading bg-tomato">
        <span class="font-panel-head">Users Data</span>
    </div>

    <div class="panel-body bg-cornsilk">


        <!-- table data -->
        <table class="table tbl-data-web">
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:25%;">Email</th>
                    <th style="width:25%;">Name</th>
                    <th style="width:25%;">Picture</th>
                    <th style="width:20%;">Pilihan</th>
                </tr>
            </thead>

            <!-- mengambil data dari ajax id tbl_data -->
            <tbody id="tbl_data">

            </tbody>
        </table>

        <div id="tbl_data_mobile" class="tbl-data-mobile">

        </div>

        <!-- Modal Edit-->
        <div id="editModal" class="modal fade" role="dialog">
            <form id="form-update">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4 class="modal-title">Edit Data</h4>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <!-- input id -->
                                <div hidden class="col-sm-6">
                                    <div class="form-group">
                                        <label for="noinduk">Id</label>
                                        <input readonly type="text" name="id" class="form-control"></input>
                                    </div>
                                </div>

                                <!-- input email -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nama">Email</label>
                                        <input type="text" name="email" class="form-control input-email"></input>
                                    </div>
                                </div>

                                <!-- input name -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="alamat">Name</label>
                                        <input type="text" name="name" class="form-control input-name"></input>
                                    </div>
                                </div>

                                <!-- input password -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <p id="show-password" style="cursor:pointer; color:blue;">Show</p>
                                        <input id="password" type="password" class="form-control" name="password">
                                        <input type="hidden" name="password-value" class="form-control"></input>
                                    </div>
                                </div>

                                <!-- input gambar berupa file -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="profile_picture">Profile Picture</label>
                                        <input type="file" id="profile_picture" name="profile_picture" class="form-control"></input>
                                        <input type="hidden" name="name-picture" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-12 text-center">
                                    <!-- berisi gabmar yang dikirim dari ajax -->
                                    <div id="test"></div>
                                </div>
                            </div>

                        </div>

                        <!-- button update dan close -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="btn_update_data">Update</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    tampil_data(); // auto load fungsi


    function tampil_data() { //Menampilkan Data di tabel
        $.ajax({
            url: '<?php echo base_url(); ?>user/dataUser', //akses url
            type: 'POST', //type methhod 
            dataType: 'json', //tipe data yang di response
            success: function(response) { //keadaan controller tidak terjadi kesalaham
                // console.log(response);
                var i;
                var no = 0;
                var html = "";
                for (i = 0; i < response.length; i++) { //mengulang sesuai dengan julmlah data yang ada
                    no++;

                    // user yang login tidak bisa menghapus datanya
                    if (response[i].id == <?php echo $this->session->userData('id') ?>) { //jika data id tabel sama dengan id user yang login maka tidak ada button hapus
                        html = html + '<tr>' +
                            '<td>' + no + '</td>' + //table data isi nomor urut
                            '<td>' + response[i].email + '</td>' + //table data isi email
                            '<td>' + response[i].name.toUpperCase() + '</td>' + //table data isi name
                            '<td>' + '<img src=" /assets/images/' + response[i].profile_picture + '" width="100px" />' + '</td>' + //table data isi gambar profile user 
                            '<td style="width: 16.66%;">' +
                            '<span><input hidden type="text" value="' + response[i].profile_picture + '" name="profile_picture"></input>' + // input nama file photo yang disembunyikan
                            '<button data-id="' + response[i].id + '" class="btn btn-primary btn_edit">Edit</button>' + //button edit
                            '<tr>';

                        // bisa menghapus data user lain
                    } else {
                        html = html + '<tr>' +
                            '<td>' + no + '</td>' + //table data isi nomor urut
                            '<td>' + response[i].email + '</td>' + //table data isi email
                            '<td>' + response[i].name.toUpperCase() + '</td>' + //table data isi name
                            '<td>' + '<img src=" /assets/images/' + response[i].profile_picture + '" width="100px" />' + '</td>' + //table data isi gambar profile user 
                            '<td style="width: 16.66%;">' +
                            '<input hidden type="text" value="' + response[i].profile_picture + '" name="profile_picture"></input>' +
                            '<span>' + //input value nama gambar yang disembunyikan 
                            '<button data-id="' + response[i].id + '" class="btn btn-primary btn_edit">Edit</button>' + // button edit
                            '<button style="margin-left: 5px;" data-id="' + response[i].id + '" class="btn btn-danger btn_hapus">Delete</button>' +
                            '</span>' +
                            '</td>' + //button hapus
                            '<tr>';
                    }
                }

                $("#tbl_data").html(html); //memasukan pada element yang memiliki attribute id tbl_data

            }

        });


        $.ajax({
            url: '<?php echo base_url(); ?>user/dataUser', //akses url
            type: 'POST', //type methhod 
            dataType: 'json', //tipe data yang di response
            success: function(response) { //keadaan controller tidak terjadi kesalaham
                // console.log(response);
                var i;
                var no = 0;
                var html = "";
                for (i = 0; i < response.length; i++) { //mengulang sesuai dengan julmlah data yang ada
                    no++;

                    // user yang login tidak bisa menghapus datanya
                    if (response[i].id == <?php echo $this->session->userData('id') ?>) { //jika data id tabel sama dengan id user yang login maka tidak ada button hapus
                        html = html + '<table class="table table-bordered">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th>No</th>' +
                                    '<td>' + no + '</td>' + //nomor urut
                                '</tr>' +
                                '<tr>' +
                                    '<th>Email</th>' +
                                    '<td>' + response[i].email + '</td>' + //data item email
                                '</tr>' +
                                '<tr>' +
                                    '<th>Name</th>' +
                                    '<td>' + response[i].name.toUpperCase() + '</td>' + //data item name
                                '</tr>' +
                                '<tr>' +
                                    '<th>Profile Picture</th>' +
                                    '<td>' + '<img src=" /assets/images/' + response[i].profile_picture + '" width="100px" />' + '</td>' + //data item foto
                                '</tr>' +
                                '<tr>' +
                                    '<td colspan="2">' +
                                        '<input hidden type="text" value="' + response[i].profile_picture + '" name="profile_picture"></input>' + //input value nama gambar yang disembunyikan 
                                        '<span>' +
                                            '<button data-id="' + response[i].id + '" class="btn btn-primary btn_edit">Edit</button>' + // button edit
                                        '</span>' +
                                    '</td>' +
                                '</tr>' +
                            '</thead>' +
                            '</table>';

                        // bisa menghapus data user lain
                    } else {
                        html = html + '<table class="table table-bordered">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th>No</th>' +
                                    '<td>' + no + '</td>' + //nomor urut
                                '</tr>' +
                                '<tr>' +
                                    '<th>Email</th>' +
                                    '<td>' + response[i].email + '</td>' + //data item email
                                '</tr>' +
                                '<tr>' +
                                    '<th>Name</th>' +
                                    '<td>' + response[i].name.toUpperCase() + '</td>' + //data item name
                                '</tr>' +
                                '<tr>' +
                                    '<th>Profile Picture</th>' +
                                    '<td>' + '<img src=" /assets/images/' + response[i].profile_picture + '" width="100px" />' + '</td>' + //gambar profile
                                '</tr>' +
                                '<tr>' +
                                    '<td colspan="2">' +
                                        '<input hidden type="text" value="' + response[i].profile_picture + '" name="profile_picture"></input>' + //input value nama gambar yang disembunyikan
                                        '<span>' +
                                            '<button data-id="' + response[i].id + '" class="btn btn-primary btn_edit">Edit</button>' + // button edit
                                            '<button style="margin-left: 5px;" data-id="' + response[i].id + '" class="btn btn-danger btn_hapus">Delete</button>' + //button hapus
                                        '</span>' +
                                    '</td>' +
                                '</tr>' +
                            '</thead>' +
                            '</table>';
                    }
                }

                // $("#tbl_data").html(html); //memasukan pada element yang memiliki attribute id tbl_data

                $("#tbl_data_mobile").html(html);
            }

        });
    }

    //Memunculkan modal edit
    $("#tbl_data").on('click', '.btn_edit', function() { //ketikabuton dengan class btn_edti di klik
        var id = $(this).attr('data-id'); //mendapatkan attribute data id data button class btn_edit

        $.ajax({
            url: '<?php echo base_url(); ?>user/dataUserById/' + id, //akses url
            type: 'POST', //tipe post
            data: { //data request yang dikirim
                id: id
            },
            dataType: 'json', //tipe yang di response
            success: function(response) { //jika pada controller tidak terjadi kesalahan
                // console.log(response);
                $("#editModal").modal('show'); //menampilkan modal edit


                $('input[name="id"]').val(response[0].id); //memasuk value id pada input dengan attribute id
                $('input[name="email"]').val(response[0].email);
                $('input[name="name"]').val(response[0].name);
                $('input[name="password-value"]').val(response[0].password);
                $('input[name="name-picture"]').val(response[0].profile_picture);
                $('#test').html('<img src="/assets/images/' + response[0].profile_picture + '" width="268px">'); //memasuk gambar profile pada attribute id test
            }
        })
    });


    $("#tbl_data_mobile").on('click', '.btn_edit', function() { //ketikabuton dengan class btn_edti di klik
        var id = $(this).attr('data-id'); //mendapatkan attribute data id data button class btn_edit

        $.ajax({
            url: '<?php echo base_url(); ?>user/dataUserById/' + id, //akses url
            type: 'POST', //tipe post
            data: { //data request yang dikirim
                id: id
            },
            dataType: 'json', //tipe yang di response
            success: function(response) { //jika pada controller tidak terjadi kesalahan
                // console.log(response);
                $("#editModal").modal('show'); //menampilkan modal edit

                $('input[name="id"]').val(response[0].id); //memasuk value id pada input dengan attribute id
                $('input[name="email"]').val(response[0].email);
                $('input[name="name"]').val(response[0].name);
                $('input[name="password-value"]').val(response[0].password);
                $('input[name="name-picture"]').val(response[0].profile_picture);
                $('#test').html('<img src="/assets/images/' + response[0].profile_picture + '" width="268px">'); //memasuk gambar profile pada attribute id test
            }
        })
    });


    $("#form-update").submit(function(e) { //jika form id form-update
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

                            // pemberitahuan success
                            Swal.fire({
                                type: 'success',
                                title: 'Succes !',
                                text: 'Data success updating!'
                            });

                            $('input[name="password"]').val(""); //mengosongkan value input password

                            $('input[name="profile_picture"]').val(""); //mengosongkan value input password

                            $("#editModal").modal('hide'); //menlakukan penutupan pada modal edit

                            tampil_data(); // load fungsi_data

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

                            // pemberitahuan success
                            Swal.fire({
                                type: 'success',
                                title: 'Succes !',
                                text: 'Data success updating!'
                            });

                            $('input[name="password"]').val(""); //mengosongkan value input password

                            $('input[name="profile_picture"]').val(""); //mengosongkan value input password

                            $("#editModal").modal('hide'); //menlakukan penutupan pada modal edit

                            tampil_data(); // load fungsi_data

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

                        // pemberitahuan success
                        Swal.fire({
                            type: 'success',
                            title: 'Succes !',
                            text: 'Data success updating!'
                        });

                        $('input[name="password"]').val(""); //mengosongkan value input password

                        $('input[name="profile_picture"]').val(""); //mengosongkan value input password

                        $("#editModal").modal('hide'); //menlakukan penutupan pada modal edit

                        tampil_data(); // load fungsi_data

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


    $("#tbl_data").on('click', '.btn_hapus', function(e) { //jika button id btn_hapus pada id tabel tbl_data di click
        e.preventDefault(); //mencegah reload halaman

        // informasi
        Swal.fire({
            type: 'success',
            title: 'Wait!',
            text: 'Proccess delete data',
            timer: 9000,
            showCancelButton: false,
            showConfirmButton: false
        });

        let id = $(this).attr('data-id'); //mendapatkan value attriute data-id pada button hapus
        let profile_picture = $('input[name="profile_picture"]').val(); //mendapatkan value name pada profile picture yang disembunyikan

        // alert(id);
        $.ajax({
            url: '<?php echo base_url() ?>user/deleteUser', //akses url
            type: 'post', //type method
            data: { //data yang dikirim
                id: id,
                profile_picture: profile_picture
            },
            success: function(response) { //jika pada controller tidak terjadi kesalahan
                if (response == "success") { //jika response pada controller bernilai "success"
                    // menampilkan pemberitahuan berhasil
                    Swal.fire({
                        type: 'success',
                        title: 'Succes',
                        text: 'Data which you delete success!'
                    });
                } else { //jika response bukan "success"
                    // menampilkan pembertahuan error
                    Swal.fire({
                        type: 'error',
                        title: 'Sorry !',
                        text: 'Data which you when delete error!'
                    });
                }

                tampil_data(); // load fungsi 
            }
        })
    });



    $("#tbl_data_mobile").on('click', '.btn_hapus', function(e) { //jika button id btn_hapus pada id tabel tbl_data di click
        e.preventDefault(); //mencegah reload halaman

        let id = $(this).attr('data-id'); //mendapatkan value attriute data-id pada button hapus
        let profile_picture = $('input[name="profile_picture"]').val(); //mendapatkan value name pada profile picture yang disembunyikan

        // alert(id);
        $.ajax({
            url: '<?php echo base_url() ?>user/deleteUser', //akses url
            type: 'post', //type method
            data: { //data yang dikirim
                id: id,
                profile_picture: profile_picture
            },
            success: function(response) { //jika pada controller tidak terjadi kesalahan
                if (response == "success") { //jika response pada controller bernilai "success"
                    // menampilkan pemberitahuan berhasil
                    Swal.fire({
                        type: 'success',
                        title: 'Succes',
                        text: 'Data which you delete success!'
                    });
                } else { //jika response bukan "success"
                    // menampilkan pembertahuan error
                    Swal.fire({
                        type: 'error',
                        title: 'Sorry !',
                        text: 'Data which you when delete error!'
                    });
                }

                tampil_data(); // load fungsi 
            }
        })
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