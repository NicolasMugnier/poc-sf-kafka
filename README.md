# POC Symfony Messenger Kafka

## Install required library

[librdkafka](https://github.com/edenhill/librdkafka)

```bash
sudo apt install librdkafka-dev
```

[arnaud-lb/php-rdkafka](https://github.com/arnaud-lb/php-rdkafka)

```bash
sudo pecl install rdkafka
```

Add `extension=rdkafka.so` to php.ini

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

```bash
php -S 127.0.0.1:8000 public/index.php
```

## Send Batch Message

```bash
curl -H "X-Correlation-ID: correlationId" -H "X-Origin: origin" -XPOST http://127.0.0.1:8000/batch-message -d '[{"id":1},{"id":2}]'
```

## Docs

- [KonstantinCodes/messenger-kafka](https://github.com/KonstantinCodes/messenger-kafka)
- [php-rdkafka](https://arnaud.le-blanc.net/php-rdkafka-doc/phpdoc/book.rdkafka.html)
- [Kafka Configuration](https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md)
