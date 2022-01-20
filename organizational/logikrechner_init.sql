# -----------------------------------------
# Drop/Create/Use database "l_logikrechner"
# drop database if exists l_logikrechner_db;
# create database l_logikrechner_db;
# use l_logikrechner_db;
# -----------------------------------------
# Create table "l_u_users"
create table l_u_users (
	l_u_id int primary key AUTO_INCREMENT,
    l_u_user varchar(32) NOT NULL,
    l_u_email varchar(64) NOT NULL,
    l_u_pw varchar(128) NOT NULL,
    l_u_verified tinyint default 0,
    l_u_code int,
    l_u_createdat datetime default CURRENT_TIMESTAMP
) engine = InnoDB;
# -----------------------------------------
# Create table "l_c_comments"
create table l_c_comments (
	l_c_id int primary key AUTO_INCREMENT,
    l_c_u_writer int NOT NULL,
    l_c_ri_riddle int NOT NULL,
    l_c_text varchar(256) NOT NULL
) engine = InnoDB;
# -----------------------------------------
# Create table "l_ri_riddles"
create table l_ri_riddles (
	l_ri_id int primary key AUTO_INCREMENT,
    l_ri_u_creator int NOT NULL,
    l_ri_title varchar(32) NOT NULL,
    l_ri_desc text NOT NULL,
    l_ri_diff int NOT NULL,
    l_ri_solution varchar(256) NOT NULL,
    l_ri_createdat datetime default CURRENT_TIMESTAMP
) engine = InnoDB;
# -----------------------------------------
# Create table "l_ra_rates"
create table l_ra_rates (
	l_ra_u_user int,
    l_ra_ri_riddle int,
    l_ra_rating int,
    primary key(l_ra_u_user, l_ra_ri_riddle)
) engine = InnoDB;
# -----------------------------------------
# Create table "l_s_solves"
create table l_s_solves (
	l_s_u_user int,
    l_s_ri_riddle int,
    l_s_solved tinyint,
    l_s_expression varchar(32),
    primary key(l_s_u_user, l_s_ri_riddle)
) engine = InnoDB;
# -----------------------------------------
# Alter table "l_c_comments"
alter table l_c_comments
add foreign key (l_c_u_writer)
references l_u_users(l_u_id),
add foreign key (l_c_ri_riddle)
references l_ri_riddles(l_ri_id);
# -----------------------------------------
# Alter table "l_ri_riddles"
alter table l_ri_riddles
add foreign key (l_ri_u_creator)
references l_u_users(l_u_id);
# -----------------------------------------
# Alter table "l_s_solves"
alter table l_s_solves
add foreign key (l_s_u_user)
references l_u_users(l_u_id),
add foreign key (l_s_ri_riddle)
references l_ri_riddles(l_ri_id);