# Project boilerplate - Matah

Matah is internal Resync backend API boilerplate that include several libraries.

### Libraries

### Authentication

-   Laravel Breeze
-   Laravel Sanctum

### Container management

-   Sail
-   Lando

### Admin

-   Laravel Nova 4.0

#### Observability

-   Laravel Horizon
-   Laravel Telescope
-   Sentry

## How to start?

To install setup project, run this command in **proper order**:

-   `artisan breeze:install api`
-   `artisan nova:install`
-   `artisan telescope:install`
-   `artisan horizon:install`
-   `artisan migrate`
-   `artisan nova:user`
-   `artisan db:seed`

## Auto Deployment

### Setting Laravel Forge Hook

Simply set `FORGE_HOOK` in the Gitlab repo settings

### Setting Laravel Envoyer Hook

Simply set `ENVOYER_HOOK` in the Gitlab repo settings
