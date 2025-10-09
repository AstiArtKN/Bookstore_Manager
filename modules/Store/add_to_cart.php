<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}


header('Content-Type: application/json'); // Phản hồi dạng JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'];
    $tenSach = $_POST['tenSach'];
    $gia = $_POST['gia'];
    $hinhAnh = $_POST['hinhAnh'];
    $quantity = (int)$_POST['quantity'];

    // Lấy giỏ hàng hiện tại từ session
    $cart = getSession('cart');
    if ($cart === false) $cart = [];

    // Lấy số lượng tồn kho thật trong DB
    $getNumBook = getOne("SELECT soLuong FROM sach WHERE ISBN = '$isbn'");
    $numBook = (int)$getNumBook['soLuong'];

    if (isset($cart[$isbn])) {
        // Nếu sách đã có trong giỏ → tăng số lượng
        $cart[$isbn]['quantity'] += $quantity;
        if ($cart[$isbn]['quantity'] > $numBook) {
            $cart[$isbn]['quantity'] = $numBook;
        }
    } else {
        // Thêm mới vào giỏ
        $cart[$isbn] = [
            'isbn' => $isbn,
            'tenSach' => $tenSach,
            'gia' => $gia,
            'hinhAnh' => $hinhAnh,
            'quantity' => min($quantity, $numBook)
        ];
    }

    // Cập nhật session
    setSession('cart', $cart);

    // Đếm tổng số sản phẩm trong giỏ
    $cartCount = 0;
    foreach ($cart as $item) {
        $cartCount += $item['quantity'];
    }

    // Trả về kết quả JSON cho AJAX
    echo json_encode([
        'success' => true,
        'message' => "Thêm sản phẩm vào giỏ hàng thành công!",
        'cartCount' => $cartCount
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ!']);
exit;
?>