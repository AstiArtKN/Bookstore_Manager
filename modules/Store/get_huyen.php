<?php
if (!defined('_KTHopLe')) die('Truy cập không hợp lệ');

$id_tinh = $_POST['id'] ?? 0;
$dsHuyen = getAll("SELECT id, tenQuanHuyen FROM quanhuyen WHERE tinhThanhPhoId = $id_tinh ORDER BY tenQuanHuyen");

echo json_encode($dsHuyen);
exit;