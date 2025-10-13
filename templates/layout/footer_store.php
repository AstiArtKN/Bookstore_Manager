<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
?>

<footer class="footer" id="hotro">
    <div class="container">
        <div class="footer-inner">
            <div class="footer-left">
                <h2 class="footer__heading">LIÊN HỆ VỚI CHÚNG TÔI</h2>
                <div class="footer-address">
                    <h3 class="address-heading">Địa chỉ</h3>
                    <p class="footer-desc">Xã long Khánh, huyện Bến Cầu, tỉnh Tây Ninh</p>
                </div>
                <div class="footer-contact">
                    <h3 class="address-heading">Liên hệ</h3>
                    <p class="footer-desc">0961.314.900</p>
                    <p class="footer-desc">khiemnguyen1350@gmail.com</p>
                </div>
            </div>
            <div class="footer-right">
                <img src="<?php echo _HOST_URL_TEMPLATES; ?>/uploads/layer 2.png" alt="k-books"
                    class="footer-right-img">
            </div>
        </div>
    </div>
</footer>

<!-- SCRIPT -->

<script src="./assets/js/js-theme.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
AOS.init();
</script>
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
document.querySelectorAll(".addToCartForm").forEach(form => {
    form.addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("?module=store&action=add_to_cart", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị thông báo thành công
                    alert("✅ " + data.message + "\nSố sản phẩm trong giỏ: " + data.cartCount);

                    // Cập nhật số lượng giỏ hàng trên header (nếu có)
                    const cartBadge = document.getElementById("cart-count");
                    if (cartBadge) cartBadge.textContent = data.cartCount;
                } else {
                    alert("⚠️ " + data.message);
                }
            })
            .catch(err => {
                console.error("Lỗi:", err);
                alert("❌ Lỗi kết nối đến máy chủ!");
            });
    });
});
</script>

</body>

</html>