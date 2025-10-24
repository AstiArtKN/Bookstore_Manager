<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
// require_once './templates/layout/sidebar.php';
// require_once './templates/layout/header.php';

$data = [
    'title' => 'Trang chủ'
];

layout('sidebar', $data);
layout('header', $data);

/*SELECT 
    s.ID,
    s.tenSach,
    s.tacGia,
    s.hinhAnh,
    SUM(ct.soLuong) AS tongSoLuongBan
FROM chitiethoadon AS ct
JOIN hoadon AS hd ON ct.hoaDonId = hd.ID
JOIN sach AS s ON ct.sachId = s.ID
WHERE MONTH(hd.ngayDatHang) = MONTH(CURDATE())
  AND YEAR(hd.ngayDatHang) = YEAR(CURDATE())
GROUP BY s.ID, s.tenSach, s.tacGia, s.hinhAnh
ORDER BY tongSoLuongBan DESC
LIMIT 5;*/


/*
SELECT 
    s.ID,
    s.tenSach,
    s.tacGia,
    s.hinhAnh,
    SUM(ct.soLuong) AS tongSoLuongBan
FROM chitiethoadon AS ct
JOIN hoadon AS hd ON ct.hoaDonId = hd.ID
JOIN sach AS s ON ct.sachId = s.ID
WHERE YEARWEEK(hd.ngayDatHang, 1) = YEARWEEK(CURDATE(), 1)
GROUP BY s.ID, s.tenSach, s.tacGia, s.hinhAnh
ORDER BY tongSoLuongBan DESC
LIMIT 5;



$topMonth = getAll("
    SELECT s.ID, s.tenSach, s.tacGia, s.hinhAnh, SUM(ct.soLuong) AS tongSoLuongBan
    FROM chitiethoadon AS ct
    JOIN hoadon AS hd ON ct.hoaDonId = hd.ID
    JOIN sach AS s ON ct.sachId = s.ID
    WHERE MONTH(hd.ngayDatHang) = MONTH(CURDATE())
      AND YEAR(hd.ngayDatHang) = YEAR(CURDATE())
    GROUP BY s.ID, s.tenSach, s.tacGia, s.hinhAnh
    ORDER BY tongSoLuongBan DESC
    LIMIT 5
");

$topWeek = getAll("
    SELECT s.ID, s.tenSach, s.tacGia, s.hinhAnh, SUM(ct.soLuong) AS tongSoLuongBan
    FROM chitiethoadon AS ct
    JOIN hoadon AS hd ON ct.hoaDonId = hd.ID
    JOIN sach AS s ON ct.sachId = s.ID
    WHERE YEARWEEK(hd.ngayDatHang, 1) = YEARWEEK(CURDATE(), 1)
    GROUP BY s.ID, s.tenSach, s.tacGia, s.hinhAnh
    ORDER BY tongSoLuongBan DESC
    LIMIT 5
");
*/ 


?>




<!-- 
     -->
<!--  -->
<!-- content -->

<!-- dashboard top -->
<div class="dashboard__top">
    <!-- Statistic cards -->
    <!-- left -->
    <section class="dashboard__stats">
        <div class="stat-card stat-card--orange">
            <div class="stat-card__wrapper">
                <a href="" class="stat-card__icon">
                    <svg class="stat-card__icon--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path fill="currentColor"
                            d="M463 448.2C440.9 409.8 399.4 384 352 384L288 384C240.6 384 199.1 409.8 177 448.2C212.2 487.4 263.2 512 320 512C376.8 512 427.8 487.3 463 448.2zM64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576 461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 336C359.8 336 392 303.8 392 264C392 224.2 359.8 192 320 192C280.2 192 248 224.2 248 264C248 303.8 280.2 336 320 336z" />
                    </svg>
                </a>
            </div>
            <div class="stat-card__number">
                <p class="stat-card__number--total">1600</p>
                <p class="stat-card__number--percent">+120%</p>
            </div>
            <h3 class="stat-card__title">Tổng số lượng sách</h3>
        </div>
        <div class="stat-card stat-card--black">
            <div class="stat-card__wrapper">
                <a href="" class="stat-card__icon">
                    <svg class="stat-card__icon--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path fill="currentColor"
                            d="M480 576L192 576C139 576 96 533 96 480L96 160C96 107 139 64 192 64L496 64C522.5 64 544 85.5 544 112L544 400C544 420.9 530.6 438.7 512 445.3L512 512C529.7 512 544 526.3 544 544C544 561.7 529.7 576 512 576L480 576zM192 448C174.3 448 160 462.3 160 480C160 497.7 174.3 512 192 512L448 512L448 448L192 448zM224 216C224 229.3 234.7 240 248 240L424 240C437.3 240 448 229.3 448 216C448 202.7 437.3 192 424 192L248 192C234.7 192 224 202.7 224 216zM248 288C234.7 288 224 298.7 224 312C224 325.3 234.7 336 248 336L424 336C437.3 336 448 325.3 448 312C448 298.7 437.3 288 424 288L248 288z" />
                    </svg>
                </a>
            </div>
            <div class="stat-card__number">
                <p class="stat-card__number--total">1600</p>
                <p class="stat-card__number--percent">+120%</p>
            </div>
            <h3 class="stat-card__title">Tổng số lượng sách</h3>
        </div>
        <div class="stat-card stat-card--orange">
            <div class="stat-card__wrapper">
                <a href="" class="stat-card__icon">
                    <svg class="stat-card__icon--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path fill="currentColor"
                            d="M24 48C10.7 48 0 58.7 0 72C0 85.3 10.7 96 24 96L69.3 96C73.2 96 76.5 98.8 77.2 102.6L129.3 388.9C135.5 423.1 165.3 448 200.1 448L456 448C469.3 448 480 437.3 480 424C480 410.7 469.3 400 456 400L200.1 400C188.5 400 178.6 391.7 176.5 380.3L171.4 352L475 352C505.8 352 532.2 330.1 537.9 299.8L568.9 133.9C572.6 114.2 557.5 96 537.4 96L124.7 96L124.3 94C119.5 67.4 96.3 48 69.2 48L24 48zM208 576C234.5 576 256 554.5 256 528C256 501.5 234.5 480 208 480C181.5 480 160 501.5 160 528C160 554.5 181.5 576 208 576zM432 576C458.5 576 480 554.5 480 528C480 501.5 458.5 480 432 480C405.5 480 384 501.5 384 528C384 554.5 405.5 576 432 576z" />
                    </svg>
                </a>
            </div>
            <div class="stat-card__number">
                <p class="stat-card__number--total">1600</p>
                <p class="stat-card__number--percent">+120%</p>
            </div>
            <h3 class="stat-card__title">Tổng số lượng sách</h3>
        </div>
        <div class="stat-card stat-card--black">
            <div class="stat-card__wrapper">
                <a href="" class="stat-card__icon">
                    <svg class="stat-card__icon--svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path fill="currentColor"
                            d="M320 32C373 32 416 75 416 128C416 181 373 224 320 224C267 224 224 181 224 128C224 75 267 32 320 32zM80 368C80 297.9 127 236.6 197.1 203.1C222.4 244.4 268 272 320 272C375.7 272 424.1 240.3 448 194C463.8 182.7 483.1 176 504 176L523.5 176C533.9 176 541.5 185.8 539 195.9L521.9 264.2C531.8 276.6 540.1 289.9 546.3 304L568 304C581.3 304 592 314.7 592 328L592 440C592 453.3 581.3 464 568 464L528 464C511.5 486 489.5 503.6 464 514.7L464 544C464 561.7 449.7 576 432 576L399 576C384.7 576 372.2 566.5 368.2 552.8L361.1 528L278.8 528L271.7 552.8C267.8 566.5 255.3 576 241 576L208 576C190.3 576 176 561.7 176 544L176 514.7C119.5 490 80 433.6 80 368zM456 384C469.3 384 480 373.3 480 360C480 346.7 469.3 336 456 336C442.7 336 432 346.7 432 360C432 373.3 442.7 384 456 384z" />
                    </svg>
                </a>
            </div>
            <div class="stat-card__number">
                <span class="stat-card__number--total">1600</span>
                <span class="stat-card__number--percent">+120%</span>
            </div>
            <h3 class="stat-card__title">Tổng số lượng sách</h3>
        </div>
    </section>

    <!-- dash board top - right -->
    <section class="dashboard__top-user">
        <div class="top-user-wrapper">
            <h2 class="top-user__heading">TOP 3 THÁCH ĐẤU</h2>
            <table class="dashboard__table">
                <thead>
                    <tr>
                        <th>TOP</th>
                        <th>Tên Khách Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>RANK</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="dashboard-col-top-user">1</td>
                        <td>Nguyễn Văn A</td>
                        <td>25.000.000 VNĐ</td>
                        <td>
                            <img src="./assets/img/thachdau-icon.png" alt="" class="table-rank-img" />
                        </td>
                    </tr>
                    <tr>
                        <td class="dashboard-col-top-user">2</td>
                        <td>NHÀ SÁCH TNA</td>
                        <td>16.000.000 VNĐ</td>
                        <td>
                            <img src="./assets/img/thachdau-icon.png" alt="" class="table-rank-img" />
                        </td>
                    </tr>
                    <tr>
                        <td class="dashboard-col-top-user">3</td>
                        <td>NGUYỄN VĂN C</td>
                        <td>14.000.000 VNĐ</td>
                        <td>
                            <img src="./assets/img/thachdau-icon.png" alt="" class="table-rank-img" />
                        </td>
                    </tr>
                </tbody>
            </table>

            <p class="top-user__desc">Những khách hàng mua nhiều nhất.</p>
        </div>
    </section>
</div>
<!-- dashboard mid -->
<div class="dashboard__mid">
    <!-- ==== Left ==== -->
    <div class="dashboard__mid-left">
        <h2 class="dashboard__mid-title">Top Sách nỗi bậc tháng</h2>
        <!-- ---- Table ----- -->
        <table class="dashboard__table dashboard__table-mid">
            <thead>
                <tr>
                    <th>TOP</th>
                    <th>Tên Sách</th>
                    <th>Tác Giả</th>
                    <th>Hình Ảnh</th>
                    <th>Số Lượng Đã Bán</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="dashboard-col-top-user dashboard-col-top-book">
                        1
                    </td>
                    <td>Thanh Gươm Diệt Quỷ Vol.22</td>
                    <td>Koyoharu Gotouge, Aya Yajima</td>
                    <td>
                        <img src="./assets/img/sach1.PNG" alt="" class="table-rank-img table-rank-img-mid" />
                    </td>
                    <td>2543</td>
                </tr>
                <tr>
                    <td class="dashboard-col-top-user dashboard-col-top-book">
                        2
                    </td>
                    <td>NHÀ SÁCH TNA</td>
                    <td>Koyoharu Gotouge, Aya Yajima</td>
                    <td>
                        <img src="./assets/img/sach1.jpg" alt="" class="table-rank-img table-rank-img-mid" />
                    </td>
                    <td>2534</td>
                </tr>

                <tr>
                    <td class="dashboard-col-top-user dashboard-col-top-book">
                        3
                    </td>
                    <td>NGUYỄN VĂN C</td>
                    <td>Koyoharu Gotouge, Aya Yajima</td>
                    <td>
                        <img src="./assets/img/sach2.jpg" alt="" class="table-rank-img table-rank-img-mid" />
                    </td>
                    <td>2523</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- ==== right ==== -->
    <div class="dashboard__mid-right">
        <h2 class="dashboard__mid-title">Top Sách Nỗi Bậc Tuần</h2>
        <div class="dashboard__mid-list">
            <!-- item 1 -->
            <article class="dashboard__mid-item">
                <div class="dashboard__mid-toprank">01</div>
                <img src="./assets/img/sach1.jpg" alt="" class="dashboard__mid-thumbnail" />
                <div class="dashboard__mid-detail">
                    <h3 class="dashboard__mid-name">
                        Thanh Gươm Diệt Quỷ Vol.22
                    </h3>
                    <p class="dashboard__mid-author">
                        Koyoharu Gotouge, Aya Yajima
                    </p>
                    <p class="dashboard__mid-price">45.000 đ</p>
                </div>
            </article>
            <!-- item 2 -->
            <article class="dashboard__mid-item">
                <div class="dashboard__mid-toprank">01</div>
                <img src="./assets/img/sach1.jpg" alt="" class="dashboard__mid-thumbnail" />
                <div class="dashboard__mid-detail">
                    <h3 class="dashboard__mid-name">
                        Thanh Gươm Diệt Quỷ Vol.22
                    </h3>
                    <p class="dashboard__mid-author">
                        Koyoharu Gotouge, Aya Yajima
                    </p>
                    <p class="dashboard__mid-price">45.000 đ</p>
                </div>
            </article>
            <!-- item 3 -->
            <article class="dashboard__mid-item">
                <div class="dashboard__mid-toprank">01</div>
                <img src="./assets/img/sach1.jpg" alt="" class="dashboard__mid-thumbnail" />
                <div class="dashboard__mid-detail">
                    <h3 class="dashboard__mid-name">
                        Thanh Gươm Diệt Quỷ Vol.22
                    </h3>
                    <p class="dashboard__mid-author">
                        Koyoharu Gotouge, Aya Yajima
                    </p>
                    <p class="dashboard__mid-price">45.000 đ</p>
                </div>
            </article>
        </div>
    </div>
</div>
<!-- dashboard bottom -->
<div class="dashboard__bottom">
    <div class="dashboard__bottom-wrapper">
        <!-- left -->
        <div class="dashboard__bottom-left">
            <div class="barchart-wrapper">
                <canvas id="myChart" class="barchart"></canvas>
            </div>
            <h3 class="barchart-title">Người Đăng Ký Mới</h3>
            <p class="barchart-desc"><span>(+23%) so với tuần trước</span></p>
        </div>
        <!-- right -->
        <div class="dashboard__bottom-right">
            <h3 class="linechart-title">Người Đăng Ký Mới</h3>
            <p class="linechart-desc">
                <span>(+23%) so với tuần trước</span>
            </p>
            <div class="linechart-wrapper">
                <canvas id="myChart-right" class="linechart"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
</main>

<?php

// require_once './templates/layout/footer.php';
layout('footer');

?>