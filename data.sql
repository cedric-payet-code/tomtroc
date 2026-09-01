DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, email, password, avatar) VALUES
(
    'John Doe',
    'john.doe@mail.com',
    '$2y$10$KreG4Paj3eoZzN0V7qCyFePu1/FZU7Z6WXBR/VPnoy8UQeq4M6JKe',
    NULL
),

(
    'Autre',
    'autre@mail.com',
    '$2y$10$KreG4Paj3eoZzN0V7qCyFePu1/FZU7Z6WXBR/VPnoy8UQeq4M6JKe',
    NULL
);


CREATE TABLE chats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user1_id INT NOT NULL,
    user2_id INT NOT NULL,
    last_message_at TIMESTAMP NULL DEFAULT NULL,

    FOREIGN KEY (user1_id) REFERENCES users(id),
    FOREIGN KEY (user2_id) REFERENCES users(id),

    CONSTRAINT unique_duo UNIQUE (user1_id, user2_id),
    CONSTRAINT no_self_chat CHECK (user1_id < user2_id)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chat_id INT NOT NULL,
    sender_id INT NOT NULL,
    message TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (chat_id) REFERENCES chats(id),
    FOREIGN KEY (sender_id) REFERENCES users(id)
);

INSERT INTO chats (user1_id, user2_id, last_message_at) VALUES (1, 2, '2026-08-31 14:05:00');

INSERT INTO messages (chat_id, sender_id, message, sent_at) VALUES
(1, 1, 'Salut ! Ça va ?', '2026-08-31 14:00:00'),
(1, 2, 'Salut ! Oui, ça va très bien et toi ?', '2026-08-31 14:02:00'),
(1, 1, 'Ça va super, merci !', '2026-08-31 14:05:00');


CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,

    owner_id INT NOT NULL,

    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    image VARCHAR(255) NULL,
    description TEXT NULL,
    available BOOLEAN NOT NULL DEFAULT FALSE,

    FOREIGN KEY (owner_id) REFERENCES users(id)
);

INSERT INTO books (owner_id, title, author, image, description, available) VALUES

(
    1,
    'L’Étranger',
    'Albert Camus',
    NULL,
    'Meursault mène une existence tranquille jusqu’au jour où un événement tragique bouleverse sa vie. Un roman emblématique de la littérature française.',
    FALSE
),

(
    1,
    'Les Misérables',
    'Victor Hugo',
    NULL,
    'L’histoire de Jean Valjean, ancien forçat cherchant à se racheter, dans une France marquée par la pauvreté et les injustices sociales.',
    TRUE
),

(
    1,
    'Madame Bovary',
    'Gustave Flaubert',
    NULL,
    'Emma Bovary rêve d’une vie romantique et passionnée mais se retrouve confrontée à la banalité de son quotidien.',
    FALSE
),

(
    1,
    'Vingt mille lieues sous les mers',
    'Jules Verne',
    NULL,
    'Le professeur Aronnax et ses compagnons embarquent à bord du Nautilus, le mystérieux sous-marin du capitaine Nemo.',
    TRUE
),

(
    1,
    'Le Comte de Monte-Cristo',
    'Alexandre Dumas',
    NULL,
    'Après avoir été injustement emprisonné, Edmond Dantès s’évade et prépare sa vengeance contre ceux qui ont détruit sa vie.',
    TRUE
),

(
    1,
    'Germinal',
    'Émile Zola',
    NULL,
    'Étienne Lantier découvre les conditions de vie difficiles des mineurs du nord de la France et participe à leur lutte sociale.',
    FALSE
),

(
    1,
    'Candide',
    'Voltaire',
    NULL,
    'Candide voyage à travers le monde et découvre une succession de catastrophes qui remettent en question sa vision optimiste de l’existence.',
    TRUE
),

(
    1,
    'Harry Potter à l’école des sorciers',
    'J.K. Rowling',
    NULL,
    'Harry Potter découvre à onze ans qu’il est un sorcier et rejoint l’école de Poudlard, où il se lie d’amitié avec Ron et Hermione.',
    TRUE
),

(
    1,
    'Le Petit Prince',
    'Antoine de Saint-Exupéry',
    'le-petit-prince.png',
    'Un aviateur perdu dans le désert rencontre un mystérieux petit prince venu d’une autre planète. Un récit poétique qui aborde l’amitié, l’amour et le sens de la vie.',
    TRUE
),

(
    1,
    '1984',
    'George Orwell',
    NULL,
    'Dans une société totalitaire contrôlée par Big Brother, Winston Smith tente de préserver sa liberté de pensée et découvre les dangers de la surveillance permanente.',
    FALSE
);