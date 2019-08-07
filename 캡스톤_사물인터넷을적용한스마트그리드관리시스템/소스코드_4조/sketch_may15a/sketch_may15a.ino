float svout = 0.0; 
float svin = 0.0;
float evout = 0.0;
float evin = 0.0;
float eAvalue = 0.0;
float sAvalue = 0.0;
float ivout = 0.0;
float ivin = 0.0;
float iAvalue = 0.0;


double eAmps = 0;      // 실제 측정된 전류 값
double sAmps = 0;
double iAmps = 0;

char cmd;

double evalue = 0.0;
double svalue = 0.0;
double ivalue = 0.0;

void setup() {
  Serial.begin(9600); //pc모니터로 전압값을 쉽게 확인하기 위하여 시리얼 통신을 설정해줍니다.
  pinMode(A0, INPUT);
  pinMode(A1, INPUT);
  pinMode(A2,INPUT);
  pinMode(A3,INPUT);
  pinMode(9,OUTPUT);
  pinMode(10, OUTPUT);
}

void loop() {
  
  evalue = analogRead(A0);
  evout = (evalue*5.0)/1024.0;
  evin = evout/0.2;
  delay(1);
  eAvalue = analogRead(A1);
  eAmps = (eAvalue*5.0)/1024.0;
  eAmps = (eAmps-2.5)*(30/2);
  delay(1);

  svalue = analogRead(A2);
  svout = (svalue * 5.0)/1024.0;
  svin = svout/0.2;
  delay(1);
  sAvalue = analogRead(A3);
  sAmps = (sAvalue*5.0)/1024.0;
  sAmps = (sAmps-2.5)*(30/2);
  delay(1);

  Serial.print(evin);
  Serial.print(" ");
  Serial.print(eAmps);
  Serial.print(" ");
  Serial.print(svin);
  Serial.print(" ");
  Serial.println(sAmps);
  Serial.print("external power : ");
  Serial.print(evin*eAmps);
  Serial.print(" ");
  Serial.print("solar power : ");
  Serial.println(svin*sAmps);
  
  if(Serial.available())
  {
    cmd = Serial.read();
    if(cmd =='0')  digitalWrite(9, HIGH);
    else if(cmd == '1')  digitalWrite(9, LOW);
    else if(cmd =='2') digitalWrite(10,HIGH);
    else if(cmd == '3') digitalWrite(10,LOW);
    else;
  }
  delay(400);
}
