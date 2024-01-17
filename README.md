# .env
скопировать .env.example в .env, поменять JTW_AUTH_SECRET, TOKEN_LIFE_TIME (при необходимости)

# Поднять докер контейнеры
Дважды запустить команду. В первый раз дождаться выполнения и посл запустить второй раз.
``` bash
sudo docker-compose -f docker-compose.yml up -d --build
```

уничтожить контейнеры
``` bash
docker-compose -f docker-compose.yml down
```

# URLs

POST http://localhost/api/auth/register - регистрация нового пользователя ['username', 'email', 'password']

POST http://localhost/api/auth/token - получение токена ['identity', 'password'], identity - это username или email
В ответе приходит:

{

   "success": true,

   "data": {
      "token": "eyJ0***98dlE",
         "duration": "86400"
   }

}

Следующие роуты требует авторизации Bearer с полученным токеном (пример Bearer eyJ0***98dlE):

GET http://localhost/api/link/all - все url пользователя

POST http://localhost/api/link/index - создание url

GET http://localhost/api/link/index{params} - просмотр url

PATCH http://localhost/api/link/index{params} - обновление url

DELETE http://localhost/api/link/index{params} - удаление url

