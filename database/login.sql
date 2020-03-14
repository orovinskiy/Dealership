
drop table if exists login;
CREATE TABLE login(
id int(10) NOT NULL AUTO_INCREMENT primary key,
admin_status TINYINT(4) NOT NULL DEFAULT '0',
username varchar(255) NOT NULL UNIQUE,
password varchar(255) NOT NULL,
 created datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 last_updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

insert into login values (null, TRUE, 'admin', MD5('@dm1n'), now(), now());
