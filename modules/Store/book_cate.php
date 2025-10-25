<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');

$getData = filterData('get');

if(empty($getData['id'])){
    $getid = $getData['slt_category'];
}
else{
    $getid = $getData['id'];
}
$slt_cate = $getid;

//xử lý trang
$maxData = getRows("SELECT ISBN FROM sach WHERE theLoaiId = '$slt_cate'");
$perPage = 4;//so dong du lieu
$maxPage = ceil($maxData/$perPage);
$offset = 0;
$page = 1;
//getpage
if(isset($getData['page'])){
    $page = $getData['page'];
}

if($page > $maxPage || $page < 1){
    $page = 1;
}

if(isset($page)){
    $offset = ($page - 1) * $perPage;
}

$getCategory = getAll("SELECT * FROM theloaisach");

$getBookcate = getAll("SELECT sach.ISBN, sach.tenSach, tacgiasach.tenTacGia, theloaisach.tenTheLoai,
sach.gia, sach.kichThuoc, nhaxuatban.tenNhaXuatBan, sach.moTa, sach.hinhAnh, sach.slug, sach.soLuong
FROM sach
INNER JOIN tacgiasach ON sach.tacGiaId = tacgiasach.ID
INNER JOIN theloaisach ON sach.theLoaiId = theloaisach.ID
INNER JOIN nhaxuatban ON sach.nhaXuatBanId = nhaxuatban.ID
WHERE sach.theLoaiId = '$slt_cate'
LIMIT $offset, $perPage
");

if(!empty($_SERVER['QUERY_STRING'])){
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page='.$page,'',$queryString);
}

// print_r($getDetailUser);
// die();

if(!empty($slt_cate)){
    $maxData2 = getRows("SELECT ISBN FROM sach 
     WHERE sach.theLoaiId = '$slt_cate'");
    $maxPage = ceil($maxData2/$perPage);
}

?>

<main>
    <div class="book-cate">
        <div class="container">

            <form action="" method="get">
                <input type="hidden" name="module" value="store">
                <input type="hidden" name="action" value="book_cate">
                <div class="book-cate__inner">
                    <div class="book-cate__action">
                        <div class="book-cate__select">
                            <select id="slt_category" name="slt_category">
                                <option value="">-chọn-</option>
                                <?php foreach($getCategory as $key => $item): ?>
                                <option value="<?php echo $item['ID']; ?>"
                                    <?php echo ($item['ID'] == $getid) ? 'selected' : false;?>>
                                    <?php echo $item['tenTheLoai']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="book-cate__button">
                            <button type="submit" class="book-cate__btn btn">Lọc</button>
                        </div>

                    </div>
            </form>


            <div class="book-cate__list">
                <?php 
                    foreach($getBookcate as $item):
                 ?>
                <!-- item -->
                <article class="book-cate__item">
                    <div class="service-detail-item-img__wrapper">
                        <a
                            href="?module=store&action=book_detail&isbn=<?php echo $item['ISBN']; ?>&<?php echo $item['slug'];?>">
                            <img src="<?php echo $item['hinhAnh']; ?>" alt="Sạch Sẽ"
                                class="service-detail-item__img book-cate__img" />
                        </a>
                    </div>
                    <p class="service-detail-item__title book-cate__title feature-detail-item__title line-clamp line-1">
                        <?php echo $item['tenSach']; ?>
                    </p>
                    <p
                        class="service-detail-item__desc book-cate__title__desc feature-detail-item__desc line-clamp line-1">
                        Giá: <span> <?php  echo number_format($item['gia'],0, ' ,', '.'); ?> đ</span>
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
                <?php 
                    endforeach;
                 ?>
            </div>

            <nav class="navpage">
                <ul class="pagination">
                    <!-- xử lý nứt 'trước' -->
                    <?php 
                if($page > 1):
             ?>
                    <li class="page-item"><a class="page-link"
                            href="?<?php echo $queryString;?>&page=<?php echo $page-1;?>">Trước</a>
                    </li>
                    <?php endif; ?>
                    <!-- dấu ... trước -->
                    <!-- tính vị trí bắt đầu -->
                    <?php $start = $page - 1;
                if($start < 1){
                    $start = 1;
                }
             ?>
                    <?php 
                if($start > 1):
             ?>
                    <li class="page-item"><a class="page-link"
                            href="?<?php echo $queryString;?>&page=<?php echo $page-1;?>">...</a>
                    </li>
                    <?php endif; 
                $end = $page + 1;
                if($end > $maxPage){
                    $end = $maxPage;
                }
            ?>

                    <!-- xử lý số trang -->
                    <?php for($i = $start ; $i <= $end; $i++): ?>
                    <li class="page-item"><a class="page-link <?php echo ($page == $i)? 'active' : false; ?>"
                            href="?<?php echo $queryString;?>&page=<?php echo $i;?>"><?php echo $i; ?></a></li>

                    <!-- dấu ... sau -->
                    <!-- tính vị trí bắt đầu -->

                    <?php 
                endfor;
                if($end < $maxPage):
             ?>
                    <li class=" page-item"><a class="page-link"
                            href="?<?php echo $queryString;?>&page=<?php echo $page+1;?>">...</a>
                    </li>
                    <?php endif; ?>

                    <!-- xử lý nứt 'sau' -->
                    <?php 
                if($page < $maxPage):
             ?>
                    <li class="page-item"><a class="page-link"
                            href="?<?php echo $queryString;?>&page=<?php echo $page+1;?>">Sau</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    </div>
</main>

<?php 
    layout("footer_store");
?>