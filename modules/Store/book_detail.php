<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');


$getData = filterData('get');
// print_r($getData); die();

$keyBook = $getData['isbn'];
if(!empty($getData)){
    $getThisBook = getOne("SELECT sach.ISBN, sach.tenSach, tacgiasach.tenTacGia, theloaisach.tenTheLoai, sach.soLuong,
                            sach.gia, sach.kichThuoc, nhaxuatban.tenNhaXuatBan, sach.moTa, sach.hinhAnh, sach.slug, year(sach.ngayXuatBan) as ngayXuatBan, sach.soTrang
                            FROM sach
                            INNER JOIN tacgiasach ON sach.tacGiaId = tacgiasach.ID
                            INNER JOIN theloaisach ON sach.theLoaiId = theloaisach.ID
                            INNER JOIN nhaxuatban ON sach.nhaXuatBanId = nhaxuatban.ID
                            WHERE sach.ISBN = '$keyBook'");
    if(empty($getThisBook)){
       redirect('/');
    }

}

?>

<main>
    <section class="book-detail">
        <div class="container">
            <!-- left -->
            <div class="book-detail-wrapper">
                <div class="book-detail_left">
                    <div class="book-detail__img--wrapper">
                        <img src="<?php echo $getThisBook['hinhAnh'];?>" alt="" class="book-detail__img" />
                    </div>


                    <!-- thêm vào giỏ hàng -->
                    <form id="addToCartForm" action="?module=store&action=add_to_cart" enctype="multipart/form-data"
                        method="post">
                        <input type="hidden" name="module" value="store">
                        <input type="hidden" name="action" value="book_detail">
                        <input type="hidden" name="isbn" value="<?php echo $getThisBook['ISBN']; ?>">
                        <input type="hidden" name="tenSach" value="<?php echo $getThisBook['tenSach']; ?>">
                        <input type="hidden" name="gia" value="<?php echo $getThisBook['gia']; ?>">
                        <input type="hidden" name="hinhAnh" value="<?php echo $getThisBook['hinhAnh']; ?>">
                        <input type="hidden" name="slug" value="<?php echo $getThisBook['slug']; ?>">
                        <div class="book-detail__action">

                            <button type="submit" name="add_to_carts" class="btn btn-db-add">
                                Thêm vào giỏ
                            </button>
                            <div class="quantity-box">
                                <button type="button" class="qty-btn minus">-</button>
                                <input type="text" name="quantity" class="qty-input" value="1" min="1"
                                    max="<?php echo $getThisBook['soLuong']; ?>" readonly>
                                <button type="button" class="qty-btn plus">+</button>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- update -->
                <!-- right -->
                <div class="book-detail_right">
                    <div class="book-detail-right__title">
                        <h1 class="book-detail-right__name">
                            <?php echo $getThisBook['tenSach'];?>
                        </h1>
                        <h2 class="book-detail-right__price"><?php echo $getThisBook['gia'];?> đ</h2>
                        <div class="book-detail-right__lylich">
                            <p class="book-detail-right__lylich--content">
                                <strong>Tác giả: </strong> <span><?php echo $getThisBook['tenTacGia'];?></span>
                            </p>
                            <p class="book-detail-right__lylich--content">
                                <strong>Nhà xuất bản: </strong> <span><?php echo $getThisBook['tenNhaXuatBan'];?></span>
                            </p>
                            <p class="book-detail-right__lylich--content">
                                <strong>kích thước: </strong> <span><?php echo $getThisBook['kichThuoc'];?></span>
                            </p>
                            <p class="book-detail-right__lylich--content">
                                <strong>Năm xuất bản: </strong> <span><?php echo $getThisBook['ngayXuatBan'];?></span>
                            </p>
                        </div>
                    </div>
                    <div class="book-detail-right__mota">
                        <p class="book-detail-right__mota--title">Nội Dung:</p>
                        <p class="book-detail-right__mota--noidung">
                            <?php echo $getThisBook['moTa'];?>
                        </p>
                    </div>
                    <div class="book-detail-chitiet">
                        <p class="book-detail-chitiet--title">Chi tiết sản phẩm</p>
                        <div class="book-detail-chitiet-wrapper">
                            <p class="book-detail-right__lylich--content chitiet-content">
                                <strong>Mã hàng: </strong> <span><?php echo $getThisBook['ISBN'];?></span>
                            </p>
                            <p class="book-detail-right__lylich--content chitiet-content">
                                <strong>Thể Loại: </strong> <span><?php echo $getThisBook['tenTheLoai'];?></span>
                            </p>
                            <p class="book-detail-right__lylich--content chitiet-content">
                                <strong>Tác giả: </strong> <span><?php echo $getThisBook['tenTacGia'];?></span>
                            </p>
                            <p class="book-detail-right__lylich--content chitiet-content">
                                <strong>Nhà xuất bản: </strong> <span><?php echo $getThisBook['tenNhaXuatBan'];?></span>
                            </p>

                            <p class="book-detail-right__lylich--content chitiet-content">
                                <strong>Số Trang: </strong> <span><?php echo $getThisBook['soTrang'];?></span>
                            </p>
                            <p class="book-detail-right__lylich--content chitiet-content">
                                <strong>Kích thước: </strong> <span><?php echo $getThisBook['kichThuoc'];?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    document.getElementById("addToCartForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch("?module=store&action=add_to_cart", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị thông báo
                    alert("✅ " + data.message + "\nSố sản phẩm trong giỏ: " + data.cartCount);

                    // Nếu bạn có hiển thị số giỏ hàng trên header:
                    const cartBadge = document.getElementById("cart-count");
                    if (cartBadge) cartBadge.textContent = data.cartCount;
                } else {
                    alert("❌ " + data.message);
                }
            })
            .catch(err => {
                console.error("Lỗi:", err);
                alert("⚠️ Lỗi kết nối đến máy chủ!");
            });
    });
    </script>


</main>

<?php
layout('footer_store');
?>