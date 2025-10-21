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

if(isPost()){
    $filter = filterData();
    $errors = [];
    // print_r($filter);
     //validate email phoneNumber
     if(empty($filter['phone'])){
        $errors['phone']['require'] = 'vui lòng nhập số điện thoại của bạn';
    }
    else{
        if(!isPhone($filter['phone'])){
            $errors['phone']['isPhone'] = 'số điện thoại không đúng định dạng';
        }
    }
    if(empty($filter['address'])){
        $errors['address']['require'] = 'vui lòng nhập địa chỉ cụ thể';
    }
    if(empty($filter['fullname'])){
        $errors['fullname']['require'] = 'vui lòng nhập tên người nhận hàng';
    }
    if(empty($errors)){
        ///tạo ID hoadon tự động
        $idrand = generateRandomID(10);

        //
        $tinhId = $_POST['tinh'] ?? 0;
        $huyenId = $_POST['huyen'] ?? 0;
        $xaId = $_POST['xa'] ?? 0;

        // Lấy tên tương ứng
        $tinh = getOne("SELECT tenTinhThanhPho FROM tinhthanhpho WHERE ID = '$tinhId'");
        $huyen = getOne("SELECT tenQuanHuyen FROM quanhuyen WHERE ID = '$huyenId'");
        $xa = getOne("SELECT tenXaPhuong FROM xaphuong WHERE ID = '$xaId'");

        $string_checkout = $filter['address'] . ', ' .
                         ($tinh['tenTinhThanhPho'] ?? '') . ', ' .
                         ($huyen['tenQuanHuyen'] ?? '') . ', ' .
                        ($xa['tenXaPhuong'] ?? '');

        
        $data_hoadon = [
            'ID' => $idrand,
            'nguoiDungId' => $user_detail['ID'],
            'tenNguoiNhan' => $filter['fullname'],
            'soDTNhanHang' => $filter['phone'],
            'diachi' => $string_checkout,
            'ghichu' => $filter['ghichu'],
            'trangThaiHoaDonId' => 'TTDH1',
            'ngayDatHang' => date('Y:m:d H:i:s')
        ];
        $insertStatus = insert('hoadon', $data_hoadon);

        //thêm dữ liệu vào bảng chitiethoadon
        foreach($cart as $isbn => $item){
            $thanhTien = $item['gia'] * $item['quantity'];
            $data_chitietHD = [
                'hoaDonId' => $idrand,
                'ISBN' => $isbn,
                'soLuongSach' => $item['quantity'],
                'dongia' => $item['gia'],
                'thanhtien' => $thanhTien
            ];
            $insertStatus = insert('hoadonchitiet',  $data_chitietHD);
            $get_one_book = getOne("SELECT soLuong from sach where ISBN = '$isbn'");
            $soluong_final = max(0, $get_one_book['soLuong'] - $item['quantity']);
            $dataUpdate = [
                    'soLuong' => $soluong_final,
                    'update_at' => date('Y:m:d H:i:s')
                ];

            $condition = "ISBN='" . $isbn . "'";

            $updateStatus = update('sach', $dataUpdate, $condition);
        }

         removeSession('cart');
        

    }
    else{
        setSessionFlash('msg', 'vui lòng kiểm tra dữ liệu nhập vào.');
        setSessionFlash('msg_type', 'danger');
        // setSessionFlash('oldData', $filter);
        setSessionFlash('errors', $errors);
    }


}

$msg = getSessionFlash('msg');
$msg_type = getSessionFlash('msg_type');
$errorArr = getSessionFlash('errors');

?>



<main>
    <div class="checkout" style="background-color: #f6f6f6;">
        <div class="container">

            <form id="checkout-form" class="form-checkout-detail" action="" method="POST" enctype="multipart/form-data">
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
                            <?php 
                                if(!empty($msg) && !empty($msg_type)){
                                    getMsg($msg, $msg_type); 
                                }
                                                    
                                ?>
                            <div class="shipping-method">
                                <!-- <button class="active">Giao tận nơi</button>
                            <button>Nhận tại cửa hàng</button> -->
                            </div>


                            <div class="form-checkout-detail-inner">
                                <div>
                                    <label>Họ và tên</label>
                                    <input type="text" name="fullname">
                                    <?php 
                                    if(!empty($errorArr)){
                                     echo formError($errorArr, 'fullname');
                                    }
                                    ?>
                                </div>
                                <div>
                                    <label>Số điện thoại</label>
                                    <input type="text" name="phone" placeholder="Nhập số điện thoại">
                                    <?php 
                                    if(!empty($errorArr)){
                                     echo formError($errorArr, 'phone');
                                    }
                                    ?>
                                </div>

                                <div>
                                    <label>Quốc gia</label>
                                    <input type="text" value="Vietnam" readonly>
                                </div>

                                <div>
                                    <label>Địa chỉ cụ thể</label>
                                    <input type="text" name="address" placeholder="Số nhà, tên đường">
                                    <?php 
                                    if(!empty($errorArr)){
                                     echo formError($errorArr, 'address');
                                    }
                                    ?>
                                </div>

                                <div>
                                    <label>Tỉnh / Thành phố:</label>
                                    <select id="tinh" name="tinh">
                                        <option value="">-- Chọn tỉnh --</option>
                                        <?php
                                            $tinhList = getAll("SELECT * FROM tinhTHANHPHO ORDER BY tenTinhThanhPho");
                                            foreach ($tinhList as $tinh) {
                                                echo '<option value="'.$tinh['ID'].'">'.$tinh['tenTinhThanhPho'].'</option>';
                                            }
                                            ?>
                                    </select>

                                    <label>Huyện / Quận:</label>
                                    <select id="huyen" name="huyen" disabled>
                                        <option value="">-- Chọn huyện --</option>
                                    </select>

                                    <label>Xã / Phường:</label>
                                    <select id="xa" name="xa" disabled>
                                        <option value="">-- Chọn xã --</option>
                                    </select>

                                </div>

                                <div>
                                    <label>Ghi chú:</label>
                                    <textarea id="ghichu" name="ghichu" rows="3" cols="50" class="check-out-ghichu"
                                        placeholder="ghi chú đơn hàng..."></textarea>
                                </div>

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
                                <?php if(empty($user_detail)): ?>
                                <a href="?module=auth&action=login" class="logout"
                                    style="display: inline-block;padding: 10px;margin-top: 10px;font-weight: 600; font-size: 1.8rem; border: solid 1px #ccc">Đăng
                                    nhập để
                                    thanh toán</a>
                                <?php else: ?>
                                <button type="submit" class="btn-checkout-thanhtoan">Đặt hàng</button>
                                <?php endif;?>

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

    <script>
    document.getElementById('tinh').addEventListener('change', function() {
        const tinhId = this.value;
        const huyenSelect = document.getElementById('huyen');
        const xaSelect = document.getElementById('xa');

        huyenSelect.innerHTML = '<option value="">-- Chọn huyện --</option>';
        xaSelect.innerHTML = '<option value="">-- Chọn xã --</option>';
        xaSelect.disabled = true;

        if (tinhId === '') {
            huyenSelect.disabled = true;
            return;
        }

        fetch('?module=store&action=get_huyen', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + tinhId
            })
            .then(res => res.json())
            .then(data => {
                huyenSelect.disabled = false;
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.tenQuanHuyen;
                    huyenSelect.appendChild(opt);
                });
            });
    });

    document.getElementById('huyen').addEventListener('change', function() {
        const huyenId = this.value;
        const xaSelect = document.getElementById('xa');
        xaSelect.innerHTML = '<option value="">-- Chọn xã --</option>';

        if (huyenId === '') {
            xaSelect.disabled = true;
            return;
        }

        fetch('?module=store&action=get_xa', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + huyenId
            })
            .then(res => res.json())
            .then(data => {
                xaSelect.disabled = false;
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.tenXaPhuong;
                    xaSelect.appendChild(opt);
                });
            });
    });
    </script>


</main>
<?php
layout('footer_store');
?>