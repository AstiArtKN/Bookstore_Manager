<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$filter = filterData('get');
if(!empty($filter)){
    $book_isbn = $filter['isbn'];
    $checkBook = getOne("SELECT * FROM sach WHERE ISBN = '$book_isbn'");
    if (!empty($checkBook)) {
    try {
        $delStatus = delete('sach', "ISBN = '$book_isbn'");
        if ($delStatus) {
            setSessionFlash('msg', 'Xoá thành công!!!');
            setSessionFlash('msg_type', 'success');
        } else {
            setSessionFlash('msg', 'Sách không thể xoá!');
            setSessionFlash('msg_type', 'danger');
        }
    } catch (PDOException $e) {
        // Bắt lỗi ràng buộc khóa ngoại
        if ($e->getCode() == '23000') {
            setSessionFlash('msg', 'Không thể xoá vì sách này đang có trong hoá đơn!');
            setSessionFlash('msg_type', 'danger');
        } else {
            setSessionFlash('msg', 'Đã xảy ra lỗi khi xoá sách: ' . $e->getMessage());
            setSessionFlash('msg_type', 'danger');
        }
    }

    redirect('?module=books&action=list');
}

}else{
    setSessionFlash('msg', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');
    setSessionFlash('msg_type', 'danger');
    redirect('?module=books&action=list');
}