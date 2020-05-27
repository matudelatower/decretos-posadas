# Decretos Posadas
Buscador de Decretos de la Ciudad de Posadas

Prerrequisitos:
=
- php 7.3 o superior
- MySQL 5.7
- Servidor web Apache2/ngingx

Deploy:
=
- clonar el repo.
- `composer install`
- configurar .env.local con las credenciales correspondientes
- `php bin/console doc:dat:create`
- `php bin/console doc:mig:mig`
- `php bin/console doc:fix:load`
- `npm i`
- `npm run build`
