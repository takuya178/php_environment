DROP TABLE IF EXISTS reviews;

CREATE TABLE reviews (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY kEY,
  title VARCHAR(255),
  author VARCHAR(255),
  status VARCHAR(5),
  score INTEGER,
  summary VARCHAR(255),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET=utf8mb4;


INSERT INTO reviews (
  title,
  author,
  status,
  score,
  summary
)
VALUES ('konosuba', 'akatuki', 'complete', 5, 'great');