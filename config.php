<?php
const _KTHopLe = true;

const _MODULES = 'Store';
const _ACTION = 'index';

//echo _KTHopLe;

//khai báo database
const _HOST = 'localhost';
const _DB = 'qlbansach';
const _USER = 'root';
const _PASS = '';
const _DRIVER = 'mysql';

//debug error
const _DEBUG = true; //chay chuong trinh và gặp lỗi nó sẽ hiện lên cho xem

//thiết lập host
//'http://'. $_SERVER['HTTP_HOST'];
define('_HOST_URL', 'http://'. $_SERVER['HTTP_HOST']. '/D_A_Manager_BookStore');
define('_HOST_URL_TEMPLATES', _HOST_URL .'/templates');

//thiết lập path
define('PATH_URL', __DIR__);
define('PATH_URL_TEMPLATES', PATH_URL. '/templates');