# HTTP Screw

> __HTTP Screw__ - _это интерфейс пакета Guzzle, который упрощает создание запросов используя ООП_

![License](https://img.shields.io/packagist/l/codememory/http-screw?logo=License&style=plastic)
![Code Size](https://img.shields.io/github/languages/code-size/codememory1/Screw?color=%2304aef1&logo=Code%20size&style=plastic)
![Packagist](https://img.shields.io/packagist/dt/codememory/http-screw.svg?maxAge=2592000&style=plastic)

# Установка
```
composer require codememory/http-screw
```

# Документация

- #### [Опции](#list-options)
    - [RedirectOption](#Redirect-Option)
    - [AuthorizationOption](#Auth-Option)
    - [TimeoutOption](#Timeout-Option)
    - [SSL Cert](#SSL-Cert-Option)
- #### [Request Методы](#Request-Method)

# <a name="Request-Method"></a>Request Методы
- `setUrl()` Добавить URL на который будет сделан запрос
    - > _string_ **$url** (_default_: null)

- `addPort()` Добавить ПОРТ к URL
    - > _integer_ **$port** (_default_: null)

- `setMethod()` Метод запроса GET|POST|PUT|DELETE|UPDATE
    - > _string_ **$method** (_default_: GET)

- `option()` Добавить опцию к запросу
    - > _string_ **$option** (_default_: null)
    - > _callable_ **$callback** (_default_: null)

- `send()` Метод отправляет запрос на указанный URL

- `response(): GuzzleResponse` Возрощает Response пакета Guzzle

# <a name="list-options"></a>Опции и их компоненты
### <a name="Redirect-Option"></a> Redirect
- `redirect()` Разришение Перенаправлений
    - > _boolean_ **$performRedirects** (_default_: false)

- `numberRedirects()` Кол-во Перенаправлений
    - > _integer_ **$redirects** (_default_: 5)

- `strictRedirect()` Строгие Перенаправления
    - > _boolean_ **$strictly** (_default_: false)

- `passingHeadersInRedirect()` Разрешить добавление заголовка referer при обноружении перенаправления
    - > _boolean_ **$allowDispatch** (_default_: true)

- `redirectHandler()` Обработчик при обнаружении перенаправления
    - > _object|callable_ **$allowDispatch** (_default_: null)

- `allowProtocols()` Разришеные протоколы
    - > _string_ **...$args** (_default_: [http, https])
### <a name="Auth-Option"></a> Authorization
- `username()` Имя пользователя
    - > _string|integer_ **$username** (_default_: null)

- `password()` Пароль пользователя
    - > _string|integer_ **$password** (_default_: null)

- `type()` Тип аутификации [**_basic_, _digest_, _ntlm_**]
    - > _string_ **$type** (_default_: null)

- `disable()` Отключить аутификацию
    - > None (_default_: true(On))

- `enable()` Включить аутификацию
    - > None (_default_: true(On))

### <a name="Timeout-Option"></a> Timeout(сек)
- `connectionTime()` Время подключения к серверу
    - > _integer|float_ **$time** (_default_: 0)

- `requestTime()` Время запроса
  - > _integer|float_ **$time** (_default_: 0)

- `readTime()` Время использования при чтении потокового тела
  - > _integer|float_ **$time** (_default_: default_socket_timeout of php.ini)

### <a name="SSL-Cert-Option"></a> SSL Cert
- `certificate()` Путь к файлу, содержащему сертификат в формате PEM
  - > _string_ **$pathCertificate** (_default_: None)
  - > _string|null_ **$password** (_default_: null)

- `key()` Путь к файлу, содержащему закрытый ключ SSL  в формате PEM
  - > _string_ **$pathCertificate** (_default_: None)
  - > _string|null_ **$password** (_default_: null)

### Отправка запроса
```php
 use Codememory\HttpRequest\Request;

 $httpRequest = new Request();
 
 $response = $httpRequest
        ->setUrl('http://example.com/') // Url запроса
        ->setMethod('GET') // Метод запроса
        ->send();
```
### Запрос с опциями
```php
 $httpRequest
    ->setUrl('http://example.com/')
    ->setMethod('GET')
    ->option(Request::O_REDIRECT, function(RedirectOption $redirect):  RedirectOption {
        $redirect
            ->redirect(true);
        
        return $redirect;
    })
    ->send();
```
### Пример использования несколько опций и их компоненты:
```php
 $httpRequest
    ->setUrl('http://example.com/')
    ->setMethod('GET')
    ->option(Request::O_REDIRECT, function(RedirectOption $redirect): RedirectOption {
        $redirect
            ->redirect(true)
            ->allowProtocols('http'); 
            
        return $redirect;
    })
    ->option(Request::TIMEOUT, function(TimeoutOption $timeout): TimeoutOption {
        $timeout
            ->delay(4)
            ->responseTime(5);
         
        return $timeout;
    })
    ->send();  
```
