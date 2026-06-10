use internship;

create table internship (
    studentname varchar(50) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    contact varchar(15) NOT NULL,
    mode enum('online', 'onsite', 'hybrid') NOT NULL
);

insert into internship (studentname, email, contact, mode) values
('Nirali Joshi', 'nirujoshi12@gmail.com', '9978796054', 'online'),
('Urvshi Thanki', 'urvshithanki14@gmail.com', '9876534201', 'online'),
('Manshi Mehta', 'manshimehta2007@gmail.com', '9876543214', 'online'),
('Diya Joshi', 'diyajoshi2008@gmail.com', '8876534201', 'online'),
('Radhika Joshi', 'joshiradhika1207@gmail.com', '8765432190', 'onsite'),
('Payal Joshi', 'payaljoshi18@gmail.com', '9876543210', 'onsite'),
('Urvshi Mehta', 'urvshimehta20@gmail.com', '9876543217', 'onsite'),
('Hina Thanki', 'hinathanki2008@gmail.com', '9123456702', 'onsite'),
('Raj Modha', 'rajmodha2006@gmail.com', '9876543210', 'hybrid'),
('Jagruti Thanki', 'jaguthanki2006@gmail.com', '9876543267', 'hybrid');