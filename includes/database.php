<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
//echo 'Trang includes';

//lấy nhiều dòng dữ liệu
function getAll( $sql){

    global $conn;
   //$SQL = "SELECT * FROM Sach ";

   $stm = $conn -> prepare($sql);

   $stm -> execute();

   $result = $stm -> fetchAll(PDO::FETCH_ASSOC);

   return $result;
}

//đếm số dòng trả về
function getRows( $sql){

    global $conn;
   //$SQL = "SELECT * FROM Sach ";

   $stm = $conn -> prepare($sql);

   $stm -> execute();

  // $result = $stm -> fetchAll(PDO::FETCH_ASSOC);

   return $stm -> rowCount();
}

//lấy một dòng dữ liệu
function getOne( $sql){

    global $conn;
   //$SQL = "SELECT * FROM Sach ";

   $stm = $conn -> prepare($sql);

   $stm -> execute();

   $result = $stm -> fetch(PDO::FETCH_ASSOC);// khác nhau ở Fetch

   return $result;
}

//Insert dữ liệu
function insert($table, $data){
    global $conn;

    /*
     $data = [
        'ID' => 'TL29',
        'tenTheLoai' => 'manga',
        'moTa' => 'the loai truyen tranh Nhat Ban';

     ];
    */
    $keys = array_keys($data); // lấy một mảng các key
    $cot = implode(',',$keys);//biến mảng key vừa lấy ở trên thành một chuỗi và nối với nhau bằng dấu ','
    $place = ':'. implode(',:',$keys);


    $sql = "INSERT INTO $table ($cot) VALUES($place)";

     $stm = $conn -> prepare($sql);
    //data can insert
    //$dt = ['99', ''];

    //thực thi câu lệnh
    $stm -> execute($data);
     

}

//hàm hupdate
function update($table, $data, $condition = ''){
    global $conn;
    $update = '';

    foreach ($data as $key => $value){
        $update .= $key . '=:' .$key . ',';
    }
    $update = trim($update, ',');//xoá dấu phẩy cuối cùng
    if(!empty($condition)){
         $sql = "UPDATE $table SET $update WHERE $condition";
    }
    else{
        $sql = "UPDATE $table SET $update";
    }
    
    //chuẩn bị câu lệnh sql
    $tmp = $conn -> prepare($sql);

    //thực thi câu lệnh
    $tmp -> execute($data);
}

//hàm xoá dữ liệu
function delete($table, $condititon = ''){
    global $conn;
    //$sql = "DELETE FROM theLoaiSach WHERE ID = :ID";
     if(!empty($condition)){
         $sql = "DELETE FROM $table WHERE $condition";
    }
    else{
        $sql = "DELETE FROM $table";
    }
    
    $stm = $conn -> prepare($sql);
    $stm -> execute();
}

//lấy id dữ liệu mới nhất (vừa mới insert)
function lastID(){
    global $conn;

    return $conn -> lastInsertId();
}