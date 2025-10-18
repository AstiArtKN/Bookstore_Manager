<?php
if (!defined('_KTHopLe')) die('Truy cập không hợp lệ');

$id_huyen = $_POST['id'] ?? 0;
$dsXa = getAll("SELECT id, tenXaPhuong FROM xaphuong WHERE quanHuyenId = $id_huyen ORDER BY tenXaPhuong");

echo json_encode($dsXa);
exit;