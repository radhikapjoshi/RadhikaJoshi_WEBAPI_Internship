-- 1. Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS qrdemo;
USE qrdemo;

-- 2. Create the students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    clg_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Insert 10 sample records
INSERT INTO students (student_id, name, surname, clg_name) VALUES
('STU001', 'Aarav', 'Sharma', 'Mumbai Institute of Technology'),
('STU002', 'Ananya', 'Patel', 'Delhi Engineering College'),
('STU003', 'Rohan', 'Verma', 'Stanford University'),
('STU004', 'Saniya', 'Khan', 'Mumbai Institute of Technology'),
('STU005', 'Arjun', 'Nair', 'Delhi Engineering College'),
('STU006', 'Diya', 'Joshi', 'Oxford College of Science'),
('STU007', 'Kabir', 'Gupta', 'Mumbai Institute of Technology'),
('STU008', 'Isha', 'Singh', 'Stanford University'),
('STU009', 'Vivaan', 'Mehta', 'Delhi Engineering College'),
('STU010', 'Meera', 'Rao', 'Oxford College of Science');