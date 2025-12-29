CREATE TABLE users (
  user_id INTEGER NOT NULL AUTO_INCREMENT,
  name VARCHAR(128),
  email VARCHAR(128),
  password VARCHAR(128),
  PRIMARY KEY(user_id)
) ENGINE = InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE users ADD INDEX(email);

-- Exemple utilisateur
INSERT INTO users (name, email, password)
VALUES ('UMSI', 'umsi@umich.edu', '1a52e17fa899cf40fb04cfc42e6352f1');
CREATE TABLE Profile (
  profile_id INTEGER NOT NULL AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  first_name TEXT,
  last_name TEXT,
  email TEXT,
  headline TEXT,
  summary TEXT,
  PRIMARY KEY(profile_id),
  FOREIGN KEY(user_id) REFERENCES users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
