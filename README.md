# POC Symfony Messenger Kafka

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
POST http://127.0.0.1:8000/batch-message -d [{"id":1},{"id":2},...]
```

## Docs

- [Symfony Messenger AMQ Transport](https://symfony.com/doc/current/messenger.html#amqp-transport)
- [Message Enqueue Transport](https://github.com/sroze/messenger-enqueue-transport)
