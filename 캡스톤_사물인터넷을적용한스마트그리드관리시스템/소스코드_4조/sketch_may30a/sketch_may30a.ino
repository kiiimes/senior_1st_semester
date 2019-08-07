float svout = 0.0; 
float svin = 0.0;
double sAmps = 0;

char cmd;

double svalue = 0.0;
double sAvalue = 0.0;

void setup() {
  Serial.begin(9600); //pc모니터로 전압값을 쉽게 확인하기 위하여 시리얼 통신을 설정해줍니다.
  pinMode(A0, INPUT);
  pinMode(A1, INPUT);
  pinMode(9,OUTPUT);
}

void loop() {
  
  svalue = analogRead(A0);
  svout = (svalue * 5.0)/1024.0;
  svin = svout/0.2;
  delay(1);
  
  sAvalue = analogRead(A1);
  sAmps = (sAvalue*5.0)/1024.0;
  sAmps = (sAmps-2.5)*(30/2);
  delay(1);
  
  Serial.print(svin);
  Serial.print(" ");
  Serial.println(sAmps);
  
  
  if(Serial.available())
  {
    cmd = Serial.read();
    if(cmd =='0')  digitalWrite(9, HIGH);
    else;
  }
  delay(400);
}
