## 🚀 Супер-быстрый старт

### Для полной настройки проекта одной командой:

```bash 
make init
```

## 🛠 Консольные команды

### 1. Добавление пользователя:
    docker-compose exec app php artisan create:user {login} {password}
    
### Пример:
    docker-compose exec app php artisan create:user admin 123456

### 2. Проведение операции по балансу:
    docker-compose exec app php artisan create:operation {login} {amount} {type} {description}

**Параметры:**

1. **type — deposit (начисление) или withdraw (списание)**

