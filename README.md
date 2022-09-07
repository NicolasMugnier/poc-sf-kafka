# POC Symfony Messenger Kafka

## Install required library

```bash
sudo apt-get install librabbitmq-dev
```

```bash
sudo pecl install amqp
```

Add `extension=amqp.so` to php.ini

## Install dependencies

```bash
composer install
```

## Run

Run Kafka container

```bash
docker-compose up -d
```

Run basic PHP server on port 8000

```
php -S 127.0.0.1:8000 public/index.php
```

## Send Batch Message

```
curl -XPOST http://127.0.0.1:8000/batch-message -d [{"id":1},{"id":2},...]
```

## Docs

- [Symfony Messenger AMQ Transport](https://symfony.com/doc/current/messenger.html#amqp-transport)
- [Message Enqueue Transport](https://github.com/sroze/messenger-enqueue-transport)
