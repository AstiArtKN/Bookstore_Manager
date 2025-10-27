<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');
$user_detail = getCurrentUserFromToken();


$getBookManga = getAll("SELECT sach.ISBN, sach.tenSach, tacgiasach.tenTacGia, theloaisach.tenTheLoai,
sach.gia, sach.kichThuoc, nhaxuatban.tenNhaXuatBan, sach.moTa, sach.hinhAnh, sach.slug, sach.soLuong
FROM sach
INNER JOIN tacgiasach ON sach.tacGiaId = tacgiasach.ID
INNER JOIN theloaisach ON sach.theLoaiId = theloaisach.ID
INNER JOIN nhaxuatban ON sach.nhaXuatBanId = nhaxuatban.ID
LIMIT 3
");
// print_r($getBookManga);die();
$getBookLN = '';
$getBookdoiSong_KH = getAll("SELECT sach.ISBN, sach.tenSach, tacgiasach.tenTacGia, theloaisach.tenTheLoai,
sach.gia, sach.kichThuoc, nhaxuatban.tenNhaXuatBan, sach.moTa, sach.hinhAnh, sach.slug, sach.soLuong
FROM sach
INNER JOIN tacgiasach ON sach.tacGiaId = tacgiasach.ID
INNER JOIN theloaisach ON sach.theLoaiId = theloaisach.ID
INNER JOIN nhaxuatban ON sach.nhaXuatBanId = nhaxuatban.ID
WHERE theloaisach.ID = 'TL1'
LIMIT 5
");
$getAllNewBook = '';//desc create_at




$msg = getSessionFlash('msg');
$msg_type = getSessionFlash('msg_type');
?>

<main>
    <!-- hero -->
    <div class="hero">
        <div class="container">
            <div class="hero__inner">
                <!-- hero img -->
                <img src="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/maomao-hero.png" alt="Dog img"
                    class="hero__img" />
                <!-- hero content -->
                <div class="hero__content">
                    <h1 class="hero__heading">Cửa hàng sách K-Books</h1>
                    <p class="hero__desc">Kho sách và truyện tranh khổng lồ</p>

                    <?php if(!empty($user_detail)): ?>
                    <a href="?module=auth&action=login" class="btn hero__btn line-clamp line-1 break-all ">xin chào,
                        <?php echo $user_detail['tenNguoiDung']; ?></a>
                    <a href="?module=store&action=my_receipt" class="btn hero__btn">lịch sử mua hàng</a>
                    <a href="?module=auth&action=logout" class="btn hero__btn">Đăng xuất</a>
                    <?php
                        else:
                     ?>
                    <a href="?module=auth&action=login" class="btn hero__btn">Đăng Nhập Ngay</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- sline-show -->
    <div class="slideshow-web">
        <div class="containeaar">
            <div class="slideshow">
                <div class="slides">
                    <img src="https://theme.hstatic.net/200000287623/1000948667/14/slideshow_2.jpg?v=531" alt="">
                    <img src="https://theme.hstatic.net/200000287623/1000948667/14/slideshow_3.jpg?v=531" alt="">
                    <!-- <img src="https://theme.hstatic.net/1000376556/1001014889/14/psl_1_r1_slide_img_1.jpg?v=68" alt="">
                    <img src="https://theme.hstatic.net/1000376556/1001014889/14/psl_1_r1_slide_img_2.jpg?v=68" alt=""> -->
                </div>

                <!-- Nút điều khiển -->
                <button class="slide-btn slide-left">◀</button>
                <button class="slide-btn slide-right">▶</button>

                <div class="dots"></div>
            </div>
        </div>
    </div>

    <!-- service -->
    <section class="service">
        <div class="container">
            <div class="service__inner">
                <!-- left tiêu đề -->
                <div class="service__left">
                    <h6 class="heading-lv6 service__heading--eng">
                        Tiểu thuyết - Light Novel
                    </h6>
                    <h2 class="heading-lv2 service__heading--vi">
                        Light Novel được yêu thích
                    </h2>
                </div>
                <!-- service list -->
                <div class="service--list">
                    <!-- item 1 -->
                    <?php foreach($getBookManga as $item): ?>
                    <article class="service-item">
                        <a
                            href="?module=store&action=book_detail&isbn=<?php echo $item['ISBN']; ?>&<?php echo $item['slug'];?>">
                            <img src="<?php echo $item['hinhAnh']; ?>" alt="CROOMING" class="service-item__img" /></a>
                        <div class="service-item__content">
                            <a
                                href="?module=store&action=book_detail&isbn=<?php echo $item['ISBN']; ?>&<?php echo $item['slug'];?>">
                                <h3 class="service-item__heading"><?php echo $item['tenSach']; ?></h3>
                            </a>

                            <p class="service-detail-item__desc feature-detail-item__desc line-clamp line-2">
                                Giá: <span><?php echo $item['gia'];?> đ</span>
                            </p>
                            <div class="service-detail-item__acction">
                                <!-- Form thêm vào giỏ hàng -->
                                <?php if($item['soLuong'] > 0): ?>
                                <form class="addToCartForm" action="?module=store&action=add_to_cart"
                                    enctype="multipart/form-data" method="post">
                                    <input type="hidden" name="module" value="store">
                                    <input type="hidden" name="action" value="book_detail">
                                    <input type="hidden" name="isbn" value="<?php echo $item['ISBN']; ?>">
                                    <input type="hidden" name="tenSach" value="<?php echo $item['tenSach']; ?>">
                                    <input type="hidden" name="gia" value="<?php echo $item['gia']; ?>">
                                    <input type="hidden" name="hinhAnh" value="<?php echo $item['hinhAnh']; ?>">
                                    <input type="hidden" name="slug" value="<?php echo $item['slug']; ?>">
                                    <div class="book-detail__action book-category__action">

                                        <button type="submit" name="add_to_carts"
                                            class="btn btn-db-add btn-db-add-category">
                                            Thêm vào giỏ
                                        </button>
                                        <div class="quantity-box">
                                            <button type="button" class="qty-btn minus">-</button>
                                            <input type="text" name="quantity" class="qty-input" value="1" min="1"
                                                max="<?php echo $item['soLuong']; ?>" readonly>
                                            <button type="button" class="qty-btn plus">+</button>
                                        </div>
                                    </div>
                                </form>
                                <?php else: ?>
                                <p class="btn hero__btn" style="border-radius: 4px; background: #ccc; width: 100%">
                                    Hết hàng
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- servive detail -->
    <section class="service-detail">
        <!-- detail top -->
        <div class="service-detail__top">
            <div class="container">
                <h2 class="heading-lv2 detail-top-heading">
                    Sách khoa học và đời sống được quan tâm
                </h2>
                <p class="detail-top-desc">
                    Sách hỗ trợ các kiến thức, kỹ năng thiết yếu và quan trọng trong
                    đời sống
                </p>
                <div class="service-detail__top--list">
                    <!-- item 1 -->
                    <?php foreach($getBookdoiSong_KH as $item): ?>
                    <article class="service-detail-item sdi1">
                        <div class="service-detail-item-img__wrapper">
                            <a
                                href="?module=store&action=book_detail&isbn=<?php echo $item['ISBN']; ?>&<?php echo $item['slug'];?>">
                                <img src="<?php echo $item['hinhAnh']; ?>" alt="sachk-h"
                                    class="service-detail-item__img" /></a>
                        </div>

                        <a
                            href="?module=store&action=book_detail&isbn=<?php echo $item['ISBN']; ?>&<?php echo $item['slug'];?>">
                            <p class="service-detail-item__title line-clamp">
                                <?php echo $item['tenSach']; ?>
                            </p>
                        </a>
                        <p class="service-detail-item__desc line-clamp line-2">
                            Giá: <span><?php echo $item['gia']; ?></span>
                        </p>
                        <div class="service-detail-item__acction">
                            <!-- Form thêm vào giỏ hàng -->
                            <?php if($item['soLuong'] > 0): ?>
                            <form class="addToCartForm" action="?module=store&action=add_to_cart"
                                enctype="multipart/form-data" method="post">
                                <input type="hidden" name="module" value="store">
                                <input type="hidden" name="action" value="book_detail">
                                <input type="hidden" name="isbn" value="<?php echo $item['ISBN']; ?>">
                                <input type="hidden" name="tenSach" value="<?php echo $item['tenSach']; ?>">
                                <input type="hidden" name="gia" value="<?php echo $item['gia']; ?>">
                                <input type="hidden" name="hinhAnh" value="<?php echo $item['hinhAnh']; ?>">
                                <input type="hidden" name="slug" value="<?php echo $item['slug']; ?>">
                                <div class="book-detail__action book-category__action">

                                    <button type="submit" name="add_to_carts"
                                        class="btn btn-db-add btn-db-add-category">
                                        Thêm vào giỏ
                                    </button>
                                    <div class="quantity-box">
                                        <button type="button" class="qty-btn minus">-</button>
                                        <input type="text" name="quantity" class="qty-input" value="1" min="1"
                                            max="<?php echo $item['soLuong']; ?>" readonly>
                                        <button type="button" class="qty-btn plus">+</button>
                                    </div>
                                </div>
                            </form>
                            <?php else: ?>
                            <p class="btn hero__btn"
                                style="border-radius: 4px; background: #ccc; width: 100%; margin-top: 20px">
                                Hết hàng
                            </p>
                            <?php endif; ?>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- detail mid -->

        <!-- detail bottom -->
    </section>
    <div class="service-detail__mid"
        style=" background-image: url('<?php echo _HOST_URL_TEMPLATES;?>/uploads/manga_banner.png');">
        <div class="container">
            <div class="service-detail__mid--inner">
                <div class="service-detail__mid--content">
                    <h2 class="detail-mid-heading">Dành cho Fan Manga</h2>
                    <p class="detail-mid-desc"></p>
                </div>
                <div class="service-detail__cta">
                    <a href="?module=store&action=book_cate&id=TL1" class="btn service-detail__mid-btn">Xem Ngay</a>
                </div>
            </div>
        </div>
    </div>
    <!-- feature 1-->
    <section class="feature">
        <div class="container">
            <div class="feature__inner">
                <!-- feature item 1 -->
                <?php foreach($getBookdoiSong_KH as $item):?>
                <article class="service-detail-item sdi1">
                    <div class="service-detail-item-img__wrapper">
                        <a
                            href="?module=store&action=book_detail&isbn=<?php echo $item['ISBN']; ?>&<?php echo $item['slug'];?>">
                            <img src="<?php echo $item['hinhAnh']; ?>" alt="sachk-h"
                                class="service-detail-item__img" /></a>
                    </div>

                    <p class="service-detail-item__title feature-detail-item__title line-clamp">
                        <?php echo $item['tenSach']; ?>
                    </p>
                    <p class="service-detail-item__desc feature-detail-item__desc line-clamp line-2">
                        Giá: <span><?php echo $item['gia']; ?></span>
                    </p>
                    <div class="service-detail-item__acction feature-item__action">
                        <!-- Form thêm vào giỏ hàng -->
                        <?php if($item['soLuong'] > 0): ?>
                        <form class="addToCartForm" action="?module=store&action=add_to_cart"
                            enctype="multipart/form-data" method="post">
                            <input type="hidden" name="module" value="store">
                            <input type="hidden" name="action" value="book_detail">
                            <input type="hidden" name="isbn" value="<?php echo $item['ISBN']; ?>">
                            <input type="hidden" name="tenSach" value="<?php echo $item['tenSach']; ?>">
                            <input type="hidden" name="gia" value="<?php echo $item['gia']; ?>">
                            <input type="hidden" name="hinhAnh" value="<?php echo $item['hinhAnh']; ?>">
                            <input type="hidden" name="slug" value="<?php echo $item['slug']; ?>">
                            <div class="book-detail__action book-category__action">

                                <button type="submit" name="add_to_carts" class="btn btn-db-add btn-db-add-category">
                                    Thêm vào giỏ
                                </button>
                                <div class="quantity-box">
                                    <button type="button" class="qty-btn minus">-</button>
                                    <input type="text" name="quantity" class="qty-input" value="1" min="1"
                                        max="<?php echo $item['soLuong']; ?>" readonly>
                                    <button type="button" class="qty-btn plus">+</button>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>
                        <p class="btn hero__btn" style="border-radius: 4px; background: #ccc; width: 100%">
                            Hết hàng
                        </p>
                        <?php endif; ?>
                    </div>
                </article>
                <?php endforeach;?>
            </div>
        </div>
    </section>

    <!-- servive detail -->
    <section class="service-detail">
        <!-- detail top -->
        <div class="service-detail__top">
            <div class="container">
                <!-- <h2 class="heading-lv2 detail-top-heading">
              Sách khoa học và đời sống được quan tâm
            </h2>
            <p class="detail-top-desc">
              Sách hỗ trợ các kiến thức, kỹ năng thiết yếu và quan trọng trong
              đời sống
            </p> -->
            </div>
        </div>
        <!-- detail mid -->
        <div class="service-detail__mid service-detail__mid--lightnovel"
            style=" background-image: url('<?php echo _HOST_URL_TEMPLATES;?>/uploads/light_novel_banner.png');">
            <div class="container">
                <div class="service-detail__mid--inner">
                    <div class="service-detail__mid--content">
                        <h2 class="detail-mid-heading">Bộ sưu tập light Novel</h2>
                        <p class="detail-mid-desc"></p>
                    </div>
                    <div class="service-detail__cta">
                        <a href="#!" class="btn service-detail__mid-btn">Xem Ngay</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- detail bottom -->
    </section>

    <!-- feature 2-->
    <section class="feature">
        <div class="container">
            <div class="feature__inner">
                <!-- feature item 1 -->
                <?php foreach($getBookdoiSong_KH as $item):?>
                <article class="service-detail-item sdi1">
                    <div class="service-detail-item-img__wrapper">
                        <a
                            href="?module=store&action=book_detail&isbn=<?php echo $item['ISBN']; ?>&<?php echo $item['slug'];?>">
                            <img src="<?php echo $item['hinhAnh']; ?>" alt="sachk-h"
                                class="service-detail-item__img" /></a>
                    </div>

                    <p class="service-detail-item__title feature-detail-item__title line-clamp">
                        <?php echo $item['tenSach']; ?>
                    </p>
                    <p class="service-detail-item__desc feature-detail-item__desc line-clamp line-2">
                        Giá: <span><?php echo $item['gia']; ?></span>
                    </p>
                    <div class="service-detail-item__acction feature-item__action">
                        <?php if($item['soLuong'] > 0): ?>
                        <!-- Form thêm vào giỏ hàng -->
                        <form class="addToCartForm" action="?module=store&action=add_to_cart"
                            enctype="multipart/form-data" method="post">
                            <input type="hidden" name="module" value="store">
                            <input type="hidden" name="action" value="book_detail">
                            <input type="hidden" name="isbn" value="<?php echo $item['ISBN']; ?>">
                            <input type="hidden" name="tenSach" value="<?php echo $item['tenSach']; ?>">
                            <input type="hidden" name="gia" value="<?php echo $item['gia']; ?>">
                            <input type="hidden" name="hinhAnh" value="<?php echo $item['hinhAnh']; ?>">
                            <input type="hidden" name="slug" value="<?php echo $item['slug']; ?>">
                            <div class="book-detail__action book-category__action">

                                <button type="submit" name="add_to_carts" class="btn btn-db-add btn-db-add-category">
                                    Thêm vào giỏ
                                </button>
                                <div class="quantity-box">
                                    <button type="button" class="qty-btn minus">-</button>
                                    <input type="text" name="quantity" class="qty-input" value="1" min="1"
                                        max="<?php echo $item['soLuong']; ?>" readonly>
                                    <button type="button" class="qty-btn plus">+</button>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>
                        <p class="btn hero__btn" style="border-radius: 4px; background: #ccc; width: 100%">
                            Hết hàng
                        </p>
                        <?php endif; ?>
                    </div>
                </article>
                <?php endforeach;?>
            </div>
        </div>
    </section>

    <!-- deals -->

    <!-- team -->
    <section class="team">
        <div class="container">
            <div class="team__top">
                <h2 class="team__heading">SÁCH MỚI</h2>
                <p class="team__desc">
                    SÁCH MỚI PHÁT HÀNH MUA NGAY CHO NÓNG!! TRỞ THÀNH NHỮNG NGƯỜI ĐẦU
                    TIÊN SỞ HỮU NHỮNG SIÊU PHẨM MỚI NHẤT!!!!
                </p>
            </div>
            <div class="team__list">
                <?php foreach($getBookdoiSong_KH as $item):?>
                <!-- item 1 -->
                <article class="team-item">
                    <figure>
                        <a
                            href="?module=store&action=book_detail&isbn=<?php echo $item['ISBN']; ?>&<?php echo $item['slug'];?>">
                            <img src="<?php echo $item['hinhAnh']; ?>" alt="sachk-h" class="team-item__img" /></a>

                    </figure>
                    <h3 class="team-item__name line-2 line-clamp">
                        <?php echo $item['tenSach']; ?>
                    </h3>
                    <p class="service-detail-item__desc line-clamp line-2" style="text-align: center;">
                        Giá: <span><?php echo $item['gia']; ?></span>
                    </p>
                    <div class="service-detail-item__acction newbooks-wrapper">
                        <!-- Form thêm vào giỏ hàng -->
                        <?php if($item['soLuong'] > 0): ?>
                        <form class="addToCartForm" action="?module=store&action=add_to_cart"
                            enctype="multipart/form-data" method="post">
                            <input type="hidden" name="module" value="store">
                            <input type="hidden" name="action" value="book_detail">
                            <input type="hidden" name="isbn" value="<?php echo $item['ISBN']; ?>">
                            <input type="hidden" name="tenSach" value="<?php echo $item['tenSach']; ?>">
                            <input type="hidden" name="gia" value="<?php echo $item['gia']; ?>">
                            <input type="hidden" name="hinhAnh" value="<?php echo $item['hinhAnh']; ?>">
                            <input type="hidden" name="slug" value="<?php echo $item['slug']; ?>">
                            <div class="book-detail__action book-category__action">

                                <button type="submit" name="add_to_carts" class="btn btn-db-add btn-db-add-category">
                                    Thêm vào giỏ
                                </button>
                                <div class="quantity-box">
                                    <button type="button" class="qty-btn minus">-</button>
                                    <input type="text" name="quantity" class="qty-input" value="1" min="1"
                                        max="<?php echo $item['soLuong']; ?>" readonly>
                                    <button type="button" class="qty-btn plus">+</button>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>
                        <p class="btn hero__btn"
                            style="border-radius: 4px; background: #ccc; width: 100%; margin-top: 30px">
                            Hết hàng
                        </p>
                        <?php endif; ?>
                    </div>
                </article>
                <?php endforeach;?>

            </div>
        </div>
    </section>

    <!-- rate -->

    <!-- price -->

    <!-- blog -->
    <section class="blog">
        <!-- <iframe
          width="1912"
          height="1075.5"
          src="https://www.youtube.com/embed/uYJQIKAVBw8?autoplay=1&mute=1&controls=0&loop=1&playlist=uYJQIKAVBw8&modestbranding=1&rel=0&showinfo=0"
          title="Chó &amp; chó con 4K"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen
          referrerpolicy="strict-origin-when-cross-origin"
        ></iframe> -->
        <iframe width="1270" height="1075.5"
            src="https://www.youtube.com/embed/HrRxvh4bkHE?autoplay=1&mute=1&controls=0&loop=1&playlist=HrRxvh4bkHE&modestbranding=1&rel=0&showinfo=0"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
        </iframe>

        <div class="container">
            <!-- slogan -->
            <div class="blog-slogan">
                <h2 class="blog-slogan__heading">Trang cộng đồng</h2>
                <p class="blog-slogan__desc">
                    Nơi những người yêu sách, tiểu thuyết, truyện tranh. Cùng chia sẻ
                    niềm vui, kiến thức, cũng như cập nhật sách mới nhất và sự kiện
                    quà tặng.
                </p>
            </div>
        </div>
    </section>
    <!-- inner blog quote  -->
    <section class="blog__inner">
        <div class="container">
            <div class="blog__inner-body">
                <!-- list -->
                <div class="blog__list">
                    <!-- item 1 -->
                    <article class="blog-item">
                        <div class="blog-item__images">
                            <img src="./assets/images/blog-girl.jpg" alt="Cộng đồng này thực sự là một nơi tuyệt vời"
                                class="blog-item__avatar blog-item__img" />
                            <img src="./assets/images/blog-quote.png" alt="Cộng đồng này thực sự là một nơi tuyệt vời"
                                class="blog-item__quote blog-item__img" />
                        </div>
                        <blockquote class="blog__quote line-clamp line-2">
                            ""
                        </blockquote>
                    </article>

                    <!-- item 2 -->
                    <article class="blog-item">
                        <div class="blog-item__images">
                            <img src="./assets/images/blog-girl.jpg" alt="Cộng đồng này thực sự là một nơi tuyệt vời"
                                class="blog-item__avatar blog-item__img" />
                            <img src="./assets/images/blog-quote.png" alt="Cộng đồng này thực sự là một nơi tuyệt vời"
                                class="blog-item__quote blog-item__img" />
                        </div>
                        <blockquote class="blog__quote line-clamp line-2">
                            ""
                        </blockquote>
                    </article>

                    <!-- item 3 -->
                    <article class="blog-item">
                        <div class="blog-item__images">
                            <img src="./assets/images/blog-girl.jpg" alt="Cộng đồng này thực sự là một nơi tuyệt vời"
                                class="blog-item__avatar blog-item__img" />
                            <img src="./assets/images/blog-quote.png" alt="Cộng đồng này thực sự là một nơi tuyệt vời"
                                class="blog-item__quote blog-item__img" />
                        </div>
                        <blockquote class="blog__quote line-clamp line-2">
                            ""
                        </blockquote>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- feedback -->
    <section class="feedback">
        <div class="container">
            <div class="feedback__inner">
                <!-- left -->
                <div class="feedback-left">
                    <img src="./assets/images/feedback-quote.png" alt="Chia sẻ được yêu thích"
                        class="feedback-left__img" />
                    <h2 class="heading-lv2 feedback-left__heading">
                        Chia sẻ được yêu thích
                    </h2>
                </div>
                <!-- right -->
                <div class="feedback-right">
                    <div class="feedback__list">
                        <!-- item 1 -->
                        <article class="feedback-item">
                            <div class="feedback-item__star">
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="feedback-item__desc">""</p>
                            <div class="feedback-info">
                                <img src="./assets/images/feedback-avatar.jpg" alt="" class="feedback-item__avatar" />
                                <div class="feedback-info__content">
                                    <h3 class="feedback-item__name">Lệnh Hồ Xung</h3>
                                    <p class="feedback-item__subname">Điêu huynh bao ngầu</p>
                                </div>
                            </div>
                        </article>

                        <!-- item 2 -->
                        <article class="feedback-item">
                            <div class="feedback-item__star">
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="feedback-item__desc">"T."</p>
                            <div class="feedback-info">
                                <img src="./assets/images/feedback-avatar.jpg" alt="" class="feedback-item__avatar" />
                                <div class="feedback-info__content">
                                    <h3 class="feedback-item__name">Lệnh Hồ Xung</h3>
                                    <p class="feedback-item__subname">Điêu huynh bao ngầu</p>
                                </div>
                            </div>
                        </article>

                        <!-- item 3 -->
                        <article class="feedback-item">
                            <div class="feedback-item__star">
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                                <span class="feature-item__icon">
                                    <svg class="detail-commit__icon feature__icon feedback-star-icon"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                                    </svg>
                                </span>
                            </div>
                            <p class="feedback-item__desc">"."</p>
                            <div class="feedback-info">
                                <img src="./assets/images/feedback-avatar.jpg" alt="" class="feedback-item__avatar" />
                                <div class="feedback-info__content">
                                    <h3 class="feedback-item__name">Lệnh Hồ Xung</h3>
                                    <p class="feedback-item__subname">Điêu huynh bao ngầu</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- community -->
    <section class="community">
        <div class="container">
            <h3 class="community__desc">cộng đồng chia sẻ sở thích về sách</h3>
            <h2 class="heading-lv2 community__heading">SÁCH SÁCH SÁCH SÁCH</h2>
            <a href="#!" class="btn community__btn">Tham gia ngay</a>
        </div>
    </section>
</main>
<script>
const slides = document.querySelector('.slides');
const images = document.querySelectorAll('.slides img');
const leftBtn = document.querySelector('.slide-left');
const rightBtn = document.querySelector('.slide-right');
const dotsContainer = document.querySelector('.dots');

let index = 0;
const total = images.length;

// Tạo chấm tròn
for (let i = 0; i < total; i++) {
    const dot = document.createElement('span');
    dot.classList.add('dot');
    if (i === 0) dot.classList.add('active');
    dot.addEventListener('click', () => goToSlide(i));
    dotsContainer.appendChild(dot);
}

const dots = document.querySelectorAll('.dot');

function showSlide() {
    slides.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach(dot => dot.classList.remove('active'));
    dots[index].classList.add('active');
}

function nextSlide() {
    index = (index + 1) % total;
    showSlide();
}

function prevSlide() {
    index = (index - 1 + total) % total;
    showSlide();
}

function goToSlide(i) {
    index = i;
    showSlide();
}

rightBtn.addEventListener('click', nextSlide);
leftBtn.addEventListener('click', prevSlide);

// Tự động chạy từ phải sang trái
let autoSlide = setInterval(nextSlide, 4000);

// Dừng khi rê chuột vào, chạy lại khi rời chuột
document.querySelector('.slideshow').addEventListener('mouseenter', () => clearInterval(autoSlide));
document.querySelector('.slideshow').addEventListener('mouseleave', () => autoSlide = setInterval(nextSlide, 4000));
</script>

<?php 
layout('footer_store');
?>