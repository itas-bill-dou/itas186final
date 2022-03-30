DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  username VARCHAR(128),
  password VARCHAR(128),
  first_name VARCHAR(20),
  last_name VARCHAR(20),
  gender ENUM('M','F', 'NA') DEFAULT 'NA',
  phone VARCHAR(15),
  user_type TINYINT DEFAULT 0
);

--
-- Create the `boat` table
--
DROP TABLE IF EXISTS boats;

CREATE TABLE boats (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(15),
  reg_num CHAR(10),
  length VARCHAR(20),
  image VARCHAR(100),
  user_id INT,
  FOREIGN KEY(user_id) REFERENCES users (id)
);

-- password is "secret"(no double quotes), should be used for all users
-- Bob's account
INSERT INTO users VALUES (DEFAULT, "admin", "$2y$10$vY3n3NhWQvPqTaNr4gJKMefck5SgKGG9CVj42KUHC6s1IrOtWgEmq","Bob", "Boss", "M", "(250) 123 4567", 1);

-- Some boat owners
INSERT INTO users VALUES (DEFAULT, "markd", "$2y$10$vY3n3NhWQvPqTaNr4gJKMefck5SgKGG9CVj42KUHC6s1IrOtWgEmq",  "Mark", "Dutchuk", "M","(111) 111 1111", 0);
INSERT INTO users VALUES (DEFAULT, "davec", "$2y$10$vY3n3NhWQvPqTaNr4gJKMefck5SgKGG9CVj42KUHC6s1IrOtWgEmq",  "Dave", "Croft","M", "(222) 222 2222", 0);
INSERT INTO users VALUES (DEFAULT, 'thurstonh', "$2y$10$vY3n3NhWQvPqTaNr4gJKMefck5SgKGG9CVj42KUHC6s1IrOtWgEmq",  "Thurston", "Howell III", "M","(333) 333 3333", 0);
INSERT INTO users VALUES (DEFAULT, "billg", "$2y$10$vY3n3NhWQvPqTaNr4gJKMefck5SgKGG9CVj42KUHC6s1IrOtWgEmq","Bill", "Gates", "M","(444) 444 4444", 0);

--
-- Insert some test records into the `boats` table
--
INSERT INTO boats VALUES (DEFAULT, "Nautilus", "", "10", "boat1.jpg", 1);
INSERT INTO boats VALUES (DEFAULT, "Kobayashi Maru", "LMZ90210", "20", "boat2.jpg", 2);
INSERT INTO boats VALUES (DEFAULT, "Bismarck", "3333", "50", "boat3.jpg", 3);
INSERT INTO boats VALUES (DEFAULT, "Exxon Valdez", "4444", "100", "boat4.jpg", 4);