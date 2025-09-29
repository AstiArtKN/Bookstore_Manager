<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$data = [
    'title' => 'Thể loại sách'
];

layout('sidebar', $data);
layout('header',  $data);

//?module=users&action=list&slt_quyenhan=&search__user=&page=1
//phân trang trước ... 3,4,5,...sau
//1,2,3...sau -> trước 1, [2], 3,...sau
//perpage, maxpage, (offset)vị trí lấy dữu liệu và đỗ dữ liệu từ đâu



$filter = filterData();
$chuoiWhere = '';
$search__user = '';

if(isGet()){
    if(isset($filter['search__user'])){
        $search__user = $filter['search__user'];
    }
    
    if(!empty($search__user)){
        if(strpos($chuoiWhere, 'WHERE') == false){
            $chuoiWhere .= ' WHERE ';
        }
        else{
            $chuoiWhere .= ' AND ';
        }

        $chuoiWhere .= " (tenTheLoai LIKE '%$search__user%') ";
    }
}


//xử lý trang
$maxData = getRows("SELECT ID FROM theloaisach");
$perPage = 6;//so dong du lieu
$maxPage = ceil($maxData/$perPage);
$offset = 0;
$page = 1;
//getpage
if(isset($filter['page'])){
    $page = $filter['page'];
}

if($page > $maxPage || $page < 1){
    $page = 1;
}

if(isset($page)){
    $offset = ($page - 1) * $perPage;
}


// echo $chuoiWhere;
$getDetailUser = getAll("SELECT *
FROM theloaisach
$chuoiWhere 
ORDER BY ID ASC
LIMIT $offset, $perPage
");

// option html
// $GetQuyenHan = getAll("SELECT * FROM theloaisach");
//xử lý query
// $_SERVER['QUERY_STRING']; -> module=users&action=list&search__user=max&page=2
if(!empty($_SERVER['QUERY_STRING'])){
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('&page='.$page,'',$queryString);
}

// print_r($getDetailUser);
// die();

if( !empty($search__user)){
    $maxData2 = getRows("SELECT ID FROM theloaisach
     $chuoiWhere");
    $maxPage = ceil($maxData2/$perPage);
}
$msg = getSessionFlash('msg');
$msg_type = getSessionFlash('msg_type');

?>

<!-- book editor -->
<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Danh Sách thể loại</h2>
        <?php 
            if(!empty($msg) && !empty($msg_type)){
                getMsg($msg, $msg_type); 
            }
                                
        ?>
        <a href="?module=book_category&action=add" class="book-editor__add btn"><i class="fa-solid fa-plus"></i> Thêm
        </a>
    </div>
    <div class="book-editor__tool">
        <form method="GET" action="">
            <input type="hidden" name="module" value="book_category">
            <input type="hidden" name="action" value="list">
            <div class="book-editor__tool-form">
                <div class="form-wrapper">
                    <div class="form-inside__container">
                        <div class="book-editor__search">
                            <input type="search" id="search__user" name="search__user" class="textarea-timsach"
                                value="<?php echo (!empty($search__user)) ? $search__user : false; ?>" />
                        </div>
                        <div class="book-editor__btn">
                            <button type="submit" value="search" class="btn btn-timsach">
                                Tìm kiếm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- <span>Mục</span> -->
    </div>
    <!-- ---- Table ----- -->
    <div class="book-editor__table-wrapper">
        <table class="dashboard__table dashboard__table-mid book-editor_table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Tên thể loại</th>
                    <!-- <th>Mô tả</th> -->
                    <th>Chỉnh Sửa</th>
                    <th>Xoá</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($getDetailUser as $key => $item ):
                ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $item['ID']; ?></td>
                    <td class="tensach"><?php echo $item['tenTheLoai']; ?></td>

                    <td>
                        <a href="?module=book_category&action=edit&id=<?php echo $item['ID'];?>"
                            class="btn btn-warning">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </td>
                    <td>
                        <a href="?module=book_category&action=delete&id=<?php echo $item['ID'];?>"
                            class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>

                <?php endforeach;?>
            </tbody>
        </table>

    </div>
    <nav aria-label="Page navigation example" class="navpage">
        <ul class="pagination">
            <!-- xử lý nứt 'trước' -->
            <?php 
                if($page > 1):
             ?>
            <li class="page-item"><a class="page-link"
                    href="?<?php echo $queryString;?>&page=<?php echo $page-1;?>">Trước</a>
            </li>
            <?php endif; ?>
            <!-- dấu ... trước -->
            <!-- tính vị trí bắt đầu -->
            <?php $start = $page - 1;
                if($start < 1){
                    $start = 1;
                }
             ?>
            <?php 
                if($start > 1):
             ?>
            <li class="page-item"><a class="page-link"
                    href="?<?php echo $queryString;?>&page=<?php echo $page-1;?>">...</a>
            </li>
            <?php endif; 
                $end = $page + 1;
                if($end > $maxPage){
                    $end = $maxPage;
                }
            ?>

            <!-- xử lý số trang -->
            <?php for($i = $start ; $i <= $end; $i++): ?>
            <li class="page-item"><a class="page-link <?php echo ($page == $i)? 'active' : false; ?>"
                    href="?<?php echo $queryString;?>&page=<?php echo $i;?>"><?php echo $i; ?></a></li>

            <!-- dấu ... sau -->
            <!-- tính vị trí bắt đầu -->

            <?php 
                endfor;
                if($end < $maxPage):
             ?>
            <li class=" page-item"><a class="page-link"
                    href="?<?php echo $queryString;?>&page=<?php echo $page+1;?>">...</a>
            </li>
            <?php endif; ?>

            <!-- xử lý nứt 'sau' -->
            <?php 
                if($page < $maxPage):
             ?>
            <li class="page-item"><a class="page-link"
                    href="?<?php echo $queryString;?>&page=<?php echo $page+1;?>">Sau</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
</div>


<?php 

layout('footer');
?>