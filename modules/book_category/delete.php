<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$filter = filterData('get');

if(!empty($filter)){
    $cate_id = $filter['id'];
    $checkCate = getOne("SELECT * FROM theloaisach WHERE ID = '$cate_id'");

    if(!empty($checkCate)){
        try {
            $delStatus = delete('theloaisach', "ID = '$cate_id'");

            if($delStatus){
                setSessionFlash('msg', 'Xoá thành công!!!');
                setSessionFlash('msg_type', 'success');
            } else {
                setSessionFlash('msg', 'Không thể xoá thể loại này!');
                setSessionFlash('msg_type', 'danger');
            }

        } catch (PDOException $e) {
            // Nếu bị lỗi ràng buộc khóa ngoại (FOREIGN KEY)
            if ($e->getCode() == '23000') {
                setSessionFlash('msg', 'Không thể xoá vì có sách thuộc thể loại này!');
                setSessionFlash('msg_type', 'danger');
            } else {
                setSessionFlash('msg', 'Đã xảy ra lỗi trong quá trình xoá!');
                setSessionFlash('msg_type', 'danger');
            }
        }

        redirect('?module=book_category&action=list');

    } else {
        setSessionFlash('msg', 'Thể loại không tồn tại!');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=book_category&action=list');
    }

} else {
    setSessionFlash('msg', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');
    setSessionFlash('msg_type', 'danger');
    redirect('?module=book_category&action=list');
}