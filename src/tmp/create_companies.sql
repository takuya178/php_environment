CREATE TABLE companies (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  establish_date DATE,
  founder VARCHAR(255),
  create_at TIMESTAMP NOT NULL DEFAULT  CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET=utf8mb4;


INSERT INTO companies (
  name,
  establish_date,
  founder
)
VALUES('株式会社なの花西日本', '1999-09-01', 'TAZIRI')


INSERT INTO companies (
  name,
  establish_date,
  founder
)
VALUES('nanohana', 'aaaa', 'TAZIRI')