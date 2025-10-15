<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');

$cart = getSession('cart');

//kiểm tra giỏ hàng trống không
if(empty($cart)){
    redirect("?module=errors&action=404");
}



?>

<main>
    <div class="checkout" style="background-color: #f6f6f6;">
        <div class="container">
            <div class="checkout-container">
                <div class="checkout-left">
                    <!-- Tài khoản -->
                    <div class="card">
                        <h3>Tài khoản</h3>
                        <div class="user-info">
                            <div class="avatar">VD</div>
                            <div>
                                <p class="name">Võ Điền</p>
                                <p class="email">vohaidien70@gmail.com</p>
                            </div>
                            <a href="?module=auth&action=logout" class="logout">Đăng xuất</a>
                        </div>
                    </div>

                    <!-- Thông tin giao hàng -->
                    <div class="card">
                        <h3>Thông tin giao hàng</h3>
                        <div class="shipping-method">
                            <!-- <button class="active">Giao tận nơi</button>
                            <button>Nhận tại cửa hàng</button> -->
                        </div>

                        <form id="checkout-form" class="form-checkout-detail">
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

                                <div>
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

                                </div>

                            </div>
                        </form>

                    </div>
                </div>

                <div class="checkout-right">
                    <!-- Giỏ hàng -->
                    <div class="card-right">
                        <h3>Giỏ hàng</h3>

                        <div class="cart-list-checkout">
                            <?php foreach($cart as $ibsn => $item): ?>
                            <div class="cart-item">
                                <img src="<?php echo $item['hinhAnh']; ?>" alt="">
                                <div class="item-info">
                                    <p class="title line-clamp line-1 break-all"><?php echo $item['tenSach']; ?></p>
                                    <!-- <p class="variant">Bản Trắng (Tái Bản)</p> -->
                                    <p class="price"><?php echo number_format($item['gia'], 0, ',', '.'); ?> ₫</p>
                                </div>
                                <div class="quantity-box">
                                    <button type="button" class="qty-btn qty-btn-check-out minus">−</button>
                                    <input type="text" value="<?php echo $item['quantity']; ?>"
                                        class="qty-input qty-input-check-out" min="1" readonly />
                                    <button type="button" class="qty-btn qty-btn-check-out plus">+</button>
                                </div>
                                <button class="delete">🗑</button>
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
                            <div class="summary-item">
                                <span>Tổng tiền hàng</span>
                                <span>35,200₫</span>
                            </div>
                            <div class="summary-item">
                                <span>Phí vận chuyển</span>
                                <span>Miễn phí</span>
                            </div>
                            <div class="summary-item total">
                                <span>Tổng thanh toán</span>
                                <span>35,200₫</span>
                            </div>
                            <button type="submit" class="btn-checkout-thanhtoan">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
<?php
layout('footer_store');
?>