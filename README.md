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
    - [ProxyOption](#Proxy-Option)
- #### [Request Методы](#Request-Method)

# <a name="Request-Method"></a>Request Методы
- `baseUrl(): HttpRequest` Добавить URL в клиент. И тогда в `setUrl()` можно просто передать ссылку
  - > _string_ **$url** (_default_: null)

- `setUrl(): HttpRequest` Добавить URL на который будет сделан запрос
    - > _string_ **$url** (_default_: null)

- `addPort(): HttpRequest` Добавить ПОРТ к URL
    - > _integer_ **$port** (_default_: null)

- `setMethod(): HttpRequest` Метод запроса [ **GET|POST|PUT|DELETE|UPDATE** ]
    - > _string_ **$method** (_default_: GET)

- `clientOptions(): HttpRequest` Следующее указаные опции добавить в клиент. Которые будут по умолчанию
  - > _boolean_ **$status** (_default_: false)

- `option(): HttpRequest` Добавить опцию к запросу
    - > _string_ **$option** (_default_: null)
    - > _callable_ **$callback** (_default_: None): $option
      - > _object_ **$option** (_default_: $option)
      
- `processResponseCode(): HttpRequest` Обработать **HTTP**-код 
  - > _callable_ **$callback** (_default_: None)
    - > _Response_ **$response** (_default_: $response)
  - > _integer_ **$code** (_default_: 200)

- `refuser(): HttpRequest` Обработать ошибку запроса. Это может быть ошибка **connect** и прочее
  - > _callable_ **$callback** (_default_: None)
    - > _RequestException_ **$e** (_default_: $e)

- `send(): HttpRequest` Метод отправляет запрос на указанный URL

- `response(): GuzzleResponse` Возрощает Response пакета Guzzle

# <a name="list-options"></a>Опции и их компоненты
### <a name="Redirect-Option"></a> Redirect
    > HttpRequest::O_REDIRECT
- `redirect()` Разришение Перенаправлений
    - > _boolean_ **$performRedirects** (_default_: false)

- `numberRedirects()` Кол-во Перенаправлений
    - > _integer_ **$redirects** (_default_: 5)

- `strictRedirect()` Строгие Перенаправления
    - > _boolean_ **$strictly** (_default_: false)

- `addRefererOnRedirect()` Разрешить добавление заголовка referer при обноружении перенаправления
    - > _boolean_ **$allowDispatch** (_default_: true)

- `redirectHandler()` Обработчик при обнаружении перенаправления
    - > _object|callable_ **$allowDispatch** (_default_: null)

- `allowProtocols()` Добавить разрешенные протоколы
    - > _string_ **...$args** (_default_: [http, https])
### <a name="Auth-Option"></a> Authorization
    > HttpRequest::O_AUTH
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
    > HttpRequest::O_TIMEOUT
- `connectionTime()` Время подключения к серверу
    - > _integer|float_ **$time** (_default_: 0)

- `requestTime()` Время запроса
  - > _integer|float_ **$time** (_default_: 0)

- `readTime()` Время использования при чтении потокового тела
  - > _integer|float_ **$time** (_default_: default_socket_timeout of php.ini)

### <a name="SSL-Cert-Option"></a> SSL Cert
    > HttpRequest::O_SSL
- `certificate()` Путь к файлу, содержащему сертификат в формате PEM
  - > _string_ **$pathCertificate** (_default_: None)
  - > _string|null_ **$password** (_default_: null)

- `key()` Путь к файлу, содержащему закрытый ключ SSL  в формате PEM
  - > _string_ **$pathCertificate** (_default_: None)
  - > _string|null_ **$password** (_default_: null)
    
- `verify()` Включить проверку SSL или Установить путь к собственому сертификату на диске
  - > _boolean|string_ **$pathOrStatus** (_default_: true)

### <a name="Proxy-Option"></a> Proxy
    > HttpRequest::O_PROXY
- `setProxy()` Добавить прокси с определенным протоколом
  - > _string_ **$proxy** (_default_: null) - URL-адрес прокси
  - > _string|null_ **$protocol** (_default_: None) - Протокол прокси

- `username()` Имя пользователя
  - > _string_ **$username** (_default_: None) - Пример с именем пользователя [http://username:password@127.0.0.1:80]

- `password()` Пароль пользователя
  - > _string_ **$password** (_default_: None)

- `setUser()` Объединение методов `username()` и `password()` 
  - > _string_ **$username** (_default_: None)
  - > _string_ **$password** (_default_: None)
  - > _boolean_ **$forAllAddresses** (_default_: false) - Добавить ко всем следующим **URL-адресам** **имя пользователя** и **пароль**  

- `preventProxy()` Добавить имена хостов, которые не следует проксировать
  - > _string_ **...$args** (_default_: None)

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
            ->requestTime(5);
         
        return $timeout;
    })
    ->send();  
```
