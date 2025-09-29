<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
$data = [
    'title' => 'Chỉnh sửa sách'
];

layout('sidebar', $data);
layout('header',  $data);

$getData = filterData('get');

// print_r($getData);

if(!empty($getData['isbn'])){
    $sach_ISBN = $getData['isbn'];
    // echo $sach_ISBN;die();
    $detailBook = getOne("SELECT * FROM sach WHERE ISBN = '$sach_ISBN'");
    // print_r($detailBook);die();
    if(empty($detailBook)){
        setSessionFlash('msg', 'Sách không tồn tại!');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=books&action=list');
    }
}
else{
     setSessionFlash('msg', 'Có lỗi xảy ra. Vui lòng thử lại sau!');
     setSessionFlash('msg_type', 'danger');
     redirect('?module=books&action=list');
}

if(isPost()){
    $filter = filterData();
    $errors = [];
    //validate firsNname
    if(empty(trim($filter['tenSach']))){
        $errors['tenSach']['require'] = 'Vui lòng nhập tên sách';
    }
    // }else{
        
    // }
    //validate middleName
    if(empty(trim($filter['kichThuoc']))){
        $errors['kichThuoc']['require'] = 'Vui lòng nhập kích thước';
    }
    // }else{
        
    // }
    //validate lastName
    if(empty(trim($filter['soTrang']))){
        $errors['soTrang']['require'] = 'Vui lòng nhập số trang';
    }
    // }else{
        
    // }
    if(empty(trim($filter['soLuong']))){
        $errors['soLuong']['require'] = 'Vui lòng nhập số lượng';
    }
    // }else{
        
    // }
    if(empty(trim($filter['gia']))){
        $errors['gia']['require'] = 'Vui lòng nhập số tiền';
    }
    // }else{
        
    // }

    //validate ISBN
    if(trim($filter['ISBN']) != $detailBook['ISBN']){
         if(empty(trim($filter['ISBN']))){
            $errors['ISBN']['require'] = 'Vui lòng nhập mã ISBN';
        }
        $maISBN = $filter['ISBN'];
        $checISBN = getRows("SELECT * FROM sach WHERE ISBN = '$maISBN' ");
        if( $checISBN > 0){//đã tồn tại
            $errors['ISBN']['check'] = 'Mã sách đã tồn tại';
        }
    }
   



    if(empty($errors)){
        // print_r($filter);
        $uploadDir = './templates/uploads/';
        if(!file_exists($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['hinhAnh']['name']);

        $targetFile = $uploadDir . time() . '-' . $fileName;

        $checkmove = move_uploaded_file($_FILES['hinhAnh']['tmp_name'], $targetFile);
        $thumnail = '';
        if($checkmove){
            $thumnail = $targetFile;
        }


        $dataUpdate = [
            'ISBN' => $filter['ISBN'],
            'tenSach' => $filter['tenSach'],
            'kichThuoc' => $filter['kichThuoc'],
            'soTrang' => $filter['soTrang'],
            'soLuong' => $filter['soLuong'],
            'gia' => $filter['gia'],
            'ngayXuatBan' => $filter['ngayXuatBan'],
            'tacGiaId' => $filter['tacGiaId'],
            'theLoaiId' => $filter['theLoaiId'],
            'nhaXuatBanId' => $filter['nhaXuatBanId'],
            'hinhAnh' => $thumnail,
            'moTa' => $filter['moTa'],
            'slug' => $filter['slug'],
            'update_at' => date('Y:m:d H:i:s')
        ];

       $condition = "ISBN='" . $detailBook['ISBN'] . "'";

        $updateStatus = update('sach', $dataUpdate, $condition);
        if( $updateStatus){
            setSessionFlash('msg', 'Chỉnh sửa sách thành công!!!');
            setSessionFlash('msg_type', 'success');
        }else{
             setSessionFlash('msg', 'TChỉnh sửa sách thất bại.');
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
if(!empty($detailBook)){
    $oldData = $detailBook;
}
$errorArr = getSessionFlash('errors');

?>

<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Chỉnh sửa sách</h2>
        <?php 
            if(!empty($msg) && !empty($msg_type)){
                getMsg($msg, $msg_type); 
            }
                                
        ?>
        <a href="?module=books&action=list" class="book-editor__add btn"><i class="fa-solid fa-list"></i> Xem DS</a>
    </div>
    <div class="user-add-wrapper">
        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">

                <div class="name-area">

                    <div class="form-group">
                        <label for="ISBN">ISBN</label>
                        <input type="text" id="ISBN" name="ISBN" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'ISBN');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'ISBN');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="tenSach">Tên sách</label>
                        <input type="text" id="tenSach" name="tenSach" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'tenSach');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'tenSach');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="kichThuoc">kích thước</label>
                        <input type="text" id="kichThuoc" name="kichThuoc" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'kichThuoc');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'kichThuoc');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="soTrang">Số trang</label>
                        <input type="number" id="soTrang" name="soTrang" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'soTrang');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'soTrang');
                            }
                        ?>
                    </div>
                </div>

                <div class="contact-area">
                    <div class="form-group">
                        <label for="soLuong">Số lượng</label>
                        <input type="number" id="soLuong" name="soLuong" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'soLuong');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'soLuong');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="gia">Giá tiền</label>
                        <input type="number" id="gia" name="gia" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'gia');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'gia');
                            }
                        ?>
                    </div>
                </div>

                <div class="privite-area">
                    <div class="form-group">
                        <label for="ngayXuatBan">Ngày xuất bản</label>
                        <input type="date" id="ngayXuatBan" name="ngayXuatBan"
                            value="<?php echo !empty($oldData['ngayXuatBan']) ? date('Y-m-d', strtotime($oldData['ngayXuatBan'])) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tacGiaId">Tác giả</label>
                        <select id="tacGiaId" name="tacGiaId">
                            <?php $getQH = getAll("SELECT * FROM tacgiasach");
                                foreach($getQH as $item):
                            ?>

                            <option value="<?php echo $item['ID']?>"
                                <?php echo ($detailBook['tacGiaId'] == $item['ID']) ? 'selected' : false; ?>>
                                <?php echo $item['tenTacGia']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="theLoaiId">Thể loại</label>
                        <select id="theLoaiId" name="theLoaiId">
                            <?php $getQH = getAll("SELECT * FROM theloaisach");
                                foreach($getQH as $item):
                            ?>

                            <option value="<?php echo $item['ID']?>"
                                <?php echo ($detailBook['theLoaiId'] == $item['ID']) ? 'selected' : false; ?>>
                                <?php echo $item['tenTheLoai']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nhaXuatBanId">Nhà xuất bản</label>
                        <select id="nhaXuatBanId" name="nhaXuatBanId">
                            <?php $getQH = getAll("SELECT * FROM nhaxuatban");
                                foreach($getQH as $item):
                            ?>

                            <option value="<?php echo $item['ID']?>"
                                <?php echo ($detailBook['nhaXuatBanId'] == $item['ID']) ? 'selected' : false; ?>>
                                <?php echo $item['tenNhaXuatBan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="hinhAnh">Hình ảnh</label>
                        <input type="file" id="hinhAnh" name="hinhAnh">
                    </div>
                    <div id="preview_img-wrapper" class="form-group form-group-img-wrapper">
                        <img id="preview_img" class="img-add-book"
                            src="<?php echo !empty($detailBook['hinhAnh']) ? $detailBook['hinhAnh'] : false;  ?>"
                            alt="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="moTa">Mô tả sách</label>
                    <textarea id="moTa" name="moTa" rows="5" cols="50"
                        placeholder="Nhập mô tả sách..."><?php echo $detailBook['moTa'];?></textarea>
                </div>
                <div class="form-group">

                    <label for="slug">slug</label>
                    <textarea id="slug" name="slug" rows="1" cols="50" placeholder=""
                        readonly><?php echo $detailBook['slug'];?></textarea>
                </div>

                <button type="submit">Sửa sách</button>
            </form>
        </div>
    </div>
    <!-- script -->
    <script>
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
    </script>
    <!-- slug -->
    <script>
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
    </script>

</div>
</div>

<?php 

layout('footer');
?>