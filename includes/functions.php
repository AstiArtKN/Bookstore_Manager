<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

function layout($layOutName, $data = []){
    if(file_exists(PATH_URL_TEMPLATES . '/layout' . $layOutName . '.php'))
    {
        require_once PATH_URL_TEMPLATES . '/layout' . $layOutName . '.php';
    }
}


//echo 'Trang includes';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//ham gui mail
function sendMail($emailTo, $subject, $content)
{
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function

    //Load Composer's autoloader (created by composer, not included with PHPMailer)
    //require 'vendor/autoload.php';
    //Create an instance; passing `true` enables exceptions

    $mail = new PHPMailer(true);
    //wmaf
    //dpobbaegfhul
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'khiemnguyen1350@gmail.com';                     //SMTP username
        $mail->Password   = '';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('khiemnguyen1350@gmail.com', 'Khiem-Nguyen');
        $mail->addAddress($emailTo);     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail -> CharSet = 'UTF-8';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    =  $content;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->SMTPOptions = array(
        'ssl' => [
            'verify_peer' => true,
            'verify_depth' => 3,
            'allow_self_signed' => true
            //'peer_name' => 'smtp.example.com',
            //'cafile' => '/etc/ssl/ca_cert.pem',
        ],
    );
        
        return $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

//kiểm tra phương thức post
function isPost(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        return true;
    }
    return false;
}

//phương thức get
function isGet(){
     if($_SERVER['REQUEST_METHOD'] == 'GET'){
        return true;
    }
    return false;
}
/*



*/

//lọc dữ liệu
// trước khi đưa vào database để db được sạch
function filterData($method = '')
{
    $filterArr = [];
    if(empty($method)){
        if(isGet()){
            if(!empty($_GET)){
                foreach($_GET as $key => $value){
                    $key = strip_tags($key);
                    if(is_array($value)){// trường hợp value dạng mạng thì xử lý ở đây
                        $filterArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    }
                    else{ // ko phải dạng mảng
                        $filterArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        if(isPost()){
             if(!empty($_POST)){
                foreach($_POST as $key => $value){
                    $key = strip_tags($key);
                    if(is_array($value)){// trường hợp value dạng mạng thì xử lý ở đây
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    }
                    else{ // ko phải dạng mảng
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
    }
    else{
        if($method == 'get'){
             if(!empty($_GET)){
                foreach($_GET as $key => $value){
                    $key = strip_tags($key);
                    if(is_array($value)){// trường hợp value dạng mạng thì xử lý ở đây
                        $filterArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    }
                    else{ // ko phải dạng mảng
                        $filterArr[$key] = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }else if($method == 'post'){
             if(!empty($_POST)){
                foreach($_POST as $key => $value){
                    $key = strip_tags($key);
                    if(is_array($value)){// trường hợp value dạng mạng thì xử lý ở đây
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    }
                    else{ // ko phải dạng mảng
                        $filterArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
    }
    
    return $filterArr;
}

//validate email
function validateEmail($email){
    if(!empty($email)){
        $checkEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    return $checkEmail;
}

//validate int
function validateInt($number){
     if(!empty($number)){
        $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
    }
    return $checkNumber;
}

//validate phone 0 + 9 chữ số
function isPhone($phone){
    $phoneFirst = false;
    if($phone[0] == '0')
    {
         $phoneFirst = true;
         $phone = substr($phone, 1);
    }
    $checkPhone = false;
    if(validateInt($phone)){
        $checkPhone = true;
    }

    if($checkPhone && $phoneFirst){
        return true;
    }

    return false;
}

/*xử lý mật khẩu
$pass = 1231231;
$rel = password_hash($pass, PASSWORD_DEFAULT);
$echo $rel;

$pass_usser_input = 1231231;
$rel2 = password_verify($pass_usser_input, $rel);
$echo $rel;

if($rel2){
echo 'mat khau dung';
}else{
    echo 'mat khau khong dung';
    }
*/

//sinh trường ID ngẫu nhiên
function generateRandomID($length = 20) {
    // tập ký tự cho phép
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomID = '';

    for ($i = 0; $i < $length; $i++) {
        // lấy ngẫu nhiên 1 ký tự trong $characters
        $index = random_int(0, $charactersLength - 1); // random_int an toàn mật mã học
        $randomID .= $characters[$index];
    }

    return $randomID;
}


//thông báo lỗi
function getMsg($msg, $type = 'success'){
   echo '<div class="annouce-message alert alert-' . $type . '">';
   echo $msg;
   echo '</div>';
}

//hiển thị lỗi
function formError($errors, $fieldName){
    return (!empty($errors[$fieldName])) ? '<div class="erro">' .reset($errors[$fieldName]) . ' </div>' : false;
}

//hàm hiển thị lại giá trị cũ
function oldData($oldData, $fieldName){
    return !empty($oldData[$fieldName]) ? $oldData[$fieldName] : null;
}

// redirect('http://localhost/D_A_Manager_BookStore/?module=auth&action=login')
//redirect('?module=auth&action=login')


//hàm chuyển hướng
function redirect($path, $pathFull = false){
    if($pathFull){
        header("Location: $path");
        exit();
    }else{
        $url = _HOST_URL . $path;
        header("Location: $url");
        exit();
    }
}

//hàm check login
function isLogin(){
    $checklogin = false;
    $tokenlogin = getSessionFlash('token_login');
    $checkToken_login = getOne("SELECT * FROM token_login WHERE token = '$tokenlogin'");
    if(!empty($checkToken_login)){
        $checklogin = true;
    }else{
        removeSession('token_login');
    }

    if(!$checkToken_login){
        redirect('?module=auth&action=login');
    }

    return $checklogin;
    
}