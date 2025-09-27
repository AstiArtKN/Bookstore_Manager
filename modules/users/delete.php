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
        //xoa tai khoan
        $checkToken = getRows("SELECT * FROM token_login WHERE nguoidung_id = '$user_id'");
        if($checkToken > 0){
            delete('token_login', "nguoidung_id = '$user_id'");
        }

        $checkDel = delete('nguoidung', "ID = '$user_id'");

        if($checkDel){
            setSessionFlash('msg', 'Xoá người dùng thành công!!!');
            setSessionFlash('msg_type', 'success');
            redirect('?module=users&action=list');
        }else{
             setSessionFlash('msg', 'Xoá người dùng thất bại.');
             setSessionFlash('msg_type', 'danger');
             redirect('?module=users&action=list');
        }

    }else{
        setSessionFlash('msg', 'Người dùng không tồn tại!');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=users&action=list');
    }

}  

echo $user_id;