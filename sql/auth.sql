// 账号表  todo 账号应该是手机号或者微信或者邮箱
CREATE TABLE `auth` (
  `aid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '玩家id',
  `account` varchar(10) NOT NULL DEFAULT '' COMMENT '玩家角色名',
  `password` varchar(10) NOT NULL DEFAULT '' COMMENT '玩家登陆密码',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='玩家账号表';