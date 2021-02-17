create table mvc_test_db.tasks
(
    id          int(9) auto_increment primary key,
    user_id     int(9)     default 0 null,
    name        text                 not null,
    description text                 not null,
    email       varchar(255)         not null,
    status      tinyint(1) default 1 null,
    deleted     tinyint(1) default 0 null
);

create table mvc_test_db.users
(
    id         int(9) auto_increment primary key,
    first_name varchar(255) not null,
    last_name  varchar(255) not null,
    login      varchar(16)  not null,
    password   varchar(32)  not null,
    role       varchar(12)  null
);

INSERT INTO mvc_test_db.users (id, first_name, last_name, login, password, role)
VALUES (1, 'Вадим', 'Админ', 'admin', '123', 'admin');
