<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$data = [
    'title' => 'Danh sách hoá đơn'
];

layout('sidebar', $data);
layout('header',  $data);

//?module=users&action=list&slt_quyenhan=&search__user=&page=1
//phân trang trước ... 3,4,5,...sau
//1,2,3...sau -> trước 1, [2], 3,...sau
//perpage, maxpage, (offset)vị trí lấy dữu liệu và đỗ dữ liệu từ đâu



$filter = filterData();
$chuoiWhere = '';
$slt_TrangThaiDH = 'TTDH1';
$search__user = '';

if(isGet()){
    if(isset($filter['search__user'])){
        $search__user = $filter['search__user'];
    }
    if(isset($filter['slt_TrangThaiDH'])){
        $slt_TrangThaiDH  = $filter['slt_TrangThaiDH'];
    }
    if(!empty($search__user)){
        if(strpos($chuoiWhere, 'WHERE') == false){
            $chuoiWhere .= ' WHERE ';
        }
        else{
            $chuoiWhere .= ' AND ';
        }

        $chuoiWhere .= " (hoadon.tenNguoiNhan LIKE '%$search__user%' OR hoadon.diachi LIKE '%$search__user%') ";
    }

    if(!empty($slt_TrangThaiDH)){
        if(strpos($chuoiWhere, 'WHERE') == false){
            $chuoiWhere .= ' WHERE ';
        }
        else{
            $chuoiWhere .= ' AND ';
        }

         $chuoiWhere .= " hoadon.trangThaiHoaDonId = '$slt_TrangThaiDH' ";
    }
}


//xử lý trang
$maxData = getRows("SELECT ID FROM hoadon");
$perPage = 3;//so dong du lieu
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

$get_HD = getAll("SELECT hoadon.ID, nguoidung.tenNguoiDung, hoadon.tenNguoiNhan,
hoadon.soDTNhanHang, hoadon.diachi, trangthaihoadon.tenTrangThai, hoadon.trangThaiHoaDonId, hoadon.ngayDatHang, hoadon.ngayGiaoHang, hoadon.tongTien
FROM hoadon
INNER JOIN `trangthaihoadon` ON hoadon.trangThaiHoaDonId  = trangthaihoadon.ID
INNER JOIN `nguoidung` ON hoadon.nguoiDungId  = nguoidung.ID
$chuoiWhere
LIMIT $offset, $perPage
");

// option html
$GetTrangthaiHoaDon = getAll("SELECT * FROM trangthaihoadon");
//xử lý query
// $_SERVER['QUERY_STRING']; -> module=users&action=list&search__user=max&page=2
if(!empty($_SERVER['QUERY_STRING'])){
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page='.$page,'',$queryString);
}

// print_r($getDetailUser);

if(!empty($slt_TrangThaiDH) || !empty($search__user)){
    $maxData2 = getRows("SELECT ID FROM hoadon 
     $chuoiWhere");
    $maxPage = ceil($maxData2/$perPage);
}
$msg = getSessionFlash('msg');
$msg_type = getSessionFlash('msg_type');

?>

<!-- book editor -->
<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Danh Sách Hoá Đơn</h2>
        <?php 
            if(!empty($msg) && !empty($msg_type)){
                getMsg($msg, $msg_type); 
            }
                                
        ?>
        
    </div>
    <div class="book-editor__tool">
        <form method="GET" action="">
            <input type="hidden" name="module" value="receipt">
            <input type="hidden" name="action" value="list">
            <div class="book-editor__tool-form">
                <div class="show-entries">
                    <label for="slt_TrangThaiDH">Trạng Thái: </label>
                    <select id="slt_TrangThaiDH" name="slt_TrangThaiDH">
                        <option value="">-chọn-</option>
                        <?php 
                            foreach($GetTrangthaiHoaDon as $item):
                        ?>
                        <option value="<?php echo $item['ID'];?>"
                            <?php echo ($slt_TrangThaiDH == $item['ID']) ? 'selected' : false; ?>>
                            <?php echo $item['tenTrangThai'];?></option>

                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-wrapper">
                    <div class="form-inside__container">
                        <div class="book-editor__search">
                            <input type="search" id="search__user" name="search__user" class="textarea-timsach"
                                value="<?php echo (!empty($search__user)) ? $search__user : false; ?>" />
                        </div>
                        <div class="book-editor__btn">
                            <button type="submit" value="search" class="btn btn-timsach">
                                Tìm kiếm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- <span>Mục</span> -->
    </div>
    <!-- ---- Table ----- -->
    <div class="book-editor__table-wrapper">
        <table class="dashboard__table dashboard__table-mid book-editor_table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Tên Tài Khoản</th>
                    <th>Tên Người Nhận</th>
                    <th>Số ĐT Nhận</th>
                    <th>Địa Chỉ</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Đặt</th>

                    <th>Tổng Tiền</th>
                    <th>Xem chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($get_HD as $key => $item ):
                ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $item['ID']; ?></td>
                    <td class="tensach"><?php echo $item['tenNguoiDung']; ?></td>
                    <td><?php echo $item['tenNguoiNhan']; ?></td>
                    <td><?php echo $item['soDTNhanHang']; ?></td>
                    <td class="mota"><?php echo $item['diachi']; ?></td>
                    <td class="email"><?php echo $item['tenTrangThai']; ?></td>
                    <td><?php echo $item['ngayDatHang']; ?></td>

                    <td><?php echo $item['tongTien']; ?></td>
                    <td>
                        <a href="?module=receipt&action=detail&id=<?php echo $item['ID'];?>&tongTien=<?php echo $item['tongTien'];?>"
                            class="btn btn-warning">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </td>
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
</div>
</div>


<?php 

layout('footer');
?>