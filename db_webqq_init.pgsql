DROP TABLE users;
CREATE TABLE users(
    id serial PRIMARY KEY,
    username varchar(32) UNIQUE,
    password varchar(128) NOT NULL,
    email varchar(32),
    realname varchar(32),
    mobile varchar(11),
    registertime timestamp DEFAULT now()
);

SELECT * FROM users;

CREATE TABLE qq_friendship(
    id serial PRIMARY KEY,
    user1 INTEGER NOT NULL,
    user2 INTEGER NOT NULL
);

SELECT * FROM qq_friendship;

CREATE TABLE qq_message(
    id serial PRIMARY KEY,
    fromid INTEGER,
    toid INTEGER,
    message varchar(1024),
    sendtime timestamp DEFAULT now()
);
SELECT * FROM qq_message;

DELETE FROM users;

INSERT INTO users(username, password, email, realname, mobile) VALUES
('zds', '123456', 'a', 'dzs', '12345678901');

SELECT * FROM users WHERE username='dzs' AND password=md5('123456');

SELECT count(1) FROM users WHERE username='dzs' AND password='123456'