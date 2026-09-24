# TomTroc

Site de mise en relation entre lecteurs pour échanger des livres. Projet développé en PHP natif (MVC, sans framework), HTML et CSS purs.

## Prérequis

- PHP 8.0 ou supérieur
- MySQL 8.0.16 ou supérieur (nécessaire pour les contraintes `CHECK`)
- Apache avec le module `mod_rewrite` activé (utilisé par le fichier `.htaccess`)
- MAMP (ou équivalent : WAMP, XAMPP)
- Un navigateur récent

## Installation

### 1. Placer le projet dans MAMP

Copiez le dossier du projet dans `htdocs` (le répertoire servi par MAMP), par exemple `C:\MAMP\htdocs\tomtroc`.

### 2. Créer la base de données

Importez le fichier `data.sql` fourni à la racine du projet via phpMyAdmin :

1. Créez une base de données nommée `tomtroc` (interclassement `utf8mb4_general_ci` conseillé)
2. Sélectionnez-la, onglet **Importer** → choisissez `data.sql` → **Exécuter**

Ce script crée les tables `users`, `books`, `chats` et `messages` (avec leurs relations et contraintes de clé étrangère) et insère des données de démonstration.

### 3. Configurer la connexion à la base de données

Copiez `config/config.example.php` en `config/config.php`, puis renseignez vos identifiants :

```php
define('DB_PASS', 'root'); // mot de passe par défaut de MAMP
```

> `config/config.php` n'est pas versionné (voir `.gitignore`) : ne jamais y mettre de vrais identifiants de production dans un dépôt public.

### 4. Configurer un virtual host

Le routeur s'appuie sur l'URL à partir de la racine du site : le projet doit donc être servi via un virtual host, et non via `localhost/tomtroc`.

1. Ouvrez le fichier des virtual hosts d'Apache :
   - Windows : `C:\MAMP\conf\apache\extra\httpd-vhosts.conf`
   - Mac : `/Applications/MAMP/conf/apache/extra/httpd-vhosts.conf`

   Vérifiez que la ligne `Include conf/extra/httpd-vhosts.conf` est bien décommentée dans `httpd.conf`.
2. Ajoutez un virtual host pointant vers le dossier du projet :
   ```apache
   <VirtualHost *:80>
       ServerName tomtroc.local
       DocumentRoot "C:/MAMP/htdocs/tomtroc"
       <Directory "C:/MAMP/htdocs/tomtroc">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
   `AllowOverride All` est indispensable pour que le `.htaccess` (réécriture des URL vers `index.php`) soit pris en compte. Adaptez le chemin et le port (`8888` par défaut sur MAMP Mac) à votre installation.
3. Ajoutez la ligne correspondante dans le fichier `hosts` de votre système (`C:\Windows\System32\drivers\etc\hosts` sur Windows, à éditer en administrateur ; `/etc/hosts` sur Mac/Linux) :
   ```
   127.0.0.1   tomtroc.local
   ```
4. Redémarrez les serveurs dans MAMP

### 5. Lancer le site

Rendez-vous sur :
```
http://tomtroc.local
```

### 6. Comptes de démonstration

Les données d'exemple contiennent plusieurs comptes. Ils partagent tous le mot de passe **`password`** :

| Pseudo         | Email                   |
|----------------|-------------------------|
| John Doe       | `john.doe@mail.com`     |
| Alexlecture    | `alex.lecture@mail.com` |
| Nathalire      | `nathalie@mail.com`     |
| Sas634         | `sas634@mail.com`       |
| Hugo1990_12    | `hugo1990@mail.com`     |
| CamilleClubLit | `camille.club@mail.com` |

Se connecter avec deux comptes différents (par exemple dans deux navigateurs) permet de tester la messagerie.

## Structure du projet

```
├── index.php               # Front controller : point d'entrée unique et déclaration des routes
├── .htaccess               # Redirige toutes les requêtes vers index.php
├── config/
│   ├── config.example.php  # Modèle de configuration (versionné)
│   ├── config.php          # Connexion BDD (non versionné)
│   └── autoload.php        # Autoload PSR-4 (namespace App\ → racine du projet)
├── Services/               # Router, DBManager, classes abstraites
├── Controllers/            # Contrôleurs
├── Managers/               # Accès aux données (BDD)
├── Models/                 # Entités (User, Book, Chat, Message)
├── views/                  # Templates PHP (main.php = layout commun)
├── assets/
│   ├── css/                # Styles (base, layout, composants, pages) et polices auto-hébergées
│   └── images/             # Images statiques et images uploadées (avatars, couvertures)
└── data.sql                # Script de création et peuplement de la base
```

## Principales routes

| URL                      | Page                                   |
|--------------------------|----------------------------------------|
| `/`                      | Accueil                                |
| `/nos-livres`            | Liste des livres (recherche avec `?q=`) |
| `/livre/{id}`            | Détail d'un livre                      |
| `/livre/add`             | Ajout d'un livre                       |
| `/livre/{id}/update`     | Modification d'un livre                |
| `/inscription`, `/connexion`, `/deconnexion` | Authentification   |
| `/mon-compte`            | Mon compte et ma bibliothèque          |
| `/compte/{id}`           | Profil public d'un membre              |
| `/messages`, `/message/{id}` | Messagerie                         |

## Fonctionnalités

- Inscription, connexion et déconnexion des membres (mots de passe hachés)
- Modification du compte : pseudo, email, mot de passe et avatar
- Bibliothèque personnelle : ajout, modification et suppression de livres, avec upload de la couverture
- Suppression automatique des anciennes images sur le disque lors d'un remplacement ou d'une suppression
- Consultation des profils publics et de leur bibliothèque
- Recherche de livres par titre
- Messagerie entre utilisateurs (création d'une conversation depuis la fiche d'un livre ou un profil)

## Notes techniques

- Aucune librairie ou framework tiers : PHP, HTML et CSS natifs uniquement
- Architecture MVC avec routeur et autoload maison conformes PSR-4 (namespaces `App\...`, sans Composer)
- Requêtes préparées PDO pour toutes les interactions avec la base de données
- Code respectant les recommandations PSR et attention portée à l'accessibilité (WCAG)
