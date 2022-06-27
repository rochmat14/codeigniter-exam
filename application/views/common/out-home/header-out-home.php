<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">
    <script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery-3.3.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery.validate.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <title>Document</title>
</head>

<style>
    body {
        background-image: url("assets/image-ui/background-outside.jpg");
        background-size: cover;
    }

    /* warna error validai input */
    label.error {
        color: red;
    }

    /* membuat panel posisi ke tengah */
    .card-profile {
        justify-content: center;
        display: flex;
    }

    /* tulisan panel headeing besar dan tebal */
    .center {
        justify-content: center;
        display: flex;
    }

    /* membuat posisi ketengan  */
    .width-auth {
        width: 30%;
        margin-top: 5%;
    }

    .font-panel-head {
        font-weight: bold;
        font-size: large;
        color: whitesmoke;
    }

    .br-tomato {
        border-color: tomato;
    }

    .bg-tomato {
        background-color: tomato;
    }

    @media screen and (max-width: 600px) {
        .width-auth {
            width: 100%;
            margin-top: 26%;
            /* margin-bottom: 100%; */
        }

        .mar-b {
            margin-bottom: 5%;
        }
    }
</style>

<body>
    <div class="container">