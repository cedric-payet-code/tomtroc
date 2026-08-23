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
    'johndoe',
    NULL
);

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
    'letranger.jpg',
    'Meursault mène une existence tranquille jusqu’au jour où un événement tragique bouleverse sa vie. Un roman emblématique de la littérature française.',
    FALSE
),

(
    1,
    'Les Misérables',
    'Victor Hugo',
    'les-miserables.jpg',
    'L’histoire de Jean Valjean, ancien forçat cherchant à se racheter, dans une France marquée par la pauvreté et les injustices sociales.',
    TRUE
),

(
    1,
    'Madame Bovary',
    'Gustave Flaubert',
    'madame-bovary.jpg',
    'Emma Bovary rêve d’une vie romantique et passionnée mais se retrouve confrontée à la banalité de son quotidien.',
    FALSE
),

(
    1,
    'Vingt mille lieues sous les mers',
    'Jules Verne',
    'vingt-mille-lieues-sous-les-mers.jpg',
    'Le professeur Aronnax et ses compagnons embarquent à bord du Nautilus, le mystérieux sous-marin du capitaine Nemo.',
    TRUE
),

(
    1,
    'Le Comte de Monte-Cristo',
    'Alexandre Dumas',
    'le-comte-de-monte-cristo.jpg',
    'Après avoir été injustement emprisonné, Edmond Dantès s’évade et prépare sa vengeance contre ceux qui ont détruit sa vie.',
    TRUE
),

(
    1,
    'Germinal',
    'Émile Zola',
    'germinal.jpg',
    'Étienne Lantier découvre les conditions de vie difficiles des mineurs du nord de la France et participe à leur lutte sociale.',
    FALSE
),

(
    1,
    'Candide',
    'Voltaire',
    'candide.jpg',
    'Candide voyage à travers le monde et découvre une succession de catastrophes qui remettent en question sa vision optimiste de l’existence.',
    TRUE
),

(
    1,
    'Harry Potter à l’école des sorciers',
    'J.K. Rowling',
    'harry-potter-a-lecole-des-sorciers.jpg',
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
    '',
    'Dans une société totalitaire contrôlée par Big Brother, Winston Smith tente de préserver sa liberté de pensée et découvre les dangers de la surveillance permanente.',
    FALSE
);