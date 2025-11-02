<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$filter = filterData('get');
if(!empty($filter)){
    $cate_id = $filter['id'];
    $checkBook = getOne("SELECT * FROM tacgiasach WHERE ID = '$cate_id'");

    if(!empty($checkBook)){
        try {
            $delStatus = delete('tacgiasach', "ID = '$cate_id'");

            if($delStatus){
                setSessionFlash('msg', 'Xoá thành công!!!');
                setSessionFlash('msg_type', 'success');
            } else {
                setSessionFlash('msg', 'Không thể xoá tác giả này!');
                setSessionFlash('msg_type', 'danger');
            }

        } catch (PDOException $e) {
            // Kiểm tra lỗi ràng buộc khoá ngoại (Integrity constraint violation)
            if ($e->getCode() == '23000') {
                setSessionFlash('msg', 'Không thể xoá vì đang có dữ liệu liên quan (ví dụ: sách của tác giả này)');
                setSessionFlash('msg_type', 'danger');
            } else {
                setSessionFlash('msg', 'Đã xảy ra lỗi trong quá trình xoá');
                setSessionFlash('msg_type', 'danger');
            }
        }

        redirect('?module=book_author&action=list');

    } else {
        setSessionFlash('msg', 'Tác giả không tồn tại!');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=book_author&action=list');
    }

} else {
    setSessionFlash('msg', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');
    setSessionFlash('msg_type', 'danger');
    redirect('?module=book_author&action=list');
}