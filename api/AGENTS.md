# Laravel API Guidelines

Este directorio contiene la aplicación Laravel de la prueba técnica Call Manager.

> **IMPORTANTE**: No instalar ni ejecutar PHP o Composer en la máquina local.
> Todas las operaciones de Laravel deben ejecutarse dentro del contenedor Docker `call_api`:
>
> ```bash
> docker compose -f ../docker/docker-compose.yml exec api php artisan <comando>
> docker compose -f ../docker/docker-compose.yml exec api composer <comando>
> ```

Consulte [AGENTS.md](../../AGENTS.md) en la raíz del proyecto para las reglas completas de arquitectura (Clean Architecture: Domain, Application, Infrastructure), idempotencia con Redis y pruebas automatizadas.
