CREATE DATABASE CourseManagement;

USE CourseManagement;

CREATE TABLE
    CourseType (
        courseTypeNo INT PRIMARY KEY,
        description VARCHAR(255)
    );

CREATE TABLE
    Location (
        locationNo INT PRIMARY KEY,
        address VARCHAR(255),
        capacity INT
    );

CREATE TABLE
    CourseFee (
        courseFeeNo INT PRIMARY KEY,
        amount DECIMAL(10, 2)
    );

CREATE TABLE
    Employee (
        employeeNo INT PRIMARY KEY,
        firstName VARCHAR(100),
        lastName VARCHAR(100),
        position VARCHAR(100)
    );

CREATE TABLE
    Client (
        clientNo INT PRIMARY KEY,
        companyName VARCHAR(255),
        address VARCHAR(255),
        contactInfo VARCHAR(255)
    );

CREATE TABLE
    Delegate (
        delegateNo INT PRIMARY KEY,
        firstName VARCHAR(100),
        lastName VARCHAR(100),
        clientNo INT,
        FOREIGN KEY (clientNo) REFERENCES Client (clientNo)
    );

CREATE TABLE
    Booking (
        bookingNo INT PRIMARY KEY,
        delegateNo INT,
        locationNo INT,
        date DATE,
        FOREIGN KEY (delegateNo) REFERENCES Delegate (delegateNo),
        FOREIGN KEY (locationNo) REFERENCES Location (locationNo)
    );

CREATE TABLE
    Course (
        courseNo INT PRIMARY KEY,
        title VARCHAR(255),
        description TEXT,
        locationNo INT,
        courseTypeNo INT,
        courseFeeNo INT,
        employeeNo INT,
        FOREIGN KEY (locationNo) REFERENCES Location (locationNo),
        FOREIGN KEY (courseTypeNo) REFERENCES CourseType (courseTypeNo),
        FOREIGN KEY (courseFeeNo) REFERENCES CourseFee (courseFeeNo),
        FOREIGN KEY (employeeNo) REFERENCES Employee (employeeNo)
    );

CREATE TABLE
    Registration (
        registrationNo INT PRIMARY KEY,
        courseNo INT,
        delegateNo INT,
        employeeNo INT,
        FOREIGN KEY (courseNo) REFERENCES Course (courseNo),
        FOREIGN KEY (delegateNo) REFERENCES Delegate (delegateNo),
        FOREIGN KEY (employeeNo) REFERENCES Employee (employeeNo)
    );

CREATE TABLE
    PaymentMethod (
        pMethodNo INT PRIMARY KEY,
        methodName VARCHAR(100)
    );

CREATE TABLE
    Invoice (
        invoiceNo INT PRIMARY KEY,
        registrationNo INT,
        pMethodNo INT,
        amount DECIMAL(10, 2),
        FOREIGN KEY (registrationNo) REFERENCES Registration (registrationNo),
        FOREIGN KEY (pMethodNo) REFERENCES PaymentMethod (pMethodNo)
    );