#include <Wire.h>
#include <LiquidCrystal_I2C.h>
const int sensorPin = A0;  
const int relayPin =7;     
LiquidCrystal_I2C lcd(0x27, 16, 2);
const int dryValue = 1023;  
const int wetValue = 0;     
void setup() {
  pinMode(relayPin, OUTPUT);
  lcd.init();
  lcd.backlight();
  Serial.begin(9600);
}
void loop() { 
  int rawValue = analogRead(sensorPin);
  int humidity = map(rawValue, dryValue, wetValue, 0, 100);
  humidity = constrain(humidity, 0, 100);
  lcd.clear();
  if (humidity > 70) {
    digitalWrite(relayPin, LOW); 
    lcd.setCursor(0, 0);
    lcd.print("Humidifier: OFF");
    lcd.setCursor(0, 1);
    lcd.print("Humid: ");
    lcd.print(humidity);
    lcd.print(" %");
  } 
  else {
    digitalWrite(relayPin, HIGH); 
    
    lcd.setCursor(0, 0);
    lcd.print("Humidifier: ON ");
    lcd.setCursor(0, 1);
    lcd.print("Humid: ");
    lcd.print(humidity);
    lcd.print(" %");
  }
  delay(2000);
} 
