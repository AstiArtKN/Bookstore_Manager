<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

// Set session

function setSession($key, $value){
    if(!empty(session_id()))
    //kiểm tra xem phiên làm việc hiện tại có 
    //id là gì và trả về id đó
    {
        $_SESSION[$key] = $value;
        return true;//set session đã thành công
    }
    return false;
}

//get session lấy ra dữ liệu từ session

function getSession($key = ''){
    if(empty($key)){
        return $_SESSION;
    }else{
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
    }

    return false;
}

//xoa session 

function removeSession($key = ''){
    if(empty($key)){
        session_destroy(); //xoá toàn bộ phiên đang có
    }else{
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);//xoá phiên này
        }
        return true;
    }
    return false;
}

//tạo session dùng chớp nhoáng tạo r dùng đi r xoá ngay

function setSessionFlash($key , $value){
    $key = $key .'FLASH';
    $rel = setSession($key, $value);

    return $rel;
}

//lấy session flash
function getSessionFlash($key){
    $key = $key .'FLASH';
    $rel = getSession($key);

    removeSession($key);

    return $rel;
}