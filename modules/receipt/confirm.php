<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$getdata = filterData('get');
$getId = $getdata['id'];

$data_update = [
    'trangThaiHoaDonId' => 'TTDH2'
];
$condition = "ID='" . $getId . "'";

$updateStatus = update('hoadon', $data_update, $condition);

 if( $updateStatus){
    redirect('?module=receipt&action=detail&id=' . $getId);
}else{
     redirect('?module=errors&action=404');
}