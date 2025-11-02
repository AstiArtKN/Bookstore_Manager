<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$data = [
    'title' => 'Danh sách sản phẩm'
];

layout('sidebar', $data);
layout('header',  $data);

//?module=users&action=list&slt_quyenhan=&search__user=&page=1
//phân trang trước ... 3,4,5,...sau
//1,2,3...sau -> trước 1, [2], 3,...sau
//perpage, maxpage, (offset)vị trí lấy dữu liệu và đỗ dữ liệu từ đâu



$filter = filterData();
$getdata = filterData('get');
$getId = $getdata['id'];

// print_r($getdata); die();


//xử lý trang
$maxData = getRows("SELECT ISBN FROM hoadonchitiet WHERE hoaDonId = '$getId'");
$perPage = 10;//so dong du lieu
$maxPage = ceil($maxData/$perPage);
$offset = 0;
$page = 1;
//getpage
if(isset($filter['page'])){
    $page = $filter['page'];
}

if($page > $maxPage || $page < 1){
    $page = 1;
}

if(isset($page)){
    $offset = ($page - 1) * $perPage;
}


// echo $chuoiWhere;
$getDetailUser = getAll("SELECT hoadonchitiet.hoaDonId, hoadonchitiet.ISBN, hoadonchitiet.soLuongSach, hoadonchitiet.donGia,
hoadonchitiet.thanhTien, sach.tenSach, sach.hinhAnh, trangthaihoadon.tenTrangThai
FROM hoadonchitiet
INNER JOIN `sach` ON hoadonchitiet.ISBN = sach.ISBN
INNER JOIN `hoadon` ON hoadonchitiet.hoaDonId  = hoadon.ID
INNER JOIN `trangthaihoadon` ON hoadon.trangThaiHoaDonId = trangthaihoadon.ID
WHERE hoadonchitiet.hoaDonId = '$getId'
LIMIT $offset, $perPage
");

$getHD = getOne("SELECT tongTien from hoadon where ID = '$getId'");
//xử lý query
// $_SERVER['QUERY_STRING']; -> module=users&action=list&search__user=max&page=2
if(!empty($_SERVER['QUERY_STRING'])){
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page='.$page,'',$queryString);
}

// print_r($getDetailUser);
// die();

// if(!empty($slt_quyenhan) || !empty($search__user)){
//     $maxData2 = getRows("SELECT ISBN FROM hoadonchitiet 
//      $chuoiWhere");
//     $maxPage = ceil($maxData2/$perPage);
// }
$msg = getSessionFlash('msg');
$msg_type = getSessionFlash('msg_type');

?>

<!-- book editor -->
<div class="book-editor">
    <div class="book-editor__header receipt_detail">
        <h2 class="dashboard__mid-title">Chi tiết hoá đơn: <?php echo $getId;?></h2>
        <h2 class="dashboard__mid-title">Trạng thái: <?= htmlspecialchars($getDetailUser[0]['tenTrangThai']) ?></h2>
        <h2 class="dashboard__mid-title">Tổng Tiền: <?php echo $getHD['tongTien'];?></h2>
        <?php 
            if(!empty($msg) && !empty($msg_type)){
                getMsg($msg, $msg_type); 
            }
                                
        ?>
        <a href="?module=receipt&action=list" class="book-editor__add btn">DS Hoá Đơn</a>
    </div>
    <div class="book-editor__tool">
        <!-- <form method="GET" action="">
            <input type="hidden" name="module" value="books">
            <input type="hidden" name="action" value="list">
        </form> -->
        <!-- <span>Mục</span> -->
    </div>
    <!-- ---- Table ----- -->
    <div class="book-editor__table-wrapper">
        <table class="dashboard__table dashboard__table-mid book-editor_table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ISBN</th>
                    <th>Tên sách</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hình ảnh</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($getDetailUser as $key => $item ):
                ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $item['ISBN']; ?></td>
                    <td class="tensach"><?php echo $item['tenSach']; ?></td>
                    <td><?php echo $item['donGia']; ?></td>
                    <td><?php echo $item['soLuongSach']; ?></td>
                    <td><?php echo $item['thanhTien']; ?></td>
                    <td><img src="<?php echo $item['hinhAnh']; ?>" alt="" class="table-rank-img table-rank-img-mid" />
                </tr>

                <?php endforeach;?>
            </tbody>
        </table>

    </div>
    <nav aria-label="Page navigation example" class="navpage">
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
    <div class="xacnhan-group">
        <a href="?module=receipt&action=confirm&id=<?php echo $getId;?>" class="book-editor__add btn"
            style="background-color: #33CC66;">Xác nhận đơn</a>
        <a href="?module=receipt&action=cancel&id=<?php echo $getId;?>" class="book-editor__add btn"
            style="background-color: #CC3333;">Huỷ đơn hàng</a>
        <a href="?module=receipt&action=comp&id=<?php echo $getId;?>" class="book-editor__add btn"
            style="background-color: #cc7d33ff;">Đã giao</a>
        <a href="?module=store&action=thank_you&id=<?php echo $getId;?>&srcp=prcpt" target="_blank"
            class="book-editor__add btn" style="background-color: #0099FF;">🖨️ In hoá đơn</a>
    </div>
</div>

</div>


<?php 

layout('footer');
?>