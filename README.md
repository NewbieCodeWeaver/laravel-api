# Dices Game

Juego de dados utilizando la arquitectura API REST. Permite a los usuarios registarse, realizar partidas, ver los ganadores y perdedores del juego así como el ranking de los usuarios. Existe un usuario con permisos de administrador que acceder a toda la lista de usuarios y todas las partidas del juego. La API utiliza un sistema de autentificación OAuth2 que aumenta la seguridad de la alicación. 



## Tecnologies

* LARAVEL
* LARAVEL PASSPORT



### Installation

```
# Clone the repository
$ git clone https://github.com/carlos-full-stack/dices-game-api-it-academy.git
$ cd dices-game-api-it-academy

# Install dependecies
$ composer install
$ composer require laravel/passport:*

# Generate database (Copy .env.example into .env and configure database credentials)
$ php artisan migrate
$ php artisan db:seed

# Generate keys
$ php artisan passport:keys
$ php artisan passport:client --personal

# Run server
$ php artisan serve
```

### Endpoints

| HTTP Request | Request URL                 | Description           | Auth            |
|--------------|-----------------------------|-----------------------|-----------------|
| **POST**     | /api/players                | User registration     | No              |
| **POST**     | /api/login                  | User login            | No              |
| **POST**     | /api/players/{id}/games/    | User roll dice        | ApiToken        |
| **PUT**      | /api/players/{id}           | Username change       | ApiToken        |
| **DELETE**   | /api/players/{id}/games     | Username remove plays | Apitoken        |
| **GET**      | /api/players/               | Get list of players   | ApiToken, admin |
| **GET**      | /api/players/{id}/games     | Get user plays        | ApiToken, admin |
| **GET**      | /api/players/ranking/loser  | Get loser             | ApiToken        |
| **GET**      | /api/players/ranking/winner | Get winner            | ApiToken        |
| **GET**      | /api/players/ranking        | Get ranking           | ApiToken        |


Set user as admin on database: users table > select user > is_admin : 1

## Authors

 [Carlos Martinez](https://carlosfullstack.es/)

## License

[MIT](https://opensource.org/licenses/MIT)
