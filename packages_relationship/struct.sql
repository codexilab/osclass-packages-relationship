ALTER TABLE /*TABLE_PREFIX*/t_user ADD b_packages_relationship_requests BOOLEAN NOT NULL DEFAULT FALSE AFTER s_access_ip;

CREATE TABLE /*TABLE_PREFIX*/t_packages_relationship_blocked (
	pk_i_id INT NOT NULL AUTO_INCREMENT,
	fk_i_from_user_id INT NULL,
	fk_i_to_user_id INT NULL,
	dt_date DATETIME NOT NULL,

	PRIMARY KEY (pk_i_id)
)	ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_packages_relationship_link (
	pk_i_id INT NOT NULL AUTO_INCREMENT,
	fk_i_user_id INT NULL,
	fk_i_user_son_id INT NULL,
	b_inherited BOOLEAN NOT NULL DEFAULT FALSE,
	b_use_package BOOLEAN NOT NULL DEFAULT TRUE,
	dt_date DATETIME NOT NULL,

	PRIMARY KEY (pk_i_id),
	UNIQUE (fk_i_user_son_id)
)	ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_packages_relationship_request (
	pk_i_id INT NOT NULL AUTO_INCREMENT,
	fk_i_from_user_id INT NULL,
	fk_i_to_user_id INT NULL,
	dt_date DATETIME NOT NULL,

	PRIMARY KEY (pk_i_id)
)	ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';

CREATE TABLE /*TABLE_PREFIX*/t_packages_relationship_event (
	pk_i_id INT NOT NULL AUTO_INCREMENT,
	fk_i_from_user_id INT NULL,
	fk_i_to_user_id INT NULL,
	dt_date DATETIME NOT NULL,
	s_type VARCHAR(60) NULL,

	PRIMARY KEY (pk_i_id)
)	ENGINE=InnoDB DEFAULT CHARACTER SET 'UTF8' COLLATE 'UTF8_GENERAL_CI';