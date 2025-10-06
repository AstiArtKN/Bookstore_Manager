<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');

$filter = filterData('get');
$getNameSearch = $filter['search_book'];

//xử lý trang
$maxData = getRows("SELECT ISBN FROM sach WHERE tenSach LIKE '%$getNameSearch%'");
$perPage = 1;//so dong du lieu
$maxPage = ceil($maxData/$perPage);
$offset = 0;
$page = 1;
//getpage
if(isset($filter ['page'])){
    $page = $filter ['page'];
}

if($page > $maxPage || $page < 1){
    $page = 1;
}

if(isset($page)){
    $offset = ($page - 1) * $perPage;
}




$getDataSearch = getAll("SELECT sach.ISBN, sach.tenSach, tacgiasach.tenTacGia, theloaisach.tenTheLoai,
sach.gia, sach.kichThuoc, nhaxuatban.tenNhaXuatBan, sach.moTa, sach.hinhAnh, sach.slug
FROM sach
INNER JOIN tacgiasach ON sach.tacGiaId = tacgiasach.ID
INNER JOIN theloaisach ON sach.theLoaiId = theloaisach.ID
INNER JOIN nhaxuatban ON sach.nhaXuatBanId = nhaxuatban.ID
WHERE sach.tenSach LIKE '%$getNameSearch%'
LIMIT $offset, $perPage
");


if(!empty($_SERVER['QUERY_STRING'])){
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page='.$page,'',$queryString);
}

// print_r($getDetailUser);
// die();

if(!empty($getNameSearch)){
    $maxData2 = getRows("SELECT ISBN FROM sach 
     WHERE tenSach LIKE '%$getNameSearch%'");
    $maxPage = ceil($maxData2/$perPage);
}



?>

<main>
    <div class="book-cate">
        <div class="container">

            <div class="result-search-name">
                <h1>Tìm kiếm</h1>
                <h3>kết quả tìm kiếm cho "<span><?php echo $getNameSearch; ?></span>"</h3>
            </div>

            <div class="book-cate__list">
                <?php 
                    foreach($getDataSearch as $item):
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
                        <?php echo $item['tenSach'] ?>
                    </p>
                    <p
                        class="service-detail-item__desc book-cate__title__desc feature-detail-item__desc line-clamp line-1">
                        Giá: <span> <?php echo $item['gia'] ?></span>
                    </p>
                    <div class="service-detail-item__acction feature-item__action">
                        <!-- Form thêm vào giỏ hàng -->
                        <form action="" method="POST">
                            <input type="hidden" name="product_id" value="php" />
                            <input type="hidden" name="quantity" value="1" />
                            <button type="submit" name="add_to_cart" class="service-detail-item__acction--add add-to">
                                Thêm vào giỏ
                            </button>
                        </form>

                        <!-- Form mua ngay -->
                        <!-- <form action="checkout.php" method="POST">
                            <input type="hidden" name="product_id" value="php" />
                            <input type="hidden" name="quantity" value="1" />
                            <button type="submit" name="buy_now" class="service-detail-item__acction--buy buy-now">
                                Mua ngay
                            </button>
                        </form> -->
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