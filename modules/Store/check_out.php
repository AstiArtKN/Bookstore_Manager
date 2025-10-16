<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');

$cart = getSession('cart');
$user_detail = getCurrentUserFromToken();

//kiểm tra giỏ hàng trống không
if(empty($cart)){
    redirect("?module=errors&action=404");
}

// Lấy dữ liệu các tỉnh
$tinhList = getAll("SELECT ID, tenTinhThanhPho FROM TinhThanhPho ORDER BY tenTinhThanhPho");

// Lấy dữ liệu huyện theo tỉnh nếu đã chọn
$huyenList = [];
if (!empty($_POST['tinh'])) {
    $tinhId = (int)$_POST['tinh'];
    $huyenList = getAll("SELECT ID, tenQuanHuyen FROM QuanHuyen WHERE tinhThanhPhoId = $tinhId ORDER BY tenQuanHuyen");
}

// Lấy dữ liệu xã theo huyện nếu đã chọn
$xaList = [];
if (!empty($_POST['huyen'])) {
    $huyenId = (int)$_POST['huyen'];
    $xaList = getAll("SELECT ID, tenXaPhuong FROM XaPhuong WHERE quanHuyenId = $huyenId ORDER BY tenXaPhuong");
}
?>

?>

<main>
    <div class="checkout" style="background-color: #f6f6f6;">
        <div class="container">
            <form id="checkout-form" class="form-checkout-detail">
                <div class="checkout-container">
                    <div class="checkout-left">
                        <!-- Tài khoản -->
                        <div class="card">
                            <h3>Tài khoản</h3>
                            <div class="user-info">
                                <?php if(empty($user_detail)): ?>
                                <a href="?module=auth&action=login" class="logout"
                                    style="font-weight: 600; font-size: 1.8rem;">Đăng nhập</a>
                                <?php else: ?>
                                <div>

                                    <p class="name"><?php echo $user_detail['tenNguoiDung']; ?></p>
                                    <p class="email"><?php echo $user_detail['email']; ?></p>
                                </div>
                                <a href="?module=auth&action=logout" class="logout">Đăng xuất</a>
                                <?php endif;?>
                            </div>
                        </div>

                        <!-- Thông tin giao hàng -->
                        <div class="card">
                            <h3>Thông tin giao hàng</h3>
                            <div class="shipping-method">
                                <!-- <button class="active">Giao tận nơi</button>
                            <button>Nhận tại cửa hàng</button> -->
                            </div>


                            <div class="form-checkout-detail-inner">
                                <div>
                                    <label>Họ và tên</label>
                                    <input type="text" name="fullname" value="Võ Điền">

                                </div>
                                <div>
                                    <label>Số điện thoại</label>
                                    <input type="text" name="phone" placeholder="Nhập số điện thoại">
                                </div>

                                <div>
                                    <label>Quốc gia</label>
                                    <input type="text" value="Vietnam" readonly>
                                </div>

                                <div>
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address" placeholder="Số nhà, tên đường">
                                </div>

                                <!-- <div>
                                    <label>Tỉnh / Thành phố:</label>
                                    <select id="tinh" name="tinh" class="select-diachi">
                                        <option value="">-- Chọn tỉnh --</option>
                                    </select>

                                    <label>Huyện / Quận:</label>
                                    <select id="huyen" name="huyen" class="select-diachi" disabled>
                                        <option value="">-- Chọn huyện --</option>
                                    </select>

                                    <label>Xã / Phường:</label>
                                    <select id="xa" name="xa" class="select-diachi" disabled>
                                        <option value="">-- Chọn xã --</option>
                                    </select>

                                </div> -->

                            </div>


                        </div>
                    </div>

                    <div class="checkout-right">
                        <!-- Giỏ hàng -->
                        <div class="card-right">
                            <h3>Giỏ hàng</h3>

                            <div class="cart-list-checkout">
                                <?php 
                            $tongTien = 0;
                            foreach($cart as $isbn => $item): 
                                $thanhTien = $item['gia'] * $item['quantity'];
                                $tongTien += $thanhTien;
                                ?>
                                <div class="cart-item" data-isbn="<?= $isbn ?>">
                                    <img src="<?= $item['hinhAnh']; ?>" alt="">
                                    <div class="item-info">
                                        <p class="title line-clamp line-1 break-all"><?= $item['tenSach']; ?></p>
                                        <p class="price"><?= number_format($item['gia'], 0, ',', '.'); ?> ₫</p>
                                    </div>
                                    <div class="quantity-box">
                                        <button type="button" class="qty-btn minus">−</button>
                                        <input type="text" value="<?= $item['quantity']; ?>"
                                            class="qty-input qty-input-checkout" min="1" max="<?php 
                                            $getThisBook = getOne("SELECT soLuong FROM SACH WHERE ISBN = '$isbn'");
                                            echo $getThisBook['soLuong'];
                                        ?>" readonly />
                                        <button type="button" class="qty-btn plus">+</button>
                                    </div>
                                    <a href="#" class="remove">Xóa</a>
                                </div>

                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="nutthanhtoan">
                            <!-- Mã khuyến mãi -->
                            <div class="nutthanhtoan-km">
                                <h3>Mã khuyến mãi</h3>
                                <div class="coupon">
                                    <input type="text" placeholder="Nhập mã khuyến mãi">
                                    <button class="apply">Áp dụng</button>
                                </div>
                            </div>

                            <!-- Tóm tắt đơn hàng -->
                            <div class="card summary">
                                <h3>Tóm tắt đơn hàng</h3>
                                <div class="summary-item tong-hang">
                                    <span>Tổng tiền hàng</span>
                                    <span><?= number_format($tongTien, 0, ',', '.'); ?> ₫</span>
                                </div>
                                <div class="summary-item phi-ship">
                                    <span>Phí vận chuyển</span>
                                    <span>Miễn phí</span>
                                </div>
                                <div class="summary-item total">
                                    <span>Tổng thanh toán</span>
                                    <span><?= number_format($tongTien, 0, ',', '.'); ?> ₫</span>
                                </div>
                                <button type="submit" class="btn-checkout-thanhtoan">Đặt hàng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- script -->
    <script>
    document.querySelectorAll('.cart-item').forEach(item => {
        const isbn = item.dataset.isbn;
        const input = item.querySelector('.qty-input');
        const minus = item.querySelector('.minus');
        const plus = item.querySelector('.plus');
        const max = parseInt(input.getAttribute('max')) || 9999;

        // Hàm gọi AJAX cập nhật số lượng
        function updateQuantity(type) {
            fetch("?module=store&action=update_cart", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: new URLSearchParams({
                        isbn,
                        type
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật lại input
                        input.value = data.item.quantity;

                        // Cập nhật tổng tiền hàng và tổng thanh toán
                        const tongHang = document.querySelector(".tong-hang span:last-child");
                        const tongThanhToan = document.querySelector(".total span:last-child");

                        if (tongHang) tongHang.textContent = data.cart_total + " ₫";
                        if (tongThanhToan) tongThanhToan.textContent = data.cart_total + " ₫";
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => console.error("Lỗi:", err));
        }

        // Nút trừ
        minus.addEventListener('click', () => {
            let value = parseInt(input.value);
            if (value > 1) updateQuantity('minus');
        });

        // Nút cộng
        plus.addEventListener('click', () => {
            let value = parseInt(input.value);
            if (value < max) updateQuantity('plus');
            else input.value = max;
        });
    });

    // Xoá sản phẩm
    document.querySelectorAll('.cart-item .remove').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const item = btn.closest('.cart-item');
            const isbn = item.dataset.isbn;

            if (!confirm("Xóa sản phẩm này khỏi giỏ hàng?")) return;

            fetch("?module=store&action=remove_from_cart", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: new URLSearchParams({
                        isbn
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        item.remove();

                        // Cập nhật lại tổng
                        const tongHang = document.querySelector(".tong-hang span:last-child");
                        const tongThanhToan = document.querySelector(".total span:last-child");

                        if (tongHang) tongHang.textContent = data.cart_total + " ₫";
                        if (tongThanhToan) tongThanhToan.textContent = data.cart_total + " ₫";

                        if (data.empty) {
                            document.querySelector(".cart-list-checkout").innerHTML =
                                "<p style='font-size:1.5rem; text-align:center;'>Giỏ hàng trống</p>";
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => console.error("Lỗi:", err));
        });
    });
    </script>



</main>
<?php
layout('footer_store');
?>