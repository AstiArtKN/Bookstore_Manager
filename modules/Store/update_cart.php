<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

header('Content-Type: application/json'); // Phản hồi dạng JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'] ?? '';
    $type = $_POST['type'] ?? ''; // plus | minus

    // Lấy giỏ hàng từ session
    $cart = getSession('cart');
    if ($cart === false) $cart = [];

    if (!$isbn || !isset($cart[$isbn])) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng!']);
        exit;
    }

    // Lấy số lượng tồn kho thật từ DB
    $getNumBook = getOne("SELECT soLuong FROM sach WHERE ISBN = '$isbn'");
    $numBook = (int)$getNumBook['soLuong'];

    // Cập nhật số lượng theo thao tác
    if ($type === 'plus') {
        $cart[$isbn]['quantity']++;
        if ($cart[$isbn]['quantity'] > $numBook) {
            $cart[$isbn]['quantity'] = $numBook;
        }
    } elseif ($type === 'minus') {
        $cart[$isbn]['quantity']--;
        if ($cart[$isbn]['quantity'] < 1) {
            $cart[$isbn]['quantity'] = 1;
        }
    }

    // Cập nhật lại session
    setSession('cart', $cart);

    // Tính tổng tiền giỏ hàng
    $tongTien = 0;
    foreach ($cart as $item) {
        $tongTien += $item['gia'] * $item['quantity'];
    }

    // Trả về JSON
    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật giỏ hàng thành công!',
        'item' => [
            'quantity' => $cart[$isbn]['quantity'],
            'subtotal' => number_format($cart[$isbn]['gia'] * $cart[$isbn]['quantity']) . ' ₫'
        ],
        'cart_total' => number_format($tongTien, 0 , ' ,', '.') . ' ₫'
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ!']);
exit;
?>