<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}


?>

<!DOCTYPE html>
<html lang="Vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="57x57"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage"
        content="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- reset css -->
    <link rel="stylesheet" href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/css/reset.css?ver=<?php rand(); ?>" />
    <!-- embed fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Road+Rage&display=swap"
        rel="stylesheet" />
    <!-- style -->
    <link rel="stylesheet" href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/css/style_store.css?ver=<?php rand(); ?>" />
    <!-- responsive -->
    <link rel="stylesheet" href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/css/reponsive.css?ver=<?php rand(); ?>" />
    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <title>[K-BOOKS] - CỬA HÀNG SÁCH MEOWS</title>
    <style>
    body {
        height: 100vh;
    }

    .maintenance {
        width: 400px;
        margin: 0 auto;
    }

    .maintenance__img {
        width: 100%;
        height: auto;
        object-fit: cover;
        margin-top: 50%;
    }

    .maintenance__heading {
        text-align: center;
        margin-top: 20px;
        font-family: "Road Rage", sans-serif;
        font-size: 6rem;
        color: #b60000ff;
    }

    .maintenance__desc {
        text-align: center;
        margin-top: 10px;
        font-weight: 700;
        font-size: 1.8rem;
    }
    </style>
</head>

<body>
    <div class="maintenance">
        <img src="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/Layer_5.png" alt="" class="maintenance__img">
        <h1 class="maintenance__heading">ĐANG BẢO TRÌ HỆ THỐNG</h1>
        <p class="maintenance__desc">Vui lòng quay lại sau!!!</p>
    </div>
</body>