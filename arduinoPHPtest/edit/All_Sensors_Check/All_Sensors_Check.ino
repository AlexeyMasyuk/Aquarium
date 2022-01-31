#include <EEPROM.h>
//#include <ESP8266WiFi.h>
#include <WiFiNINA.h>
#include <OneWire.h>
#include <DallasTemperature.h>

const int High_LevelPin = A2;
const int Low_LevelPin = A1;
#define ONE_WIRE_BUS 2
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature temperatureSensor(&oneWire);

void setup() {
  Serial.begin(9600);
  delay(2000);
}

void loop() {

  Serial.print("PH: ");
  Serial.println(GetPH());
  Serial.println();
  delay(1000);
}

String GetLevelValue() {
  int MidCalc = 200;
  int High = digitalRead(High_LevelPin);
  int Low = digitalRead(Low_LevelPin);
  if (High == 1) {
    return "300";
  } else if (Low == 1) {
    return "200";
  } else {
    return String(MidCalc);
  }
}

// Function reading Temperature value
String GetTemperature() {
  String TempReturened = "";
  temperatureSensor.requestTemperatures();
  float ReaadedTemperature = 0;
  ReaadedTemperature = temperatureSensor.getTempCByIndex(0);
  TempReturened.concat(ReaadedTemperature);
  return TempReturened;
}

// Function reading PH value
String GetPH() {
  float m = 0.167;
  float b = 0.00;

  float measurings = 0;
  float resolution  = 1024.0;
  float voltage;
  float pHvalue;
  String ReturenedPH = "";
  for (int i = 0; i < 10; i++)
  {
    measurings = measurings + analogRead(A0);
    delay(10);
  }
  voltage = ((5 / resolution) * (measurings / 10));

  pHvalue = ((7 + ((2.5 - voltage) / m))) + b;   // ADJUST after calibration
  ReturenedPH.concat(pHvalue);
  return ReturenedPH;
}
