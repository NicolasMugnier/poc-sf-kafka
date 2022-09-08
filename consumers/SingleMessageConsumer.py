from kafka import KafkaConsumer
from kafka.errors import KafkaError
import json
import http.client


brokers = ['127.0.0.1:9093']
singleMessageTopic = 'single-messages'
singleMessageConsumerGroupId = 'single-messages-group'

# To consume latest messages and auto-commit offsets
consumer = KafkaConsumer(singleMessageTopic,
                         group_id=singleMessageConsumerGroupId,
                         bootstrap_servers=brokers,
                         value_deserializer=lambda m: json.loads(m.decode('ascii')))


for singleMessage in consumer:
    headers = singleMessage.headers
    # print("%s" % (singleMessage.value))
    connection = http.client.HTTPConnection("127.0.0.1", 8000)
    connection.request("POST", "/single-message",
                       json.dumps(singleMessage.value))
    response = connection.getresponse()
    print("POST /single-message %s %d" %
          (singleMessage.value, response.status))
