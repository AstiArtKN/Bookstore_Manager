<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$getdata = filterData('get');
$getId = $getdata['id'];

$get_mail_from_recep = getOne("SELECT nguoidung.email
FROM hoadon
INNER JOIN nguoidung ON nguoidung.ID = hoadon.nguoiDungId
WHERE hoadon.ID = '$getId';
");

$data_update = [
    'trangThaiHoaDonId' => 'TTDH6'
];
$condition = "ID='" . $getId . "'";

$updateStatus = update('hoadon', $data_update, $condition);

 if( $updateStatus){
    $emailTo = $get_mail_from_recep['email'];
    $subject = 'Đơn hàng ' . $getId . ' Đã giao thành công';
    $content = 'Cảm ơn bạn đã luôn tin tưởng và ủng hộ K-BOOKS!^^, </>';
    $content .= 'Chúc bạn có những giây phút thư giãn tuyệt vời nhất!!';
    //gửi email
    sendMail($emailTo,$subject,$content);
    redirect('?module=receipt&action=detail&id=' . $getId);
}else{
     redirect('?module=errors&action=404');
}