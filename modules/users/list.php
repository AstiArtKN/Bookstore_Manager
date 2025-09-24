<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$data = [
    'title' => 'Danh sách người dùng'
];

layout('sidebar', $data);
layout('header',  $data);

//?module=users&action=list&slt_quyenhan=&search__user=
$filter = filterData();
$chuoiWhere = '';
$slt_quyenhan = 'KH';
$search__user = '';

if(isGet()){
    if(isset($filter['search__user'])){
        $search__user = $filter['search__user'];
    }
    if(isset($filter['slt_quyenhan'])){
        $slt_quyenhan  = $filter['slt_quyenhan'];
    }
    if(!empty($search__user)){
        if(strpos($chuoiWhere, 'WHERE') == false){
            $chuoiWhere .= ' WHERE ';
        }
        else{
            $chuoiWhere .= ' AND ';
        }

        $chuoiWhere .= " tenNguoiDung LIKE '%$search__user%' OR email LIKE '%$search__user%' ";
    }

    if(!empty($slt_quyenhan)){
        if(strpos($chuoiWhere, 'WHERE') == false){
            $chuoiWhere .= ' WHERE ';
        }
        else{
            $chuoiWhere .= ' AND ';
        }

         $chuoiWhere .= " quyenhan.ID = '$slt_quyenhan' ";
    }
}

// echo $chuoiWhere;

$getDetailUser = getAll("SELECT nguoidung.ID, nguoidung.tenNguoiDung, nguoidung.ho, nguoidung.tenLot,
nguoidung.ten, nguoidung.email, nguoidung.SDT, nguoidung.ngaySinh, nguoidung.gioiTinh,
nguoidung.trangThai, quyenhan.tenQuyenHan
FROM nguoidung
INNER JOIN `quyenhan` ON nguoidung.quyenHanId = quyenhan.ID
$chuoiWhere
");

$GetQuyenHan = getAll("SELECT * FROM quyenhan");

// print_r($getDetailUser);

?>

<!-- book editor -->
<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Danh Sách Người Dùng</h2>
        <a href="?module=books&action=add" class="book-editor__add btn"><i class="fa-solid fa-plus"></i> Thêm Người
            Dùng</a>
    </div>
    <div class="book-editor__tool">
        <form method="GET" action="">
            <input type="hidden" name="module" value="users">
            <input type="hidden" name="action" value="list">
            <div class="book-editor__tool-form">
                <div class="show-entries">
                    <label for="slt_quyenhan">Người Dùng: </label>
                    <select id="slt_quyenhan" name="slt_quyenhan">
                        <option value="">-chọn-</option>
                        <?php 
                            foreach($GetQuyenHan as $item):
                        ?>
                        <option value="<?php echo $item['ID'];?>"
                            <?php echo ($slt_quyenhan == $item['ID']) ? 'selected' : false; ?>>
                            <?php echo $item['tenQuyenHan'];?></option>

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
                    <th>Tên Người Dùng</th>
                    <th>Họ</th>
                    <th>Tên Lót</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>SDT</th>
                    <th>Ngày Sinh</th>
                    <th>Giới Tính</th>
                    <th>Trạng Thái</th>
                    <th>Quyền Hạn</th>
                    <th>Phân quyền</th>
                    <th>Chỉnh Sửa</th>
                    <th>Xoá</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($getDetailUser as $key => $item ):
                ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $item['ID']; ?></td>
                    <td class="tensach"><?php echo $item['tenNguoiDung']; ?></td>
                    <td><?php echo $item['ho']; ?></td>
                    <td><?php echo $item['tenLot']; ?></td>
                    <td class="mota"><?php echo $item['ten']; ?></td>
                    <td class="email"><?php echo $item['email']; ?></td>
                    <td><?php echo $item['SDT']; ?></td>
                    <td><?php echo $item['ngaySinh']; ?></td>
                    <td><?php echo $item['gioiTinh']; ?></td>
                    <td><?php echo $item['trangThai']; ?></td>
                    <td><?php echo $item['tenQuyenHan']; ?></td>
                    <td> <a href="?module=users&action=permission&id=<?php echo $item['ID'];?>" class="btn btn-setting">
                            <i class="fa-solid fa-gears"></i>
                        </a></td>
                    <td>
                        <a href="#" class="btn btn-warning">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        <a href="#" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>

                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
</div>


<?php 

layout('footer');
?>