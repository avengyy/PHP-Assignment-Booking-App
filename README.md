# Web Programming in PHP (Academic Assignment)

This repository holds the source code of a Framework-less PHP Website.

The Site mainly display the following functionalities besides basic CRUD of MySQL:

- Registering of User Account w/ Password Hashing
- Updating User Email
- Updating User Password
- Basic browsing and Navigation
- Adding and Removing of bookmarks
- Basic Search Queries

## Tilltro - All-in-one Booking platform

View [Demo](https://zac.qzonetech.com/)

SCSS Files are watched and compiled into CSS with Gulp

```bash
$ npm install
$ gulp serve
```

### _Usage on macOS with MAMP or Windows with XAMPP_

Extract files in _/htdocs/_ directory in Applications/MAMP and navigate to localhost:(YOUR PORT) in browser

### _Usage on Windows with WAMP_

Extract files in _wamp/www_ directory and and navigate to localhost:(YOUR PORT) in browser

## **Additional Instructions**

1. Ensure MySQL is set up properly with required table, columns etc.
2. Update constants.php with MySQL credentials
3. Run

### Database Schema

Tables

- LOGIN
  - userId INT(11) NOT NULL AUTO_INCREMENT
  - name VARCHAR(255) NOT NULL
  - username VARCHAR(255) NOT NULL
  - email VARCHAR(255) NOT NULL
  - password VARCHAR(60) NOT NULL
- HOTELS
  - id INT(11) NOT NULL AUTO_INCREMENT
  - title VARCHAR(50) NOT NULL
  - location TEXT NOT NULL
  - description TEXT  NOT NULL
  - stars INT(1) NOT NULL
  - rating DECIMAL(10,1) NOT NULL
  - mainImagePath TEXT NOT NULL
  - category TEXT NOT NULL
- TOURS
  - id INT(11) NOT NULL AUTO_INCREMENT
  - title VARCHAR(50) NOT NULL
  - subtitle VARCHAR(75) NOT NULL
  - location TEXT NOT NULL
  - description TEXT  NOT NULL
  - stars INT(1) NOT NULL
  - rating DECIMAL(10,1) NOT NULL
  - mainImagePath TEXT NOT NULL
  - category TEXT NOT NULL
- HOTEL_LOGIN
  - userId INT(11) NOT NULL
  - hotelId INT(11) NOT NULL
- TOUR_LOGIN
  - userId INT(11) NOT NULL
  - tourId INT(11) NOT NULL

### **References & Credits**

---

Template based on [Trillo](https://github.com/jonasschmedtmann/advanced-css-course/tree/master/Trillo/final) (Credits to: [Jonas Schmedtmann](https://github.com/jonasschmedtmann))

Project is licensed under ISC.