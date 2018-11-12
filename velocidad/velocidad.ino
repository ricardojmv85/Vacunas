#include <LiquidCrystal.h>
int sensorpin1 = A0;
int sensorpin2=A1;
int lectura_sensor1=0;
int lectura_sensor2=0;
float tiempo=0;
bool flag1=false;
bool flag2=false;
LiquidCrystal lcd(7, 8, 9, 10, 11, 12);

void setup() {
  Serial.begin(2000000);
  lcd.begin(16, 2);
  lcd.print("    Velocidad");
}

void loop() {
  lectura_sensor1=analogRead(sensorpin1);
  lectura_sensor2=analogRead(sensorpin2);
  if (lectura_sensor1<950){
      tiempo=millis();
      flag1=true;
    }
  if (lectura_sensor2<950 && tiempo>0 && flag1==true){
    tiempo=millis()-tiempo;
    flag2=true;
    };
   if (flag1==true && flag2==true){
    Serial.println(0.17/(tiempo/1000));
    lcd.setCursor(0, 1);
    // print the number of seconds since reset:
    lcd.print("      ");
    lcd.print(0.23/(tiempo/1000));
    lcd.print(" m/s");
    flag2=false;
    flag1=false;
    }
    
    //delay(2000);
    
}
