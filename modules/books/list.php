<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$data = [
    'title' => 'Quản lý sách'
];

layout('sidebar', $data);
layout('header', $data);

?>

<!-- book editor -->
<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Danh Sách Sản Phẩm</h2>
        <a href="?module=books&action=add" class="book-editor__add btn"><i class="fa-solid fa-plus"></i> Thêm Sách</a>
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
                    <th>ISBN</th>
                    <th>Tên Sách</th>
                    <th>Tác Giả</th>
                    <th>Thể Loại</th>
                    <th>Mô Tả</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Hình Ảnh</th>
                    <th>Số trang</th>
                    <th>Chỉnh sửa</th>
                    <th>Xoá</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ISBN</td>
                    <td class="tensach">TÊN SÁCH</td>
                    <td>TÁC GIẢ</td>
                    <td>
                        thể loại

                    </td>
                    <td class="mota">mô tả</td>
                    <td>
                        số lượng
                    </td>
                    <td>giá</td>
                    <td> <img src="./assets/img/sach1.PNG" alt="hình ảnh" class="table-rank-img table-rank-img-mid" />
                    </td>
                    <td>Số trang</td>
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