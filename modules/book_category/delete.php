<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$filter = filterData('get');
if(!empty($filter)){
    $cate_id = $filter['id'];
    $checkBook = getOne("SELECT * FROM theloaisach WHERE ID = '$cate_id'");
    if(!empty($checkBook)){
        $delStatus = delete('theloaisach', "ID = '$cate_id'");
        if($delStatus){
            setSessionFlash('msg', 'Xoá thành công!!!');
            setSessionFlash('msg_type', 'success');
            redirect('?module=book_category&action=list');
        }
    }
    else{
        setSessionFlash('msg', 'Sách không tồn tại!');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=book_category&action=list');
    }
}else{
    setSessionFlash('msg', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');
    setSessionFlash('msg_type', 'danger');
    redirect('?module=book_category&action=list');
}