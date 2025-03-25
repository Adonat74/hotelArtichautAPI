# Hotel Artichaut Laravel API

API Laravel du site internet d'un hotel permettant la gestion des users, des réservations, du paiement mais aussi et surtout la gestion de tous les contenus du site et de leur traduction à la manière d'un CMS.

---

## :dart: Contexte et Motivations 

- ### Contexte : 
Projet d'école réalisé en groupe. Une API pour le front-end réalisé par le même groupe.

- ### Objectifs :
Gestion des utilisateurs et de leur authentification JWT, des réservations, du paiement grâce à stripe, du contenu de chaques pages du site web, de leur traduction à la manière d'un CMS et des médias (images, vidéos).

- ### Choix techniques :
Laravel est idéal pour une API d'hôtel grâce à sa flexibilité, sa sécurité intégrée (authentification,
gestion des utilisateurs), et ses outils comme Eloquent pour gérer les réservations et les contenus.


---

## :wrench: Technologies et Outils utilisés 

- ### Framework :
Laravel 11

- ### Authentification : 
php-open-source-saver/jwt-auth (JWT)

- ### Base de donnée : 
MySQL

- ### Autres outils : 
Postman, Swagger, Git, Composer, Sanctum.

- ### technos requises :
PHP 8.3, MySQL 8.0.4, Composer 2.7.7

---

## :building_construction: Architecture et Structure du Projet 

- ### Architecture :
API RESTful

- ### Structure des répertoires : 
Structure Laravel classique qui ne ré-invente pas la roue.

---

## :rocket: Installation

1. Cloner le répertoire.
2. `cd hotelArtichautAPI`
3. `npm install` pour installer les dépendances.
4. `cp .env.example .env`
5. Renseigner les identifiants pour se connecter à la base de donnée dans le `.env`.
6. `php artisan key:generate` pour générer une APP_KEY servant à encrypt/decrypt data, generate random strings and tokens.
6. `php artisan jwt:secret` pour générer une clé secrète.
7. `sudo apt-get install php8.3-imagick`Installer le package imagick pour la génération de QR codes en images png :
8. Ajouter `QR_CODE_DRIVER=imagick` au .env 
8. `sudo phpenmod imagick` pour activer le package.
9. `sudo systemctl restart apache2` re-démarrer le serveur.
10. Ajouter un cronjob pour envoyer les qr codes par email au jour du début de la réservation : `crontab -e` dans le terminal puis ajouter cette ligne dans le fichier : `* * * * * cd /chemin/absolut/du/projet && php artisan schedule:run >> /dev/null 2>&1`


## :scroll: utilisation

1. Démarrer le serveur avec `php artisan serve`.
2. Accéder à la documentation swagger et les routes via cette route `http://127.0.0.1/api/documentation/`

---

## :construction: Sécurité

### Authentification JWT et Gestion des Rôles

L’authentification repose sur des JSON Web Tokens (JWT) qui, une fois générés après une connexion réussie, contiennent des informations essentielles (comme l’ID utilisateur et des métadonnées d’expiration). Le client doit inclure ce token dans l’en-tête `Authorization` pour accéder aux routes protégées.

Les rôles sont hiérarchisés de façon incrémentale :
- **user** : permissions de base,
- **employee** : droits du user + supplémentaires,
- **manager** : droits de l’employee + privilèges de gestion,
- **master** : tous les droits cumulés.

La vérification se fait via des policies ou middlewares, qui autorisent l’accès si l’utilisateur connecté a un rôle égal ou supérieur à celui requis.

---
## :warning: Récap éléments du projet

- ### Policies : 
Reviews et Users, servent à vérifier si l'utilisateur qui cherche à modifier des informations ou bien des review sont bien les siennes.

- ### Middlewares :
  - CheckTokenVersion : Sert à vérifier que le token est valide et est bien le dernier à avoir été généré dans le cas de plusieurs connexions raprochée et donc plusieurs token encore valides.
  - CheckRole : Sert à vérifier si l'utilisateur à le bon role pour accéder à une route.

- ### Console/Commands + routes/console.php
  - les commandes permettent d'écrire et d'éxécuter des tâches via les lignes de commandes. 
  - Le fichier console.php permet dans notre cas de planifier l'éxécution de commandes artisan avec Schedule.

---

## :star: Contribution

Les contributions sont les bienvenues. N'hésitez pas à ouvrir des issues et à faire des pull requests.

---

## License

This project is licensed under the [MIT License](LICENSE).
