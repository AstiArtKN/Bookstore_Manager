-------------------------------------------------------------------------------------------------
-- Tạo database
CREATE DATABASE QLBanSach ON PRIMARY
(
    NAME = 'QLBanSach_Primary',
	FILENAME = '',
	SIZE = 5 MB,
	MAXSIZE = 10 MB,
	FILEGROWTH = 10%
)

LOG ON
(
    NAME = 'QLBanSach_Log',
	FILENAME = '',
	SIZE = 2 MB,
	MAXSIZE = 5 MB,
	FILEGROWTH = 15%
)

-------------------------------------------------------------------------------------------------
-- Sử dụng database

go
use QLBanSach 
go

-------------------------------------------------------------------------------------------------
-- Tạo bảng
-- + Phần tài khoản người dùng và người quản trị

create table NguoiDung
(
	ID varchar(100),
	tenNguoiDung varchar(200) not null,
	ho varchar(50),
	tenLot varchar(50),
	ten varchar(50),
	email varchar(100) not null,
	SDT varchar(20) not null,
	matKhau varchar(100) not null,
	ngaySinh datetime,
	gioitinh varchar(10),
	trangThai INT null,
	quyenHanId varchar(100) null,
	forgot_token varchar(500) null,
	active_token VARCHAR(500) NULL,
	create_at datetime null,

	constraint PK_NguoiDung primary key (ID),
	constraint UNI_NguoiDung unique (tenNguoiDung)
)

create table token_login
(
	ID INT AUTO_INCREMENT,
	nguoidung_id varchar(100) null,
	token varchar(200) null,

	constraint PK_tokenlog_id primary key (ID)
)

create table QuyenHan
(
	ID varchar(100),
	tenQuyenHan varchar(200) not null,
	moTa text,

	constraint PK_QuyenHan primary key (ID),
	constraint UNI_tenQuyenHan unique (tenQuyenHan)
)

-- +/ Phần tài khoản người dùng và người quản trị

-- + Phần địa chỉ

create table DiaChiGiaoHang
(
	ID varchar(10),
	diaChiCuThe varchar(500) not null,
	xaPhuongId bigint not null,

	constraint PK_DiaChiGiaoHang primary key (ID)
)

create table XaPhuong
(
	ID bigint AUTO_INCREMENT,
	tenXaPhuong varchar(200) not null,
    quanHuyenId bigint not null,

	constraint PK_XaPhuong primary key (ID)
)

create table QuanHuyen
(
	ID bigint AUTO_INCREMENT,
	tenQuanHuyen varchar(200) not null,
    tinhThanhPhoId bigint not null,

	constraint PK_QuanHuyen primary key (ID)
)

create table TinhThanhPho
(
	ID bigint AUTO_INCREMENT,
	tenTinhThanhPho varchar(200) not null,
    quocGiaId bigint not null,

	constraint PK_TinhThanhPho primary key (ID)
)

create table QuocGia
(
	ID bigint AUTO_INCREMENT,
	tenQuocGia varchar(200) not null,

	constraint PK_QuocGia primary key (ID)
)

-- +/ Phần địa chỉ

-- + Phần sách và các bảng liên quan như: Category, BookAuthor

create table Sach
(
	ISBN varchar(100),
	tenSach varchar(100) not null,
	ngonNguId varchar(10) not null,
	kichThuoc varchar(50),
	ngayXuatBan varchar(50),
	soTrang int,
	dinhDang varchar(100),
	gia float not null,
	giamGia float not null,
	soLuong bigint not null,
	theLoaiId varchar(10) not null,
	tacGiaId varchar(10) not null,
	nhaXuatBanId varchar(10) not null,
	moTa text,
	hinhAnh varchar(200),
    trangThaiId varchar(10) not null,
	luotXem bigint,
	
	constraint PK_Sach primary key(ISBN)
)

create table NgonNguSach
(
	ID varchar(10),
	tenNgonNgu varchar(100),

	constraint PK_NgonNguSach primary key(ID)
)

 create table TrangThaiSach
 (
	ID varchar(10),
	tenTrangThai varchar(100) not null,
	moTa text,

	constraint PK_TrangThaiSach primary key(ID),
	constraint UNI_tenTrangThaiSach unique (tenTrangThai)
)

create table TacGiaSach
(
	ID varchar(10),
	tenTacGia varchar(100) not null,
	email varchar(100),
	SDT varchar(20),
	moTa text,
    
	constraint PK_TacGiaSach primary key(ID)
)

create table TheLoaiSach
(
	ID varchar(10),
	tenTheLoai varchar(100) not null,
	moTa text,
    
	constraint PK_TheLoaiSach primary key(ID)
)

-- create table DongGopCuaTacGia
-- (
-- 	ISBN varchar(100),
-- 	tacGiaId varchar(10),
-- 	vaiTro varchar(100) not null,

-- 	constraint PK_DongGopCuaTacGia primary key(ISBN,tacGiaId)
-- )

 create table NhaXuatBan
 (
	ID varchar(10),
	tenNhaXuatBan varchar(100) not null,
	moTa text,
	email varchar(100) not null,
	SDT varchar(20),

	constraint PK_NhaXuatBan primary key(ID)
 )

-- +/ Phần sách và các bảng liên quan như: Category, BookAuthor

-- + Phần nhà cung cấp, nhập hàng

create table NhaCungCap
(
	ID varchar(10),
	tenNhaCungCap varchar(100) not null,
	email varchar(100) not null,
	SDT varchar(20),

	constraint PK_NhaCungCap primary key(ID)
)

CREATE TABLE NhapHang (
    ISBN VARCHAR(100),
    nhaCungCapId VARCHAR(10),
    lanNhap INT NOT NULL DEFAULT 1,
    soLuong BIGINT NOT NULL,
    gia FLOAT NOT NULL,
    ngayNhapHang DATETIME NULL,
    CONSTRAINT PK_NhapHang PRIMARY KEY(ISBN, nhaCungCapId, lanNhap)
);

DELIMITER //

CREATE TRIGGER check_lanNhap_before_insert
BEFORE INSERT ON NhapHang
FOR EACH ROW
BEGIN
    IF NEW.lanNhap <= 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Lỗi: lanNhap phải > 0';
    END IF;
END//

CREATE TRIGGER check_lanNhap_before_update
BEFORE UPDATE ON NhapHang
FOR EACH ROW
BEGIN
    IF NEW.lanNhap <= 0 THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Lỗi: lanNhap phải > 0';
    END IF;
END//

DELIMITER ;


-- +/ Phần nhà cung cấp, nhập xuất hàng

-- + Phần hóa đơn

create table HoaDon
(
	ID varchar(10),
	tenHoaDon varchar(100) not null,
	nguoiDungId varchar(100) not null,
	diaChiGiaoHangId varchar(10) not null,
	trangThaiHoaDonId varchar(10),
	ngayDatHang datetime not null,
	ngayGiaoHang datetime null,
	tongTien float not null,
    
	constraint PK_HoaDon primary key(ID)
    -- constraint CHK_ngayDatHangVaGiaoHang check(ngayDatHang <= ngayGiaoHang) -- bỏ vì MySQL ko thực thi
);

DELIMITER //

CREATE TRIGGER trg_HoaDon_CheckDates
BEFORE INSERT ON HoaDon
FOR EACH ROW
BEGIN
    IF NEW.ngayGiaoHang IS NOT NULL 
       AND NEW.ngayDatHang > NEW.ngayGiaoHang THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ngayDatHang must be <= ngayGiaoHang';
    END IF;
END//

DELIMITER ;



create table HoaDonChiTiet
(
	hoaDonId varchar(10),
	ISBN varchar(100),
	soLuongSach int not null,
	donGia float not null,
	thanhTien float not null,
	
	constraint PK_HoaDonChiTiet primary key(hoaDonId, ISBN)
 )

 create table TrangThaiHoaDon
 (
	 ID varchar(10),
	 tenTrangThai varchar(100) not null,
	 moTa text,

	 constraint PK_TrangThaiHoaDon primary key(ID),
	 constraint UNI_tenTrangThaiHD unique (tenTrangThai)
 )

-- +/ Phần hóa đơn

-------------------------------------------------------------------------------------------------
-- Các ràng buộc toàn vẹn

-- + Các ràng buộc liên quan phần người dùng và quản trị

alter table NguoiDung
add constraint FK_NguoiDung_QuyenHan foreign key (quyenHanId) references QuyenHan (ID)

--+/ các ràng buộc token_login

alter table token_login
add constraint fk_NguoiDung_Token_login foreign key (nguoidung_id) references NguoiDung(ID)

-- +/ Các ràng buộc liên quan phần người dùng và quản trị

-- + Các ràng buộc liên quan tới phần địa chỉ

alter table XaPhuong
add constraint FK_XaPhuong_QuanHuyen foreign key(quanHuyenId) references QuanHuyen(ID)

alter table QuanHuyen
add constraint FK_QuanHuyen_TinhThanhPho foreign key(tinhThanhPhoId) references TinhThanhPho(ID)

alter table TinhThanhPho
add constraint FK_TinhThanhPho_QuocGia foreign key(quocGiaId) references QuocGia(ID)

alter table DiaChiGiaoHang
add constraint FK_DiaChiGiaoHang_XaPhuong foreign key (xaPhuongId) references XaPhuong (ID)


-- +/ Các ràng buộc liên quan tới phần địa chỉ

 -- + Các ràng buộc liên quan tới sách

alter table Sach
add constraint FK_Sach_TheLoaiSach foreign key (theLoaiId) references TheLoaiSach(ID)

alter table Sach
add constraint FK_Sach_NhaXuatBan foreign key (nhaXuatBanId) references NhaXuatBan(ID)

alter table Sach
add constraint FK_Sach_NgonNguSach foreign key(ngonNguId) references NgonNguSach (ID)

alter table Sach
add constraint FK_Sach_TrangThaiSach foreign key (trangThaiId) references TrangThaiSach (ID)

alter table DongGopCuaTacGia
add constraint FK_DongGopCuaTacGia_TacGiaSach foreign key (tacGiaId) references TacGiaSach (ID)

alter table DongGopCuaTacGia
add constraint FK_DongGopCuaTacGia_Sach foreign key (ISBN) references Sach (ISBN)

 -- +/ Các ràng buộc liên quan tới sách

 ALTER TABLE sach
ADD CONSTRAINT fk_sach_tg_id
FOREIGN KEY (tacGiaId) REFERENCES tacgiasach(ID);


-- + Các ràng buộc liên quan tới nhà cung cấp, nhập hàng

 alter table NhapHang
add constraint FK_NhapHang_Sach foreign key(ISBN) references Sach(ISBN)

alter table NhapHang
add constraint FK_NhapHang_NhaCungCap foreign key(nhaCungCapId) references NhaCungCap(ID)

-- +/ Các ràng buộc liên quan tới nhà cung cấp, nhập hàng

 -- + Các ràng buộc liên quan tới phần hóa đơn

alter table HoaDon
add constraint FK_HoaDon_DiaChiGiaoHang foreign key (diaChiGiaoHangId) references DiaChiGiaoHang(ID)

alter table HoaDon
add constraint FK_HoaDon_NguoiDung foreign key (nguoiDungId) references NguoiDung(ID)

alter table HoaDon
add constraint FK_HoaDon_TrangThaiHoaDon foreign key (trangThaiHoaDonId) references TrangThaiHoaDon(ID)

alter table HoaDonChiTiet
add constraint FK_HoaDonChiTiet_Sach foreign key (ISBN) references Sach (ISBN)

alter table HoaDonChiTiet
add constraint FK_HoaDonChiTiet_HoaDon foreign key (hoaDonId) references HoaDon (ID)

 -- +/ Các ràng buộc liên quan tới phần hóa đơn

-------------------------------------------------------------------------------------------------
-- Thêm dữ liệu



-- Insert into TrangThaiNguoiDung(ID, tenTrangThai, moTa)
-- values
-- 	('TTND1', N'Chưa xác minh', N'Tài khoản đã đăng ký, nhưng chưa xác minh'),
-- 	('TTND2', N'Đã xác minh', N'Tài khoản đã đăng ký và đã xác minh'),
-- 	('TTND3', N'Đã bị khóa tạm thời', N'Tài khoản đã bị khóa do vi phạm chính sách'),
-- 	('TTND4', N'Đã bị khóa vĩnh viễn', N'Tài khoản đã bị khóa do vi phạm chính sách, khóa vĩnh viễn')



Insert into QuyenHan(ID, tenQuyenHan, moTa)
values
	('QTV', N'Quản trị viên', N'Giữ quyền cao nhất trong hệ thống'),
	('NV', N'Biên tập viên', N'Có quyền hạn giới hạn, quản lý sản phẩm, đơn hàng'),
	('KH', N'Người dùng', N'Người dùng có quyền mua và xem sản phẩm,đơn hàng')


set dateformat DMY
Insert into NguoiDung
	(
		ID, tenNguoiDung, ho, tenLot, ten, email, SDT, matKhau,
		matKhauBoSung, ngaySinh, gioitinhId, trangThaiId, quyenHanId
	)
values 
	



Insert into TheLoaiSach(ID, tenTheLoai, moTa)
values
	('TL1', N'Khoa học - Kỹ thuật', N'Sách về lĩnh vực khoa học, kỹ thuật ( thiên văn học, vật lý học, sinh vật học,... )'),
	('TL2', N'Văn học Việt Nam', N'Sách về lĩnh vực văn học của Việt Nam' ),
	('TL3', N'Kinh tế - Quản lý', N'Sách về lĩnh vực kinh tế và quản lý ( tài chính, chứng khoán, cổ phiếu,... )'),
	('TL4', N'Công nghệ thông tin', N'Sách về lĩnh vực công nghệ thông tin'),
	('TL5', N'Lịch sử - Chính trị', N'Sách về lĩnh vực lịch sử chính trị của Việt Nam và của cả thế giới'),
	('TL6', N'Thiếu nhi', N'Sách dành cho lứa tuổi thiếu nhi'),
	('TL7', N'Tử vi - Phong thủy', N''),
	('TL8', N'Văn hóa - Nghệ thuật', N''),
	('TL9', N'Phiêu lưu - Mạo hiểm', N''),
	('TL10', N'Triết học', N''),
	('TL11', N'Thể thao - Nghệ thuật', N''),
	('TL12', N'Hồi ký - Tùy bút', N''),
	('TL13', N'Trinh thám - Hình sự', N''),
	('TL14', N'Ẩm thực - Nấu ăn', N'Sách về lĩnh vực ẩm thực và nấu ăn'),
	('TL15', N'Cổ tích - Thần thoại', N''),
	('TL16', N'Kiến trúc - Xây dựng', N''),
	('TL17', N'Y học - Sức khỏe', N''),
	('TL18', N'Pháp luật', N''),
	('TL19', N'Tâm lý - Kỹ năng sống', N'Sách về lĩnh vực tâm lý, kỹ năng sống'),
	('TL20', N'Truyện cười - Tiếu lâm', N'Sách về thể loại truyền cười,...'),
	('TL21', N'Marketing - Bán hàng', N''),
	('TL22', N'Tài liệu học tập', N''),
	('TL23', N'Tiểu thuyết', N''),
	('TL24', N'Truyện teen - Tuổi học trò', N'Sách dành cho lứa tuổi teen,...'),
	('TL25', N'Ngoại ngữ', N'Sách về lĩnh vực ngoại ngữ ( tiếng Anh, tiếng Pháp, tiếng Nhật,..'),
	('TL26', N'Truyện tranh', N''),
	('TL27', N'Truyện ngắn', N''),
	('TL28', N'Văn học nước ngoài', N'')


Insert into NgonNguSach(ID, tenNgonNgu)
values 
	('NNS1', N'Tiếng Việt'),
	('NNS2', N'Tiếng Anh'),
	('NNS3', N'Tiếng Pháp'),
	('NNS4', N'Tiếng Bồ Đào Nha'),
	('NNS5', N'Tiếng Tây Ban Nha'),
	('NNS6', N'Tiếng Nhật'),
	('NNS7', N'Tiếng Italia'),
	('NNS8', N'Tiếng Ả Rập'),
	('NNS9', N'Tiếng Indonesia'),
	('NNS10', N'Tiếng Thái'),
	('NNS11', N'Tiếng Đức'),
	('NNS12', N'Tiếng Nga'),
	('NNS13', N'Tiếng Thụy Điển'),
	('NNS14', N'Tiếng Hàn')


Insert into TrangThaiSach(ID, tenTrangThai, moTa)
values 
	('TTS1', N'Đang bán', N'Sách này đang được bán'),
	('TTS2', N'Đã hết hàng', N'Sách này đã hết hàng nhưng sẽ có lại sau 1 thời gian'),
	('TTS3', N'Ngừng bán', N'Sách này đã không còn được bán nữa'),
	('TTS4', N'Đặt trước', N'Sách này đã có và sẵn sàng mở bán sau 1 thời gian nữa')



Insert into NhaXuatBan(ID, tenNhaXuatBan, moTa, email, SDT)
values 
	(
		'NXB1',
		N'NXB Hồng Đức', 
		NULL,
		N'nxbhongduc@gmail.com', NULL
	),
	(
		'NXB2',
		N'NXB Hội Nhà Văn',
		N'Nhà xuất bản Hội nhà văn là tên gọi một nhà xuất bản nhà nước thành lập năm 1957, có trụ sở hiện nay đóng tại 65, Nguyễn Du, quận Hai Bà Trưng, Hà Nội và chủ sở hữu là Hội nhà văn Việt Nam. Sản phẩm chủ yếu là nhà xuất bản là sách đa dạng các thể loại (tiểu thuyết, nghiên cứu, thơ...) và báo chí.', 
		N'nxbhoinhavan65@gmail.com', N'02438222135'
	),
	(
		'NXB3',
		N'NXB Trẻ', 
		N'là công ty TNHH một thành viên trực thuộc Thành Đoàn Thành phố Hồ Chí Minh. Thành lập 24.3.1981. Trụ sở tại TP. Hồ Chí Minh', 
		N'hopthubandoc@nxbtre.com.vn', N'02839316289'
	),
	(
		'NXB4',
		N'NXB Phụ Nữ', 
		N'NXB Phụ Nữ Là cơ quan thông tin, tuyên truyên truyền, giáo dục của Hội Liên Hiệp Phụ Nữ Việt Nam',
		N'truyenthong.nxbpn@gmail.com', N'02439710717'
	),
	(
		'NXB5',
		N'NXB Lao Động', 
		NULL,
		N'nxblaodong@yahoo.com', N'0438515380'
	),
	(
		'NXB6',
		N'NXB Tổng Hợp TPHCM', 
		NULL, 
		N'tonghop@nxbhcm.com.vn', N'02838256713'
	),
	(
		'NXB7',
		N'NXB Văn Học',
		NULL,
		N'nxbvanhoc@gmail.com', NULL
	),
	(
		'NXB8',
		N'NXB Dân Trí', 
		NULL, 
		N'nxbdantri@gmail.com', NULL
	),
	(
		'NXB9',
		N'NXB Thanh Niên', 
		NULL,
		N'thanhnien@gmail.com', NULL
	),
	(
		'NXB10',
		N'NXB Kim Đồng', 
		NULL,
		N'nxbkimdong@gmail.com', NULL
	)


Insert into NhaCungCap(ID, tenNhaCungCap, email, SDT)
values
	('NCC1', N'IPM', N'info@ipm.vn', N'02432252470'),
	('NCC2', N'Nhã Nam', N'info@nhanam.vn', NULL),
	('NCC3', N'NXB Trẻ', N'hopthubandoc@nxbtre.com.vn', N'02839316289'),
	('NCC4', N'Minh Long', N'minhlongbook@gmail.com', N'024 7300 8377'),
	('NCC5', N'Thái Hà', N'online_marketing@thaihabooks.com', NULL),
	('NCC6', N'Skybooks', N'contact.skybooks@gmail.com', NULL),
	('NCC7', N'FIRST NEWS', N'hotline@firstnews.com.vn', N'02838227979'),
	('NCC8', N'CÔNG TY TNHH MỌT SÁCH', N'motsachcompany@gamil.com', NULL),
	('NCC9', N'ZGROUP', N'zgvn@gmail.com', NULL),
	('NCC10', N'AZ Việt Nam', N'azvietnam@gmail.com', NULL),
	('NCC11', N'Nhà Xuất Bản Kim Đồng', N'nxbkimdong@gmail.com', NULL),
	('NCC12', N'QuanVanBooks', N'qvanbooks@gmail.com', NULL)


Insert into TacGiaSach(ID, tenTacGia, email, SDT, moTa)
values
	('TG1', N'ZEN', NULL, NULL, NULL),
	('TG2', N'Phan Kế Bính', NULL, NULL, NULL),
	('TG3', N'Nguyễn Anh Tú', NULL, NULL, NULL),
	('TG4', N'Nguyễn Nhật Ánh', NULL, NULL, N'Nguyễn Nhật Ánh (sinh ngày 7 tháng 5 năm 1955) là một nhà văn người Việt. Ông được biết đến qua nhiều tác phẩm văn học về đề tài tuổi mới lớn, các tác phẩm của ông rất được độc giả ưa chuộng và nhiều tác phẩm đã được chuyển thể thành phim.'),
	('TG5', N'ở Đây Zui Nè', NULL, NULL, NULL),
	('TG6', N'Nguyễn Ngọc ký', NULL, NULL, N'Nguyễn Ngọc Ký (sinh ngày 28 tháng 6 năm 1947) Là một nhà giáo Việt Nam. Từ năm lên 4 tuổi, ông bị bệnh và bị bại liệt cả hai tay, nhưng ông đã cố gắng vượt qua số phận của mình và trở thành nhà giáo ưu tú, lập kỷ lục Việt Nam "Người thầy đầu tiên của Việt Nam dùng chân để viết".'),
	('TG7', N'Rosie Nguyễn', NULL, NULL, N'tên thật là Nguyễn hoàng Nguyên(1987)'),
	('TG8', N'Từ Ninh', NULL, NULL, NULL),
	('TG9', N'Nguyễn Ngọc Thạch', NULL, NULL, NULL),
	('TG10', N'Lini Thông Minh', NULL, NULL, NULL),
	('TG11', N'Tô hoài', NULL, NULL, NULL),
	('TG12', N'Tạ huy Long', NULL, NULL, NULL),
	('TG13', N'Trác Nhã', NULL, NULL, NULL),
	('TG14', N'Lý Ái Linh', NULL, NULL, NULL),
	('TG15', N'Nguyễn Mạnh hùng', NULL, NULL, NULL)


insert into Sach(ISBN, tenSach, ngonNguId, kichThuoc, ngayXuatBan, soTrang, dinhDang,
gia, giamGia, soLuong, theLoaiId, nhaXuatBanId, moTa, trangThaiId, luotXem)
values
	('978-604-2247-33-2', N'Xanh Nửa Đêm','NNS1', '20.5 x 14.5 cm' , 2021, 460, N'Boxset', 150000, 0, 150 , 'TL26','NXB1', N'' ,'TTS1' , 0),
	('978-604-9950-56-9', N'Việt Nam Phong Tục', 'NNS1', '25 x 17 cm', 2020, 304, N'Bìa cứng', 200000, 0, 100, 'TL8','NXB2', N'', 'TTS1', 0),
	('978-604-306-114-7', N'Tuổi Trẻ Đáng Giá Bao Nhiêu?', 'NNS1', '14 x 20.5 cm', 2018, 292, N'Bìa mềm' ,80000, 0, 50, 'TL19','NXB2', N'', 'TTS2', 0),
	('978-604-1-14219-0', N'Sống Có Giá Trị - Nơi Bạn Dừng Chân', 'NNS1', '13 x 20 cm', 2018, 188, N'Bìa mềm', 62000, 0, 123, 'TL19','NXB3', N'', 'TTS3', 0),
	('978-604-1-00475-7', N'Cho Tôi Xin Một Vé Đi Tuổi Thơ - Phiên Bản Đặc Biệt', 'NNS1', '24 x 19 cm', 2021, 200, N'Bìa cứng', 465000, 0, 231, 'TL23','NXB3', N'', 'TTS4', 0),
	('978-604-1-17140-4', N'Mắt Biếc', 'NNS1', '13 x 20 cm', 2019, 300, N'Bìa mềm', 110000, 0, 34, 'TL23','NXB3', N'', 'TTS4', 0),
	('978-604-1-17093-3', N'Tôi Thấy hoa Vàng Trên Cỏ Xanh', 'NNS1', '13 x 20 cm', 2018, 378, N'Bìa mềm', 125000, 0, 54, 'TL23','NXB3', N'', 'TTS1', 0),
	('978-604-56-7740-7', N'Cẩm Nang Tuổi Dậy Thì Dành Cho Bạn Trai', 'NNS1', '14.5 x 20.5 cm', 2017, 244, N'Bìa mềm', 62000, 0, 120, 'TL19','NXB4', N'', 'TTS1', 0),
	('978-604-1-17981-1', N'9 Nguyên Tắc Làm Một Người Chồng Tốt', 'NNS1', '19 x13 x 2 cm', 2020, 500, N'Bìa mềm', 119000, 0, 24, 'TL19','NXB4', N'', 'TTS2', 0),
	('978-604-1-18901-2', N'Vui Vẻ Không Quạu Nha', 'NNS1', '12 x 10 cm', 2020, 280, N'Bìa mềm', 69000, 0, 88, 'TL27','NXB4', N'', 'TTS1', 0),
	('978-604-45-7750-6', N'Ai Là Thầy Thuốc Tốt Nhất Của Bạn? Có Thể Bạn Sẽ Giật Mình Khi Biết Sự Thật', 'NNS1', '19 x 13 cm', 2021, 144, N'Bìa mềm', 69000, 0, 110, 'TL17','NXB5', N'', 'TTS1', 0),
	('978-604-2117-56-2', N'Ta Vui Đời Sẽ Vui', 'NNS1', '14 x 20.5 cm', 2019, 217, N'Bìa mềm', 69000, 0, 325, 'TL19','NXB5', N'', 'TTS1', 0),
	('978-604-2-17811-1', N'Hạnh Phúc Thật Giản Đơn', 'NNS1', '13 x 20.5 cm', 2014, 300, N'Bìa mềm', 55000, 0, 45, 'TL19','NXB5', N'', 'TTS4', 0),
	('978-604-58-8094-4', N'Tôi Học Đại Học', 'NNS1', '14.5 x 20.5 cm', 2016, 304, N'Bìa Mềm', 88000, 0, 78, 'TL12','NXB6', N'', 'TTS2', 0),
	('978-604-9829-78-9', N'Tuổi Trẻ hoang Dại', 'NNS1', '12.5 x 20 cm', 2019, 288, N'Bìa mềm', 85000, 0, 33, 'TL27','NXB7', N'', 'TTS1', 0),
	('978-604-2-13221-4', N'Khéo Ăn Nói Sẽ Có Được Thiên Hạ - Bản Mới', 'NNS1', '14.5 x 20.5 cm', 2018, 406, N'Bìa mềm', 111000, 0, 67, 'TL19','NXB7', N'', 'TTS3', 0),
	('978-604-88-9577-8', N'Nhà Nàng ở Cạnh Nhà Tôi', 'NNS1', '13 x 20.5 cm', 2016, 352, N'Bìa mềm', 99000, 0, 44, 'TL27','NXB8', N'', 'TTS4', 0),
	('978-604-973-378-9', N'Mình Phải Sống Một Tuổi Trẻ Rực Rỡ', 'NNS1', '13 x 20.5 cm', 2018, 245, N'Bìa mềm', 98000, 0, 99, 'TL19','NXB9', N'','TTS1', 0),
	('978-604-1-00215-3', N'Dám Yêu Dám Gánh vác', 'NNS1', '20.5 x 14.5 cm', 2020, 336, N'Bìa mềm', 119000, 0, 68, 'TL19','NXB9', N'', 'TTS1', 0),
	('978-604-2-16001-8', N'Dế Mèn Phiêu Lưu Ký', 'NNS1', '24 x 32 cm', 2019, 166, N'Bìa cứng', 300000, 0, 54, 'TL24','NXB10', N'', 'TTS1', 0)


-- Insert into DongGopCuaTacGia(ISBN, tacGiaId, vaiTro)
-- values
-- 	('978-604-2247-33-2', 'TG1', N'Tác giả'),
-- 	('978-604-9950-56-9', 'TG2', N'Tác giả'),
-- 	('978-604-306-114-7', 'TG7', N'Tác giả'),
-- 	('978-604-1-14219-0', 'TG3', N'Tác giả'),
-- 	('978-604-1-00475-7', 'TG4', N'Tác giả'),
-- 	('978-604-1-17140-4', 'TG4', N'Tác giả'),
-- 	('978-604-1-17093-3', 'TG4', N'Tác giả'),
-- 	('978-604-56-7740-7', 'TG8', N'Tác giả'),
-- 	('978-604-1-17981-1', 'TG13', N'Tác giả'),
-- 	('978-604-1-18901-2', 'TG5', N'Tác giả'),
-- 	('978-604-45-7750-6', 'TG3', N'Tác giả'),
-- 	('978-604-2117-56-2', 'TG15', N'Tác giả'),
-- 	('978-604-2-17811-1', 'TG15', N'Tác giả'),
-- 	('978-604-58-8094-4', 'TG6', N'Tác giả'),
-- 	('978-604-9829-78-9', 'TG9', N'Tác giả'),
-- 	('978-604-2-13221-4', 'TG13', N'Tác giả'),
-- 	('978-604-88-9577-8', 'TG10', N'Tác giả'),
-- 	('978-604-973-378-9', 'TG10', N'Tác giả'),
-- 	('978-604-1-00215-3', 'TG14', N'Tác giả'),
-- 	('978-604-2-16001-8', 'TG11', N'Tác giả'),
-- 	('978-604-2-16001-8', 'TG12', N'Tác giả')


Insert into NhapHang(ISBN, nhaCungCapId, lanNhap, soLuong, gia, ngayNhapHang)
values
	('978-604-2247-33-2', 'NCC1', 1, 150, 110000, '2/1/2020'),
	('978-604-9950-56-9', 'NCC2', 1, 100, 165000, '2/1/2020'),
	('978-604-306-114-7', 'NCC2', 1, 50, 50000, '15/1/2020'),
	('978-604-1-14219-0', 'NCC3', 1, 123, 40000, '24/1/2020'),
	('978-604-1-00475-7', 'NCC3', 1, 231, 390000, '18/1/2020'),
	('978-604-1-17140-4', 'NCC3', 1, 34, 80000, '20/1/2020'),
	('978-604-1-17093-3', 'NCC3', 1, 54, 90000, '21/1/2020'),
	('978-604-56-7740-7', 'NCC4', 1, 120, 45000, '10/1/2020'),
	('978-604-1-17981-1', 'NCC12', 1, 24, 70000, '15/1/2020'),
	('978-604-1-18901-2', 'NCC6', 1, 88, 40000, '28/1/2020'),
	('978-604-45-7750-6', 'NCC5', 1, 110, 40000, '10/1/2020'),
	('978-604-2117-56-2', 'NCC5', 1, 325, 40000, '22/1/2020'),
	('978-604-2-17811-1', 'NCC5', 1, 45, 30000, '4/1/2020'),
	('978-604-58-8094-4', 'NCC7', 1, 78, 40000, '18/1/2020'),
	('978-604-9829-78-9', 'NCC8', 1, 33, 50000, '5/1/2020'),
	('978-604-2-13221-4', 'NCC4', 1, 67, 80000, '17/1/2020'),
	('978-604-88-9577-8', 'NCC9', 1, 44, 50000, '8/1/2020'),
	('978-604-973-378-9', 'NCC10', 1, 98, 55000, '15/1/2020'),
	('978-604-1-00215-3', 'NCC10', 1, 68, 80000, '21/1/2020'),
	('978-604-2-16001-8', 'NCC11', 1, 54, 24000, '14/1/2020')


Insert into DiaChiGiaoHang(ID, diaChiCuThe, xaPhuongId)
values
	('DC1', N'102 Nguyễn Quý Anh',  9314),
	('DC2', N'59/29 Nguyễn Sơn', 9320),
	('DC3', N'Ấp Long Phú', 8858),
	('DC4', N'Ấp Long Châu', 8858),
	('DC5', N'140 Lê Trọng Tấn', 9315),
	('DC6', N'56 Vườn Lài', 9319),
	('DC7', N'164 Vườn Lài', 9319),
	('DC8', N'177 Độc Lập', 9317),
	('DC9', N'211 Lê Thúc hoạch', 9319),
	('DC10', N'60C Văn Cao', 9319),
	('DC11', N'313 Nguyễn Sơn', 9320),
	('DC12', N'67-67A Nguyễn Sơn', 9320),
	('DC13', N'199 Thạch Lam', 9320),
	('DC14', N'545 Lũy Bán Bích', 9322),
	('DC15', N'119 Lê Trọng Tấn', 9316),
	('DC16', N'87 Nguyễn Đỗ Cung', 9315),
	('DC17', N'27 Đường C2', 9315),
	('DC18', N'1 Trường Chinh', 9315),
	('DC19', N'186 Trương Vĩnh Ký', 9315),
	('DC20', N'175 Hòa Bình',9323)


Insert into TrangThaiHoaDon(ID, tenTrangThai, moTa)
values 
	('TTDH1', N'Đang chờ xác nhận', N'Đơn đặt hàng của bạn đã được nhận và đang trong quá trình xác nhận'),
	('TTDH2', N'Đã giao hàng', N'Đơn đặt hàng của bạn đã được vận chuyển tới chỗ của bạn'),
	('TTDH3', N'Đang giao hàng', N'Đơn đặt hàng của bạn đang được vận chuyển tới chỗ của bạn'),
	('TTDH4', N'Đã hủy', N'Đơn đặt hàng của bạn đã bị hủy'),
	('TTDH5', N'Đang bị hoãn', N'Đơn đặt hàng của bạn đang bị hoãn')
	


Insert into HoaDon(ID, tenHoaDon, nguoiDungId, diaChiGiaoHangId,
			trangThaiHoaDonId, ngayDatHang, ngayGiaoHang, tongTien)
values
('HD1', N'HD1_220520210953PM', '595b5e5b-0a34-47c1-a66a-34b8c5fb0559', 'DC1', 'TTDH1', '20/07/2020', '21/07/2020', 0),
('HD2', N'HD2_220520210953PM', '595b5e5b-0a34-47c1-a66a-34b8c5fb0559', 'DC2', 'TTDH1', '21/06/2020', '22/06/2020', 0),
('HD3', N'HD3_220520210953PM', '04e835c1-7d9f-4ed3-8b55-fd4bb66ef0d0', 'DC3', 'TTDH1', '22/05/2020', '23/05/2020', 0),
('HD4', N'HD4_220520210953PM', '04e835c1-7d9f-4ed3-8b55-fd4bb66ef0d0', 'DC4', 'TTDH1', '23/04/2020', '24/04/2020', 0),
('HD5', N'HD5_220520210953PM', '595b5e5b-0a34-47c1-a66a-34b8c5fb0559', 'DC5', 'TTDH2', '24/03/2020', '25/03/2020', 0),
('HD6', N'HD6_220520210953PM', '595b5e5b-0a34-47c1-a66a-34b8c5fb0559', 'DC6', 'TTDH2', '25/02/2020', '26/02/2020', 0),
('HD7', N'HD7_220520210953PM', '04e835c1-7d9f-4ed3-8b55-fd4bb66ef0d0', 'DC7', 'TTDH2', '26/01/2020', '27/01/2020', 0),
('HD8', N'HD8_220520210953PM', '04e835c1-7d9f-4ed3-8b55-fd4bb66ef0d0', 'DC8', 'TTDH2', '20/01/2021', '21/01/2021', 0),
('HD9', N'HD9_220520210953PM', 'e2e6608c-4ce5-47a5-b6cb-4a2d00d7557d', 'DC9', 'TTDH4', '20/02/2020', '21/02/2020', 0),
('HD10', N'HD10_220520210953PM', 'e2e6608c-4ce5-47a5-b6cb-4a2d00d7557d', 'DC10', 'TTDH5', '20/03/2020', '21/03/2020', 0),
('HD11', N'HD11_220520210953PM', 'e2e6608c-4ce5-47a5-b6cb-4a2d00d7557d', 'DC11', 'TTDH1', '20/04/2020', '21/04/2020', 0),
('HD12', N'HD12_220520210953PM', 'e2e6608c-4ce5-47a5-b6cb-4a2d00d7557d', 'DC12', 'TTDH2', '20/05/2020', '21/05/2020', 0),
('HD13', N'HD13_220520210953PM', '16683d91-26db-4e87-965a-638b5f6ed0e9', 'DC13', 'TTDH1', '19/05/2020', '20/05/2020', 0),
('HD14', N'HD14_220520210953PM', '152641f8-5d76-465a-adb2-45305d435576', 'DC14', 'TTDH2', '28/04/2020', '29/04/2020', 0),
('HD15', N'HD15_220520210953PM', '16683d91-26db-4e87-965a-638b5f6ed0e9', 'DC15', 'TTDH3', '22/04/2020', '23/04/2020', 0),
('HD16', N'HD16_220520210953PM', '152641f8-5d76-465a-adb2-45305d435576', 'DC16', 'TTDH4', '21/03/2020', '22/03/2020', 0),
('HD17', N'HD17_220520210953PM', '16683d91-26db-4e87-965a-638b5f6ed0e9', 'DC17', 'TTDH5', '21/02/2020', '22/02/2020', 0),
('HD18', N'HD18_220520210953PM', '152641f8-5d76-465a-adb2-45305d435576', 'DC18', 'TTDH2', '23/03/2020', '24/03/2020', 0),
('HD19', N'HD19_220520210953PM', '595b5e5b-0a34-47c1-a66a-34b8c5fb0559', 'DC19', 'TTDH3', '24/05/2020', '25/05/2020', 0),
('HD20', N'HD20_220520210953PM', '04e835c1-7d9f-4ed3-8b55-fd4bb66ef0d0', 'DC20', 'TTDH3', '29/01/2020', '30/01/2020', 0)


Insert into HoaDonChiTiet(hoaDonId, ISBN, soLuongSach, donGia, thanhTien)
values
	('HD1', '978-604-2247-33-2', 2, 0, 0),
	('HD2', '978-604-306-114-7', 1, 0, 0),
	('HD3', '978-604-9950-56-9', 2, 0, 0),
	('HD4', '978-604-1-14219-0', 2, 0, 0),
	('HD5', '978-604-2247-33-2', 1, 0, 0),
	('HD6', '978-604-306-114-7', 1, 0, 0),
	('HD7', '978-604-9950-56-9', 4, 0, 0),
	('HD8', '978-604-1-00475-7', 10, 0, 0),
	('HD9', '978-604-1-00475-7', 2, 0, 0),
	('HD10', '978-604-2247-33-2', 15, 0, 0),
	('HD11', '978-604-1-17140-4', 5, 0, 0),
	('HD12', '978-604-1-17093-3', 6, 0, 0),
	('HD13', '978-604-56-7740-7', 2, 0, 0),
	('HD14', '978-604-1-17981-1', 4, 0, 0),
	('HD15', '978-604-1-18901-2', 1, 0, 0),
	('HD16', '978-604-45-7750-6', 1, 0, 0),
	('HD17', '978-604-1-17093-3', 1, 0, 0),
	('HD18', '978-604-2-17811-1', 1, 0, 0),
	('HD19', '978-604-58-8094-4', 1, 0, 0),
	('HD20', '978-604-1-17140-4', 12, 0, 0)
	
-------------------------------------------------------------------------------------------------
-- Truy vấn dữ liệu

-- 1. Lấy tất cả thông tin sách

select * from Sach

-- 2. Lấy thông tin sách có mã ISBN là "978-604-1-17140-4"

select * from Sach where Sach.ISBN = '978-604-1-17140-4'

-- 3. Lấy tất cả thể loại sách

select * from TheLoaiSach

-- 4. Lấy tất cả sách có tên thể loại là "Tiểu thuyết"

select B.* from Sach as B, TheLoaiSach as C
where B.theLoaiId = C.ID and C.tenTheLoai = N'Tiểu thuyết'

-- 5. Lấy những quyển sách của tác giả "Nguyễn Nhật Ánh"

select Sach.* from Sach, DongGopCuaTacGia, TacGiaSach
where Sach.ISBN = DongGopCuaTacGia.ISBN and DongGopCuaTacGia.tacGiaId = TacGiaSach.ID
	and TacGiaSach.tenTacGia = N'Nguyễn Nhật Ánh'

-- 6. Lấy tên, số trang, định dạng, tên nhà xuất bản, giá của những quyển sách của nhà xuất bản phụ nữ có giá từ 50000 đến 70000

select Sach.tenSach as N'Tên sách', Sach.soTrang as N'Số trang', Sach.dinhDang as N'Định dạng',
		NhaXuatBan.tenNhaXuatBan as N'Tên nhà xuất bản', Sach.gia as 'Giá' from Sach,NhaXuatBan
where Sach.nhaXuatBanId = NhaXuatBan.ID
	and NhaXuatBan.tenNhaXuatBan = N'NXB Phụ Nữ' and Sach.gia between 50000 and 70000

-- 7. Lấy thông tin (ISBN, tên sách, số lượng, tên nhà xuất bản, ngày phát hành) những quyến sách phát hành năm 2018

select Sach.ISBN, Sach.tenSach as N'Tên sách', Sach.soLuong as N'Số lượng', 
		NhaXuatBan.tenNhaXuatBan as N'Tên nhà xuất bản', Sach.ngayXuatBan as N'Ngày phát hành'
from Sach,NhaXuatBan
where Sach.nhaXuatBanId = NhaXuatBan.ID and year(Sach.ngayXuatBan) = 2018

-- 8. Lấy thông tin (ISBN, tên sách, số lượng, giá) của những quyển sách có giá trị trên 100.000 VNĐ

select Sach.ISBN, Sach.tenSach as N'Tên sách', Sach.soLuong as N'Số lượng', Sach.gia as N'Giá'
from Sach where Sach.gia > 100000

-- 9. Lấy thông tin (ISBN, tên sách, số lượng, tên thể loại, tên nhà xuất bản, giá) của những quyển sách có giá trị dưới 100.000 VNĐ

select Sach.ISBN, Sach.tenSach as N'Tên sách', Sach.soLuong as N'Số lượng',
	TheLoaiSach.tenTheLoai as N'Tên thể loại', NhaXuatBan.tenNhaXuatBan as N'Tên NXB', Sach.gia as N'Giá'
from Sach, TheLoaiSach, NhaXuatBan
where Sach.theLoaiId = TheLoaiSach.ID
	and Sach.nhaXuatBanId = NhaXuatBan.ID
	and Sach.gia < 100000

-- 10. lấy những quyển sách của nhà xuất bản Tổng hợp Thành phố Hồ Chí Minh

select Sach.* from Sach, NhaXuatBan
where Sach.nhaXuatBanId = NhaXuatBan.ID
	and NhaXuatBan.tenNhaXuatBan = N'NXB Tổng Hợp TPHCM'

-- 11. Lấy thông tin tác giả của sách có tên "Tôi Thấy hoa Vàng Trên Cỏ Xanh"

select TacGiaSach.* from TacGiaSach, DongGopCuaTacGia, Sach 
where TacGiaSach.ID = DongGopCuaTacGia.tacGiaId
	and DongGopCuaTacGia.ISBN = Sach.ISBN
	and Sach.tenSach = N'Tôi Thấy hoa Vàng Trên Cỏ Xanh'

-- 12. Lấy tất cả sách có ngôn ngữ là "Tiếng Việt"

select Sach.* from Sach 
where Sach.ngonNguId = (Select ID from NgonNguSach where NgonNguSach.tenNgonNgu = N'Tiếng Việt')

-- 13. Đếm số lượng sách của từng thể loại (chỉ đếm những thể loại có sách)

select TheLoaiSach.tenTheLoai as N'Tên sách', count(Sach.ISBN) as N'Số lượng sách' 
from Sach, TheLoaiSach where Sach.theLoaiId = TheLoaiSach.ID 
group by TheLoaiSach.ID, TheLoaiSach.tenTheLoai

-- 14. Đếm số lượng sách của từng thể loại và sắp xếp giảm dần theo số lượng (chỉ đếm những thể loại có sách)

select TheLoaiSach.tenTheLoai as N'Tên sách', count(Sach.ISBN) as N'Số lượng sách' 
from Sach, TheLoaiSach where Sach.theLoaiId = TheLoaiSach.ID 
group by TheLoaiSach.ID, TheLoaiSach.tenTheLoai
order by count(Sach.ISBN) desc

-- 15. Đếm số lượng sách của từng ngôn ngữ (chỉ đếm những ngôn ngữ có sách)

select NgonNguSach.tenNgonNgu as N'Tên ngôn ngữ', count(Sach.ISBN) as N'Số lượng sách' 
from Sach, NgonNguSach 
where Sach.ngonNguId = NgonNguSach.ID 
group by NgonNguSach.ID, NgonNguSach.tenNgonNgu

-- 16. Đếm số lượng sách của từng ngôn ngữ (đếm tất cả ngôn ngữ)

select BKLang.tenNgonNgu as N'Tên ngôn ngữ', 
	(select count(Sach.ISBN) from Sach where Sach.ngonNguId = BKLang.ID) as N'Số lượng sách'
from NgonNguSach as BKLang

-- 17. Lấy mã ISBN, tên sách của những sách có số trang hơn 200

select Sach.ISBN, Sach.tenSach from Sach where Sach.soTrang > 200

-- 18. Lấy thông tin địa chỉ ( địa chỉ cụ thể, tên xã/phường, tên huyện/quận, tên tỉnh/thành phố và tên quốc gia) đang có trong bảng DiaChiGiaoHang

select DiaChiGiaoHang.diaChiCuThe as N'Địa chỉ cụ thể', XaPhuong.tenXaPhuong as N'Xã/Phường', QuanHuyen.tenQuanHuyen as N'Huyện/Quận',
	TinhThanhPho.tenTinhThanhPho as N'Tỉnh/Thành phố', QuocGia.tenQuocGia as N'Quốc gia'
from DiaChiGiaoHang, XaPhuong, QuanHuyen, TinhThanhPho, QuocGia
where DiaChiGiaoHang.xaPhuongId = XaPhuong.ID and XaPhuong.quanHuyenId = QuanHuyen.ID
	and QuanHuyen.tinhThanhPhoId = TinhThanhPho.ID and TinhThanhPho.quocGiaId = QuocGia.ID

-- 19. Cập nhật đơn giá trong hóa đơn chi tiết ( đơn giá = giá gốc - số tiền được giảm )

update HoaDonChiTiet 
set donGia = (select Sach.gia - Sach.giamGia from Sach where Sach.ISBN = HoaDonChiTiet.ISBN)

-- 20. Cập nhật thành tiền trong hóa đơn chi tiết ( thành tiền = đơn giá * số lượng )

update HoaDonChiTiet set thanhTien = donGia * soLuongSach

-- 21. Cập nhật tổng tiền cho tất cả hóa đơn

update HoaDon set tongTien = (select sum(HoaDonChiTiet.thanhTien) 
									from HoaDonChiTiet where HoaDon.ID = HoaDonChiTiet.hoaDonId)

-- 22. Đặt thời gian giao hàng là NULL đối với cái đơn hàng đã bị hủy

update HoaDon 
set ngayGiaoHang = NULL 
where trangThaiHoaDonId = (select ID from TrangThaiHoaDon where tenTrangThai = N'Đã hủy')

-- 23. Lấy thông tin đơn hàng có mã hóa đơn là HD5

select HoaDon.* from HoaDon, HoaDonChiTiet 
where HoaDon.ID = HoaDonChiTiet.hoaDonId and HoaDon.ID = 'HD5'

-- 24. Lấy thông tin đơn hàng của khách hàng có tên người dùng là 'caotri'

select HoaDon.* from HoaDon, HoaDonChiTiet, NguoiDung
where HoaDonChiTiet.hoaDonId = HoaDon.ID
	and HoaDon.nguoiDungId = NguoiDung.ID
	and NguoiDung.tenNguoiDung = 'caotri'

-- 25. Lấy thông tin đơn hàng đã được tạo vào ngày 20/01/2021

set dateformat dmy

select HoaDon.* from HoaDon,HoaDonChiTiet
where HoaDon.ID = HoaDonChiTiet.hoaDonId and HoaDon.ngayDatHang = '20/01/2021'

-- 26. Lấy tất cả đơn hàng có tên sách "Xanh Nửa Đêm"

select I.* from HoaDon as I, HoaDonChiTiet as ID, Sach as B
where ID.hoaDonId = I.ID and B.ISBN = ID.ISBN and B.tenSach = N'Xanh Nửa Đêm'

-- 27. Lấy tất cả đơn hàng có tổng tiền trên 500000 VNĐ

select * from HoaDon where tongTien > 500000

-- 28. Lấy tất cả đơn hàng mà trong đó có ít nhất 1 sản phẩm (sách) với thành tiền trên 150000

select HoaDon.* from HoaDon, HoaDonChiTiet
where HoaDonChiTiet.hoaDonId = HoaDon.ID and HoaDonChiTiet.thanhTien > 150000

-- 29. Lấy tất cả sách đã hết hàng

select * from Sach, TrangThaiSach 
where Sach.trangThaiId = TrangThaiSach.ID
	and TrangThaiSach.tenTrangThai = N'Đã hết hàng'

-- 30. Lấy tất cả đơn hàng đã bị hủy

select I.* from HoaDon as I, TrangThaiHoaDon as ISTate
where I.trangThaiHoaDonId = ISTate.ID and ISTate.tenTrangThai = N'Đã hủy'

-- 31. Lấy thông tin (ID, tên đơn hàng, địa chỉ, tổng tiền) tất cả đơn hàng có trạng thái là "Đã giao hàng"

select I.ID, I.tenHoaDon as N'Tên hóa đơn', 
	(select DiaChiGiaoHang.diaChiCuThe + ' - ' + XaPhuong.tenXaPhuong + ' - ' + QuanHuyen.tenQuanHuyen + ' - '
		+ TinhThanhPho.tenTinhThanhPho + ' - ' + QuocGia.tenQuocGia
	from DiaChiGiaoHang, XaPhuong, QuanHuyen, TinhThanhPho, QuocGia
	where DiaChiGiaoHang.xaPhuongId = XaPhuong.ID and XaPhuong.quanHuyenId = QuanHuyen.ID
		and QuanHuyen.tinhThanhPhoId = TinhThanhPho.ID and TinhThanhPho.quocGiaId = QuocGia.ID and DiaChiGiaoHang.ID = I.diaChiGiaoHangId) as N'Địa chỉ',
	I.tongTien as N'Tổng tiền'
from HoaDon as I, TrangThaiHoaDon as ISTate
where I.trangThaiHoaDonId = ISTate.ID and ISTate.tenTrangThai = N'Đã giao hàng'

-- 32. Cho biết tổng tiền của hóa đơn cao nhất và thấp nhất

select max(tongTien) as N'Tổng tiền cao nhất', min(tongTien) as N'Tổng tiền thấp nhất'
from HoaDon

-- 33. Lấy thông tin những hóa đơn có tổng tiền cao nhất

select *
from HoaDon where tongTien = (select max(tongTien) from HoaDon)

-- 34. Cho biết thông tin sách chưa có người mua

select * from Sach 
where ISBN not in (select distinct HoaDonChiTiet.ISBN 
					from HoaDon, HoaDonChiTiet 
					where HoaDon.ID = HoaDonChiTiet.hoaDonId)

-- 35. Tìm hóa đơn đã mua sản phẩm "Tôi Thấy hoa Vàng Trên Cỏ Xanh" có số lượng trên 5

select * from HoaDon 
where ID in (select distinct HoaDonChiTiet.hoaDonId 
			from HoaDonChiTiet, Sach 
			where HoaDonChiTiet.ISBN = Sach.ISBN and Sach.tenSach = N'Tôi Thấy hoa Vàng Trên Cỏ Xanh'
				and HoaDonChiTiet.soLuongSach > 5)

-- 36. Tìm hóa đơn có sản phẩm "Xanh Nửa Đêm" hoặc sản phẩm "Mắt Biếc" có số lượng mua từ 3 đến 8

select * from HoaDon 
where ID in (select distinct HoaDonChiTiet.hoaDonId 
			from HoaDonChiTiet, Sach 
			where HoaDonChiTiet.ISBN = Sach.ISBN and Sach.tenSach in (N'Xanh Nửa Đêm',N'Mắt Biếc')
				and HoaDonChiTiet.soLuongSach between 3 and 8)

-- 37. Lấy tên, số trang, định dạng, tên nhà xuất bản, giá của những cuốn sách có giá cao nhất

select Sach.tenSach as N'Tên sách', Sach.soTrang as N'Số trang', Sach.dinhDang as N'Định dạng',
		NhaXuatBan.tenNhaXuatBan as N'Tên nhà xuất bản', Sach.gia as 'Giá'
from Sach, NhaXuatBan 
where Sach.nhaXuatBanId = NhaXuatBan.ID and gia = (select max(gia) from Sach)

-- 38. Lấy thông tin của 5 cuốn sách có giá cao nhất (sắp xếp giảm dần)

select top 5 * from Sach order by Sach.gia desc

-- 39. In ra tổng tiền mà trong tháng 3 năm 2020 đã bán được (là những hóa đơn có trạng thái là "Đã giao hàng")

select sum(HoaDon.tongTien) as N'Tổng tiền 3/2020' from HoaDon, TrangThaiHoaDon 
where HoaDon.trangThaiHoaDonId = TrangThaiHoaDon.ID 
	and year(HoaDon.ngayGiaoHang) = 2020 and month(HoaDon.ngayGiaoHang) = 3
	and TrangThaiHoaDon.tenTrangThai = N'Đã giao hàng'

-- 40. Xuất tổng tiền của các tháng trong bảng Hóa đơn của năm 2020 ( chỉ tính những hóa đơn có trạng thái là "Đã giao hàng" )

select month(HoaDon.ngayGiaoHang) as N'Tháng', sum(HoaDon.tongTien) as N'Tổng tiền'
from HoaDon, TrangThaiHoaDon 
where  HoaDon.trangThaiHoaDonId = TrangThaiHoaDon.ID and TrangThaiHoaDon.tenTrangThai = N'Đã giao hàng'
	and year(HoaDon.ngayGiaoHang) = 2020 
group by month(HoaDon.ngayGiaoHang)

-------------------------------------------------------------------------------------------------
-- View

-- 1. Tạo view lấy thông tin của những cuốn sách. Thông tin bao gồm: Tên sách, Tên ngôn ngữ, Số trang, Định dạng, Giá, Tên thể loại, Tên nhà xuất bản

go

create view vw_HienThiThongTinNhungCuonSach
as
	select Sach.ISBN, Sach.tenSach as N'Tên sách',  NgonNguSach.tenNgonNgu as N'Tên ngôn ngữ',
		Sach.soTrang as N'Số trang', Sach.dinhDang as N'Định dạng', Sach.gia as N'Giá',
		TheLoaiSach.tenTheLoai as N'Tên thể loại', NhaXuatBan.tenNhaXuatBan as N'Tên NXB'
	from Sach, NgonNguSach, NhaXuatBan, TheLoaiSach
	where Sach.ngonNguId = NgonNguSach.ID and Sach.nhaXuatBanId = NhaXuatBan.ID
		and Sach.theLoaiId = TheLoaiSach.ID

go

select * from vw_HienThiThongTinNhungCuonSach

-- 2. Tạo view lấy thông tin của những cuốn sách có trạng thái là "Đang bán". Thông tin bao gồm: Tên sách, Tên ngôn ngữ, Số trang, Định dạng, Giá, Tên thể loại, Tên nhà xuất bản

go

create view vw_HienThiThongTinNhungCuonSach_TrangThaiDangBan
as
	select Sach.ISBN, Sach.tenSach as N'Tên sách',  NgonNguSach.tenNgonNgu as N'Tên ngôn ngữ',
		Sach.soTrang as N'Số trang', Sach.dinhDang as N'Định dạng', Sach.gia as N'Giá',
		TheLoaiSach.tenTheLoai as N'Tên thể loại', NhaXuatBan.tenNhaXuatBan as N'Tên NXB'
	from Sach, NgonNguSach, NhaXuatBan, TheLoaiSach, TrangThaiSach
	where Sach.ngonNguId = NgonNguSach.ID and Sach.nhaXuatBanId = NhaXuatBan.ID
		and Sach.trangThaiId = TrangThaiSach.ID and Sach.theLoaiId = TheLoaiSach.ID
		and TrangThaiSach.tenTrangThai = N'Đang bán'

go

select * from vw_HienThiThongTinNhungCuonSach_TrangThaiDangBan

-- 3. Tạo view lấy thông tin của 20 cuốn sách và sắp xếp giảm dần theo giá tiền. Thông tin bao gồm: Tên sách, Tên ngôn ngữ, Số trang, Định dạng, Giá, Tên thể loại, Tên nhà xuất bản

go

create view vw_HienThiThongTinNhungCuonSach_SapXepGiamTheoGiaTien
as
	select top 20 Sach.ISBN, Sach.tenSach as N'Tên sách', NgonNguSach.tenNgonNgu as N'Tên ngôn ngữ',
		Sach.soTrang as N'Số trang', Sach.dinhDang as N'Định dạng', Sach.gia as N'Giá',
		TheLoaiSach.tenTheLoai as N'Tên thể loại', NhaXuatBan.tenNhaXuatBan as N'Tên NXB'
	from Sach, NgonNguSach, NhaXuatBan, TheLoaiSach
	where Sach.ngonNguId = NgonNguSach.ID and Sach.nhaXuatBanId = NhaXuatBan.ID
		and Sach.theLoaiId = TheLoaiSach.ID
	order by Sach.gia desc

go

select * from vw_HienThiThongTinNhungCuonSach_SapXepGiamTheoGiaTien

-- 4. Tạo view lấy thông tin địa chỉ ( địa chỉ cụ thể, tên xã/phường, tên huyện/quận, tên tỉnh/thành phố và tên quốc gia) đang có trong bảng DiaChiGiaoHang

go

create view vw_HienThiNhungThongTinDiaChi
as
	select DiaChiGiaoHang.diaChiCuThe as N'Địa chỉ cụ thể', XaPhuong.tenXaPhuong as N'Xã/Phường', QuanHuyen.tenQuanHuyen as N'Huyện/Quận',
		TinhThanhPho.tenTinhThanhPho as N'Tỉnh/Thành phố', QuocGia.tenQuocGia as N'Quốc gia'
	from DiaChiGiaoHang, XaPhuong, QuanHuyen, TinhThanhPho, QuocGia
	where DiaChiGiaoHang.xaPhuongId = XaPhuong.ID and XaPhuong.quanHuyenId = QuanHuyen.ID
		and QuanHuyen.tinhThanhPhoId = TinhThanhPho.ID and TinhThanhPho.quocGiaId = QuocGia.ID

go

select * from vw_HienThiNhungThongTinDiaChi

-- 5. Tạo view lấy thông tin (ID, tên người dùng, họ tên người đặt hàng, tên đơn hàng, địa chỉ, tổng tiền) tất cả đơn hàng

go

create view vw_HienThiTatCaHoaDon
as
	select I.ID, I.tenHoaDon as N'Tên hóa đơn', 
		U.tenNguoiDung as N'Tên người dùng của người đặt hàng',
		U.ho + ' ' + U.tenLot + ' ' + U.ten as N'Họ tên người đặt hàng',
		(select DiaChiGiaoHang.diaChiCuThe + ' - ' + XaPhuong.tenXaPhuong + ' - ' + QuanHuyen.tenQuanHuyen + ' - '
			+ TinhThanhPho.tenTinhThanhPho + ' - ' + QuocGia.tenQuocGia
		from DiaChiGiaoHang, XaPhuong, QuanHuyen, TinhThanhPho, QuocGia
		where DiaChiGiaoHang.xaPhuongId = XaPhuong.ID and XaPhuong.quanHuyenId = QuanHuyen.ID
			and QuanHuyen.tinhThanhPhoId = TinhThanhPho.ID and TinhThanhPho.quocGiaId = QuocGia.ID and DiaChiGiaoHang.ID = I.diaChiGiaoHangId) as N'Địa chỉ',
		I.tongTien as N'Tổng tiền'
	from HoaDon as I, NguoiDung as U
	where I.nguoiDungId = U.ID

go

select * from vw_HienThiTatCaHoaDon

-- 6. Tạo view lấy thông tin (ID, tên người dùng, họ tên người đặt hàng, tên đơn hàng, địa chỉ, tổng tiền) của 20 đơn hàng có trạng thái là "Đã giao hàng" và sắp xếp giảm dần theo tổng tiền

go

create view vw_HienThiTatCaHoaDon_TTDaGiaoHang_SapXepGiamDanTheoTongTien
as
	select top 20 I.ID, I.tenHoaDon as N'Tên hóa đơn', 
		U.tenNguoiDung as N'Tên người dùng của người đặt hàng',
		U.ho + ' ' + U.tenLot + ' ' + U.ten as N'Họ tên người đặt hàng',
		(select DiaChiGiaoHang.diaChiCuThe + ' - ' + XaPhuong.tenXaPhuong + ' - ' + QuanHuyen.tenQuanHuyen + ' - '
			+ TinhThanhPho.tenTinhThanhPho + ' - ' + QuocGia.tenQuocGia
		from DiaChiGiaoHang, XaPhuong, QuanHuyen, TinhThanhPho, QuocGia
		where DiaChiGiaoHang.xaPhuongId = XaPhuong.ID and XaPhuong.quanHuyenId = QuanHuyen.ID
			and QuanHuyen.tinhThanhPhoId = TinhThanhPho.ID and TinhThanhPho.quocGiaId = QuocGia.ID and DiaChiGiaoHang.ID = I.diaChiGiaoHangId) as N'Địa chỉ',
		I.tongTien as N'Tổng tiền'
	from HoaDon as I, TrangThaiHoaDon as IState, NguoiDung as U
	where I.trangThaiHoaDonId = IState.ID and I.nguoiDungId = U.ID and IState.tenTrangThai = N'Đã giao hàng'
	order by I.tongTien desc

go

select * from vw_HienThiTatCaHoaDon_TTDaGiaoHang_SapXepGiamDanTheoTongTien


--/View

-------------------------------------------------------------------------------------------------
--Thủ tục

-- 1. Tăng lượt xem sách lên 1, truyền vào mã ISBN

go

create proc sp_TangLuotXem @ISBN varchar(100)
as 
	begin 
		if not exists (select * from Sach where ISBN = @ISBN)
			print N'Không tồn tại sách có mã này'
		else
			begin
				update Sach set luotXem = luotXem + 1 where ISBN = @ISBN
				print N'Đã tăng views thành công'
			end
	end

go

exec sp_TangLuotXem '9708-604-2117-56-2' -- Không tồn tại sách có mã này

exec sp_TangLuotXem '978-604-2117-56-2' -- Tăng lượt xem thành công

-- 2. Cập nhật đơn giá trong hóa đơn chi tiết

go

create proc sp_CapNhatDonGia_HoaDonChiTiet
as
	update HoaDonChiTiet 
	set donGia = (select Sach.gia - Sach.giamGia from Sach where Sach.ISBN = HoaDonChiTiet.ISBN)

go

exec sp_CapNhatDonGia_HoaDonChiTiet

-- 3. Cập nhật thành tiền trong hóa đơn chi tiết

go

create proc sp_CapNhatThanhTien_HoaDonChiTiet
as
	update HoaDonChiTiet set thanhTien = donGia * soLuongSach

go

exec sp_CapNhatThanhTien_HoaDonChiTiet

-- 4. Cập nhật tổng tiền cho tất cả hóa đơn

go

create proc sp_CapNhatTongTien_HoaDon
as
	update HoaDon 
	set tongTien = (select sum(HoaDonChiTiet.thanhTien) 
					from HoaDonChiTiet where HoaDon.ID = HoaDonChiTiet.hoaDonId)

go

exec sp_CapNhatTongTien_HoaDon

-- 5. Đặt thời gian giao hàng là NULL đối với cái đơn hàng đã bị hủy

go

create proc sp_DatNgayGiaoHangBangNull_HoaDon
as
	update HoaDon set ngayGiaoHang = NULL 
	where trangThaiHoaDonId = (select ID from TrangThaiHoaDon where tenTrangThai = N'Đã hủy')

go

exec sp_DatNgayGiaoHangBangNull_HoaDon

-- 6. Đếm số lượng sách của tác giả bất kỳ và có trạng thái là "Đang bán". Tham số truyền vào là tên của tác giả.

go
create proc sp_DemSoLuongSachDangBan_TheoTenTacGia @tenTacGia nvarchar(100), @soLuongSach int output
as
	set @soLuongSach = (select count(*) from Sach, DongGopCuaTacGia, TacGiaSach, TrangThaiSach 
		where Sach.ISBN = DongGopCuaTacGia.ISBN and TacGiaSach.ID = DongGopCuaTacGia.tacGiaId
			and Sach.trangThaiId = TrangThaiSach.ID and TacGiaSach.tenTacGia = @tenTacGia
			and TrangThaiSach.tenTrangThai = N'Đang bán')

go

declare @SLSach int
declare @tenTacGia nvarchar(100)
set @tenTacGia = N'Nguyễn Nhật Ánh'
exec sp_DemSoLuongSachDangBan_TheoTenTacGia @tenTacGia, @SLSach output

print N'Số lượng sách đang bán của tác giả "' + @tenTacGia + N'" là: ' + convert(varchar(20), @SLSach)

-- 7. Đếm số lượng sách của nhà xuất bản bất kỳ và có giá trên 100000 VND. Tham số truyền vào là tên của nhà xuất bản

go
create proc sp_DemSoLuongSachCoGiaTren100000_TheoTenNXB @tenNhaXuatBan nvarchar(100), @soLuongSach int output
as
	set @soLuongSach = (select count(*) from Sach, NhaXuatBan where Sach.nhaXuatBanId = NhaXuatBan.ID 
	and NhaXuatBan.tenNhaXuatBan = @tenNhaXuatBan and Sach.gia > 100000)

go

declare @SLSach2 int
declare @tenNhaXuatBan nvarchar(100)
set @tenNhaXuatBan = N'NXB Trẻ'
exec sp_DemSoLuongSachCoGiaTren100000_TheoTenNXB @tenNhaXuatBan, @SLSach2 output

print N'Số lượng sách đang bán của nhà xuất bản "' + @tenNhaXuatBan + N'" là: ' + convert(varchar(20), @SLSach2)

-- 8. Tính doanh thu của năm bất kỳ. Tham số truyền vào là năm

go
create proc sp_TinhDoanhThu_TheoNam @nam int, @doanhThu float output
as
	set @doanhThu = (select sum(tongTien) from HoaDon, TrangThaiHoaDon where HoaDon.trangThaiHoaDonId = TrangThaiHoaDon.ID 
	and year(ngayDatHang) = @nam and TrangThaiHoaDon.tenTrangThai = N'Đã giao hàng')

go

declare @doanhThu float
declare @nam int
set @nam = 2020
exec sp_TinhDoanhThu_TheoNam @nam, @doanhThu output

print N'Doanh thu của năm ' + convert(varchar(50), @nam) + ' là: ' + ltrim(str(@doanhThu, 20, 5))

-- 9. Đếm số lượng những nhà cung cấp đã thực hiện nhập hàng

go
create proc sp_DemSoLuongNCCDaTHNhapHang @soLuongNhaCungCap int output
as
	set @soLuongNhaCungCap = (select count(*) from NhaCungCap where ID in (Select distinct nhaCungCapId from NhapHang))

go

declare @SLNCC int
exec sp_DemSoLuongNCCDaTHNhapHang @SLNCC output

print N'Số lượng nhà cung cấp đã thực hiện nhập hàng: ' + convert(nvarchar(20), @SLNCC)

-- 10. Đếm số lượng hóa đơn của người dùng có địa chỉ có email và tổng tiền nằm trong khoảng bất kỳ. Tham số truyền vào bao gồm địa chỉ email, giá cao nhất, giá thấp nhất.

go
create proc sp_DemSoLuongHoaDon_TheoEmailVaPhamViTongTien @email varchar(200), @giaThapNhat float, @giaCaoNhat float, @SoLuongHoaDon int output
as
	set @SoLuongHoaDon = (select count(*) from HoaDon, NguoiDung where HoaDon.nguoiDungId = NguoiDung.ID
		and (tongTien between @giaThapNhat and @giaCaoNhat) and NguoiDung.email = @email)

go

declare @SLHoaDon int
declare @diaChiEmail varchar(200), @giaThapNhat float, @giaCaoNhat float
set @diaChiEmail = 'nguyenkhiem239058@gmail.com'
set @giaThapNhat = 80000
set @giaCaoNhat = 150000
exec sp_DemSoLuongHoaDon_TheoEmailVaPhamViTongTien @diaChiEmail, @giaThapNhat, @giaCaoNhat, @SLHoaDon output

print N'Số lượng hóa đơn của người mua có địa chỉ email "' + @diaChiEmail 
	+ N'" và tổng tiền nằm trong khoảng ' + ltrim(str(@giaThapNhat, 20, 5)) + ' - ' 
	+ ltrim(str(@giaCaoNhat, 20, 5)) + ' là: ' + convert(varchar(20), @SLHoaDon)

-------------------------------------------------------------------------------------------------
-- Hàm

-- 1. Lấy tất cả thông tin sách

go

create function f_LayThongTinNhungCuonSach()
returns table
as
	return (select * from Sach)

go

select * from f_LayThongTinNhungCuonSach()

-- 2. Lấy thông tin của 20 cuốn sách và sắp xếp giảm dần theo lượt xem

go

create function f_Lay20ThongTinSach_SapXepGiamDanTheoLuotXem()
returns table
as
	return (select top 20 * from Sach order by luotXem desc)

go

select * from f_Lay20ThongTinSach_SapXepGiamDanTheoLuotXem()

-- 3. Lấy thông tin của sách có mã ISBN là "978-604-2-16001-8"

go

create function f_LayThongTinSach_TheoISBN(@ISBN varchar(100))
returns table
as
	return (select * from Sach where ISBN = @ISBN)

go

select * from f_LayThongTinSach_TheoISBN('978-604-2-16001-8')

-- 4. Lấy thông tin (ISBN, tên sách, số lượng, tên thể loại, tên nhà xuất bản) của những quyển sách với tham số truyền vào là tên nhà xuất bản

go

create function f_LayThongTinNhungCuonSach_TheoTenNXB(@tenNhaXuatBan nvarchar(100))
returns table
as
	return (select Sach.ISBN, Sach.tenSach as N'Tên sách', Sach.soLuong as N'Số lượng',
			TheLoaiSach.tenTheLoai as N'Tên thể loại', NhaXuatBan.tenNhaXuatBan as N'Tên NXB'
		from Sach, TheLoaiSach, NhaXuatBan
		where Sach.theLoaiId = TheLoaiSach.ID
			and Sach.nhaXuatBanId = NhaXuatBan.ID
			and NhaXuatBan.tenNhaXuatBan = @tenNhaXuatBan)

go

select * from f_LayThongTinNhungCuonSach_TheoTenNXB(N'NXB Trẻ')

-- 5. Lấy thông tin (ISBN, tên sách, số lượng, tên thể loại, tên nhà xuất bản) của những quyển sách với tham số truyền vào là tên thể loại

go

create function f_LayThongTinNhungCuonSach_TheoTenTheLoai(@tenTheLoai nvarchar(100))
returns table
as
	return (select Sach.ISBN, Sach.tenSach as N'Tên sách', Sach.soLuong as N'Số lượng',
			TheLoaiSach.tenTheLoai as N'Tên thể loại', NhaXuatBan.tenNhaXuatBan as N'Tên NXB'
		from Sach, TheLoaiSach, NhaXuatBan
		where Sach.theLoaiId = TheLoaiSach.ID
			and Sach.nhaXuatBanId = NhaXuatBan.ID
			and TheLoaiSach.tenTheLoai = @tenTheLoai)

go

select * from f_LayThongTinNhungCuonSach_TheoTenTheLoai(N'Tâm lý - Kỹ năng sống')

-- 6. Lấy 5 tác giả (sắp xếp giảm dần theo tên tác giả) với điều kiện có số lượng sách lớn hơn hoặc bằng một số bất kỳ. Tham số truyền vào là số lượng sách.

go
create function f_Lay5ThongTinTacGia_TheoSLSach_SapXepGiamTheoTenTacGia(@soLuongSach int)
returns table as
	return (select top 5 TacGiaSach.* from TacGiaSach, (select TacGiaSach.ID as tacGiaId, count(Sach.ISBN) as SoLuong 
		from Sach, DongGopCuaTacGia, TacGiaSach 
		where Sach.ISBN = DongGopCuaTacGia.ISBN and DongGopCuaTacGia.tacGiaId = TacGiaSach.ID
		group by TacGiaSach.ID having count(Sach.ISBN) >= @soLuongSach) as ThongKe
	where ThongKe.tacGiaId = TacGiaSach.ID
	order by TacGiaSach.tenTacGia desc)

go

select * from f_Lay5ThongTinTacGia_TheoSLSach_SapXepGiamTheoTenTacGia(2);

-- 7. Đếm số lượng những nhà cung cấp chưa thực hiện nhập hàng

go
create function f_DemSoLuongNNCChuaTHNhapHang()
returns int as
	begin
		declare @soLuong int
		select @soLuong = count(*) from NhaCungCap where ID not in (Select distinct nhaCungCapId from NhapHang)
		return @soLuong
	end
	
go

declare @SLNCC1 int
set @SLNCC1 = dbo.f_DemSoLuongNNCChuaTHNhapHang();

print N'Số lượng nhà cung cấp chưa thực hiện nhập hàng là: ' + convert(varchar(20), @SLNCC1)

-- 8. Tính doanh thu của năm bất kỳ. Tham số truyền vào là năm

go
create function f_TinhTongDoanhThu_TheoNam(@nam int)
returns float as
	begin
		declare @doanhThuCuaNam float
		select @doanhThuCuaNam = sum(tongTien) from HoaDon, TrangThaiHoaDon where HoaDon.trangThaiHoaDonId = TrangThaiHoaDon.ID 
			and year(ngayDatHang) = @nam and TrangThaiHoaDon.tenTrangThai = N'Đã giao hàng'
		return @doanhThuCuaNam
	end

go

declare @doanhThu1 float
declare @nam1 int 
set @nam1 = 2020
set @doanhThu1 = dbo.f_TinhTongDoanhThu_TheoNam(@nam1)

print N'Doanh thu của năm ' + convert(varchar(20), @nam1) + ' là: ' + ltrim(str(@doanhThu1, 20, 5))

-- 9. Nhập vào địa chỉ email của người dùng, trả về họ tên đầy đủ. Tham số truyền vào là địa chỉ email

go
create function f_LayHoTenDayDu_TheoEmail(@diaChiEmail varchar(100))
returns nvarchar(100) as
	begin
		declare @hotenDayDu nvarchar(100)
		if not exists(select ho, tenlot, ten from NguoiDung where email = @diaChiEmail)
			set @hotenDayDu = N'Không tồn tại'
		else
			begin
				select @hotenDayDu = ho + ' ' + tenlot + ' ' + ten from NguoiDung where email = @diaChiEmail
			end
		return @hotenDayDu
	end

go

declare @htDayDu nvarchar(100)
declare @dcEmail varchar(100)
set @dcEmail = 'nguyenkhiem239058@gmail.com'                                                                                                                                                                          
set @htDayDu = dbo.f_LayHoTenDayDu_TheoEmail(@dcEmail)

if(@htDayDu = N'Không tồn tại')
	print N'Không tìm thấy người dùng có địa chỉ Email này!'
else
	print N'Họ tên đầy đủ là: ' + @htDayDu

-- 10. Nhập vào địa chỉ Email, trả về các thông tin thống kê của hóa đơn có địa chỉ email đã truyền vào như sau: 
-- Tổng số hóa đơn, số hóa đơn đã được giao, đang giao, đã bị hủy,đang bị hoãn,
-- Tổng tiền các hoá đơn đã được giao, đang giao, đã bị hủy, đang bị hoãn và tổng tiền của tất cả hoán đơn

go
create function f_ThongKeHoaDonCuaNguoiDung_TheoEmail(@diaChiEmail varchar(100))
returns @bangThongKe table 
(
	soHoaDon int, soHDDaGiao int, soHDDangDuocGiao int, soHDDaHuy int, soHDDangHoan int, soHDDangChoXacNhan int,
	TTHDDaGiao float, TTHDDangDuocGiao float, TTHDDaHuy float, TTHDDangHoan float, TTHDDangChoXacNhan float, TTTatCaHD float
) as
	begin
		declare @TTHDDaGiao float, @TTHDDangDuocGiao float, @TTHDDaHuy float, @TTHDDangHoan float, @TTHDDangChoXacNhan float, @TTTatCaHD float
		declare @soHD int, @soDHDaGiao int, @soDHDangDuocGiao int, @soDHDaHuy int, @soDHDangHoan int, @soHDDangChoXacNhan int
		select @soHD = 0, @soDHDaGiao = 0, @soDHDangDuocGiao = 0, @soDHDaHuy = 0, @soDHDangHoan = 0, @soHDDangChoXacNhan = 0, 
			@TTHDDaGiao = 0, @TTHDDangDuocGiao = 0, @TTHDDaHuy = 0, @TTHDDangHoan = 0, @TTHDDangChoXacNhan = 0
		
		select @soHD = count(*) from HoaDon, NguoiDung 
			where HoaDon.nguoiDungId = NguoiDung.ID and NguoiDung.email = @diaChiEmail

		declare @bangDLTam table (tenTTDH nvarchar(100), SLDH int, tongTien float)
		insert into @bangDLTam (tenTTDH, SLDH, tongTien) select TrangThaiHoaDon.tenTrangThai, count(*), sum(HoaDon.tongTien)
		from HoaDon, NguoiDung, TrangThaiHoaDon	
		where HoaDon.nguoiDungId = NguoiDung.ID and NguoiDung.email = @diaChiEmail
			and HoaDon.trangThaiHoaDonId = TrangThaiHoaDon.ID
		group by TrangThaiHoaDon.tenTrangThai

		select @soDHDaGiao = SLDH, @TTHDDaGiao = tongTien from @bangDLTam where tenTTDH = N'Đã giao hàng'
		select @soDHDangDuocGiao = SLDH, @TTHDDangDuocGiao = tongTien from @bangDLTam where tenTTDH = N'Đang giao hàng'
		select @soDHDaHuy = SLDH, @TTHDDaHuy = tongTien from @bangDLTam where tenTTDH = N'Đã hủy'
		select @soDHDangHoan = SLDH, @TTHDDangHoan = tongTien from @bangDLTam where tenTTDH = N'Đang bị hoãn'
		select @soHDDangChoXacNhan = SLDH, @TTHDDangChoXacNhan = tongTien from @bangDLTam where tenTTDH = N'Đang chờ xác nhận'

		set @TTTatCaHD = @TTHDDaGiao + @TTHDDangDuocGiao + @TTHDDaHuy + @TTHDDangChoXacNhan + @TTHDDangHoan
		insert into @bangThongKe values(
			@soHD, @soDHDaGiao, @soDHDangDuocGiao, @soDHDaHuy, @soDHDangHoan, @soHDDangChoXacNhan, @TTHDDaGiao, 
			@TTHDDangDuocGiao, @TTHDDaHuy, @TTHDDangHoan, @TTHDDangChoXacNhan, @TTTatCaHD)

		return
	end

go

declare @dcEmail1 varchar(100)
set @dcEmail1 = 'nguyenkhiem239058@gmail.com'                                                                                                                                                                          
select * from f_ThongKeHoaDonCuaNguoiDung_TheoEmail(@dcEmail1)

-------------------------------------------------------------------------------------------------
-- Trigger

-- 1. Kiểm tra chỉ cho thêm dữ liệu khi số lượng sách nhập lớn hơn 0. Đồng thời nếu số lượng hợp lệ, 
-- thực hiện cập nhật số lượng sách trong bảng Sách khi thực hiện nhập hàng một cuốn sách mới.

go
create trigger trg_CapNhatSLSach on NhapHang for insert
as
	if(select soLuong from inserted) > 0
		begin
			update Sach set soLuong = soLuong + (select soluong from inserted) where ISBN = (select ISBN from inserted)
			print N'Nhập hàng thành công, đã cập nhật số lượng mới vào bản Sách'
		end
	else
		begin
			print N'Số lượng không được nhỏ hơn hoặc bằng 0'
			rollback tran
		end

go

--- Nhập dữ liệu sai
set dateformat dmy
Insert into NhapHang(ISBN, nhaCungCapId, lanNhap, soLuong, gia, ngayNhapHang)
	values('978-604-1-00215-3', 'NCC10', 2, 0, 80000, '07/09/2021')

--- Nhập dữ liệu đúng
set dateformat dmy
Insert into NhapHang(ISBN, nhaCungCapId, lanNhap, soLuong, gia, ngayNhapHang)
	values('978-604-1-00215-3', 'NCC10', 2, 2, 80000, '07/09/2021')

--- Kiểm tra dữ liệu
select * from Sach where ISBN = '978-604-1-00215-3'
select * from NhapHang where ISBN = '978-604-1-00215-3'

--- Thực hiện xóa (khi cần thiết)
delete from NhapHang where ISBN = '978-604-1-00215-3' and nhaCungCapId = 'NCC10' and lanNhap = 2

-- 2. Kiểm tra vài trò của tác giả trong sách phải có giá trị là "Tác giả" hoặc "Đồng tác giả" hoặc "Dịch giả"

go
create trigger trg_KTVaiTroTrongSach on DongGopCuaTacGia for insert, update
as
	begin
		if exists(select * from inserted where vaiTro = N'Tác giả' or vaiTro = N'Đồng tác giả' or vaiTro = N'Dịch giả')
			commit tran
		else
			begin
				rollback tran
				print N'Vai trò của tác giả trong sách không hợp lệ'
			end
	end

--- Nhập dữ liệu sai
Insert into DongGopCuaTacGia(ISBN, tacGiaId, vaiTro)
	values ('978-604-2247-33-2', 'TG2', N'TG')

--- Nhập dữ liệu đúng
Insert into DongGopCuaTacGia(ISBN, tacGiaId, vaiTro)
	values ('978-604-2247-33-2', 'TG2', N'Đồng tác giả')

--- Chỉnh sửa dữ liệu sai
update DongGopCuaTacGia set vaiTro = N'TG' where ISBN = '978-604-2247-33-2' and tacGiaId = 'TG1'

--- Chỉnh sửa dữ liệu đúng
update DongGopCuaTacGia set vaiTro = N'Đồng tác giả' where ISBN = '978-604-2247-33-2' and tacGiaId = 'TG1'

--- Kiểm tra dữ liệu
select * from DongGopCuaTacGia where ISBN = '978-604-2247-33-2'

--- Thực hiện xóa (khi cần thiết)
delete from DongGopCuaTacGia where ISBN = '978-604-2247-33-2' and tacGiaId = 'TG2'

-- 3. Kiểm tra giá tiền của sách phải lớn hơn 0

go
create trigger trg_KiemTraGiaTienLonHon0 on Sach for insert, update
as
	if(select gia from inserted) > 0
		commit tran
	else
		begin
			rollback tran
			print N'Giá tiền của sách phải lớn hơn 0' 
		end

--- Nhập dữ liệu sai
insert into Sach(ISBN, tenSach, ngonNguId, kichThuoc, ngayXuatBan, soTrang, dinhDang,
gia, giamGia, soLuong, theLoaiId, nhaXuatBanId, moTa, trangThaiId, luotXem)
values
	('978-604-1-00215-3-0', N'Dám Yêu Dám Gánh vác Demo', 'NNS1', '20.5 x 14.5 cm', 2020, 336, N'Bìa mềm', 0, 0, 68, 'TL19','NXB9', N'', 'TTS1', 0)

--- Nhập dữ liệu đúng
insert into Sach(ISBN, tenSach, ngonNguId, kichThuoc, ngayXuatBan, soTrang, dinhDang,
gia, giamGia, soLuong, theLoaiId, nhaXuatBanId, moTa, trangThaiId, luotXem)
values
	('978-604-1-00215-3-0', N'Dám Yêu Dám Gánh vác Demo', 'NNS1', '20.5 x 14.5 cm', 2020, 336, N'Bìa mềm', 119000, 0, 68, 'TL19','NXB9', N'', 'TTS1', 0)

--- Chỉnh sửa dữ liệu sai
update Sach set gia = 0 where ISBN = '978-604-1-00215-3'

--- Chỉnh sửa dữ liệu đúng
update Sach set gia = 120000 where ISBN = '978-604-1-00215-3'

--- Kiểm tra dữ liệu
select * from Sach where ISBN = '978-604-1-00215-3-0'
select * from Sach where ISBN = '978-604-1-00215-3'

--- Thực hiện xóa (khi cần thiết)
delete from Sach where ISBN = '978-604-1-00215-3-0'
delete from Sach where ISBN = '978-604-1-00215-3'

-- 4. Kiểm tra khi thêm, hoặc chỉnh sửa một thể loại sách thì tên thể loại không được trùng với các thể loại đã có trong bảng TheLoaiSach

go
create trigger trg_KTTrungTenTheLoai on TheLoaiSach instead of insert, update
as
	begin
		declare @tenTLCu nvarchar(100), @tenTLMoi nvarchar(100), @TLID varchar(10), @moTa nvarchar(max)
		select @TLID = ID, @tenTLMoi = tenTheLoai, @moTa = moTa from inserted

		if not exists(select * from deleted)
			begin
				if not exists(select * from TheLoaiSach where tenTheLoai = @tenTLMoi)
					begin
						insert into TheLoaiSach(ID, tenTheLoai, moTa) values (@TLID, @tenTLMoi, @moTa)
						print N'Thêm thành công'
					end

				else
					print N'Thêm không thành công, do trùng tên thể loại'

			end
		else
			begin
				set @tenTLCu = (select tenTheLoai from deleted)
				if (@tenTLCu = @tenTLMoi) or (@tenTLCu != @tenTLMoi 
					and not exists(select * from TheLoaiSach where tenTheLoai = @tenTLMoi))
					begin
						update TheLoaiSach set tenTheLoai = @tenTLMoi, moTa = @moTa where ID = @TLID
						print N'Chỉnh sửa thành công'
					end
				else
					print N'Chỉnh sửa không thành công, do trùng tên thể loại'
			end
	end

--- Nhập dữ liệu sai
Insert into TheLoaiSach(ID, tenTheLoai, moTa)
	values ('TL29', N'Khoa học - Kỹ thuật', N'')

--- Nhập dữ liệu đúng
Insert into TheLoaiSach(ID, tenTheLoai, moTa)
	values ('TL29', N'Thể loại thử nghiệm', N'Thử nghiệm')

--- Chỉnh sửa dữ liệu sai
update TheLoaiSach set tenTheLoai = N'Kinh tế - quản lý' where ID = 'TL4'

--- Chỉnh sửa dữ liệu đúng
update TheLoaiSach set tenTheLoai = N'Công nghệ thông tin' where ID = 'TL4'
update TheLoaiSach set tenTheLoai = N'CNTT' where ID = 'TL4'

--- Kiểm tra dữ liệu
select * from TheLoaiSach
select * from TheLoaiSach where ID = 'TL4'
select * from TheLoaiSach where ID = 'TL29'

--- Thực hiện xóa (khi cần thiết)
delete from TheLoaiSach where ID = 'TL29'

-- 5. Kiểm tra khi thêm, hoặc chỉnh sửa một ngôn ngữ sách thì tên ngôn ngữ không được trùng với các thể loại đã có trong bảng NgonNguSach

go
create trigger trg_KTTrungTenNgonNgu on NgonNguSach instead of insert, update
as
	begin
		declare @tenNNCu nvarchar(100), @tenNNMoi nvarchar(100), @NNID varchar(10)
		select @NNID = ID, @tenNNMoi = tenNgonNgu from inserted

		if not exists(select * from deleted)
			begin
				if not exists(select * from NgonNguSach where tenNgonNgu = @tenNNMoi)
					begin
						insert into NgonNguSach(ID, tenNgonNgu) values (@NNID, @tenNNMoi)
						print N'Thêm thành công'
					end
				else
					print N'Thêm không thành công, do trùng tên ngôn ngữ'

			end
		else
			begin
				set @tenNNCu = (select tenNgonNgu from deleted)
				if (@tenNNCu = @tenNNMoi) or (@tenNNCu != @tenNNMoi 
					and not exists(select * from NgonNguSach where tenNgonNgu = @tenNNMoi))
					begin
						update NgonNguSach set tenNgonNgu = @tenNNMoi where ID = @NNID
						print N'Chỉnh sửa thành công'
					end
				else
					print N'Chỉnh sửa không thành công, do trùng tên ngôn ngữ'
			end
	end

--- Nhập dữ liệu sai
Insert into NgonNguSach(ID, tenNgonNgu) values ('NNS15', N'Tiếng Anh')

--- Nhập dữ liệu đúng
Insert into NgonNguSach(ID, tenNgonNgu) values ('NNS15', N'Tiếng Ukraina')

--- Chỉnh sửa dữ liệu sai
update NgonNguSach set tenNgonNgu = N'Tiếng Nhật' where ID = 'NNS2'

--- Chỉnh sửa dữ liệu đúng
update NgonNguSach set tenNgonNgu = N'Tiếng Anh - English' where ID = 'NNS2'
update NgonNguSach set tenNgonNgu = N'Tiếng Anh' where ID = 'NNS2'

--- Kiểm tra dữ liệu
select * from NgonNguSach
select * from NgonNguSach where ID = 'NNS2'
select * from NgonNguSach where ID = 'NNS15'

--- Thực hiện xóa (khi cần thiết)
delete from NgonNguSach where ID = 'NNS15'

-- 6. Kiểm tra khi thêm, hoặc chỉnh sửa một nhà xuất bản thì tên nhà xuất bản không được trùng với các thể loại đã có trong bảng NhaXuatBan

go
create trigger trg_KTTrungTenNXB on NhaXuatBan instead of insert, update
as
	begin
		declare @tenNXBCu nvarchar(100), @tenNXBMoi nvarchar(100), @NXBID varchar(10), @moTa nvarchar(max), @email varchar(100), @sdt varchar(20)
		select @NXBID = ID, @tenNXBMoi = tenNhaXuatBan, @moTa = moTa, @email = email, @sdt = SDT from inserted

		if not exists(select * from deleted)
			begin
				if not exists(select * from NhaXuatBan where tenNhaXuatBan = @tenNXBMoi)
					begin
						insert into NhaXuatBan(ID, tenNhaXuatBan, moTa, email, SDT) values (@NXBID, @tenNXBMoi, @moTa, @email, @sdt)
						print N'Thêm thành công'
					end
				else
					print N'Thêm không thành công, do trùng tên nhà xuất bản'

			end
		else
			begin
				set @tenNXBCu = (select tenNhaXuatBan from deleted)
				if (@tenNXBCu = @tenNXBMoi) or (@tenNXBCu != @tenNXBMoi 
					and not exists(select * from NhaXuatBan where tenNhaXuatBan = @tenNXBMoi))
					begin
						update NhaXuatBan set tenNhaXuatBan = @tenNXBMoi, moTa = @moTa, email = @email, SDT = @sdt where ID = @NXBID
						print N'Chỉnh sửa thành công'
					end
				else
					print N'Chỉnh sửa không thành công, do trùng tên nhà xuất bản'
			end
	end

--- Nhập dữ liệu sai
Insert into NhaXuatBan(ID, tenNhaXuatBan, moTa, email, SDT) 
	values ('NXB11', N'NXB Hồng Đức', N'Thử nghiệm', 'nxbthunghiem@gmail.com', NULL)

--- Nhập dữ liệu đúng
Insert into NhaXuatBan(ID, tenNhaXuatBan, moTa, email, SDT) 
	values ('NXB11', N'NXB Thử nghiệm', N'Thử nghiệm', 'nxbthunghiem@gmail.com', NULL)

--- Chỉnh sửa dữ liệu sai
update NhaXuatBan set tenNhaXuatBan = N'NXB Hồng Đức' where ID = 'NXB6'

--- Chỉnh sửa dữ liệu đúng
update NhaXuatBan set tenNhaXuatBan = N'NXB Tổng hợp Thành phố HCM' where ID = 'NXB6'
update NhaXuatBan set tenNhaXuatBan = N'NXB Tổng hợp TPHCM' where ID = 'NXB6'

--- Kiểm tra dữ liệu
select * from NhaXuatBan
select * from NhaXuatBan where ID = 'NXB6'
select * from NhaXuatBan where ID = 'NXB11'

--- Thực hiện xóa (khi cần thiết)
delete from NhaXuatBan where ID = 'NXB11'

-- 7. Kiểm tra sự hợp lệ của địa chỉ email nhà cung cấp khi thực hiện thêm mới hoặc cập nhật dữ liệu trên bảng NhaCungCap

go
create trigger trg_KTEmailNCCHopLe on NhaCungCap for insert, update
as
	begin
		if exists(select * from inserted where email like '_%@__%.__%')
			commit tran
		else
			begin
				rollback tran
				print N'Địa chỉ email không hợp lệ'
			end
	end

--- Nhập dữ liệu sai
Insert into NhaCungCap(ID, tenNhaCungCap, email, SDT)
	values ('NCC13', N'NhaCungCap1', N'infoipm.vn', N'02432252470')

--- Nhập dữ liệu đúng
Insert into NhaCungCap(ID, tenNhaCungCap, email, SDT)
	values ('NCC13', N'NhaCungCap1', N'info@nccsach.vn', N'02432252470')

--- Kiểm tra dữ liệu
select * from NhaCungCap
select * from NhaCungCap where ID = 'NCC13'

--- Thực hiện xóa (khi cần thiết)
delete from NhaCungCap where ID = 'NCC13'

-- 8. Kiểm tra sự hợp lệ của tên người dùng khi thực hiện thêm mới hoặc cập nhật dữ liệu trên bảng NguoiDung

go
create trigger trg_KTTenNguoiDungHopLe on NguoiDung for insert, update
as
	begin
		if not exists(select * from inserted where tenNguoiDung like '%[^a-zA-Z0-9]%')
			commit tran
		else
			begin
				rollback tran
				print N'Tên người dùng không hợp lệ'
			end
	end

--- Nhập dữ liệu sai
set dateformat DMY
Insert into NguoiDung(ID, tenNguoiDung, ho, tenLot, ten, email, SDT, matKhau,matKhauBoSung, ngaySinh, gioiTinhId, trangThaiId, quyenHanId)
values (
		'16683d91-26db-4e87-965a-638b5f6ed0e1', 'Phan Chánh Demo', N'Phan', N'Xuân', N'Chánh', 'phanchanh123@gmail.com', '0312843523', '638b5f6ed0e9',
		'4e87-965a', '14/06/2001', 'GT1', 'TTND1', 'ee11cbb19052e40b07aac0ca060c23ee'
	)

--- Nhập dữ liệu đúng
set dateformat DMY
Insert into NguoiDung(ID, tenNguoiDung, ho, tenLot, ten, email, SDT, matKhau,matKhauBoSung, ngaySinh, gioiTinhId, trangThaiId, quyenHanId)
values (
		'16683d91-26db-4e87-965a-638b5f6ed0e1', 'phanchanhdemo', N'Phan', N'Xuân', N'Chánh', 'phanchanh123@gmail.com', '0312843523', '638b5f6ed0e9',
		'4e87-965a', '14/06/2001', 'GT1', 'TTND1', 'ee11cbb19052e40b07aac0ca060c23ee'
	)

--- Chỉnh sửa dữ liệu sai
update NguoiDung set tenNguoiDung = 'phanxuan chanh' where ID = '04e835c1-7d9f-4ed3-8b55-fd4bb66ef0d0'

--- Chỉnh sửa dữ liệu đúng
update NguoiDung set tenNguoiDung = 'phanxuanchanh' where ID = '04e835c1-7d9f-4ed3-8b55-fd4bb66ef0d0'

--- Kiểm tra dữ liệu
select * from NguoiDung
select * from NguoiDung where ID = '16683d91-26db-4e87-965a-638b5f6ed0e1'
select * from NguoiDung where ID = '04e835c1-7d9f-4ed3-8b55-fd4bb66ef0d0'

--- Thực hiện xóa (khi cần thiết)
delete from NguoiDung where ID = '16683d91-26db-4e87-965a-638b5f6ed0e1'

-- 9. 



-- 10. 



-------------------------------------------------------------------------------------------------
-- Cursor

-- 1. In ra danh sách các sách, thông tin bao gồm: ISBN, tên sách, kích thước, định dạng, số trang, giá.

declare curDSSach cursor dynamic
for select ISBN, tenSach, kichThuoc, dinhDang, soTrang, gia from Sach 

open curDSSach 
declare @ISBN1 varchar(100), @tenSach nvarchar(100), @kichThuoc varchar(50), @dinhDang nvarchar(100), @soTrang int, @gia float
fetch next from curDSSach into @ISBN1, @tenSach, @kichThuoc, @dinhDang, @soTrang, @gia

while(@@FETCH_STATUS = 0)
	begin
		print N'Mã sách: ' + @ISBN1 + N';Tên sách: ' + @tenSach + N';Kích thước: ' 
			+ @kichThuoc + N';Định dạng: ' + @dinhDang + N';Số trang: ' + convert(varchar(20), @soTrang)
			+ N';Giá: ' + ltrim(str(@gia, 20, 5))
		fetch next from curDSSach into @ISBN1, @tenSach, @kichThuoc, @dinhDang, @soTrang, @gia
	end

close curDSSach
deallocate curDSSach

-- 2. Cập nhật giảm giá tại dòng thứ 3 của bảng Sách (giảm 5% dựa trên giá gốc)

declare curCNGiamGia cursor scroll for select ISBN from Sach

open curCNGiamGia
fetch absolute 3 from curCNGiamGia

if(@@FETCH_STATUS = 0)
	update Sach set giamGia = gia * 0.05 where current of curCNGiamGia

close curCNGiamGia
deallocate curCNGiamGia

-- 3. -- Cập nhật giảm giá dựa theo mức giá tiền cho sách. Nếu giá tiền 0 < x <= 100000 thì giảm 5%, 
-- giá tiền từ 100000 < x <= 200000 thì giảm 8%, giá tiền 200000 < x <= 400000 thì giảm 10%, trường hợp lớn hơn 400000 thì giảm 15%

declare curCNGiamGiaTheoGiaGoc cursor dynamic
for select ISBN, gia from Sach

open curCNGiamGiaTheoGiaGoc
declare @ISBN2 varchar(100), @gia1 float, @giamGia float
fetch next from curCNGiamGiaTheoGiaGoc into @ISBN2, @gia1

while(@@FETCH_STATUS = 0)
	begin
		if(@gia1 > 400000)
			set @giamGia = @gia1 * 0.15
		else if(@gia1 > 200000)
			set @giamGia = @gia1 * 0.10
		else if(@gia1 > 100000)
			set @giamGia = @gia1 * 0.08
		else 
			set @giamGia = @gia1 * 0.05

		update Sach set giamGia = @giamGia where ISBN = @ISBN2
		fetch next from curCNGiamGiaTheoGiaGoc into @ISBN2, @gia1
	end

close curCNGiamGiaTheoGiaGoc
deallocate curCNGiamGiaTheoGiaGoc

-- 4. Đếm số lượng sách đang bán của từng tác giả, sử dụng cursor kết hợp với thủ tục đã làm ở các bước trên

 declare curDemSLSachTungTG cursor dynamic
 for select tenTacGia from TacGiaSach

 open curDemSLSachTungTG
 declare @tenTacGia1 nvarchar(100), @SLSachTungTG int
 fetch next from curDemSLSachTungTG into @tenTacGia1

 while(@@FETCH_STATUS = 0)
	begin
		exec sp_DemSoLuongSachDangBan_TheoTenTacGia @tenTacGia1, @SLSachTungTG output
		print N'Số lượng sách của tác giả "' + @tenTacGia1 + '" là: ' + convert(nvarchar(20), @SLSachTungTG)
		fetch next from curDemSLSachTungTG into @tenTacGia1
	end

close curDemSLSachTungTG
deallocate curDemSLSachTungTG

-- 5. Đếm số lượng sách của từng nhà xuất bản

declare curDemSLSachTungNXB cursor dynamic
for select ID, tenNhaXuatBan from NhaXuatBan

open curDemSLSachTungNXB
declare @nhaXuatBanId varchar(10), @tenNhaXuatBan1 nvarchar(100), @soLuongSach1 int
fetch next from curDemSLSachTungNXB into @nhaXuatBanId, @tenNhaXuatBan1

while(@@FETCH_STATUS = 0)
	begin
		set @soLuongSach1 = (select count(*) from Sach, NhaXuatBan where Sach.nhaXuatBanId = NhaXuatBan.ID 
		and NhaXuatBan.ID = @nhaXuatBanId)
		print N'Số lượng sách của nhà xuất bản có tên "' + @tenNhaXuatBan1 + ' (' + @nhaXuatBanId + ') là: ' + convert(varchar(20), @soLuongSach1)

		fetch next from curDemSLSachTungNXB into @nhaXuatBanId, @tenNhaXuatBan1
	end

close curDemSLSachTungNXB
deallocate curDemSLSachTungNXB

-- 6. Thực hiện cập nhật đơn giá, thành tiền trong bảng HoaDonChiTiet. Sau đó thực hiện cập nhật tổng tiền cho các hóa đơn
-- Đặt ngày giao hàng trong bảng HoaDon thành NULL nếu như có trạng thái hóa đơn là "Đã hủy"

declare curCapNhatHDCT_VaHD cursor dynamic
for select ID from HoaDon

open curCapNhatHDCT_VaHD
declare @hoaDonId varchar(10)
fetch next from curCapNhatHDCT_VaHD into @hoaDonId

while(@@FETCH_STATUS = 0)
	begin
		update HoaDonChiTiet 
		set donGia = (select Sach.gia - Sach.giamGia from Sach where Sach.ISBN = HoaDonChiTiet.ISBN)
		where hoaDonId = @hoaDonId

		update HoaDonChiTiet set thanhTien = donGia * soLuongSach
		where hoaDonId = @hoaDonId

		
		if not exists(select * from HoaDon, TrangThaiHoaDon where HoaDon.trangThaiHoaDonId = TrangThaiHoaDon.ID 
			and TrangThaiHoaDon.tenTrangThai = N'Đã hủy' and HoaDon.ID = @hoaDonId)
			update HoaDon 
			set tongTien = (select sum(HoaDonChiTiet.thanhTien) from HoaDonChiTiet where HoaDonChiTiet.hoaDonId = @hoaDonId) 
			where ID = @hoaDonId
		else
			update HoaDon 
			set ngayGiaoHang = NULL,
				tongTien = (select sum(HoaDonChiTiet.thanhTien) from HoaDonChiTiet where HoaDonChiTiet.hoaDonId = @hoaDonId) 
			where ID = @hoaDonId

		fetch next from curCapNhatHDCT_VaHD into @hoaDonId
	end

close curCapNhatHDCT_VaHD
deallocate curCapNhatHDCT_VaHD

-- 7. In ra thống kê hóa đơn của từng người dùng đã từng mua hàng. Bao gồm các thông tin như sau:
-- ID của người dùng
-- Tổng số hóa đơn, số hóa đơn đã được giao, đang giao, đã bị hủy,đang bị hoãn,
-- Tổng tiền các hoá đơn đã được giao, đang giao, đã bị hủy, đang bị hoãn và tổng tiền của tất cả hoán đơn

declare curTKHDCuaTatCaNguoiDung cursor dynamic
for select ID from NguoiDung

open curTKHDCuaTatCaNguoiDung
declare @nguoiDungId varchar(100)
declare @bangThongKe table 
(
	nguoiDungId varchar(100), soHoaDon int, soHDDaGiao int, soHDDangDuocGiao int, soHDDaHuy int, soHDDangHoan int, soHDDangChoXacNhan int,
	TTHDDaGiao float, TTHDDangDuocGiao float, TTHDDaHuy float, TTHDDangHoan float, TTHDDangChoXacNhan float, TTTatCaHD float
)
declare @TTHDDaGiao float, @TTHDDangDuocGiao float, @TTHDDaHuy float, @TTHDDangHoan float, @TTHDDangChoXacNhan float, @TTTatCaHD float
declare @soHD int, @soDHDaGiao int, @soDHDangDuocGiao int, @soDHDaHuy int, @soDHDangHoan int, @soHDDangChoXacNhan int
declare @bangDLTamThoi table (tenTTDH nvarchar(100), SLDH int, tongTien float)
fetch next from curTKHDCuaTatCaNguoiDung into @nguoiDungId


while(@@FETCH_STATUS = 0)
	begin
		select @soHD = 0, @soDHDaGiao = 0, @soDHDangDuocGiao = 0, @soDHDaHuy = 0, @soDHDangHoan = 0, @soHDDangChoXacNhan = 0, 
			@TTHDDaGiao = 0, @TTHDDangDuocGiao = 0, @TTHDDaHuy = 0, @TTHDDangHoan = 0, @TTHDDangChoXacNhan = 0
		
		select @soHD = count(*) from HoaDon where nguoiDungId = @nguoiDungId

		insert into @bangDLTamThoi (tenTTDH, SLDH, tongTien) select TrangThaiHoaDon.tenTrangThai, count(*), sum(HoaDon.tongTien)
		from HoaDon, TrangThaiHoaDon	
		where HoaDon.nguoiDungId = @nguoiDungId and HoaDon.trangThaiHoaDonId = TrangThaiHoaDon.ID
		group by TrangThaiHoaDon.tenTrangThai

		select @soDHDaGiao = SLDH, @TTHDDaGiao = tongTien from @bangDLTamThoi where tenTTDH = N'Đã giao hàng'
		select @soDHDangDuocGiao = SLDH, @TTHDDangDuocGiao = tongTien from @bangDLTamThoi where tenTTDH = N'Đang giao hàng'
		select @soDHDaHuy = SLDH, @TTHDDaHuy = tongTien from @bangDLTamThoi where tenTTDH = N'Đã hủy'
		select @soDHDangHoan = SLDH, @TTHDDangHoan = tongTien from @bangDLTamThoi where tenTTDH = N'Đang bị hoãn'
		select @soHDDangChoXacNhan = SLDH, @TTHDDangChoXacNhan = tongTien from @bangDLTamThoi where tenTTDH = N'Đang chờ xác nhận'
		delete from @bangDLTamThoi

		set @TTTatCaHD = @TTHDDaGiao + @TTHDDangDuocGiao + @TTHDDaHuy + @TTHDDangChoXacNhan + @TTHDDangHoan
		insert into @bangThongKe values(
			@nguoiDungId, @soHD, @soDHDaGiao, @soDHDangDuocGiao, @soDHDaHuy, @soDHDangHoan, @soHDDangChoXacNhan, 
			@TTHDDaGiao, @TTHDDangDuocGiao, @TTHDDaHuy, @TTHDDangHoan, @TTHDDangChoXacNhan, @TTTatCaHD)

		fetch next from curTKHDCuaTatCaNguoiDung into @nguoiDungId
	end

select * from @bangThongKe

close curTKHDCuaTatCaNguoiDung
deallocate curTKHDCuaTatCaNguoiDung

-- 8. In ra ISBN, tên sách và danh sách các tác giả (kèm theo vai trò của tác giả đó trong sách)
-- Định dạng xuất: ISBN:...;Tên sách:...;Tác giả: [(Tên tác giả --> Vai trò),...]

declare curDSSachVaTGCuaSach cursor dynamic for select ISBN, tenSach from Sach

open curDSSachVaTGCuaSach
declare @ISBN2 varchar(100), @tenSach1 nvarchar(100)
declare @ketQuaHienThi nvarchar(300), @tacGiaId varchar(10), @tenTacGia2 nvarchar(100), @vaiTro nvarchar(100);
fetch next from curDSSachVaTGCuaSach into @ISBN2, @tenSach1

while(@@FETCH_STATUS = 0)
	begin
		if not exists(select * from DongGopCuaTacGia where ISBN = @ISBN2)
			set @ketQuaHienThi = N'ISBN: ' + @ISBN2 + N';Tên sách: ' + @tenSach1 + N';Tác giả: Chưa được thêm'
		else
			begin
				set @ketQuaHienThi = N'ISBN: ' + @ISBN2 + N';Tên sách: ' + @tenSach1 + N';Tác giả: ['
				declare curLayDSTG cursor dynamic for select tacGiaId, vaiTro from DongGopCuaTacGia where ISBN = @ISBN2
				open curLayDSTG
				fetch next from curLayDSTG into @tacGiaId, @vaiTro
				while(@@FETCH_STATUS = 0)
					begin 
						select @tenTacGia2 = tenTacGia from TacGiaSach where ID = @tacGiaId
						set @ketQuaHienThi = @ketQuaHienThi + '(' + @tenTacGia2 + ' --> ' + @vaiTro + '), '
						fetch next from curLayDSTG into @tacGiaId, @vaiTro
					end
				close curLayDSTG
				deallocate curLayDSTG
				set @ketQuaHienThi = @ketQuaHienThi + ']'
				fetch next from curDSSachVaTGCuaSach into @ISBN2, @tenSach1
			end

		print @ketQuaHienThi
	end

close curDSSachVaTGCuaSach
deallocate curDSSachVaTGCuaSach

-- 9. Sắp xếp sách giảm dần theo số trang. Sau đó in ra ISBN, tên sách của sách có số trang ít nhất 

declare curSachCoSoTrangNhoNhat cursor scroll for select ISBN, tenSach from Sach order by soTrang desc

open curSachCoSoTrangNhoNhat
declare @ISBN4 varchar(100), @tenSach2 nvarchar(100)
fetch last from curSachCoSoTrangNhoNhat into @ISBN4, @tenSach2

if(@@FETCH_STATUS = 0)
	print N'Sách có số trang nhỏ nhất là: ' + @ISBN4 + ' -- "' + @tenSach2 + '"'

close curSachCoSoTrangNhoNhat
deallocate curSachCoSoTrangNhoNhat

-- 10. In ra sách có giá cao nhất và sách có giá thấp nhất. Thông tin bao gồm: ISBN, tên sách.

declare curSachCoGiaCaoNhatVaThapNhat cursor scroll for select ISBN, tenSach from Sach order by gia desc

open curSachCoGiaCaoNhatVaThapNhat
declare @ISBN5 varchar(100), @tenSach3 nvarchar(100)
fetch first from curSachCoGiaCaoNhatVaThapNhat into @ISBN5, @tenSach3

if(@@FETCH_STATUS = 0)
	begin
		print N'Sách có giá cao nhất là: ' + @ISBN5 + ' -- "' + @tenSach3 + '"'
		fetch last from curSachCoGiaCaoNhatVaThapNhat into @ISBN5, @tenSach3
		if(@@FETCH_STATUS = 0)
			print N'Sách có giá thấp nhất là: ' + @ISBN5 + ' -- "' + @tenSach3 + '"'
	end

close curSachCoGiaCaoNhatVaThapNhat
deallocate curSachCoGiaCaoNhatVaThapNhat

-------------------------------------------------------------------------------------------------
-- Sao lưu và phục hồi

-- Sao lưu

-- + Chạy lệnh Full Backup
Backup database QLBanSach to disk = 'F:\ĐỒ ÁN\HQTCSDL\SQL_BanChinh\BACKUP\qlbansach_full.bak'

-- + Lệnh Differential Backup (thực hiện khi cần lưu những thay đổi kể từ lần sao lưu gần nhất)
Backup database QLBanSach to disk = 'F:\ĐỒ ÁN\HQTCSDL\SQL_BanChinh\BACKUP\qlbansach_diff.bak' with differential

-- + Transaction Log Backup
Backup log QLBanSach to disk = 'F:\ĐỒ ÁN\HQTCSDL\SQL_BanChinh\BACKUP\qlbansach_log.trn'

-- Phục hồi

-- + Phục hồi (Full Backup)

--- Nếu không thực hiện tiếp các lệnh backup
Restore database QLBanSach from disk = 'F:\ĐỒ ÁN\HQTCSDL\SQL_BanChinh\BACKUP\qlbansach_full.bak' with Recovery
--- Nếu vẫn tiếp tục thực hiện các lệnh backup
Restore database QLBanSach from disk = 'F:\ĐỒ ÁN\HQTCSDL\SQL_BanChinh\BACKUP\qlbansach_full.bak' with noRecovery

-- + Phục hồi (Differential Backup)

--- Nếu không thực hiện tiếp các lệnh backup
Restore database QLBanSach from disk = 'F:\ĐỒ ÁN\HQTCSDL\SQL_BanChinh\BACKUP\qlbansach_diff.bak' with Recovery
--- Nếu vẫn tiếp tục thực hiện các lệnh backup
Restore database QLBanSach from disk = 'F:\ĐỒ ÁN\HQTCSDL\SQL_BanChinh\BACKUP\qlbansach_diff.bak' with noRecovery

-- + Phục hồi (Transaction Log Backup)
Restore log QLBanSach from disk = 'F:\ĐỒ ÁN\HQTCSDL\SQL_BanChinh\BACKUP\qlbansach_log.trn' with Recovery

-------------------------------------------------------------------------------------------------
-- Phân quyền

-- + Tạo các tài khoản đăng nhập

create login TKQuanTri with password = N'123456789'--, default_database = QLBanSach
create login TKNhanVien with password = N'987654321'--, default_database = QLBanSach
create login TKThongThuong with password = N'1234512345'--, default_database = QLBanSach

-- + Tạo các tài khoản người dùng

use QLBanSach

create user QuanTriVien1 for login TKQuanTri
create user QuanTriVien2 without login -- Tạo tài khoản, không liên kết với tài khoản đăng nhập
create user NhanVien1 for login TKNhanVien
create user NhanVien2 without login -- Tạo tài khoản, không liên kết với tài khoản đăng nhập
create user TaiKhoanThongThuong1 for login TKThongThuong
create user TaiKhoanThongThuong2 without login -- Tạo tài khoản, không liên kết với tài khoản đăng nhập
create user TaiKhoanThongThuong3 without login -- Tạo tài khoản, không liên kết với tài khoản đăng nhập

-- + Tạo các nhóm quyền và thêm các tài khoản người dùng vào các nhóm tương ứng

exec sp_addrole NhomQuanTri
exec sp_addrole NhomNhanVien
exec sp_addrole NhomTKThongThuong

exec sp_addrolemember NhomQuanTri, QuanTriVien1
exec sp_addrolemember NhomQuanTri, QuanTriVien2

exec sp_addrolemember NhomNhanVien, NhanVien1
exec sp_addrolemember NhomNhanVien, NhanVien2

exec sp_addrolemember NhomTKThongThuong, TaiKhoanThongThuong1
exec sp_addrolemember NhomTKThongThuong, TaiKhoanThongThuong2
exec sp_addrolemember NhomTKThongThuong, TaiKhoanThongThuong3

-- + Thực hiện cấp quyền cho các nhóm

--- Phân quyền cho nhóm quản trị

grant all on DiaChiGiaoHang to NhomQuanTri
grant all on DongGopCuaTacGia to NhomQuanTri
grant all on GioiTinh to NhomQuanTri
grant all on HoaDon to NhomQuanTri
grant all on HoaDonChiTiet to NhomQuanTri
grant all on NgonNguSach to NhomQuanTri
grant all on NguoiDung to NhomQuanTri
grant all on NhaCungCap to NhomQuanTri
grant all on NhapHang to NhomQuanTri
grant all on NhaXuatBan to NhomQuanTri
grant all on QuanHuyen to NhomQuanTri
grant all on QuocGia to NhomQuanTri
grant all on QuyenHan to NhomQuanTri
grant all on Sach to NhomQuanTri
grant all on TacGiaSach to NhomQuanTri
grant all on TheLoaiSach to NhomQuanTri
grant all on TinhThanhPho to NhomQuanTri
grant all on TrangThaiHoaDon to NhomQuanTri
grant all on TrangThaiNguoiDung to NhomQuanTri
grant all on TrangThaiSach to NhomQuanTri
grant all on XaPhuong to NhomQuanTri

--- Phân quyền cho nhóm nhân viên

grant select, insert, update on DiaChiGiaoHang to NhomNhanVien
grant select, insert, update on DongGopCuaTacGia to NhomNhanVien
grant select on GioiTinh to NhomNhanVien
grant select, insert, update on HoaDon to NhomNhanVien
grant select, insert, update on HoaDonChiTiet to NhomNhanVien
grant select, insert, update on NgonNguSach to NhomNhanVien
grant select on NguoiDung to NhomNhanVien
grant select on NhaCungCap to NhomNhanVien
grant select on NhapHang to NhomNhanVien
grant select, insert, update on NhaXuatBan to NhomNhanVien
grant select on QuanHuyen to NhomNhanVien
grant select on QuocGia to NhomNhanVien
grant select on QuyenHan to NhomNhanVien
grant select, insert, update on Sach to NhomNhanVien
grant select, insert, update on TacGiaSach to NhomNhanVien
grant select, insert, update on TheLoaiSach to NhomNhanVien
grant select on TinhThanhPho to NhomNhanVien
grant select on TrangThaiHoaDon to NhomNhanVien
grant select on TrangThaiNguoiDung to NhomNhanVien
grant select on TrangThaiSach to NhomNhanVien
grant select on XaPhuong to NhomNhanVien

-- Phân quyền cho nhóm tài khoản thông thường

grant select on DiaChiGiaoHang to NhomTKThongThuong
grant select on DongGopCuaTacGia to NhomTKThongThuong
grant select on GioiTinh to NhomTKThongThuong
grant select on HoaDon to NhomTKThongThuong
grant select on HoaDonChiTiet to NhomTKThongThuong
grant select on NgonNguSach to NhomTKThongThuong
grant select on NguoiDung to NhomTKThongThuong
grant select on NhaCungCap to NhomTKThongThuong
grant select on NhapHang to NhomTKThongThuong
grant select on NhaXuatBan to NhomTKThongThuong
grant select on QuanHuyen to NhomTKThongThuong
grant select on QuocGia to NhomTKThongThuong
grant select on QuyenHan to NhomTKThongThuong
grant select on Sach to NhomTKThongThuong
grant select on TacGiaSach to NhomTKThongThuong
grant select on TheLoaiSach to NhomTKThongThuong
grant select on TinhThanhPho to NhomTKThongThuong
grant select on TrangThaiHoaDon to NhomTKThongThuong
grant select on TrangThaiNguoiDung to NhomTKThongThuong
grant select on TrangThaiSach to NhomTKThongThuong
grant select on XaPhuong to NhomTKThongThuong

