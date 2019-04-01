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
INSERT INTO users(username, password, email, realname, mobile) VALUES
('x', 'x', 'x', 'x', '2');

SELECT * FROM users;

SELECT * FROM qq_friendship;
DROP TABLE qq_friendship;
CREATE TABLE qq_friendship(
    id serial PRIMARY KEY,
    user1 varchar(32) NOT NULL,
    user2 varchar(32) NOT NULL
);

CREATE TABLE qq_message(
    id serial PRIMARY KEY,
    fromid INTEGER,
    toid INTEGER,
    message varchar(1024),
    sendtime timestamp DEFAULT now()
);

DROP TABLE qq_message;
CREATE TABLE qq_message(
    id serial PRIMARY KEY,
    fromuser varchar(32),
    touser varchar(32),
    message varchar(1024),
    sendtime timestamp DEFAULT now()
);
INSERT INTO qq_message(fromuser, touser, message) VALUES
('a', 'd', 'a 发给 d'),
('a', 'q', 'a 发给 q'),
('a', 'r', 'a 发给 r'),
('d', 'a', 'd 发给 a'),
('q', 'a', 'q 发给 a'),
('r', 'a', 'r 发给 a');


SELECT * FROM qq_message;

DELETE FROM users;

INSERT INTO users(username, password, email, realname, mobile) VALUES
('zds', '123456', 'a', 'dzs', '12345678901');

SELECT * FROM users WHERE username='dzs' AND password=md5('123456');

SELECT count(1) FROM users WHERE username='dzs' AND password='123456';

INSERT INTO qq_friendship(user1, user2) VALUES
('a', 'd'),
('a', 'q'),
('a', 'r'),
('d', 'a'),
('q', 'a'),
('r', 'a')

SELECT username FROM users WHERE id IN (
    SELECT user2 FROM qq_friendship WHERE user1 IN (
        SELECT id FROM users WHERE username='q'
    )
);

select array_to_json(array_agg(row_to_json(t)))
from (
    SELECT username FROM users WHERE id IN (
        SELECT user2 FROM qq_friendship WHERE user1 IN (
            SELECT id FROM users WHERE username='q'
        )   
    )
) AS t;


SELECT username FROM users WHERE id IN (
        SELECT user2 FROM qq_friendship WHERE user1 IN (
            SELECT id FROM users WHERE username='q'
        )   
    );


SELECT fromuser, touser, message FROM qq_message 
WHERE (fromuser='q' OR fromuser='a')
AND (touser='q' OR touser='a');

SELECT users.username FROM users WHERE id IN(
    SELECT fromid FROM qq_message WHERE fromid IN (
        SELECT id FROM users WHERE username = 'q' OR username = 'a'
    ) AND toid IN(
        SELECT id FROM users WHERE username = 'a' OR username = 'q'
    )
);