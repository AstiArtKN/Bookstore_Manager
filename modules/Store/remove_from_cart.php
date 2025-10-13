<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

header('Content-Type: application/json'); // Phản hồi dạng JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'] ?? '';

    // Lấy giỏ hàng từ session
    $cart = getSession('cart');
    if ($cart === false) $cart = [];

    if (!$isbn || !isset($cart[$isbn])) {
        echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng!']);
        exit;
    }

    // Xóa sản phẩm
    unset($cart[$isbn]);

    // Cập nhật session
    setSession('cart', $cart);

    // Kiểm tra giỏ hàng còn trống không
    if (empty($cart)) {
        echo json_encode([
            'success' => true,
            'message' => 'Đã xóa sản phẩm, giỏ hàng hiện trống!',
            'empty' => true,
            'cart_total' => '0 ₫'
        ]);
        exit;
    }

    // Tính lại tổng tiền
    $tongTien = 0;
    foreach ($cart as $item) {
        $tongTien += $item['gia'] * $item['quantity'];
    }

    echo json_encode([
        'success' => true,
        'message' => 'Xóa sản phẩm thành công!',
        'empty' => false,
        'cart_total' => number_format($tongTien,0, ' ,', '.') . ' ₫'
    ]);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ!']);
exit;
?>