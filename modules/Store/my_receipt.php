<?php
if (!defined('_KTHopLe')) {
    die('Truy cập không hợp lệ');
}

layout('header_store');

$user_detail = getCurrentUserFromToken();
$getID_u = $user_detail['ID'];

// Lấy tất cả chi tiết hóa đơn theo user
$getDetail_HD = getAll("
    SELECT hoadonchitiet.hoaDonId, hoadonchitiet.ISBN, hoadonchitiet.soLuongSach, hoadonchitiet.donGia,
           hoadonchitiet.thanhTien, sach.tenSach, sach.hinhAnh,
           hoadon.ID, nguoidung.tenNguoiDung, hoadon.tenNguoiNhan,
           hoadon.soDTNhanHang, hoadon.diachi, hoadon.trangThaiHoaDonId,
           trangthaihoadon.tenTrangThai, hoadon.ngayDatHang, hoadon.ngayGiaoHang, hoadon.tongTien
    FROM hoadonchitiet
    INNER JOIN sach ON hoadonchitiet.ISBN = sach.ISBN
    INNER JOIN hoadon ON hoadonchitiet.hoaDonId = hoadon.ID
    INNER JOIN nguoidung ON hoadon.nguoiDungId = nguoidung.ID
    INNER JOIN trangthaihoadon ON hoadon.trangThaiHoaDonId = trangthaihoadon.ID
    WHERE hoadon.nguoiDungId = '$getID_u'
    ORDER BY hoadon.ngayDatHang DESC
");

// Nếu không có hóa đơn
if (!$getDetail_HD) {
    echo '<main><div class="b-cart"><div class="container"><p style="font-size:2rem; font-weight:600; text-align:center;">Bạn chưa mua một cuốn sách nào</p></div></div></main>';
    layout('footer_store');
    exit;
}

// Gom chi tiết theo mã hóa đơn
$hoaDons = [];
foreach ($getDetail_HD as $item) {
    $hoaDons[$item['hoaDonId']][] = $item;
}
?>

<main>
    <div class="b-cart">
        <div class="container">
            <h2 class="cart-title">Hóa đơn mua hàng</h2>

            <?php foreach ($hoaDons as $hoaDonId => $dsSach): ?>
            <?php $info = $dsSach[0]; // lấy thông tin chung 1 lần ?>
            <div class="tb-container">
                <p style=" margin-bottom: 10px;">Đơn hàng: <strong
                        style="font-weight: 600; margin-bottom: 5px;"><?= $hoaDonId ?></strong></p>
                <p style=" margin-bottom: 10px;"><strong style="font-weight: 600;">Ngày đặt: </strong>
                    <?= $info['ngayDatHang'] ?>
                </p>
                <p style=" margin-bottom: 10px;"><strong style="font-weight: 600;">Trạng thái: </strong>
                    <?= htmlspecialchars($info['tenTrangThai']) ?></p>

                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Hình</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá tiền</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dsSach as $item): ?>
                        <tr data-isbn="<?= $item['ISBN'] ?>">
                            <td><img src="<?= $item['hinhAnh'] ?>" alt="book" width="60" /></td>
                            <td><?= htmlspecialchars($item['tenSach']) ?></td>
                            <td><?= $item['soLuongSach'] ?></td>
                            <td><?= number_format($item['donGia'], 0, ',', '.') ?> ₫</td>
                            <td><?= number_format($item['thanhTien'], 0, ',', '.') ?> ₫</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-footer">
                    <div class="cart-summary">
                        <p><strong>Tổng cộng:</strong>
                            <span><?= number_format($info['tongTien'], 0, ',', '.') ?> ₫</span>
                        </p>
                        <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($info['diachi']) ?></p>
                        <p><strong>Người nhận:</strong> <?= htmlspecialchars($info['tenNguoiNhan']) ?> -
                            <?= $info['soDTNhanHang'] ?></p>
                    </div>
                </div>
            </div>
            <div style="margin-bottom: 30px; border-bottom: solid 1px #ccc;"></div>
            <?php endforeach; ?>

        </div>
    </div>
</main>

<?php layout('footer_store'); ?>