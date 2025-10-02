<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

layout('header_store');


$getData = filterData('get');

print_r($getData);

?>