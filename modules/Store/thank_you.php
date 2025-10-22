<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');

$getdata = filterData('get');
$getId = $getdata['id'];

//nếu không có đơn hàng
if(empty($getId)){
    redirect('?module=errors&action=404');
}


$get_HD = getOne("SELECT hoadon.ID, nguoidung.tenNguoiDung, hoadon.tenNguoiNhan,
hoadon.soDTNhanHang, hoadon.diachi, trangthaihoadon.tenTrangThai, hoadon.trangThaiHoaDonId, hoadon.ngayDatHang, hoadon.ngayGiaoHang, hoadon.tongTien
FROM hoadon
INNER JOIN `trangthaihoadon` ON hoadon.trangThaiHoaDonId  = trangthaihoadon.ID
INNER JOIN `nguoidung` ON hoadon.nguoiDungId  = nguoidung.ID
WHERE hoadon.ID = '$getId'
");

//nếu không có đơn hàng
if(!$get_HD){
    redirect('?module=errors&action=404');
}

$getDetail_HD = getAll("SELECT hoadonchitiet.hoaDonId, hoadonchitiet.ISBN, hoadonchitiet.soLuongSach, hoadonchitiet.donGia,
hoadonchitiet.thanhTien, sach.tenSach, sach.hinhAnh, trangthaihoadon.tenTrangThai
FROM hoadonchitiet
INNER JOIN `sach` ON hoadonchitiet.ISBN = sach.ISBN
INNER JOIN `hoadon` ON hoadonchitiet.hoaDonId  = hoadon.ID
INNER JOIN `trangthaihoadon` ON hoadon.trangThaiHoaDonId = trangthaihoadon.ID
WHERE hoadonchitiet.hoaDonId = '$getId'
");

?>

<div class="thankyou">
    <div class="thankyou-inner">
        <div class="header-thankyou">
            <img src="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/logo_web_store.png" alt="Fahasa Logo">
            <div class="order-info">
                <strong>MÃ ĐƠN HÀNG: <?php echo $getId; ?></strong>
                <span><?php echo $get_HD['ngayDatHang'];?></span>
            </div>
        </div>

        <p>Xin chào <strong><?php echo $get_HD['tenNguoiDung'];?></strong>,</p>
        <p>Cảm ơn bạn đã mua hàng tại <strong>K-Books</strong>! Dưới đây là chi tiết đơn hàng của bạn:</p>

        <div class="section-title">Thông tin thanh toán</div>
        <table class="info-table">
            <tr>
                <td><strong>Người thanh toán:</strong></td>
                <td><?php echo $get_HD['tenNguoiDung'];?></td>
            </tr>
            <tr>
                <td><strong>Địa chỉ:</strong></td>
                <td><?php echo $get_HD['diachi'];?></td>
            </tr>
            <tr>
                <td><strong>Điện thoại:</strong></td>
                <td><?php echo $get_HD['soDTNhanHang'];?></td>
            </tr>
            <tr>
                <td><strong>Phương thức thanh toán:</strong></td>
                <td>Thanh toán khi nhận hàng</td>
            </tr>
        </table>

        <div class="section-title">Thông tin giao hàng</div>
        <table class="info-table">
            <tr>
                <td><strong>Người nhận:</strong></td>
                <td><?php echo $get_HD['tenNguoiNhan'];?></td>
            </tr>
            <tr>
                <td><strong>Địa chỉ giao hàng:</strong></td>
                <td><?php echo $get_HD['diachi'];?></td>
            </tr>
            <tr>
                <td><strong>Điện thoại:</strong></td>
                <td><?php echo $get_HD['soDTNhanHang'];?></td>
            </tr>
            <tr>
                <td><strong>Phương thức giao hàng:</strong></td>
                <td>Giao hàng tiêu chuẩn</td>
            </tr>
        </table>

        <div class="section-title">Sản phẩm</div>
        <table class="table-products">
            <tr>
                <th>Sản phẩm</th>
                <th>SKU</th>
                <th>Đơn giá</th>
                <th>SL</th>
                <th>Thành tiền</th>
            </tr>
            <?php foreach($getDetail_HD as $item):?>
            <tr>
                <td><?php echo $item['tenSach']; ?></td>
                <td><?php echo $item['ISBN']; ?></td>
                <td><?php echo $item['donGia']; ?></td>
                <td><?php echo $item['soLuongSach']; ?></td>
                <td><?php echo $item['thanhTien']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="total">
            <p>Thành tiền: <?php echo $get_HD['tongTien'];?> đ</p>
            <p>Phí vận chuyển: Miễn phí</p>
            <p><strong>Tổng cộng: <?php echo $get_HD['tongTien'];?> đ</strong></p>
        </div>

        <div class="note">
            <p><strong>Lưu ý:</strong></p>
            <p>1. Vui lòng kiểm tra sản phẩm khi nhận hàng.</p>
            <p>2. Đơn hàng của bạn có thể được tách ra để giao nhiều lần nếu gồm nhiều sản phẩm.</p>
            <p>3. Trong trường hợp có vấn đề phát sinh, <strong>K-Books</strong> sẽ liên lạc với bạn.</p>
        </div>

        <div class="footer-thankyou">
            K-books – Chăm Sóc Khách Hàng | Hotline: 1900636467 | Email:
            <a href="mailto:sales@kbooks.com">sales@kbooks.com</a>
        </div>
        <?php if(!empty($getdata['srcp'])): ?>
        <button class="print-btn btn-checkout-thanhtoan" style="background: #0099ff;" onclick="window.print()">🖨️ In
            hóa
            đơn</button>
        <?php endif;?>
    </div>
</div>


<?php
layout('footer_store');
?>