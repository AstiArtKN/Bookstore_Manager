<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$getTheLoai = getAll("SELECT * FROM theloaisach");


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
</head>

<body>
    <header class="header header-fixed">
        <div class="container">
            <!-- header top -->
            <div class="header__top">
                <!-- logo -->
                <a href="<?php echo _HOST_URL ?>"><img
                        src="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/logo_web_store.png" alt="K-BOOKS"
                        class="header__logo" /></a>
                <!-- navbar -->
                <div class="navbar">
                    <ul class="navbar__list" id="nvpc">
                        <li class="navbar__item">
                            <a href="<?php echo _HOST_URL; ?>" class="navbar__link">Trang chủ</a>
                        </li>
                        <li class="navbar__item">
                            <a href="#!" class="navbar__link">Thể loại</a>
                            <ul class="submenu">
                                <?php foreach($getTheLoai as $item):?>
                                <li class="submenu-item"><a
                                        href="?module=store&action=book_cate&id=<?php echo $item['ID']?>"
                                        class="submenu-link"><?php echo $item['tenTheLoai'] ?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li class="navbar__item">
                            <a href="#hotro" class="navbar__link">Hỗ trợ</a>
                        </li>
                        <li class="navbar__item">
                            <!-- search -->
                            <div class="header-search">
                                <form action="">
                                    <input type="hidden" name="module" value="store">
                                    <input type="hidden" name="action" value="book_search">
                                    <input class="header-search__input" type="search" id="search_book"
                                        name="search_book" placeholder="nhập tên sách để tìm sách" />
                                    <button type="submit" class="header-search__btn btn">
                                        Tìm
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- buy -->
                <a href="?module=store&action=book_cart" class="cart-shop">
                    <svg class="cart-shop__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path fill="currentColor"
                            d="M24 0C10.7 0 0 10.7 0 24S10.7 48 24 48l45.5 0c3.8 0 7.1 2.7 7.9 6.5l51.6 271c6.5 34 36.2 58.5 70.7 58.5L488 384c13.3 0 24-10.7 24-24s-10.7-24-24-24l-288.3 0c-11.5 0-21.4-8.2-23.6-19.5L170.7 288l288.5 0c32.6 0 61.1-21.8 69.5-53.3l41-152.3C576.6 57 557.4 32 531.1 32L360 32l0 102.1 23-23c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-64 64c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l23 23L312 32 120.1 32C111 12.8 91.6 0 69.5 0L24 0zM176 512a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm336-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0z" />
                    </svg>
                </a>
            </div>
        </div>
    </header>
    <!-- menu drop mobile -->
    <div class="menu-mobile">
        <input type="checkbox" id="checked-menu" name="checked-menu" hidden />
        <label for="checked-menu">
            <svg class="menu-mobile__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path fill="currentColor"
                    d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z" />
            </svg>
        </label>

        <!-- overlay -->
        <label for="checked-menu" class="menu-overlay"></label>
        <!-- menu -->
        <div class="menu-drawer">
            <!-- menu top -->
            <div class="menu-drawer-top">
                <!-- logo -->
                <img src="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/logo_web_store.png" alt="K-BOOKS"
                    class="logo-mobile" />
                <!-- close -->
                <label for="checked-menu">
                    <svg class="close-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M226.5 92.9c14.3 42.9-.3 86.2-32.6 96.8s-70.1-15.6-84.4-58.5s.3-86.2 32.6-96.8s70.1 15.6 84.4 58.5zM100.4 198.6c18.9 32.4 14.3 70.1-10.2 84.1s-59.7-.9-78.5-33.3S-2.7 179.3 21.8 165.3s59.7 .9 78.5 33.3zM69.2 401.2C121.6 259.9 214.7 224 256 224s134.4 35.9 186.8 177.2c3.6 9.7 5.2 20.1 5.2 30.5l0 1.6c0 25.8-20.9 46.7-46.7 46.7c-11.5 0-22.9-1.4-34-4.2l-88-22c-15.3-3.8-31.3-3.8-46.6 0l-88 22c-11.1 2.8-22.5 4.2-34 4.2C84.9 480 64 459.1 64 433.3l0-1.6c0-10.4 1.6-20.8 5.2-30.5zM421.8 282.7c-24.5-14-29.1-51.7-10.2-84.1s54-47.3 78.5-33.3s29.1 51.7 10.2 84.1s-54 47.3-78.5 33.3zM310.1 189.7c-32.3-10.6-46.9-53.9-32.6-96.8s52.1-69.1 84.4-58.5s46.9 53.9 32.6 96.8s-52.1 69.1-84.4 58.5z" />
                    </svg>
                </label>
            </div>
            <ul id="nvmobile"></ul>
            <!-- script -->
            <script>
            const navpc = document.querySelector("#nvpc");
            const navmobile = document.querySelector("#nvmobile");
            // sao chép
            navmobile.innerHTML = navpc.innerHTML;
            </script>
        </div>
    </div>

    <!----------------- end header ---------------- -->