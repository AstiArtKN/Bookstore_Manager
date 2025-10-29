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
    'trangThaiHoaDonId' => 'TTDH2'
];
$condition = "ID='" . $getId . "'";

$updateStatus = update('hoadon', $data_update, $condition);

 if( $updateStatus){
    $emailTo = $get_mail_from_recep['email'];
    $subject = 'Đơn hàng ' . $getId . ' Đã được xác nhận';
    $content = 'Vui lòng chú ý điện thoại trong vài ngày tới, </>';
    $content .= 'Để kiểm tra đơn hàng vui lòng truy cập vào K-Books: </br>';
    $content .= 'Cảm ơn bạn đã tin tưởng và ủng hộ K-BOOKS!^^';
    //gửi email
    sendMail($emailTo,$subject,$content);
    redirect('?module=receipt&action=detail&id=' . $getId);
}else{
     redirect('?module=errors&action=404');
}