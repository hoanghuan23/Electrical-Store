-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 02, 2023 lúc 10:21 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `btl_web06_stt13`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `ad_name` varchar(255) NOT NULL,
  `ad_password` varchar(255) NOT NULL,
  `ad_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `ad_name`, `ad_password`, `ad_status`) VALUES
(1, 'admin1', 'admin123', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_cart_detail`
--

CREATE TABLE `tbl_cart_detail` (
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cate_id` int(11) NOT NULL,
  `cate_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category`
--

INSERT INTO `tbl_category` (`cate_id`, `cate_name`, `status`) VALUES
(6, 'Basas', 1),
(7, 'Urbas', 1),
(8, 'Vintas', 1),
(9, 'Pattas', 1),
(10, 'Tote Bag', 1),
(11, 'Hoodie', 1),
(12, 'Track 6', 1),
(13, 'Hat', 1),
(16, 'Graphic Tee', 1),
(17, 'Socks | Vớ', 1),
(18, 'Sweater', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_news`
--

CREATE TABLE `tbl_news` (
  `new_id` int(11) NOT NULL,
  `cate_id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `news_desc` varchar(10000) NOT NULL,
  `author` varchar(50) NOT NULL,
  `cont1` varchar(1000) NOT NULL,
  `cont2` varchar(1000) NOT NULL,
  `cont3` varchar(1000) NOT NULL,
  `img` varchar(255) NOT NULL,
  `img2` varchar(255) NOT NULL,
  `img3` varchar(255) NOT NULL,
  `img_note` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_news`
--

INSERT INTO `tbl_news` (`new_id`, `cate_id`, `title`, `news_desc`, `author`, `cont1`, `cont2`, `cont3`, `img`, `img2`, `img3`, `img_note`, `date`, `status`) VALUES
(2, 9, 'SNEAKER FEST VIETNAM VÀ SỰ KẾT HỢP', '                    Việc sử dụng dáng giày Vulcanized High Top của Ananas trong thiết kế và cảm hứng bắt nguồn từ linh vật Peeping - đại diện cho tinh thần xuyên suốt 6 năm qua Sneaker Fest Vietnam, chúng tôi tự tin đây sẽ là sản phẩm đáng mong chờ cho mọi “đầu giày” vào mùa hè năm nay...     \r\n', 'admin', '<p>Có mặt tại Sneaker Fest Vietnam 2019, Ananas hân hạnh giới thiệu đến bạn một phát hành mang tên Ananas Peeping Pattas - bản collab giới hạn đặc biệt đánh dấu cho lần đầu hợp tác giữa hai bên. Dáng giày Vulcanized High Top của Ananas được lựa chọn trong thiết kế và cảm hứng bắt nguồn từ linh vật Peeping - đại diện cho tinh thần xuyên suốt 6 năm qua của Sneaker Fest Vietnam, chúng tôi tự tin đây sẽ là sản phẩm đáng mong chờ cho mọi “đầu giày” vào mùa hè 2019 này.</p>', '<p>Với số lượng phát hành giới hạn chỉ 50 đôi, cộng với việc các chi tiết sản phẩm, packaging của Ananas Peeping Pattas đều được \"chăm chút\" với các ý tưởng mới, khác biệt so với những phiên bản trước đây từ Ananas càng làm cho bản collab trở nên đặc biệt.</p>', '<p>Về tổng thể, bộ đế cao su All white tối giản làm phần nền vững chắc và tạo điểm nhấn cho phần Upper bên trên có phần phức tạp. Chất liệu vải canvas 10oz cao cấp màu Black được sử dụng bao quanh bức tranh đầy màu sắc, trải dài và phủ toàn bộ phần má và cổ giày. Gương mặt Peeping (linh vật quen thuộc của các kì Sneaker Fest VietNam) trở nên nổi bật hơn bao giờ hết khi được sử dụng 2 màu black&amp;white ngay tại trung tâm artwork. Bản collab đem lại cho người nhìn cảm giác về một thế hệ trẻ cá tính, có phần nổi loạn nhưng cũng rất tích cực trong hành trình tìm kiếm và khẳng định bản thân.</p>', 'news_item3.jpg', 'news_item3-1.jpg', 'news_item3-2.jpg', 'Thiết kế mang \"linh hồn của Sneaker Fest Vietnam với linh vật đại diện Peeping làm trung tâm', '2023-11-15 15:25:05', 1),
(4, 8, 'VINTAS SAIGON 1980s', 'Với bộ 5 sản phẩm, Vintas Saigon 1980s Pack đem đến một sự lựa chọn “cũ kỹ thú vị” cho những người trẻ sống giữa thời hiện đại nhưng lại yêu nét bình dị của Sài Gòn ngày xưa ...                ', 'admin', '<p>Là một bộ sưu tập thuộc dòng sản phẩm Vintas, <i><strong>Saigon 1980s Pack</strong></i> đem đến một sự lựa chọn “cũ kỹ thú vị”, phù hợp cho những người trẻ sống giữa thời hiện đại nhưng lại yêu cái nét bình dị của Sài Gòn ngày xưa.</p>', '<p>Với cảm hứng từ hình ảnh mang \"màu film\" của đường phố Sài Gòn, nét riêng của Vintas Saigon 1980s Pack nổi bật qua đặc điểm: không “nét căng”, không rực rỡ mà lại thiên về sắc xanh, đỏ nhiều cảm xúc. Cụ thể, những màu sắc như Dark Denim, Vin Black, Sedona Sage và Vin Cordovan được ứng dụng trong thiết kế đều là những màu bạn dễ dàng bắt gặp khi tìm đọc các tài liệu về Sài Gòn trong quá khứ. Trên dáng giày Low Top / High Top cơ bản, cảm giác hoài niệm mà Vintas Saigon 1980s mang lại gợi người ta nhớ về hình bóng của Sài Gòn vào những năm “1900 hồi đó”. Gam màu trầm của Upper khi sử dụng chất liệu Canvas dày dặn phối cùng Suede, cộng thêm sự chắc chắn của chiếc đế cao su (vulcanized) màu gum tự nhiên, 5 lựa chọn thuộc Vintas Saigon 1980s Pack tạo nên một bức tranh hoài cổ, thể hiện sự điềm đạm trong tính cách người mang.</p>', '<p>Những quán cà phê “cóc” kê cái bàn, cái ghế đơn giản với đủ mọi đối tượng khách hàng từ anh xe ôm đến bác hàng xóm ra ngồi đọc báo, chơi cờ; những tiệm may đo áo dài, veston nơi người thợ may tự tay cầm thước dây đo khách từng chút một; những chiếc bạt dựng tạm nơi vỉa hè cùng dòng chữ “hớt tóc” viết vội bằng tay. Nghĩ về Sài Gòn xưa, có lẽ rất khó để không nhớ đến những hình ảnh đặc trưng này.</p><p>Trong quá trình tìm kiếm chất liệu để thể hiện concept, chúng tôi may mắn gặp được một nhóm bạn trẻ mang sẵn \"nét xưa Vintas\" trong tính cách. Họ vốn đã yêu Sài Gòn, yêu những điều xưa cũ và gần gũi nơi đây. Do đó, câu chuyện về một ngày bình thường trong bối cảnh \"hơi khác thường\" của cậu thanh niên Thích Thanh Thế được xây dựng với cảm xúc rất tự nhiên, chân thật.</p>', 'news_item2.jpg', 'news_item2-1.jpg', 'news_item2-2.jpg', 'Vintas “Saigon 1980s” - must-have item của những con người yêu phong cách vintage / retro', '2023-11-15 16:14:24', 1),
(7, 6, '\"GIẢI PHẪU\" GIÀY VULCANIZED', 'Trong phạm vi bài viết ngắn, hãy cùng nhau tìm hiểu cấu tạo giày Vulcanized Sneaker - loại sản phẩm mà Ananas đã chọn làm \"cốt lõi\" để theo đuổi trong suốt hành trình của mình...', 'admin', '<p>Trước khi thực hiện cuộc \"giải phẫu\" như tiêu đề của bài viết, chúng tôi nghĩ bạn cần biết rằng những đôi giày Sneaker bạn trên chân mỗi ngày hiện tại đang được chia làm 2 nhóm chính nếu phân loại chúng dựa trên phương pháp sản xuất:</p>', '<p>- Nhóm thứ nhất là <i><strong>Cold Cement Sneaker</strong></i> bao gồm những mẫu Sneaker được làm từ phương pháp dán đế lạnh - đại diện cho nhóm này là những đôi giày \"ai cũng biết\" như Nike Air Force 1, Adidas Originals Stan Smith, Puma Suede, Asics Onitsuka Tiger Corsair,..hay những đôi giày Sportswear phục vụ cho các hoạt động thể thao.<br>- Nhóm thứ hai là <i><strong>Vulcanized Sneaker</strong></i> hay còn gọi giày cao su lưu hóa. Đây là những đôi giày mang form dáng classic, tối giản đã trở nên \"bất hủ\" với phương pháp sản xuất đã có từ rất lâu như Converse Chuck Taylor All Star, Vans Old Skool...và những đôi giày thuộc các dòng Basas, Vintas, Urbas từ Ananas hiện tại các bạn đang chọn lựa.</p>', '<p>Mỗi nhóm giày lại mang một ưu, nhược điểm khác nhau tuỳ theo sự lựa chọn của mỗi người. Trong phạm vi ngắn của bài viết này, Ananas xin phép chỉ đào sâu thông tin xoay quanh cấu tạo của <i><strong>Vulcanized Sneaker</strong></i> (giày Vulcanized) - loại giày mà chúng tôi đã chọn làm \"cốt lõi\" để theo đuổi trong suốt hành trình của mình và \"mách\" cho bạn cách dễ nhất để phân biệt chúng với nhóm còn lại.</p>', 'news_item4.jpg', 'news_item4-1.jpg', 'news_item4-2.jpg', 'Có nhiều thông tin về cách gọi tên về các bộ phận trên giày, vì thế để tránh thông tin bị nhập nhằng, chúng tôi đã thống nhất sử dụng các từ ngữ được dùng trong quá trình sản xuất để gọi tên những bộ phận trên đôi giày của mình.', '2023-11-15 17:09:02', 1),
(8, 7, 'URBAS CORLURAY PACK', 'Mỗi nhóm giày lại mang một ưu, nhược điểm khác nhau tuỳ theo sự lựa chọn của mỗi người. Trong phạm vi ngắn của bài viết này, Ananas xin phép chỉ đào sâu thông tin xoay quanh cấu tạo của Vulcanized Sneaker (giày Vulcanized) - loại giày mà chúng tôi đã chọn làm \"cốt lõi\" để theo đuổi trong suốt hành trình của mình và \"mách\" cho bạn cách dễ nhất để phân biệt chúng với nhóm còn lại.', 'admin', '<p>Là bộ sản phẩm thuộc dòng Urbas, <strong>Corluray Pack</strong> đem đến lựa chọn “làm mới mình” với sự kết hợp 5 gam màu mang sắc thu; phù hợp với những người trẻ năng động, mong muốn thể hiện cá tính riêng biệt khó trùng lặp.</p>', '<p>Chất liệu <i>Corduroy</i> lần đầu tiên được ứng dụng trên dáng giày Low/High Top quen thuộc, kết hợp với cảm hứng bất chợt từ những tia nắng (ray) cuối cùng của kì nghỉ xuân “dài hạn\", vượt qua mùa hạ để chạm thẳng sang thu. Hai yếu tố trên phối trộn cùng với những gam màu tươi tắn để tạo nên một cái tên <strong>Corluray</strong> đầy ý nghĩa.</p>', '<p>Hẳn mọi người đã không mấy xa lạ với chất liệu Corduroy - Nhung gân với các sợi nổi trên bề mặt cùng tính chất bền bỉ, đa dụng và ấm áp. Đặc biệt, tên gọi khác của loại vải Corduroy sợi to (3-8 sợi/inch) - <strong>Elephant Cord</strong> được chúng tôi cố tình cho xuất hiện cầu kỳ trên tất cả các phối màu của bộ sản phẩm nhằm nhấn mạnh và tạo ấn tượng với việc lần đầu tiên ứng dụng loại vải khác trên phần Upper.</p>', 'news_item1.jpg', 'news_item1-1.jpg', 'news_item1-2.jpg', 'Urbas Corluray Pack đem đến cho bạn một cảm giác khác \"lạ\".', '2023-11-15 17:48:11', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_order`
--

CREATE TABLE `tbl_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_code` int(255) NOT NULL,
  `total_price` int(255) NOT NULL,
  `order_payment_method` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `product_code` varchar(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_color` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_desc` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `img_hover` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `cate_id`, `product_code`, `product_name`, `product_color`, `product_price`, `product_desc`, `img`, `img_hover`, `gender`, `product_quantity`, `date`, `status`) VALUES
(6, 16, 'Ao111', 'Graphic Tee - The Guitar Sings', 'Jet Black', 240000, '', 'men1-500x500.jpg', 'men1-hover-500x500.jpg', 'men', 9, '2023-11-15 09:52:34', 3),
(9, 16, 'Ao112', 'Graphic Tee - Skate 4p', 'Vibrant Orange', 250000, '', 'men2-500x500.jpg', 'men2-hover-500x500.jpg', 'men', 6, '2023-11-10 16:46:53', 3),
(10, 16, 'Ao113', 'Long Sleeve Graphic Tee - Love, Peace & Music', 'Jet Black', 250000, '<p>Men</p>', 'men3-500x500.jpg', 'men3-hover-500x500.jpg', 'men', 6, '2023-11-10 16:48:37', 3),
(11, 16, 'Ao114', 'Long Sleeve Graphic Tee - Love, Peace & Music', 'Snow White', 250000, '<p>men</p>', 'men4-500x500.jpg', 'men4-hover-500x500.jpg', 'men', 5, '2023-11-10 17:16:48', 3),
(12, 13, 'Mu001', 'Trucker Hat - Be Positive', 'Black/White', 150000, '<p>This is hat.</p>', 'men5-500x500.jpg', 'men5-hover-500x500.jpg', 'unisex', 10, '2023-11-10 17:18:04', 3),
(13, 18, 'Sw001', 'Typo Sweatshirt', 'White', 290000, '<p>This is Sweater</p>', 'men6-500x500.jpg', 'men6-hover-500x500.jpg', 'men', 11, '2023-11-15 15:43:21', 3),
(14, 12, 'Giay001', 'Track 6 2.Blues - Low Top', 'Bluewash', 1175000, '<p>This is shoes</p>', 'men7-500x500.jpeg', 'men7-hover-500x500.jpeg', 'unisex', 3, '2023-11-10 17:22:43', 3),
(16, 7, 'Giay002', 'Urbas Corluray Mix - Low Top', 'Corluray Mix', 750000, '<p>This is shoes</p>', 'men8-500x500.jpeg', 'men8-hover-500x500.jpeg', 'unisex', 5, '2023-11-10 17:23:54', 3),
(17, 17, 'Tat001', 'High Crew Socks - Ananas Puppet Club', 'Tie Dye', 90000, '<p>This is socks</p>', 'men9-500x500.jpeg', 'men9-hover-500x500.jpg', 'unisex', 6, '2023-11-10 17:29:50', 3),
(19, 16, 'Ao115', 'Graphic Tee - Skate 4p', 'Snow White', 250000, '', 'wm1-500x500.jpg', 'wm1-hover-1-500x500.jpg', 'women', 5, '2023-11-10 17:38:25', 3),
(20, 16, 'Ao116', 'Graphic Tee - The Guitar Sings', 'Jet Black', 250000, '', 'wm2-500x500.jpg', 'wm2-hover-500x500.jpg', 'women', 8, '2023-11-10 17:40:02', 3),
(21, 10, 'Tui001', 'Tote Bag - Go Skate', 'Jet Black', 190000, '<p>This is Tote Bag</p>', 'wm3-500x500.jpeg', 'wm3-hover-500x500.jpeg', 'women', 1, '2023-11-10 17:41:07', 3),
(22, 9, 'Giay003', 'Pattas Tomo - High Top', 'Offwhite', 1590000, '<p>This is shoes</p>', 'wm4-500x500.jpeg', 'wm4-hover-500x500.jpeg', 'unisex', 4, '2023-11-10 17:42:06', 3),
(23, 6, 'Giay004', 'Basas Bumper Gum EXT NE - Low Top', 'Offwhite/Gum', 580000, '<p>This is shoes</p>', 'wm5-500x500.jpg', 'wm5-hover-500x500.jpg', 'unisex', 9, '2023-11-10 17:43:37', 3),
(24, 6, 'Giay005', 'Basas Bumper Gum NE - Mule', 'Offwhite/Gum', 490000, '<p>This is shoes</p>', 'wm6-500x500.jpeg', 'wm6-hover-500x500.jpeg', 'women', 6, '2023-11-10 17:44:43', 3),
(25, 18, 'Ao117', 'Cactus LL Symbol Sweatshirt', 'Golden Orange', 290000, '', 'wm7-500x500.jpg', 'wm7-hover-500x500.jpg', 'women', 4, '2023-11-10 17:46:48', 3),
(28, 16, 'Ao118', 'Hiphop Graphic Tee - Est. \'17', 'Black/Brown', 190000, 'This is T-shirt\'s woman', 'wm8-500x500.jpg', 'wm8-hover-500x500.jpg', 'unisex', 8, '2023-11-15 15:44:03', 3),
(30, 16, 'Ao119', 'Graphic Tee - Skate 4p', 'Vibrant Orange', 250000, '', 'wm9-500x500.jpg', 'wm9-hover-500x500.jpg', 'women', 12, '2023-11-10 17:54:48', 3),
(31, 16, 'Ao119', 'Hiphop Graphic Tee - Outline Typo', 'Red', 290000, '', 'wm10-500x500.jpg', 'wm10-hover-500x500.jpg', 'women', 20, '2023-11-10 17:56:50', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_mobile` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user_contact`
--

CREATE TABLE `tbl_user_contact` (
  `user_id` int(11) NOT NULL,
  `order_code` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user_order`
--

CREATE TABLE `tbl_user_order` (
  `order_code` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `tbl_cart_detail`
--
ALTER TABLE `tbl_cart_detail`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cate_id`);

--
-- Chỉ mục cho bảng `tbl_news`
--
ALTER TABLE `tbl_news`
  ADD PRIMARY KEY (`new_id`);

--
-- Chỉ mục cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `tbl_news`
--
ALTER TABLE `tbl_news`
  MODIFY `new_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
