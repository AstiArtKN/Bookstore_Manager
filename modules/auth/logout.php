<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}


// $token = getSession('token_login');
if(isLogin()){
    $token = getSession('token_login');
    $removeToken = delete('token_login',"token= '$token'");

    if($removeToken){
        removeSession('token_login');
        redirect('/');
    }
    else{
        setSessionFlash('msg', 'lỗi hệ thống TOKEN. Xin vui lòng thử lại sau.');
        setSessionFlash('msg_type', 'danger');
    }
}
else{
    setSessionFlash('msg', 'lỗi hệ thống. Xin vui lòng thử lại sau.');
    setSessionFlash('msg_type', 'danger');
}