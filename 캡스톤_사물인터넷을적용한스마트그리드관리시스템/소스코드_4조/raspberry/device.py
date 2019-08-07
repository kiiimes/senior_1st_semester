import serial
import time
import re
from datetime import datetime
import paho.mqtt.client as mqtt

ser = serial.Serial('/dev/ttyACM0',9600)

def on_message(client,userdata,message):
    mess = str(message.payload.decode('utf-8'))
  
    ml = message.topic.split('/')
    
    if ml[4]=='1':
        if mess=='0':
            time.sleep(0.2)
            ser.write(b'1')
        elif mess=='1':
            time.sleep(0.2)
            ser.write(b'0')

    elif ml[4]=='2':
        if mess=='0':
            time.sleep(0.2)
            ser.write(b'3')
        elif mess=='1':
            time.sleep(0.2)
            ser.write(b'2')
    elif ml[4]=='3':
        if mess=='0':
            time.sleep(0.2)
            ser.write(b'5')
        elif mess=='1':
            time.sleep(0.2)
            ser.write(b'4')

def switchControl(signal):
    if signal=='0':
        ser.write(b'1')
    elif signal=='1':
        ser.write(b'0')

try:
    broker_address = "203.250.148.23"
    print("creating new instance")
    firstSubClient = mqtt.Client("firstSubDevice")
    firstPubClient = mqtt.Client("firstPubDevice")
    secondSubClient = mqtt.Client("secondSubDevice")
    secondPubClient = mqtt.Client("secondPubDevice")
    thirdSubClient = mqtt.Client("thirdSubDevice")
    thirdPubClient = mqtt.Client("thirdPubDevice")
    totalClient = mqtt.Client("total")


    firstSubClient.on_message = on_message
    secondSubClient.on_message = on_message
    thirdSubClient.on_message = on_message
    
    print("connecting to broker")
    firstSubClient.connect(broker_address,1883,60)
    firstPubClient.connect(broker_address,1883,60) 
    secondSubClient.connect(broker_address,1883,60) 
    secondPubClient.connect(broker_address,1883,60)
    thirdSubClient.connect(broker_address,1883,60)
    thirdPubClient.connect(broker_address,1883,60)
    totalClient.connect(broker_address,1883,60)

    firstSubClient.loop_start()    
    secondSubClient.loop_start()
    thirdSubClient.loop_start()
    
    while 1:
        data = str(ser.readline())
        lis = re.findall(r"[-+]?\d*\.\d+|=d+",data)
        if len(lis)!=6:
            continue
        print(lis)
    
        firstPubClient.publish("house/device/smarthome/1",lis[0]+" "+lis[1]) 
        secondPubClient.publish("house/device/smarthome/2",lis[2]+" "+lis[3])
        thirdPubClient.publish("house/device/smarthome/3",lis[4]+" "+lis[5])
        totalClient.publish("house/device/consumption/smarthome",str(float(lis[0])*abs(float(lis[1])))+" "+str(float(lis[2])*abs(float(lis[3])))+" "+str(float(lis[4])*abs(float(lis[5]))))

        firstSubClient.subscribe("house/device/switch/smarthome/1")
        secondSubClient.subscribe("house/device/switch/smarthome/2")
        thirdSubClient.subscribe("house/device/switch/smarthome/3")

except:
    firstSubClient.loop_stop()
    secondSubClient.loop_stop()
    thirdSubClient.loop_stop()

    ser.write(b'1')
    time.sleep(0.2)
    ser.write(b'3')
    time.sleep(0.2)
    ser.write(b'5')

    ser.close()

