<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
$data = [
    'title' => 'Thêm thể loại'
];

layout('sidebar', $data);
layout('header',  $data);

if(isPost()){
    $filter = filterData();
    
    $errors = [];
    //validate firsNname
    if(empty(trim($filter['tenTacGia']))){
        $errors['tenTacGia']['require'] = 'Vui lòng nhập tên thể loại';
    }
    // }else{
        
    //validate ISBN
    
    if(empty(trim($filter['ID']))){
            $errors['ID']['require'] = 'Vui lòng nhập mã ID';
    }
    $maID = $filter['ID'];
    $checkID = getRows("SELECT * FROM tacGiaSach WHERE ID = '$maID' ");
    if( $checkID > 0){//đã tồn tại
        $errors['ID']['check'] = 'ID đã tồn tại';
    }



    if(empty($errors)){
        // print_r($filter);


        $dataInsert = [
            'ID' => $filter['ID'],
            'tenTacGia' => $filter['tenTacGia'],
            'create_at' => date('Y:m:d H:i:s')
        ];
        $insertStatus = insert('tacgiasach', $dataInsert);
        if($insertStatus){
            setSessionFlash('msg', 'thêm tác giả thành công!!!');
            setSessionFlash('msg_type', 'success');
        }else{
             setSessionFlash('msg', 'Thêm tác giả thất bại.');
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
$errorArr = getSessionFlash('errors');

?>

<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Thêm tác giả</h2>
        <?php 
            if(!empty($msg) && !empty($msg_type)){
                getMsg($msg, $msg_type); 
            }
                                
        ?>
        <a href="?module=book_author&action=list" class="book-editor__add btn"><i class="fa-solid fa-list"></i> Xem
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
                    <label for="tenTacGia">Tên tác giả</label>
                    <input type="text" id="tenTacGia" name="tenTacGia" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'tenTacGia');
                                                    }
                                                    
                                                ?>">
                    <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'tenTacGia');
                            }
                        ?>
                </div>

                <button type="submit">Thêm tác giả</button>
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