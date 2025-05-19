## 🚀 Супер-быстрый старт

### Для полной настройки проекта одной командой (возможно с sudo):

```bash 
make init
```

### Приложение будет доступно по адресу:
http://localhost:8000/

## 🛠 Консольные команды

### 1. Добавление пользователя:
    docker-compose exec app php artisan create:user {login} {password}
    
### Пример:
    docker-compose exec app php artisan create:user admin 123456

### 2. Проведение операции по балансу:
    docker-compose exec app php artisan create:operation {login} {amount} {type} {description}

**Параметры:**

1. **type — deposit (начисление) или withdraw (списание)**

### Пример:
    docker-compose exec app php artisan create:operation admin 555 deposit 'first dep'

