<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');


$cart = getSession('cart');

// echo '<pre>';
// print_r($cart);
// echo '</pre>';
// die();


?>

<main>
    <div class="b-cart">
        <div class="container">
            <h2 class="cart-title">GIỎ HÀNG</h2>
            <?php if ($cart === false || empty($cart)): ?>
            <p style="font-size: 2rem; font-weight: 600; text-align: center;">giỏ hàng trống</p>
            <?php else: ?>
            <form action="#">
                <div class="tb-container">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá tiền</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                        <tbody>
                            <?php 
                                $tongTien = 0;
                                foreach($cart as $isbn => $item):
                                    $thanhTien = $item['gia'] * $item['quantity'];
                                    $tongTien += $thanhTien;
                            ?>
                            <tr data-isbn="<?php echo $isbn; ?>">
                                <td><img src="<?php echo $item['hinhAnh']; ?>" alt="book" /></td>
                                <td>
                                    <p class="cart-book-title"><?php echo $item['tenSach']; ?></p>
                                </td>
                                <td>
                                    <div class="quantity-box">
                                        <button type="button" class="qty-btn minus">−</button>
                                        <input type="text" value="<?php echo $item['quantity']; ?>" class="qty-input"
                                            min="1" max="<?php 
                                             $getThisBook = getOne("SELECT soLuong FROM SACH WHERE ISBN = '$isbn'");
                                                echo $getThisBook['soLuong'];
                                        ?>" readonly />
                                        <button type="button" class="qty-btn plus">+</button>
                                    </div>
                                </td>
                                <td class="price"><?php echo number_format($item['gia'], 0, ',', '.'); ?> ₫</td>
                                <td><a href="#" class="remove">Xóa</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                        </tbody>
                    </table>
                </div>

                <div class="cart-footer">
                    <div class="cart-note">
                        <label for="note">Ghi chú đơn hàng</label>
                        <textarea id="note" rows="3" placeholder="Nhập ghi chú..."></textarea>
                        <a href="#" class="continue-shopping">← Tiếp tục mua hàng</a>
                    </div>

                    <div class="cart-summary">
                        <p><strong>Tổng cộng:</strong> <span><?php echo number_format($tongTien,0, ' ,', '.'); ?>
                                ₫</span></p>

                        <div class="cart-buttons">
                            <a href="?module=store&action=check_out" class="btn btn-checkout">Thanh toán →</a>
                        </div>
                    </div>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</main>
<!-- script -->
<script>
document.querySelectorAll('.quantity-box').forEach(box => {
    const input = box.querySelector('.qty-input');
    const minus = box.querySelector('.minus');
    const plus = box.querySelector('.plus');

    const max = parseInt(input.getAttribute('max')) || 9999; // phòng trường hợp không có max ;)))))

    minus.addEventListener('click', () => {
        let value = parseInt(input.value);
        if (value > 1) input.value = value - 1;
    });

    plus.addEventListener('click', () => {
        let value = parseInt(input.value);
        if (value < max) {
            input.value = value + 1;
        } else {
            // Nếu vượt quá max thì gán về giá trị tối đa
            input.value = max;
        }
    });
});
</script>
<script>
document.querySelectorAll('.quantity-box').forEach(box => {
    const input = box.querySelector('.qty-input');
    const minus = box.querySelector('.minus');
    const plus = box.querySelector('.plus');
    const tr = box.closest('tr');
    const isbn = tr.dataset.isbn;

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
                    input.value = data.item.quantity;
                    // tr.querySelector(".price").textContent = data.item.subtotal;
                    document.querySelector(".cart-summary span").textContent = data.cart_total;
                } else {
                    alert(data.message);
                }
            })
            .catch(err => console.error("Lỗi:", err));
    }

    minus.addEventListener('click', () => updateQuantity('minus'));
    plus.addEventListener('click', () => updateQuantity('plus'));
});

// Xoá sản phẩm bằng AJAX
document.querySelectorAll('.remove').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const tr = this.closest('tr');
        const isbn = tr.dataset.isbn;

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
                    tr.remove();
                    document.querySelector(".cart-summary span").textContent = data.cart_total +
                        " ₫";

                    // Nếu giỏ trống -> thay nội dung toàn trang
                    if (data.empty) {
                        document.querySelector(".b-cart").innerHTML =
                            "<p style='font-size:2rem; font-weight:600; text-align:center;'>Giỏ hàng trống</p>";
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(err => console.error("Lỗi:", err));
    });
});
</script>


<?php
layout('footer_store');
?>