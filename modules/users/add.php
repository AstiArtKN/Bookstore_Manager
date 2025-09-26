<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
$data = [
    'title' => 'Thêm người dùng'
];

layout('sidebar', $data);
layout('header',  $data);

?>

<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Thêm Người Dùng</h2>
        <a href="?module=users&action=list" class="book-editor__add btn"><i class="fa-solid fa-list"></i> Xem DS</a>
    </div>
    <div class="user-add-wrapper">
        <div class="form-container">
            <form action="" method="POST">

                <div class="name-area">

                    <div class="form-group">
                        <label for="tenNguoiDung">Tên Người Dùng</label>
                        <input type="text" id="tenNguoiDung" name="tenNguoiDung" required>
                    </div>

                    <div class="form-group">
                        <label for="ho">Họ</label>
                        <input type="text" id="ho" name="ho">
                    </div>

                    <div class="form-group">
                        <label for="tenLot">Tên Lót</label>
                        <input type="text" id="tenLot" name="tenLot">
                    </div>

                    <div class="form-group">
                        <label for="ten">Tên</label>
                        <input type="text" id="ten" name="ten">
                    </div>
                </div>

                <div class="contact-area">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="sdt">Số Điện Thoại</label>
                        <input type="text" id="sdt" name="SDT">
                    </div>
                </div>

                <div class="privite-area">
                    <div class="form-group">
                        <label for="matKhau">Mật Khẩu</label>
                        <input type="password" id="matKhau" name="matKhau" required>
                    </div>

                    <div class="form-group">
                        <label for="ngaySinh">Ngày Sinh</label>
                        <input type="date" id="ngaySinh" name="ngaySinh">
                    </div>

                    <div class="form-group">
                        <label for="gioiTinh">Giới Tính</label>
                        <select id="gioiTinh" name="gioiTinh">
                            <option value="">-- Chọn --</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="trangThai">Trạng Thái</label>
                        <select id="trangThai" name="trangThai">
                            <option value="1">Hoạt động</option>
                            <option value="0">Không hoạt động</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quyenHanId">Quyền Hạn</label>
                        <select id="quyenHanId" name="quyenHanId">
                            <?php $getQH = getAll("SELECT * FROM quyenhan");
                                foreach($getQH as $item):
                            ?>

                            <option value="<?php echo $item['ID']?>"><?php echo $item['tenQuyenHan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button type="submit">Thêm Người Dùng</button>
            </form>
        </div>
    </div>
</div>
</div>

<?php 

layout('footer');
?>