<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$getData = filterData('get');

if(!empty($getData['id'])){
    $user_id = $getData['id'];
    $checkUser = getRows("SELECT * FROM nguoidung WHERE ID = '$user_id'");

    if($checkUser > 0){
        try {
            // Xoá token nếu có
            $checkToken = getRows("SELECT * FROM token_login WHERE nguoidung_id = '$user_id'");
            if($checkToken > 0){
                delete('token_login', "nguoidung_id = '$user_id'");
            }

            // Xoá người dùng
            $checkDel = delete('nguoidung', "ID = '$user_id'");

            if($checkDel){
                setSessionFlash('msg', 'Xoá người dùng thành công!!!');
                setSessionFlash('msg_type', 'success');
            } else {
                setSessionFlash('msg', 'Xoá người dùng thất bại.');
                setSessionFlash('msg_type', 'danger');
            }

        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                // Lỗi ràng buộc khóa ngoại
                setSessionFlash('msg', 'Không thể xoá người dùng này vì có dữ liệu liên kết (ví dụ: hoá đơn, giỏ hàng, v.v.)!');
                setSessionFlash('msg_type', 'danger');
            } else {
                setSessionFlash('msg', 'Đã xảy ra lỗi khi xoá người dùng!');
                setSessionFlash('msg_type', 'danger');
            }
        }

        redirect('?module=users&action=list');

    } else {
        setSessionFlash('msg', 'Người dùng không tồn tại!');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=users&action=list');
    }

} else {
    setSessionFlash('msg', 'Thiếu thông tin người dùng!');
    setSessionFlash('msg_type', 'danger');
    redirect('?module=users&action=list');
}