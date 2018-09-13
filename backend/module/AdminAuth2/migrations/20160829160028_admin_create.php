<?php

use Phinx\Migration\AbstractMigration;

class AdminCreate extends AbstractMigration
{
  function up() {
    $this->execute(<<<'EOD'
CREATE TABLE admin_roles (
  id BIGINT(11) AUTO_INCREMENT NOT NULL,
  name VARCHAR(50) NOT NULL UNIQUE,
  description TEXT,
  resources TEXT NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT '1',
  created_at DATETIME NOT NULL,
  updated_at DATETIME,
  created_by BIGINT(11),
  updated_by BIGINT(11),
  PRIMARY KEY(id)
) ENGINE=Innodb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE admin_users (
  id BIGINT(11) AUTO_INCREMENT NOT NULL,
  admin_roles_id BIGINT(11) NOT NULL,
  name VARCHAR(50) NOT NULL,
  username VARCHAR(24) NOT NULL UNIQUE,
  email VARCHAR(100),
  password CHAR(60) NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT '1',
  is_superuser TINYINT(1) NOT NULL DEFAULT '0',
  created_at DATETIME NOT NULL,
  updated_at DATETIME,
  created_by BIGINT(11),
  updated_by BIGINT(11),
  PRIMARY KEY(id),
  FOREIGN KEY(admin_roles_id) REFERENCES admin_roles(id),
  FOREIGN KEY(created_by) REFERENCES admin_users(id),
  FOREIGN KEY(updated_by) REFERENCES admin_users(id)
) ENGINE=Innodb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
EOD
    );
  }


  function down() {
    $this->execute(<<<'EOD'
DROP TABLE admin_users;
DROP TABLE admin_roles;
EOD
    );
  }
}
