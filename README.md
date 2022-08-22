## Billie coding assignment

To run the project it's necessary to go through several steps:

#### The project is set up using the Laravel Sail package and Docker
To start this project run `./vendor/bin/sail up`
#### To initialize all the dependencies run `./vendor/bin/sail composer install`
#### To run all migrations - `./vendor/bin/sail artisan migrate`
#### To create OpenApi documentation - `/vendor/bin/sail artisan l5-swagger:generate`

The project uses MySql as a default DB in Docker.
Open API Swagger is accessible by `http://localhost/api/documentation` by default

### Next steps to do:
1. Create custom validation rules to not allow run even controllers with wrong input data
2. Create ent-to-end 'feature' tests to cover logic of controllers
3. Validate OpenApi documentation using the `https://github.com/thephpleague/openapi-psr7-validator`
4. Create Unit tests to validate business logic
5. Add support of currencies
6. Add custom exceptions instead of generic ones and set up more correct exceptions handling
