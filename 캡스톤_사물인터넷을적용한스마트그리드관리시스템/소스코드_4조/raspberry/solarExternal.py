import serial
import time
import re
from datetime import datetime
import paho.mqtt.client as mqtt

ser = serial.Serial('/dev/ttyACM0', 9600)

externalSwitch = 0
solarSwitch = 0
flag = 0
dd = []

def on_message(client,userdata,message):
    global externalSwitch
    global solarSwitch
    global flag
    global dd
    global level
    data = str(message.payload.decode('utf-8'))

    if data=="1":
        time.sleep(0.2)
        ser.write(b'2')
        solarSwitch = 1
        time.sleep(0.2)
        ser.write(b'1')
        externalSwitch = 0
    elif data == "0" and flag==0:
        time.sleep(0.2)
        ser.write(b'0')
        externalSwitch = 1
        time.sleep(0.2)
        ser.write(b'3')
        solarSwitch = 0
   
    dd = data.split()
    if len(dd) == 2:
        l =( level/1.2)/3600/4
        p=0
        if l>=12.6: 
            p = 1
        elif l>=12.5:
            p = 0.9+l-12.5
        elif l>=12.42:
            p = 0.8+l-12.42
        elif l>=12.32:
            p = 0.7+l-12.32
        elif l>=12.20:
            p = 0.6+l-12.20
        elif l>=12.06:
            p = 0.5+l-12.06
        elif l>=11.9:
            p = 0.4+l-11.9
        elif l>=11.75:
            p = 0.3+l-11.75
        elif l>=11.58:
            p = 0.2+l-11.58
        elif l>=11.1:
            p = 0.1+l-11.1
        elif l>=10.5:
            p = 0+l-10.5
        subSolar.publish("house/solar/gen/smarthome",str(dd[0])+" "+str(dd[1])+" "+str(p))
    else:
        dd = []


def checkBlackout(extern,check,solar):#extern is curent
    global solarSwitch
    global flag
    if float(extern)< 2.0 and flag==0:
        flag = 1
        
        print("----------blackout--------")
        print("flag:",flag) 

        solarSwitch = 1
        time.sleep(0.2)
        ser.write(b'2')
      
       
        #solarSwitch = 0
        #time.sleep(0.2)
        #ser.write(b'3') 
        
    return flag

def checkBatteryLevel(lis,level):
    global dd
    if solarSwitch ==1: 
        outWatt = float(lis[0])*abs(float(lis[1]))
        level = level - outWatt

    # 사용하지 않을때 충전 하니까 
        #암페어시 고려함 
        # 11.1 이면 과 방전 
    if level > 191808 and level < 212889.6:
        inWatt = 0
        if(len(dd)==2):
            inWatt = float(dd[0])*abs(float(dd[1]))
        
        level = level + inWatt

    return level 

try:
    level = 211161.6
    broker_address = "203.250.148.23"
    print("creating new instance")

    subClient = mqtt.Client("subBattery")
    pubExternBattery = mqtt.Client("pubExternalBattery")
    pubSolarBattery = mqtt.Client("pubSolarBattery")
    subSolar = mqtt.Client("subSolar")
    pubSolar = mqtt.Client("pubSolar")

    subClient.on_message = on_message
    subSolar.on_message = on_message
    print("connecting to broker")
    
    subClient.connect(broker_address,1883,60)
    pubExternBattery.connect(broker_address,1883,60)
    pubSolarBattery.connect(broker_address,1883,60)
    pubSolar.connect(broker_address,1883,60)
    subSolar.connect(broker_address,1883,60)

    subClient.loop_start()
    subSolar.loop_start()

    for i in range(3):
        ser.write(b'0')
        externalSwitch = 1
        time.sleep(1)
        time.sleep(0.1)
    flag=0
    check=0
    solarSwitch = 0
    for i in range(30):
        data = str(ser.readline())
    while 1:
            data = str(ser.readline())  

            lis = re.findall(r"[-+]?\d*\.\d+|=d+",data)
            
            if len(lis)!=4:
                continue
           
            print(lis)

            checkBlackout(lis[0],check,lis[2])
            
            pubExternBattery.publish("house/battery/external/smarthome",lis[0]+" "+ lis[1]+" "+str(externalSwitch)+" "+str(flag))
            pubSolarBattery.publish("house/battery/solar/smarthome",lis[2]+" "+lis[3]+" "+str(solarSwitch))

            subSolar.subscribe("house/solar/charging")
            
            level = checkBatteryLevel(lis,level)
            
            subClient.subscribe("house/battery/change/smarthome")
            

except Exception as e:
    subClient.loop_stop()
    subSolar.loop_stop()

    print("end")
    print(e)
    ser.write(b'1')
    time.sleep(0.2)
    ser.write(b'3')
    time.sleep(0.2)
    ser.close()

