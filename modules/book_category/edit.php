<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
$data = [
    'title' => 'Sửa thể loại'
];

layout('sidebar', $data);
layout('header',  $data);

$getData = filterData('get');

// print_r($getData);

if(!empty($getData['id'])){
    $tlID= $getData['id'];
   
    $detailTL = getOne("SELECT * FROM theloaisach WHERE ID = '$tlID'");
    
    if(empty( $detailTL )){
        setSessionFlash('msg', 'Thể loại không tồn tại!');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=book_category&action=list');
    }
}
else{
     setSessionFlash('msg', 'Có lỗi xảy ra. Vui lòng thử lại sau!');
     setSessionFlash('msg_type', 'danger');
     redirect('?module=book_category&action=list');
}


if(isPost()){
    $filter = filterData();
    
    $errors = [];
    //validate firsNname
    if(empty(trim($filter['tenTheLoai']))){
        $errors['tenTheLoai']['require'] = 'Vui lòng nhập tên thể loại';
    }
    // }else{
        
    //validate ISBN
    
  //validate ISBN
    if(trim($filter['ID']) != $detailTL['ID']){
         if(empty(trim($filter['ID']))){
            $errors['ID']['require'] = 'Vui lòng nhập mã ID';
        }
        $maID = $filter['ID'];
        $checID = getRows("SELECT * FROM theloaisach WHERE ID = '$maID' ");
        if( $checID > 0){//đã tồn tại
            $errors['ID']['check'] = 'Mã thể loại đã tồn tại';
        }
    }



    if(empty($errors)){
        // print_r($filter);

        $dataUpdate = [
            'ID' => $filter['ID'],
            'tenTheLoai' => $filter['tenTheLoai'],
            
            'update_at' => date('Y:m:d H:i:s')
        ];

       $condition = "ID='" . $detailTL['ID'] . "'";

        $updateStatus = update('theloaisach', $dataUpdate, $condition);
        if($updateStatus){
            setSessionFlash('msg', 'Chỉnh sửa thể loại thành công!!!');
            setSessionFlash('msg_type', 'success');
        }else{
             setSessionFlash('msg', 'Sửa thể loại thất bại.');
             setSessionFlash('msg_type', 'danger');
        }
        
        
    }
    else{
        setSessionFlash('msg', 'vui lòng kiểm tra dữ liệu nhập vào.');
        setSessionFlash('msg_type', 'danger');
        setSessionFlash('oldData', $filter);
        setSessionFlash('errors', $errors);
    }

}
$msg = getSessionFlash('msg');
$msg_type = getSessionFlash('msg_type');
$oldData = getSessionFlash('oldData');
if(!empty($detailTL)){
    $oldData = $detailTL;
}
$errorArr = getSessionFlash('errors');

?>

<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Thêm thể loại</h2>
        <?php 
            if(!empty($msg) && !empty($msg_type)){
                getMsg($msg, $msg_type); 
            }
                                
        ?>
        <a href="?module=book_category&action=list" class="book-editor__add btn"><i class="fa-solid fa-list"></i> Xem
            DS</a>
    </div>
    <div class="user-add-wrapper">
        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">


                <div class="form-group">
                    <label for="ID">ID</label>
                    <input type="text" id="ID" name="ID" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'ID');
                                                    }
                                                    
                                                ?>">
                    <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'ID');
                            }
                        ?>
                </div>

                <div class="form-group">
                    <label for="tenTheLoai">Tên thể loại</label>
                    <input type="text" id="tenTheLoai" name="tenTheLoai" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'tenTheLoai');
                                                    }
                                                    
                                                ?>">
                    <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'tenTheLoai');
                            }
                        ?>
                </div>

                <button type="submit">Chỉnh sửa</button>
            </form>
        </div>
    </div>
    <!-- script -->
    <!-- <script>
        const thumbInput = document.getElementById('hinhAnh');
        const previewImg = document.getElementById('preview_img');
        const preview_img_wrapper = document.getElementById('preview_img-wrapper');

        thumbInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.setAttribute('src', e.target.result);
                    previewImg.style.display = 'block';
                    preview_img_wrapper.style.display = 'block';
                }
                reader.readAsDataURL(file);

            } else {
                previewImg.style.display = 'none';
                preview_img_wrapper.style.display = 'none';
            }
        });
    </script> -->
    <!-- slug -->
    <!-- <script>
        function createSlug(str) {
            return str.toLowerCase() // chuyển ký tự thành chữ thường
                .normalize('NFD') // chuyển ký tự có dấu thành tổ hợp: é -> e + ´
                .replace(/[\u0300-\u036f]/g, '') // xóa dấu
                .replace(/đ/g, 'd') // thay đ -> d
                .replace(/[^a-z0-9\s-]/g, '') // xóa ký tự đặc biệt
                .trim() // bỏ khoảng trắng đầu/cuối
                .replace(/\s+/g, '-') // thay khoảng trắng -> -
                .replace(/-+/g, '-'); // bỏ trùng dấu -
        }

        document.getElementById('tenSach').addEventListener('input', function() {
            const getValue = this.value;

            document.getElementById('slug').value = createSlug(getValue);
        });
    </script> -->

</div>
</div>

<?php 

layout('footer');
?>