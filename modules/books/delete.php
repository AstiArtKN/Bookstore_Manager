<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$filter = filterData('get');
if(!empty($filter)){
    $book_isbn = $filter['isbn'];
    $checkBook = getOne("SELECT * FROM sach WHERE ISBN = '$book_isbn'");
    if(!empty($checkBook)){
        $delStatus = delete('sach', "ISBN = '$book_isbn'");
        if($delStatus){
            setSessionFlash('msg', 'Xoá thành công!!!');
            setSessionFlash('msg_type', 'success');
            redirect('?module=books&action=list');
        }
    }
    else{
        setSessionFlash('msg', 'Sách không tồn tại!');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=books&action=list');
    }
}else{
    setSessionFlash('msg', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');
    setSessionFlash('msg_type', 'danger');
    redirect('?module=books&action=list');
}