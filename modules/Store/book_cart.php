<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');

?>

<main>
    <div class="b-cart">
        <div class="container">
            <h2 class="cart-title">GIỎ HÀNG</h2>

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
                            <tr>
                                <td><img src="https://cdn.hstatic.net/products/200000287623/5_giay_dem_nguoc__phu_thuy_duoc_yeu_manga_oneshot_bia_1_6f61addf8fbf4625bced233ccabf2072_master.png"
                                        alt="book" />
                                </td>
                                <td>
                                    <p class="cart-book-title">5 Giây Đếm Ngược, Phù Thủy Được Yêu</p>
                                    <p class="cart-book-author">Tác giả: Aoi Akira</p>
                                </td>
                                <td>
                                    <div class="quantity-box">
                                        <button type="button" class="qty-btn minus">−</button>
                                        <input type="text" value="1" class="qty-input" min="1" readonly />
                                        <button type="button" class="qty-btn plus">+</button>
                                    </div>
                                </td>
                                <td>152.000đ</td>
                                <td><a href="#" class="remove">Xóa</a></td>
                            </tr>

                            <tr>
                                <td><img src="https://cdn0.fahasa.com/media/catalog/product/g/i/given_9.jpg"
                                        alt="book" />
                                </td>
                                <td>
                                    <p class="cart-book-title">Given - Tập 9</p>
                                    <p class="cart-book-author">Tác giả: Kizu Natsuki</p>
                                </td>
                                <td>
                                    <div class="quantity-box">
                                        <button type="button" class="qty-btn minus">−</button>
                                        <input type="text" value="2" class="qty-input" min="1" readonly />
                                        <button type="button" class="qty-btn plus">+</button>
                                    </div>
                                </td>
                                <td>114.400đ</td>
                                <td><a href="#" class="remove">Xóa</a></td>
                            </tr>
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
                        <p><strong>Tổng cộng:</strong> <span>266.400đ</span></p>

                        <div class="cart-buttons">
                            <a href="#" class="btn btn-checkout">Thanh toán →</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<!-- script -->
<script>
document.querySelectorAll('.quantity-box').forEach(box => {
    const input = box.querySelector('.qty-input');
    const minus = box.querySelector('.minus');
    const plus = box.querySelector('.plus');

    minus.addEventListener('click', () => {
        let val = parseInt(input.value);
        if (val > 1) input.value = val - 1;
    });

    plus.addEventListener('click', () => {
        let val = parseInt(input.value);
        input.value = val + 1;
    });
});
</script>
<?php
layout('footer_store');
?>