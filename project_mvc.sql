-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 01, 2022 lúc 05:01 AM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `project_mvc`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `avatar`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BÁNH SANDWICHES', '1650637490-8x3Banner.png', '<p>B&aacute;nh m&igrave; SandWiches mềm dai, thơm ngon cho bữa s&aacute;ng tiện lợi, dinh dưỡng!</p>\r\n', 0, '2021-12-18 05:34:51', '2022-06-28 08:39:49'),
(4, 'BÁNH MÌ CHAY', '1650638097-bread-banner (1).jpg', '<p>B&aacute;nh m&igrave; chay được l&agrave;m từ bột m&igrave; nguy&ecirc;n chất v&agrave; kh&ocirc;ng th&ecirc;m bất cứ hương liệu n&agrave;o để giữ nguy&ecirc;n vị tươi ngon của l&uacute;a m&igrave;.</p>\r\n', 0, '2021-12-18 05:57:12', '2022-06-30 15:22:59'),
(11, 'BÁNH MÌ NHÂN DỪA', '1650638224-IMG_0908.jpg', '<p>Nh&acirc;n dừa thơm ngon, b&ugrave;i b&ugrave;i rất vừa miệng!</p>\r\n', 1, '2021-12-19 10:51:39', '2022-04-22 21:37:04'),
(12, 'BÁNH MÌ ĐEN', '1650638403-banh-mi-den-giam-can.jpg', '<p>C&ograve;n gọi l&agrave; b&aacute;nh m&igrave; l&uacute;a mạch, c&oacute; chiết xuất từ hạt l&uacute;a mạch đen. H&agrave;m lượng chất xơ cao gấp 4 lần b&aacute;nh m&igrave; trắng th&ocirc;ng thường!</p>\r\n', 1, '2021-12-19 10:54:47', '2022-04-22 21:40:03'),
(17, 'BÔNG LAN TRỨNG MUỐI', '1650638502-20180427104101.jpg', '<p>B&aacute;nh m&igrave; b&ocirc;ng lan mềm mại kết hợp với sốt bơ v&agrave; trứng muối sẽ mang lại cho bạn trải nghiệm tuyệt vời!</p>\r\n', 1, '2022-01-10 04:39:27', '2022-04-22 21:41:42'),
(18, 'BÁNH MÌ HOA CÚC', '1650638718-45558801_2190373571241245_5499501414012944384_n-1541491464-665-width640height480_schema_article.jpg', '<p>C&oacute; xuất sứ từ nước Ph&aacute;p, khi du nhập s&aacute;ng Việt Nam được gọi l&agrave; b&aacute;nh m&igrave; hoa c&uacute;c. Thớ b&aacute;nh dai, mềm v&agrave; c&oacute; thể x&eacute; th&agrave;nh sợi nhỏ. Ph&ugrave; hợp cho cả người lớn lẫn trẻ nhỏ d&ugrave;ng l&agrave;m bữa s&aacute;ng hoặc bữa phụ trong ng&agrave;y.</p>\r\n', 1, '2022-01-10 04:42:22', '2022-04-22 21:45:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `introduces`
--

CREATE TABLE `introduces` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `status` tinyint(3) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `introduces`
--

INSERT INTO `introduces` (`id`, `title`, `summary`, `avatar`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 'VÌ SAO NÊN CHỌN BÁNH MÌ ?', 'Do điều kiện tương đồng về văn hóa, gần về địa lý nên trên 70% khối lượng hàng hóa nông sản của ta được xuất khẩu sang các nước châu Á, còn với các thị trường khác như châu Phi,...', '1650641181-introduce-bread-basket-banner.png', '<p><strong>B&aacute;nh m&igrave;</strong>&nbsp;(<a href=\"https://vi.wikipedia.org/wiki/Ti%E1%BA%BFng_Anh\">tiếng Anh</a>:&nbsp;<em>bread</em>) l&agrave; thực phẩm được chế biến từ&nbsp;<a href=\"https://vi.wikipedia.org/wiki/B%E1%BB%99t_m%C3%AC\">bột m&igrave;</a>&nbsp;hoặc từ&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ng%C5%A9_c%E1%BB%91c\">ngũ cốc</a>&nbsp;được nghiền ra trộn với&nbsp;<a href=\"https://vi.wikipedia.org/wiki/N%C6%B0%E1%BB%9Bc\">nước</a>, thường l&agrave; bằng c&aacute;ch nướng. Trong suốt qu&aacute; tr&igrave;nh&nbsp;<a href=\"https://vi.wikipedia.org/wiki/L%E1%BB%8Bch_s%E1%BB%AD\">lịch sử</a>, b&aacute;nh m&igrave; đ&atilde; được phổ biến tr&ecirc;n to&agrave;n thế giới v&agrave; l&agrave; một trong những loại&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Th%E1%BB%B1c_ph%E1%BA%A9m\">thực phẩm</a>&nbsp;nh&acirc;n tạo l&acirc;u đời nhất, v&agrave; rất quan trọng kể từ l&uacute;c ban đầu của ng&agrave;nh&nbsp;<a href=\"https://vi.wikipedia.org/wiki/N%C3%B4ng_nghi%E1%BB%87p\">n&ocirc;ng nghiệp</a>.</p>\r\n\r\n<p>C&oacute; nhiều c&aacute;ch kết hợp v&agrave; tỷ lệ của c&aacute;c loại&nbsp;<a href=\"https://vi.wikipedia.org/wiki/B%E1%BB%99t\">bột</a>&nbsp;v&agrave; c&aacute;c nguy&ecirc;n liệu kh&aacute;c, v&agrave; cũng c&oacute; c&aacute;c c&ocirc;ng thức nấu ăn truyền thống kh&aacute;c nhau v&agrave; phương thức để tạo ra b&aacute;nh m&igrave;. Kết quả l&agrave; c&oacute; rất nhiều chủng loại, h&igrave;nh dạng, k&iacute;ch thước v&agrave; kết cấu của b&aacute;nh m&igrave; ở c&aacute;c v&ugrave;ng kh&aacute;c nhau. B&aacute;nh m&igrave; c&oacute; thể được&nbsp;<a href=\"https://vi.wikipedia.org/wiki/L%C3%AAn_men\">l&ecirc;n men</a>&nbsp;bằng nhiều qu&aacute; tr&igrave;nh kh&aacute;c nhau, từ việc sử dụng c&aacute;c&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Vi_sinh_v%E1%BA%ADt\">vi sinh vật</a>&nbsp;tự nhi&ecirc;n (v&iacute; dụ như trong&nbsp;<a href=\"https://vi.wikipedia.org/w/index.php?title=B%E1%BB%99t_chua&amp;action=edit&amp;redlink=1\">bột chua</a>) cho tới c&aacute;ch d&ugrave;ng phương ph&aacute;p th&ocirc;ng kh&iacute; nh&acirc;n tạo với &aacute;p lực cao trong qu&aacute; tr&igrave;nh chuẩn bị hoặc nướng. Tuy nhi&ecirc;n, một số sản phẩm b&aacute;nh m&igrave; c&ograve;n lại kh&ocirc;ng để l&ecirc;n men, hoặc v&igrave; cho sở th&iacute;ch, hoặc v&igrave; l&yacute; do truyền thống hay&nbsp;<a href=\"https://vi.wikipedia.org/wiki/T%C3%B4n_gi%C3%A1o\">t&ocirc;n gi&aacute;o</a>. Nhiều th&agrave;nh phần kh&ocirc;ng phải&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ng%C5%A9_c%E1%BB%91c\">ngũ cốc</a>&nbsp;c&oacute; thể được đưa v&agrave;o b&aacute;nh m&igrave;: từ&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Tr%C3%A1i_c%C3%A2y\">tr&aacute;i c&acirc;y</a>&nbsp;v&agrave; c&aacute;c loại&nbsp;<a href=\"https://vi.wikipedia.org/wiki/H%E1%BA%A1t\">hạt</a>&nbsp;đến c&aacute;c&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ch%E1%BA%A5t_b%C3%A9o\">chất b&eacute;o</a>&nbsp;kh&aacute;c nhau. B&aacute;nh m&igrave; thương mại n&oacute;i ri&ecirc;ng thường chứa c&aacute;c chất phụ gia, một số trong số ch&uacute;ng kh&ocirc;ng c&oacute;&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Dinh_d%C6%B0%E1%BB%A1ng\">dinh dưỡng</a>&nbsp;nhằm cải thiện hương vị, kết cấu, m&agrave;u sắc, thời hạn sử dụng, hoặc để&nbsp;<a href=\"https://vi.wikipedia.org/wiki/S%E1%BA%A3n_xu%E1%BA%A5t\">sản xuất</a>&nbsp;dễ d&agrave;ng hơn.</p>\r\n', 1, '2021-12-18 06:31:54', '2022-04-22 22:26:21'),
(2, 'LỊCH SỬ CỦA BÁNH MÌ', 'Bánh mì là một trong những thực phẩm được sản xuất lâu đời nhất', '1653266092-introduce-20200618_074856_498010_han-su-dung-cua-ban.max-1800x1800.jpg', '<p>B&aacute;nh m&igrave; l&agrave; một trong những thực phẩm được sản xuất l&acirc;u đời nhất. Bằng chứng từ 30.000 năm trước tại ch&acirc;u &Acirc;u cho thấy c&oacute; một lượng tinh bột tr&ecirc;n c&aacute;c h&ograve;n đ&aacute; được sử dụng để cắt xẻ c&acirc;y.<a href=\"https://vi.wikipedia.org/wiki/B%C3%A1nh_m%C3%AC#cite_note-1\">[1]</a>&nbsp;C&oacute; thể l&agrave; trong thời gian n&agrave;y, chiết xuất tinh bột từ rễ của c&aacute;c c&acirc;y, như đu&ocirc;i m&egrave;o v&agrave;&nbsp;<a href=\"https://vi.wikipedia.org/wiki/D%C6%B0%C6%A1ng_x%E1%BB%89\">dương xỉ</a>, đ&atilde; được đặt tr&ecirc;n một tảng đ&aacute; bằng phẳng, sau đ&oacute; được đặt tr&ecirc;n một ngọn lửa v&agrave; nấu th&agrave;nh một dạng b&aacute;nh m&igrave; cắt l&aacute;t nguy&ecirc;n thủy. Khoảng năm 10.000 TCN, với b&igrave;nh minh của&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Th%E1%BB%9Di_%C4%91%E1%BA%A1i_%C4%91%E1%BB%93_%C4%91%C3%A1_m%E1%BB%9Bi\">Thời đại đồ đ&aacute; mới</a>&nbsp;v&agrave; sự mở rộng của n&ocirc;ng nghiệp, c&aacute;c loại ngũ cốc đ&atilde; trở th&agrave;nh th&agrave;nh phần ch&iacute;nh của b&aacute;nh m&igrave;. B&agrave;o tử nấm men c&oacute; mặt khắp nơi, kể cả tr&ecirc;n bề mặt của&nbsp;<a href=\"https://vi.wikipedia.org/wiki/C%C3%A2y_l%C6%B0%C6%A1ng_th%E1%BB%B1c\">c&acirc;y lương thực</a>, v&igrave; vậy bất kỳ bột m&igrave; n&agrave;o để l&acirc;u sẽ được&nbsp;<a href=\"https://vi.wikipedia.org/wiki/L%C3%AAn_men\">l&ecirc;n men</a>&nbsp;tự nhi&ecirc;n.<a href=\"https://vi.wikipedia.org/wiki/B%C3%A1nh_m%C3%AC#cite_note-2\">[2]</a></p>\r\n\r\n<p>C&oacute; nhiều nguồn s&aacute;ch vở cho thấy b&aacute;nh m&igrave; thời gian đầu được l&ecirc;n men. Nấm men trong kh&ocirc;ng kh&iacute; c&oacute; thể được d&ugrave;ng bằng c&aacute;ch để lại bột m&igrave; chưa nấu tiếp x&uacute;c với kh&ocirc;ng kh&iacute; một thời gian trước khi nấu.&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Gaius_Plinius_Secundus\">Pliny the Elder</a>&nbsp;viết rằng người Gaul v&agrave; Iberia sử dụng bọt từ bia để sản xuất &quot;một loại b&aacute;nh m&igrave; nhẹ hơn b&aacute;nh m&igrave; của c&aacute;c d&acirc;n tộc kh&aacute;c.&quot; Người thế giới cổ đại uống rượu vang thay bia đ&atilde; sử dụng một hỗn hợp nước &eacute;p nho v&agrave; bột m&igrave; đ&atilde; được l&ecirc;n men, hoặc c&aacute;m l&uacute;a m&igrave; để ngập trong rượu vang, như một nguồn cho nấm men. C&aacute;ch l&ecirc;n men phổ biến nhất được d&ugrave;ng l&agrave; giữ lại một phần bột từ ng&agrave;y h&ocirc;m trước để sử dụng như một sản phẩm l&ecirc;n men d&ugrave;ng l&agrave;m mồi.<a href=\"https://vi.wikipedia.org/wiki/B%C3%A1nh_m%C3%AC#cite_note-3\">[3]</a></p>\r\n\r\n<p>Năm 1961 qu&aacute; tr&igrave;nh l&agrave;m b&aacute;nh m&igrave; Chorleywood đ&atilde; được ph&aacute;t triển, trong đ&oacute; sử dụng c&aacute;c &aacute;p lực cơ kh&iacute; lớn l&ecirc;n bột m&igrave; để l&agrave;m giảm đ&aacute;ng kể thời gian l&ecirc;n men v&agrave; thời gian thực hiện để tạo ra một ổ b&aacute;nh m&igrave;. Qu&aacute; tr&igrave;nh n&agrave;y sử dụng quy tr&igrave;nh trộn năng lượng cao cho ph&eacute;p sử dụng c&aacute;c hạt protein thấp hơn, hiện nay được sử dụng rộng r&atilde;i tr&ecirc;n to&agrave;n thế giới trong c&aacute;c nh&agrave; m&aacute;y lớn. Nhờ thế b&aacute;nh m&igrave; c&oacute; thể được sản xuất rất nhanh ch&oacute;ng v&agrave; với chi ph&iacute; thấp cho nh&agrave; sản xuất cũng như người ti&ecirc;u d&ugrave;ng. Tuy nhi&ecirc;n, đ&atilde; c&oacute; một số chỉ tr&iacute;ch của c&aacute;c hiệu ứng sản xuất n&agrave;y tr&ecirc;n gi&aacute; trị dinh dưỡng của b&aacute;nh m&igrave;.<a href=\"https://vi.wikipedia.org/wiki/B%C3%A1nh_m%C3%AC#cite_note-4\">[4]</a></p>\r\n\r\n<p>Gần đ&acirc;y, m&aacute;y b&aacute;nh m&igrave; trong nh&agrave; với việc tự động h&oacute;a qu&aacute; tr&igrave;nh l&agrave;m b&aacute;nh m&igrave; đ&atilde; trở n&ecirc;n phổ biến.</p>\r\n\r\n<h2>&nbsp;</h2>\r\n', 1, '2021-12-18 06:32:58', '2022-05-23 07:34:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `maps`
--

CREATE TABLE `maps` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `hotline` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `map_url` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `maps`
--

INSERT INTO `maps` (`id`, `title`, `hotline`, `fax`, `email`, `summary`, `map_url`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Số nhà 5, ngõ 132/72, Nguyên Xá, Bắc Từ Liêm, Hà Nội', '0966614730', '894657', 'huyen622001@gmail.com', 'Gần mà đi có xíu', 'https://www.google.com/maps/embed?=!1m18!1m12!1m3!1d3919.310729061172!2d106.6539626784669!3d10.787496261978522!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ecbb6275cc3%3A0x634b1cfb9f2ed0be!2zNTYgVsOibiBDw7RpLCBwaMaw4budbmcgNywgVMOibiBCw6xuaC', 0, '2021-12-18 06:35:49', '2022-05-17 15:41:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `status` tinyint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `category_id`, `title`, `summary`, `avatar`, `content`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'NGUYÊN LIỆU TỪ ĐÂU?', 'Lúa mì hay lúa miến, tiểu mạch, tên khoa học: Triticum spp, là cây lương thực, thuộc một nhóm các loài cỏ đã thuần dưỡng từ khu vực Levant và được gieo trồng rộng khắp thế giới. ', '1650640831-new-lua-mi-2.jpg', '<p>Về tổng thể, l&uacute;a m&igrave; l&agrave; thực phẩm quan trọng cho lo&agrave;i người, sản lượng của n&oacute; chỉ đứng sau&nbsp;<a href=\"https://vi.wikipedia.org/wiki/B%E1%BA%AFp\">bắp</a>&nbsp;v&agrave;&nbsp;<a href=\"https://vi.wikipedia.org/wiki/L%C3%BAa\">l&uacute;a gạo</a>&nbsp;trong số c&aacute;c lo&agrave;i c&acirc;y&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Th%E1%BB%B1c_ph%E1%BA%A9m\">lương thực</a>&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Qu%E1%BA%A3_th%C3%B3c\">Hạt</a>&nbsp;l&uacute;a m&igrave; l&agrave; một loại lương thực chung được sử dụng để l&agrave;m&nbsp;<a href=\"https://vi.wikipedia.org/wiki/B%E1%BB%99t_m%C3%AC\">bột m&igrave;</a>&nbsp;trong sản xuất c&aacute;c loại&nbsp;<a href=\"https://vi.wikipedia.org/wiki/B%C3%A1nh_m%C3%AC\">b&aacute;nh m&igrave;</a>;&nbsp;<a href=\"https://vi.wikipedia.org/wiki/M%C3%AC_s%E1%BB%A3i\">m&igrave; sợi</a>, b&aacute;nh, kẹo v.v&nbsp;cũng như được l&ecirc;n men để sản xuất&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Bia_(%C4%91%E1%BB%93_u%E1%BB%91ng)\">bia</a>&nbsp;<a href=\"https://vi.wikipedia.org/wiki/R%C6%B0%E1%BB%A3u\">rượu</a>&nbsp;hay&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Nhi%C3%AAn_li%E1%BB%87u_sinh_h%E1%BB%8Dc\">nhi&ecirc;n liệu sinh học</a>. L&uacute;a m&igrave; cũng được gieo trồng ở quy m&ocirc; hạn hẹp l&agrave;m&nbsp;<a href=\"https://vi.wikipedia.org/wiki/C%E1%BB%8F_kh%C3%B4\">cỏ kh&ocirc;</a>&nbsp;cho&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Gia_s%C3%BAc\">gia s&uacute;c</a>&nbsp;v&agrave;&nbsp;<a href=\"https://vi.wikipedia.org/wiki/R%C6%A1m\">rơm</a>&nbsp;cũng c&oacute; thể d&ugrave;ng l&agrave;m cỏ kh&ocirc; cho gia s&uacute;c hay vật liệu x&acirc;y dựng để lợp m&aacute;i.</p>\r\n', 1, '2021-12-18 06:26:46', '2022-05-23 07:28:50'),
(5, 1, 'BÁNH MÌ MỚI LẠ!', 'Tiệm bánh có nhiều loại bánh thơm ngon, hương vị khác nhau, phù hợp với mọi lứa tuổi. Tiệm luôn cập nhật những loại bánh mới, hot hit trên thị trường.  Chủ tiệm bánh luôn học hỏi các kinh nghiệm và sáng tạo ra các công thức làm bánh mới.', '1650641005-product-hieuhieu-194008024038-banh-mi-va-niem-tu-hao-cua-nuoc-phap.jpg', '<p><strong>B&aacute;nh m&igrave; Việt Nam</strong>&nbsp;(gọi tắt:&nbsp;<strong>b&aacute;nh m&igrave;</strong>) l&agrave; một m&oacute;n ăn&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Vi%E1%BB%87t_Nam\">Việt Nam</a>, với lớp vỏ ngo&agrave;i l&agrave; một ổ&nbsp;<a href=\"https://vi.wikipedia.org/wiki/B%C3%A1nh_m%C3%AC\">b&aacute;nh m&igrave;</a>&nbsp;nướng c&oacute; da gi&ograve;n, ruột mềm, c&ograve;n b&ecirc;n trong l&agrave; phần nh&acirc;n. T&ugrave;y theo văn h&oacute;a v&ugrave;ng miền hoặc sở th&iacute;ch c&aacute; nh&acirc;n, người ta c&oacute; thể chọn nhiều nh&acirc;n b&aacute;nh m&igrave; kh&aacute;c nhau. Tuy nhi&ecirc;n, loại nh&acirc;n b&aacute;nh truyền thống thường chứa&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ch%E1%BA%A3_l%E1%BB%A5a\">chả lụa</a>,&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Th%E1%BB%8Bt\">thịt</a>,&nbsp;<a href=\"https://vi.wikipedia.org/wiki/C%C3%A1_(th%E1%BB%B1c_ph%E1%BA%A9m)\">c&aacute;</a>,&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Thu%E1%BA%A7n_chay\">thực phẩm chay</a>&nbsp;hoặc&nbsp;<a href=\"https://vi.wikipedia.org/wiki/M%E1%BB%A9t\">mứt tr&aacute;i c&acirc;y</a>, k&egrave;m theo một số nguy&ecirc;n liệu phụ kh&aacute;c như&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Pat%C3%AA\">pat&ecirc;</a>,&nbsp;<a href=\"https://vi.wikipedia.org/wiki/B%C6%A1\">bơ</a>,&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Rau\">rau</a>,&nbsp;<a href=\"https://vi.wikipedia.org/wiki/%E1%BB%9At\">ớt</a>&nbsp;v&agrave;&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Mu%E1%BB%91i_chua\">đồ chua</a>. B&aacute;nh m&igrave; được xem như một loại&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Th%E1%BB%A9c_%C4%83n_nhanh\">thức ăn nhanh</a>&nbsp;b&igrave;nh d&acirc;n v&agrave; thường được ti&ecirc;u thụ trong bữa s&aacute;ng hoặc bất kỳ bữa phụ n&agrave;o trong ng&agrave;y. Do c&oacute; gi&aacute; th&agrave;nh ph&ugrave; hợp n&ecirc;n b&aacute;nh m&igrave; trở th&agrave;nh m&oacute;n ăn được rất nhiều người ưa chuộng.</p>\r\n', 1, '2022-04-22 15:23:25', '2022-05-17 15:48:07'),
(6, 1, 'VÌ SAO LẠI NÊN ĂN BÁNH MÌ SANDWICHES VÀO BUỔI SÁNG?', 'Sandwich là món bánh mì kẹp có nguồn gốc từ phương Tây. Một chiếc sandwich điển hình gồm có rau củ, thịt, phomai thái lát và hai miếng bánh mì sandwich.', '1653270701-new-cach-lam-banh-mi-sandwich-1-600x400.jpg', '<p>Tuy nhi&ecirc;n, khi du nhập v&agrave;o Việt Nam, sandwich được biến tấu với nhiều th&agrave;nh phần v&agrave; gia vị kh&aacute;c nhau. Với m&oacute;n sandwich c&aacute; ngừ, bạn c&oacute; thể tận dụng những nguy&ecirc;n liệu trong tủ v&agrave; kết hợp th&agrave;nh bữa s&aacute;ng thơm ngon, dễ d&agrave;ng chế biến.&nbsp;</p>\r\n', 1, '2022-05-23 01:51:27', '2022-05-23 08:51:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `price_total` int(11) NOT NULL,
  `payment_status` tinyint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `address`, `mobile`, `email`, `note`, `price_total`, `payment_status`, `created_at`, `updated_at`) VALUES
(15, 0, 'Nguyễn Thị Huyền', 'Nguyên Xá - Bắc Từ Liêm - Hà Nội', 123, 'nguyenhuyenit2.k14@gmail.com', 'Không', 15000, 0, '2022-06-27 14:26:31', '2022-06-27 21:26:31'),
(16, 0, 'Nguyễn Thị Huyền', 'Nguyên Xá - Bắc Từ Liêm - Hà Nội', 123, 'nguyenhuyenit2.k14@gmail.com', 'Không', 15000, 1, '2022-06-27 14:30:03', '2022-06-27 22:00:59'),
(17, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 966614732, 'nguyenhuyenit2.k14@gmail.com', 'Không', 35000, 0, '2022-06-27 14:32:49', '2022-06-27 21:32:49'),
(18, 0, 'Lê Thị Hiền', 'Nguyên Xá - Bắc Từ Liêm - Hà Nội', 123456, 'lehien@gmail.com', 'Không', 120000, 1, '2022-06-27 14:59:36', '2022-07-01 07:19:03'),
(19, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 123, 'huyenkute622001@gmail.com', '', 50000, 1, '2022-06-27 15:02:14', '2022-06-30 15:23:46'),
(20, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 123456, 'huyenkute622001@gmail.com', '', 250000, 0, '2022-06-27 15:06:05', '2022-06-27 22:06:05'),
(21, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 966614732, 'nguyenhuyenit2.k14@gmail.com', 'Không', 30000, 0, '2022-06-28 03:27:30', '2022-06-28 10:27:30'),
(22, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 966614732, 'nguyenhuyenit2.k14@gmail.com', 'Không', 30000, 0, '2022-06-28 04:33:15', '2022-06-28 11:33:15'),
(23, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 966614732, 'nguyenhuyenit2.k14@gmail.com', 'Không', 30000, 0, '2022-06-28 04:33:20', '2022-06-28 11:33:20'),
(24, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 966614731, 'nguyenhuyenit2.k14@gmail.com', 'Không', 60000, 0, '2022-06-30 08:21:19', '2022-06-30 15:21:19'),
(25, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 966614731, 'nguyenhuyenit2.k14@gmail.com', 'Không', 60000, 0, '2022-06-30 08:22:04', '2022-06-30 15:22:04'),
(26, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 198, 'nguyenhuyenit2.k14@gmail.com', 'Không', 50000, 0, '2022-06-30 16:35:43', '2022-06-30 23:35:43'),
(27, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 123, 'nguyenhuyenit2.k14@gmail.com', 'Không', 30000, 0, '2022-07-01 00:15:41', '2022-07-01 07:15:41'),
(28, 0, 'Nguyễn Thị Huyền', 'Đan Phượng - Hà Nội', 3265, 'huyenkute622001@gmail.com', 'giao nhanh', 80000, 0, '2022-07-01 00:35:03', '2022-07-01 07:35:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quality` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quality`, `created_at`, `updated_at`) VALUES
(1, 14, 8, '1', '2022-06-27 14:13:43', '2022-06-27 21:13:43'),
(2, 17, 7, '1', '2022-06-27 14:32:49', '2022-06-27 21:32:49'),
(3, 17, 10, '1', '2022-06-27 14:32:49', '2022-06-27 21:32:49'),
(4, 18, 14, '2', '2022-06-27 14:59:36', '2022-06-27 21:59:36'),
(5, 18, 9, '1', '2022-06-27 14:59:36', '2022-06-27 21:59:36'),
(6, 19, 14, '1', '2022-06-27 15:02:14', '2022-06-27 22:02:14'),
(7, 20, 14, '5', '2022-06-27 15:06:05', '2022-06-27 22:06:05'),
(8, 21, 13, '1', '2022-06-28 03:27:30', '2022-06-28 10:27:30'),
(9, 22, 13, '1', '2022-06-28 04:33:15', '2022-06-28 11:33:15'),
(10, 23, 13, '1', '2022-06-28 04:33:20', '2022-06-28 11:33:20'),
(11, 24, 13, '2', '2022-06-30 08:21:19', '2022-06-30 15:21:19'),
(12, 25, 13, '2', '2022-06-30 08:22:04', '2022-06-30 15:22:04'),
(13, 26, 14, '1', '2022-06-30 16:35:43', '2022-06-30 23:35:43'),
(14, 27, 13, '1', '2022-07-01 00:15:41', '2022-07-01 07:15:41'),
(15, 28, 13, '1', '2022-07-01 00:35:03', '2022-07-01 07:35:03'),
(16, 28, 14, '1', '2022-07-01 00:35:03', '2022-07-01 07:35:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `hot` varchar(255) DEFAULT NULL,
  `status` tinyint(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `title`, `avatar`, `price`, `weight`, `supplier`, `summary`, `content`, `hot`, `status`, `created_at`, `updated_at`) VALUES
(3, 2, 'Quả mâm xôi', '1639807356-product-phuc-bon-tu_large.jpg', 10000, '200 gr', 'Bách hóa xanh', 'Ngọt, mát và giàu vitamin', '<p>Được theo trồng theo m&ocirc; h&igrave;nh hiện đại, n&oacute;i kh&ocirc;ng với thuốc trừ s&acirc;u v&agrave; ph&acirc;n b&oacute;n h&oacute;a học mang lại hương vị thanh m&aacute;t</p>\r\n', '1', 1, '2021-12-18 06:02:36', '2021-12-18 13:02:36'),
(4, 2, 'Bí đỏ', '1639807575-product-bi-nhat_large.jpg', 6000, '600 gr', 'Bách hóa xanh', 'Giàu vitamin A và chất xơ', '<p>Gieo trồng trong m&ocirc;i trường tự nhi&ecirc;n, c&oacute; vị b&eacute;o, b&ugrave;i rất th&iacute;ch hợp để l&agrave;m thức ăn bổ dưỡng.</p>\r\n', '1', 1, '2021-12-18 06:06:15', '2021-12-18 13:06:15'),
(5, 3, 'Đậu bắp', '1639807661-product-dau_bap_large.gif', 15000, '500 gr', 'Bách hóa xanh', 'GIàu chất xơ và vitamin', '<p>Th&iacute;ch hợp ăn lẩu trong m&ugrave;a đ&ocirc;ng lạnh gi&aacute;</p>\r\n', NULL, 1, '2021-12-18 06:07:41', '2021-12-18 13:07:41'),
(6, 3, 'Khoai lang mật', '1639807746-product-khoai-lang-mat_large.jpg', 20000, '700 gr', 'Nông sản Việt', 'Giàu vitamin ', '<p>Khoa lang mật nướng l&ecirc;n ngon tuyệt c&uacute; m&egrave;o!</p>\r\n', '1', 1, '2021-12-18 06:09:06', '2021-12-18 13:09:06'),
(7, 1, 'Sandwiches', '1650639179-product-(443x443)_fh_Banh_Mi_Sandwich.jpg', 15000, '500 gr', 'Tiệm bánh Thanh Cảnh', 'Giàu tinh bột  và chất xơ', '<p>Mang đến cho người d&ugrave;ng hương vị thơm ngon, ngậy ngậy từ l&uacute;a mạch nguy&ecirc;n chất</p>\r\n', '1', 1, '2021-12-18 06:10:51', '2022-05-17 15:52:14'),
(8, 1, 'Sandwiches', '1650639011-product-(443x443)_fh_Banh_Mi_Sandwich.jpg', 15000, '200 gr', 'Tiệm bánh Thanh Cảnh', 'Giàu tinh bột và chất xơ', '<p>Mang đến cho người d&ugrave;ng hương vị thơm ngon, ngậy ngậy từ l&uacute;a mạch nguy&ecirc;n chất</p>\r\n', '1', 1, '2021-12-18 06:12:07', '2022-05-17 15:53:51'),
(9, 4, 'Bánh mì chay', '1652750565-product-Screenshot 2022-05-17 082223.png', 20000, '200 gr', 'Tiệm bánh Thanh Cảnh', 'Bánh mì thơm ngon', '<p>B&aacute;nh m&igrave; đơn giản với sự kết hợp c&ugrave;ng c&aacute;c thực phẩm chay tạo n&ecirc;n m&ugrave;i vị mới lạ!</p>\r\n', '1', 1, '2022-04-22 14:59:55', '2022-05-17 15:50:24'),
(10, 4, 'Bánh mì chay', '1652750589-product-Screenshot 2022-05-17 082223.png', 20000, '500 gr', 'Tiệm bánh Thanh Cảnh', 'Bánh mì thơm ngon', '<p>B&aacute;nh m&igrave; đơn giản với sự kết hợp c&ugrave;ng c&aacute;c thực phẩm chay tạo n&ecirc;n m&ugrave;i vị mới lạ!</p>\r\n', '1', 1, '2022-04-22 15:01:16', '2022-05-17 15:50:33'),
(11, 11, 'Bánh mì nhân dừa', '1650640201-product-thanh-pham-16.png', 10000, '200 gr', 'Tiệm bánh Thanh Cảnh', 'Bánh mì thơm ngoan, bùi bùi', '<p>B&aacute;nh M&igrave; Ngọt Nh&acirc;n Sữa Dừa ngon tuyệt của nh&agrave; m&igrave;nh nhaa</p>\r\n', '1', 1, '2022-04-22 15:04:05', '2022-05-17 15:53:37'),
(12, 11, 'Bánh mì nhân dừa', '1650640292-product-thanh-pham-16.png', 20000, '500 gr', 'Tiệm bánh Thanh Cảnh', 'Bánh mì thơm ngon', '<p>B&aacute;nh M&igrave; Ngọt Nh&acirc;n Sữa Dừa ngon tuyệt của nh&agrave; m&igrave;nh nhaa</p>\r\n', '1', 0, '2022-04-22 15:11:32', '2022-05-17 15:52:50'),
(13, 12, 'Bánh mì đen', '1650683784-product-banh-mi-den-tot-cho-suc-khoe.jpg', 30000, '250 gr', 'Tiệm bánh Thanh Cảnh', 'Bánh mì có mùi vị ngon tuyệt cú mèo!', '<p>B&aacute;nh m&igrave; đen hay b&aacute;nh m&igrave; l&uacute;a mạch l&agrave; một loại b&aacute;nh m&igrave; được chế biến nh&agrave;o bột bằng tỷ lệ kh&aacute;c nhau của bột m&igrave; từ hạt l&uacute;a mạch đen.&nbsp;</p>\r\n', '1', 1, '2022-04-23 03:15:05', '2022-05-17 15:51:46'),
(14, 12, 'Bánh mì đen', '1652750405-product-banh-mi-den-tot-cho-suc-khoe.jpg', 50000, '500 gr', 'Tiệm bánh Thanh Cảnh', 'Bánh mì thơm ngon tuyệt cú mèo!', '<p>B&aacute;nh m&igrave; đen hay b&aacute;nh m&igrave; l&uacute;a mạch l&agrave; một loại b&aacute;nh m&igrave; được chế biến nh&agrave;o bột bằng tỷ lệ kh&aacute;c nhau của bột m&igrave; từ hạt l&uacute;a mạch đen.</p>\r\n', '1', 1, '2022-04-23 04:10:03', '2022-05-17 15:51:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `component_img` varchar(255) NOT NULL,
  `title_component` varchar(255) NOT NULL,
  `title_detail` varchar(255) NOT NULL,
  `store_img` varchar(255) NOT NULL,
  `status` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `slides`
--

INSERT INTO `slides` (`id`, `avatar`, `position`, `component_img`, `title_component`, `title_detail`, `store_img`, `status`, `created_at`, `updated_at`) VALUES
(15, '1650636155-Bread_Banner.jpg', 1, '1650636868-banner_spring_bread.jpg', 'ĐA DẠNG LOẠI BÁNH', 'Bánh mì đen lúa mạch được làm từ sự kết hợp giữa hạt và bột lúa mạch đen. Hiện nay, có nhiều loại bánh mì đen lúa mạch khác nhau, tùy thuộc vào các công thức kết hợp riêng của từng loại bánh. Có loại bánh mì đen chỉ được làm từ bột lúa mạch lấy phần lõi..', '1652775440-IMG_0908.jpg', 1, '2022-04-22 14:02:35', '2022-05-17 15:17:20'),
(16, '1650636212-Rye-Bread-with-Toppings-banner-crop.jpg', 1, '1650637213-banner.jpg', 'CHẤT LƯỢNG TUYỆT VỜI', 'Một chiếc Bánh mì chỉ có giá 20 nghìn nhưng người ăn sẽ được thỏa mãn cả 6 giác quan: nhìn ngon mắt, ăn ngon miệng, nghe vui tai, cầm ấm nóng, mùi thơm lừng và no căng bụng. Vỏ bánh giòn rụm còn nhân thì ngập những miếng thịt quay thơm lừng, pate béo ngậy', '1652775461-banh-mi-chay-1.jpg', 1, '2022-04-22 14:03:32', '2022-05-17 15:17:41'),
(17, '1650636294-bread-banner.jpg', 1, '1650637253-bread-basket-banner.png', 'NGUYÊN LIỆU 100% TỰ NHIÊN', 'Lúa mì là một trong những loại ngũ cốc lâu đời nhất thế giới, nó còn có tên gọi khác là lúa miến hay tiểu mạch. Trong các giống lúa mì hiện nay, loại lúa mì Triticum aestivum, đây là một giống thuộc nhóm cỏ Triticum và thuần dưỡng từ khu vực Levant...', '1652775484-Hoa-Cúc-3.jpg', 1, '2022-04-22 14:04:54', '2022-05-17 15:18:04'),
(19, '1652750051-531461.jpg', 1, '1652237222-recipe1886-635702376825999931.jpg', 'MÙI VỊ TUYỆT ĐỐI', 'Những cửa hàng bánh mì đã có mặt trên những con đường ở khu Little Saigon từ mấy thập niên, nhưng mãi đến gần đây mới thật sự chinh phục được bao tử của những người dân bản xứ. Ổ bánh mì kẹp thịt, ly cà phê đen... Những món ăn rất đơn giản ở quê nhà', '1652775521-photo.jpg', 1, '2022-04-23 04:12:12', '2022-05-17 15:18:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` text NOT NULL,
  `address` text NOT NULL,
  `email` char(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `phone`, `address`, `email`, `created_at`, `updated_at`) VALUES
(1, 'LeHien', 'f3b4dd0cc01eef2fd1bdd64c37fd25aa', '', '', '', '', '', '2021-12-18 05:32:51', '2021-12-18 12:32:51'),
(2, 'Lê Thị Hiền', 'a07d1c62752a41a23123a931dee03598', '', '', '', '', '', '2021-12-28 15:05:03', '2021-12-28 22:05:03'),
(3, 'Thùy chi', 'a07d1c62752a41a23123a931dee03598', '', '', '', '', '', '2022-01-10 03:45:36', '2022-01-10 10:45:36'),
(4, 'vuquan1234567812345678@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'Tùng', 'Vũ', '01234556677', 'nam từ liêm hà nội', 'vuquan1234567812345678@gmail.com', '2024-06-19 08:09:54', '2024-06-19 15:09:54'),
(5, '2020600157', '25d55ad283aa400af464c76d713c07ad', 'Tùng', 'Vũ', '(+84) 784 570 335', 'nam từ liêm hà nội', 'vutuantu@gmail.com', '2024-06-19 08:19:37', '2024-06-19 15:19:37'),
(6, '12345678', '25d55ad283aa400af464c76d713c07ad', 'Tùng', 'Vũ', '0941208572', 'nam từ liêm hà nội', 'nvt@gmail.com', '2024-06-19 08:20:43', '2024-06-19 15:20:43');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `introduces`
--
ALTER TABLE `introduces`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `introduces`
--
ALTER TABLE `introduces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `maps`
--
ALTER TABLE `maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
