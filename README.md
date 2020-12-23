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
    - [ParamsOption](#Params-Option)
    - [HeadersOption](#Headers-Option)
    - [HttpOption](#Http-Option)
    - [ProgressOption](#Progress-Option)
- #### [Request Методы](#Request-Method)
- #### [Response Методы](#Response-Method)

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

- `addBody(): HttpRequest` Отправить Body
  - > _string_ **$body** (_default_: None)

- `addJson(): HttpRequest` Загрузка данных в кодировке JSON в качестве тела запроса. Заголовок Content-Type `application/json` будет добавлен, если в сообщении уже нет заголовка Content-Type.
  - > _mixed_ **$data** (_default_: None)
    
- `saveBody(): HttpRequest` Добавить Путь, где будет сохранен **body** ответ

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

### <a name="Params-Option"></a> Params
  > HttpRequest::O_PARAMS
- `form()` Передать **POST** данные, если метод запроса **POST**
  - > _array_ **$data** (_default_: None)

- `query()` Передать **GET** данные, если метод запроса **GET**
  - > _array_ **$data** (_default_: None)

- `withFiles(): ParamsOption` Отправить файлы. **Не работает вместе с методом `form()`**
  - > _string_ **$inputName** (_default_: None)
  - > _mixed **NOT** null_ **$contents** (_default_: None) - Данные для использования в элементе формы.
  - > _?string_ **$filename** (_default_: Null)
  - > _?array_ **$headers** (_default_: [])  

### <a name="Headers-Option"></a> Headers
  > HttpRequest::O_HEADERS
- `decodeContent(): HeadersOption` Укажите, будут ли `Content-Encoding` ответы (gzip, deflate и т. Д.) Автоматически декодироваться.
  - > _string|boolean_ **$decode** (_default_: true)
- `header()` Добавить заголовок
  - > _string_ **$name** (_default_: None)
  - > _mixed_ **$value** (_default_: None)
- `onHeaders()` Вызываемый объект, который вызывается, когда HTTP-заголовки ответа получены, но тело еще не начало загружаться.
  - > _callable_ **$callback** (_default_: None)
    - > _Response_ **$response** (_default_: Response)
- `expect()` Управляет поведением заголовка «Expect: 100-Continue».
  - > _integer|boolean_ **$rule** (_default_: 1048576)

### <a name="Http-Option"></a> Http
  > HttpRequest::O_HTTP
- `setVersion()` Установить версию протокола
  - > _integer|float_ **$version** (_default_: 1.1)
- `stream()` Установить потоковою передачу ответа, а не для загрузки сразу
  - > _boolean_ **$status** (_default_: false)
- `idnConversion()` Поддержка интернационализированных доменных имен (IDN) (включена по умолчанию, если `intl` расширение доступно).
  - > _integer|boolean_ **$support** (_default_: true or false)
- `httpExceptions()` Выдача исключений по **HTTP-code**
  - > _boolean_ **$status** (_default_: true)
- `ipVersion()` Установить версию IP
  - > _string_ **$version** (_default_: None)
- `stats()` Позволяет получить доступ к статистике передачи запроса и доступ к деталям передачи нижнего уровня обработчика, связанного с вашим клиентом.
  - > _callable_ **$callback** (_default_: None)
    - > _TransferStats_ **$stats** (_default_: TransferStats)
- `sync()` Сообщить обработчикам HTTP, что вы собираетесь ожидать ответ. Это может быть полезно для оптимизации
  - > _boolean_ **$status** (_default_: None)

### <a name="Progress-Option"></a> Progress
  > HttpRequest::O_PROGRESS
- `progress()` Определяет функцию, вызываемую при выполнении передачи.
  - > _callable_ **$callback** (_default_: None)
    - > _integer_ **$downloadTotal** (_default_: 0) - общее количество байтов, ожидаемых к загрузке, ноль, если неизвестно
    - > _integer_ **$downloadedBytes** (_default_: 0) - количество байтов, загруженных на данный момент
    - > _integer_ **$uploadTotal** (_default_: 0) - общее количество байтов, которые должны быть загружены
    - > _integer_ **$uploadedBytes** (_default_: 0) - количество байтов, загруженных на данный момент

### <a name="Response-Method"></a> Response Методы
- `responseType()` Преоброзовать ответ Body в ТИП:
  - > _integer_ **$type** (_default_: String(4)) <br>
      `Response::RESPONSE_JSON` <br>
      `Response::RESPONSE_ARRAY` <br>
      `Response::RESPONSE_OBJECT` <br>
      `Response::RESPONSE_STRING` <br>
    
- `getBody()` Получить Body ответа
- `getHttpCode()` Получить **HTTP-код**
- `getResponseGuzzle(): GuzzleResponse` Вернуть обьект класса `GuzzleResponse`
- `__call()` Другие методы из обьекта `GuzzleResponse` **[Подробнее](https://docs.guzzlephp.org/)**

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
