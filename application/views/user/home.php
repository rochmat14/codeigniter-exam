<div class="card-profile">
    <div class="panel br-tomato w-50 mb-5 mt-3">

        <div class="panel-heading bg-tomato">

            <!-- title -->
            <span style="color: whitesmoke; font-size: xx-large; font-weight: bold;">Welcome <span id="name-wel-title"></span> in happy website</span> 

            <hr style="background-color: grey;">

            <!-- email -->
            <h5 class="font-panel-head">Email : <span id="email-wel"></span></h5>

            <!-- name -->
            <h5 class="font-panel-head">Nama : <span id="name-wel"></span></h5>
        </div>

        <div class="panel-body bg-cornsilk text-center">
            
            <!-- akan di masukan gambar menggunakan ajax -->
            <div id="image-wel"></div>
        </div>
    </div>
</div>

<!-- <button  class="btn btn-warning mb-5 btn-block">Logout</button> -->

<script type="text/javascript">
    tampil_profil(); //auto load jika ada perubahan data pada fungsi

    //Menampilkan Data di tabel
    function tampil_profil() {
        $.ajax({
            url: '<?php echo base_url(); ?>user/dataUserById/'+<?php echo $this->session->userData('id') ?>, //url yang di akses
            type: 'POST',  //tipe method
            dataType: 'json', //type data yang di response
            success: function(response) {
                $("#name-wel-title").html(response[0].name.toUpperCase()); //memasukan data pada id name-wel-title
                $("#email-wel").html(response[0].email);
                $("#name-wel").html(response[0].name.toUpperCase());
                $("#image-wel").html('<img src="/assets/images/' + response[0].profile_picture + '" width="268px">' );
            }
        });
    }
</script>