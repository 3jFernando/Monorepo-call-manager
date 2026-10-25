###### Para crear el proyecto use un contendor de Composer ya que no uso herrramientas en local (composer, node, npm, etc)

docker run --rm -v "$(pwd)/api":/app composer:latest create-project laravel/laravel .

###### Al trabajar con una Clean Architecture:
- empezamos con el dominio (con el fin de que el código sea escalable, mantenible y no dependa de framework alguno o base de datos)