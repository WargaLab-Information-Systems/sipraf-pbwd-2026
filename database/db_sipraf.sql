CREATE TABLE users_table (

    id INT PRIMARY KEY AUTO_INCREMENT,

    username VARCHAR(100),

    email VARCHAR(100)

);

CREATE TABLE facility (

    id INT PRIMARY KEY AUTO_INCREMENT,

    facility_name VARCHAR(100)

);

CREATE TABLE reservation (

    id INT PRIMARY KEY AUTO_INCREMENT,

    reservation_date DATE,

    facility_name VARCHAR(100)

);

CREATE TABLE approval (

    id INT PRIMARY KEY AUTO_INCREMENT,

    status VARCHAR(50)

);

INSERT INTO users_table(username, email)
VALUES
('sultan', 'sultan@gmail.com'),
('admin', 'admin@gmail.com');

INSERT INTO facility(facility_name)
VALUES
('Aula'),
('Ruang Meeting'),
('Lab Komputer');

INSERT INTO reservation(reservation_date, facility_name)
VALUES
('2026-05-20', 'Aula'),
('2026-05-21', 'Ruang Meeting'),
('2026-05-22', 'Lab Komputer');

INSERT INTO approval(status)
VALUES
('Approved'),
('Pending');