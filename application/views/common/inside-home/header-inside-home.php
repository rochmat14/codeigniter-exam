<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-3.3.1.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('/assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery.validate.min.js'); ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

        <style>
            /* backgorund */
            body { 
                background-image: url("assets/image-ui/background-inside.jpg");
                background-size: cover;
            }
            
            /* warna error validai input */
            label.error {
                color: red;
            }

            /* jaran ke bawah menu navigasi */
            .navbar {
                margin-bottom: 0px;
            }

            /* tulisan pada navigasi hitam */
            .navbar-inverse 
            .navbar-brand {
                color: black;
            }

            /* ketika pointer diarahkan pada link di navbar maka tulisan akan berubah warna tomato dan tebal */
            .navbar-inverse 
            .navbar-brand:hover {
                color: tomato;
                font-weight: bold;
            }

            /* warna brand abdul rochmat wagna hitam */
            .navbar-inverse
            .navbar-nav>li>a {
                color: black;
            }

            /* ketika brand navbar di arahkan pointer berubah warna menjadi tomato dan tebal */
            .navbar-inverse
            .navbar-nav>li>a:hover {
                color: tomato;
                font-weight: bold;
            }

            /* bacground navbar transparant */
            .navbar-inverse {
                border-color: transparent;
                background-color:transparent;
            }
            
            /* membuat panel posisi ke tengah */
            .card-profile {
                justify-content: center;
                display: flex;
            }

            /* tulisan panel headeing besar dan tebal */
            .font-panel-head {
                font-weight: bold;
                font-size: large;
            }

            /* membuat posisi ketengan  */
            .center {
                justify-content: center;
                display: flex; 
            }

            /* font heading pada panel warna shitesmoke, tebal, dan besar */
            .font-panel-head {
                font-weight: bold;
                font-size: large;
                color: whitesmoke;
            }

            /* border tomato */
            .br-tomato {
                border-color: tomato;
            }

            /* bacground tomato */
            .bg-tomato {
                background-color: tomato;
            }

            /* backerogn cornsilk */
            .bg-cornsilk {
                background-color: cornsilk;
            }

            /* hurug pada jumbotron besar dan tebal */
            .jmb-font {
                font-size: -webkit-xxx-large;
                font-weight: bold;
            }

            /* tabel mobile ketika pada halaman web akan hilang */
            .tbl-data-mobile {
                display: none;
            }

            /* button mobile ketika pada halaman web akan hilang */
            .btn-mobile {
                display: none;
            }
            
            /* button untuk slide navbar ketika posisi mobile */
            .btn-slide {
                border-radius: 6px;
                padding: 6px;
                background: tomato;
                width: 55px;
                height: 35px;
                margin-left: 3%;
                margin-bottom: 3%;
                margin-top: 2%;
            }

            /* garis 3 di dalam button slide navbar yang berwarna hitam */
            .rules-btn-slide{
                background-color: black;
                display: block;
                width: 44px;
                height: 5px;
                margin-bottom: 4px;
            }

            /* responsive tampilakn pada mobile */
            @media screen and (max-width: 600px) {
                /* navbar pertama dibuka halaman akan tersembunyi dan ketika button di klik baru akan muncul */
                .navbar {
                    display: none;
                }
                
                /* lebar 100% pada menu login, register dan forgot password  */
                .width-auth {
                    width: 100%;
                }

                /* margin bottom 5 */
                .mar-b {
                    margin-bottom: 5%;
                }

                /* tabel web akan hilang pada tampilan mobile */
                .tbl-data-web {
                    display: none;
                }

                /* tabel mobile akan tampil ketika tampilan mobile */
                .tbl-data-mobile {
                    display: block;
                }

                /* button slide pada posisi mobile akan tampil */
                .btn-mobile {
                    display: block;
                }
            }
        </style>

    </head>

    <body>
        <header>
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="/">Abdul Rochmat</a>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="li"><a class="a" href="/">Home</a></li>
                        <li class="li"><a class="a" href="/user-view">User Data</a></li>
                        <li class="li"><a class="a" href="/user-guide">User Guide</a></li>
                        <li class="li"><a class="a" href="/about">About</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/user-edit"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a></li>
                        <li><a href="/user/logout" style="cursor: pointer;"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    </ul>
                </div>
            </nav>

            <!-- button slide navbar -->
            <div class="bg-btn-slide btn-mobile">
                <div class="btn-slide">
                    <span class="rules-btn-slide"></span>
                    <span class="rules-btn-slide"></span>
                    <span class="rules-btn-slide"></span>
                </div>
            </div>
            
        </header>

        <div class="container">
    

        <script type="text/javascript">
            
            // evetn button slide navbar
            $('.btn-slide').click(function(){
                $('.navbar').slideToggle(100);
            });
        </script>