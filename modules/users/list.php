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

?>

<!-- book editor -->
<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Danh Sách Người Dùng</h2>
        <a href="?module=books&action=add" class="book-editor__add btn"><i class="fa-solid fa-plus"></i> Thêm Người
            Dùng</a>
    </div>
    <div class="book-editor__tool">
        <div class="show-entries">
            <label for="entries">Xem</label>
            <form method="GET" action="">
                <select id="entries" name="entries">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </form>
            <span>Mục</span>
        </div>
        <div class="form-wrapper">
            <form action="" method="get">
                <div class="form-inside__container">
                    <div class="book-editor__search">
                        <input type="search" id="search__book" name="search__book" class="textarea-timsach" />
                    </div>
                    <div class="book-editor__btn">
                        <button type="submit" value="search" class="btn btn-timsach">
                            Tìm kiếm sách
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- ---- Table ----- -->
    <div class="book-editor__table-wrapper">
        <table class="dashboard__table dashboard__table-mid book-editor_table">
            <thead>
                <tr>
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
                    <th>Chỉnh Sửa</th>
                    <th>Xoá</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ISBN</td>
                    <td class="tensach">Tên Người Dùng</td>
                    <td>Họ</td>
                    <td>Tên Lót</td>
                    <td class="mota">tên</td>
                    <td>email</td>
                    <td>sdt</td>
                    <td>ngày sinh</td>
                    <td>giới tính</td>
                    <td>Trạng Thái</td>
                    <td>Quyền Hạn</td>
                    <td>
                        <a href="sua.php?id=1" class="btn btn-warning">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        <a href="xoa.php?id=1" class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xoá không?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>


<?php 

layout('footer');
?>