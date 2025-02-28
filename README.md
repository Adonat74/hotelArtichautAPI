# Hotel Artichaut Laravel API

API Laravel du site internet d'un hotel permettant la gestion des users, des réservations, du paiement mais aussi et surtout la gestion de tous les contenus du site et de leur traduction à la manière d'un CMS.


## Contexte et Motivations :dart:

- ### Contexte : 
Projet d'école réalisé en groupe. Une API pour le front-end réalisé par le même groupe.

- ### Objectifs :
Gestion des utilisateurs et de leur authentification JWT, des réservations, du paiement grâce à stripe, du contenu de chaques pages du site web, de leur traduction à la manière d'un CMS et des médias (images, vidéos).

- ### Choix techniques :
Laravel est idéal pour une API d'hôtel grâce à sa flexibilité, sa sécurité intégrée (authentification,
gestion des utilisateurs), et ses outils comme Eloquent pour gérer les réservations et les contenus.



## Technologies et Outils utilisés :wrench:

- **Framework** : Laravel 11

- **Authentification** : php-open-source-saver/jwt-auth (JWT)

- **Base de donnée** : MySQL

- **Autres outils** : Postman, Swagger, Git, Composer, Sanctum.


## Architecture et Structure du Projet :building_construction:








## Installation

1. Clone this repository.
2. Navigate to the project directory.
3. Run `npm install` to install dependencies.
4. Configure your MariaDB connection in `credential/dbConfig.js`.
5. Set up your private key for JWT in `credential/private-key.js` file.

## Usage

1. Start the server by running `npm start`.
2. Use API endpoints for user creation, login, update, and deletion.

## API Endpoints

- `POST /api/createUser`: Create a new user.
- `POST /api/login`: Log in existing user.
- `PUT /api/updateUser/`: Update user data.
- `DELETE /api/deleteUser`: Delete a user account.

## User Model

The user model contains the following data types:

- `id` (integer)
- `email` (string)
- `username` (string)
- `password` (string)
- `favoritemusicgenre` (string)

each one contains various constraint.

## Middleware

### Custom Middleware

- **src/auth/auth.js**: Middleware to verify the JWT token present in the request header using a private key.

### Express Middleware

- `body-parser`: Parses incoming request bodies.
- `cors`: Enables CORS.
- `express-mongo-sanitize`: Sanitizes input against NoSQL Injection.
- `express-rate-limit`: Limits repeated requests to prevent abuse.
- `xss-clean`: Sanitizes user input against XSS.

## Initialization

- **Express Initialization**: Configuration of middleware, routes, and server start in `App.js`.
- **Database Initialization**: Connection to MariaDB and synchronization of user model with database table in `sequelize.js`.

## Contributing

Contributions are welcome. Feel free to open issues and pull requests.

## License

This project is licensed under the [MIT License](LICENSE).
