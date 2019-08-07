import serial
import time
import re
import paho.mqtt.client as mqtt

ser = serial.Serial('/dev/ttyACM0',9600)

broker_address = "203.250.148.23"
print("creating new instance")
solarClient = mqtt.Client("solarClient")
print("connecting to broker")
solarClient.connect(broker_address,1883)
while 1:
    data = str(ser.readline())
        
    lis = re.findall(r"[-+]?\d*\.\d+|=d+",data)
    if len(lis)!=2:
        continue
    print(lis)
        
    solarClient.publish("house/solar/charging",str(lis[0])+" "+str(lis[1]))









