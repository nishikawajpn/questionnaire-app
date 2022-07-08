DROP DATABASE pollapp;
CREATE DATABASE IF NOT EXISTS pollapp DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE pollapp;

CREATE USER IF NOT EXISTS 'test_user'@'localhost' IDENTIFIED BY 'pwd';
GRANT ALL ON pollapp.* TO 'test_user'@'localhost';

CREATE TABLE `users` (
  `id` varchar(10) PRIMARY KEY COMMENT 'ユーザーID',
  `pwd` varchar(60) NOT NULL COMMENT 'パスワード',
  `nickname` varchar(10) NOT NULL COMMENT '公開用の名前',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `update_by` varchar(20) NOT NULL DEFAULT 'nishikawa' COMMENT '最終更新者',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
);

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT 'トピックID',
  `title` varchar(50) NOT NULL COMMENT 'トピック本文',
  `published` int(1) NOT NULL COMMENT '公開状態(1: 公開、0: 非公開)',
  `views` int(10) NOT NULL DEFAULT '0' COMMENT 'PV数',
  `user_id` varchar(10) NOT NULL COMMENT '作成したユーザーID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `update_by` varchar(20) NOT NULL DEFAULT 'nishikawa' COMMENT '最終更新者',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
);

CREATE TABLE `choices` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT '選択肢ID',
  `body` varchar(20) NOT NULL COMMENT '選択肢本文',
  `topic_id` int(10) NOT NULL COMMENT '所属するトピックのID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `update_by` varchar(20) NOT NULL DEFAULT 'nishikawa' COMMENT '最終更新者',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
);

CREATE TABLE `poll` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT '投票ID',
  `choice_id` int(10) COMMENT '選択肢ID',
  `topic_id` int(10) NOT NULL COMMENT 'トピックID',
  `user_id` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `update_by` varchar(20) NOT NULL DEFAULT 'nishikawa' COMMENT '最終更新者',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
);

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT 'コメントID',
  `body` varchar(30) NOT NULL COMMENT 'コメント本文',
  `topic_id` int(10) NOT NULL COMMENT 'トピックID',
  `user_id` varchar(10) NOT NULL COMMENT 'ユーザーID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `update_by` varchar(20) NOT NULL DEFAULT 'nishikawa' COMMENT '最終更新者',
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
);

START TRANSACTION;

SET time_zone = "+09:00";

INSERT INTO `users` (`id`, `pwd`, `nickname`, `del_flg`) VALUES
('test1', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー1', 0),
('test2', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー2', 0),
('test3', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー3', 0),
('test4', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー4', 0),
('test5', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー5', 0),
('test6', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー6', 0);

INSERT INTO `topics` (`id`, `title`, `published`, `views`, `user_id`, `del_flg`) VALUES
(1, '血液型は何型ですか？', 1, 8, 'test1', 0),
(2, '誕生日は何月ですか？', 1, 23, 'test1', 0),
(3, '身長は何センチですか？', 1, 3, 'test1', 0),
(4, '生まれ変わるなら男？女？', 1, 4, 'test1', 0);

INSERT INTO `choices` (`id`, `body`, `topic_id`, `del_flg`) VALUES
(1, 'A型', 1, 0),
(2, 'B型', 1, 0),
(3, 'O型', 1, 0),
(4, 'AB型', 1, 0),
(5, '1月', 2, 0),
(6, '2月', 2, 0),
(7, '3月', 2, 0),
(8, '4月', 2, 0),
(9, '5月', 2, 0),
(10, '6月', 2, 0),
(11, '7月', 2, 0),
(12, '8月', 2, 0),
(13, '9月', 2, 0),
(14, '10月', 2, 0),
(15, '11月', 2, 0),
(16, '12月', 2, 0),
(17, '140cm未満', 3, 0),
(18, '140〜149cm', 3, 0),
(19, '150〜159cm', 3, 0),
(20, '160〜169cm', 3, 0),
(21, '170〜179cm', 3, 0),
(22, '180〜189cm', 3, 0),
(23, '190〜199cm', 3, 0),
(24, '200cm以上', 3, 0),
(25, '男 → 男', 4, 0),
(26, '男 → 女', 4, 0),
(27, '女 → 男', 4, 0),
(28, '女 → 女', 4, 0);

INSERT INTO `poll` (`id`,  `choice_id`, `topic_id`, `user_id`, `del_flg`) VALUES
(1, 1, 1, 'test1', 0),
(2, 3, 1, 'test2', 0),
(3, 4, 1, 'test3', 0),
(4, 2, 1, 'test4', 0),
(5, 2, 1, 'test5', 0),
(6, 2, 1, 'test6', 0),
(7, 5, 2, 'test1', 0),
(8, 7, 2, 'test2', 0),
(9, 15, 2, 'test3', 0),
(10, 13, 2, 'test4', 0),
(11, 9, 2, 'test5', 0),
(12, 15, 2, 'test6', 0),
(13, 21, 3, 'test1', 0),
(14, 22, 3, 'test2', 0),
(15, 21, 3, 'test3', 0),
(16, 20, 3, 'test4', 0),
(17, 21, 3, 'test5', 0),
(18, 20, 3, 'test6', 0),
(19, 25, 4, 'test1', 0),
(20, 26, 4, 'test2', 0),
(21, 27, 4, 'test3', 0),
(22, 28, 4, 'test4', 0),
(23, 27, 4, 'test5', 0),
(24, 25, 4, 'test6', 0);

INSERT INTO `comments` (`id`, `body`,`topic_id`, `user_id`, `del_flg`) VALUES
(1, 'A型です。', 1, 'test1', 0),
(2, 'O型だよ。', 1, 'test2', 0),
(3, 'AB型だと思う。', 1, 'test3', 0),
(4, 'わからない。', 1, 'test4', 0),
(5, 'たぶんB型。', 1, 'test6', 0),

(6, '3月', 2, 'test1', 0),
(7, '1月生まれ。', 2, 'test2', 0),

(8, '169cm！', 3, 'test3', 0),
(9, '176cm (￣∇￣)', 3, 'test4', 0),
(10, '来世は男がいい。', 4, 'test5', 0),
(11, '女かな？', 4, 'test6', 0),
(12, '次は男。', 4, 'test1', 0);

COMMIT;
