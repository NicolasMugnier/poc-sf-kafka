from kafka import KafkaConsumer
from kafka import KafkaProducer
from kafka.errors import KafkaError
import json
import logging


# on success callback
def on_send_success(record_metadata):
    print("[OK] Send message on %s" % record_metadata.topic)
    # print(record_metadata.partition)
    # print(record_metadata.offset)


# on error callback
def on_send_error(excp):
    logging.error('I am an errback', exc_info=excp)


brokers = ['127.0.0.1:9093']
batchMessageTopic = 'batch-messages'
singleMessageTopic = 'single-messages'
batchMessageConsumerGroupId = 'batch-messages-group'

# To consume latest messages and auto-commit offsets
consumer = KafkaConsumer(batchMessageTopic,
                         group_id=batchMessageConsumerGroupId,
                         bootstrap_servers=brokers,
                         value_deserializer=lambda m: json.loads(m.decode('ascii')))

producer = KafkaProducer(bootstrap_servers=brokers,
                         value_serializer=lambda m: json.dumps(m).encode('ascii'), retries=5)

for batchMessage in consumer:
    headers = batchMessage.headers
    for singleMessage in batchMessage.value:
        #print("%s" % (singleMessage))
        #correlationId = bytes('correlationId', encoding='utf-8')
        #origin = bytes('origin', encoding='utf-8')
        #headers = [('X-Correlation-ID', correlationId), ('X-Origin', origin)]
        producer.send(singleMessageTopic, value=singleMessage, headers=headers).add_callback(
            on_send_success).add_errback(on_send_error)

producer.flush()
