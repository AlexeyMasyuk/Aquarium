#include <EEPROM.h>
#include <ESP8266WiFi.h>

typedef struct {
  String userData[7];
} userData_type;
userData_type data = {"", "", "alex", "1234", "", "", ""};


String input = "";         // a string to hold incoming data
boolean strComplete = false;  // whether the string is complete

boolean monitorMode = false;

WiFiClient client;
String server = "192.168.1.27";


void(* resetFunc)(void) = 0;

//--------------------------- FUNCTIONS ------------------------//
 

String CUT(String str)
{
  String newStr;
  for (int i = 0; str.charAt(i) != ',' && str.charAt(i) != '\n'; i++) {
    newStr.concat(str.charAt(i));
  }
  return newStr;
}

void dataToStruct(int count, int startIndex)
{
  String newStr = input.substring(5);
  for (int i = startIndex; i < (startIndex + count); i++) {
    data.userData[i] = CUT(newStr.substring(0));
    newStr = newStr.substring(data.userData[i].length() + 1);
  }
}

boolean toStructCheck(int count, int startIndex)
{
  for (int i = startIndex; i < (startIndex + count); i++) {
    if (data.userData[i].length() == 0) {
      return false;
    }
  }
  return true;
}

//***              serialAndDataHandlerEvent()              ***//

void serialEvent()
{
  while (Serial.available()) {
    delay(20);
    char inChar = (char)Serial.read();
    input += inChar;
    if (inChar == '\n') {
      strComplete = true;
    }
  }
}

boolean validInp()
{
  String tmp = input.substring(1, 5);
  if (tmp == "OKEY") {
    return true;
  }
  return false;
}

boolean serialAndDataHandlerEvent()
{
  // unsigned long currentMillis = millis();
  // unsigned long previousMillis = currentMillis;
  // unsigned long interval = 5000;
  if (Serial) {
    while (!strComplete) {
      serialEvent();
      delay(50);
      // if (currentMillis - previousMillis > interval) {
      //   break;
      // }
      // currentMillis = millis();
    }
    if (strComplete && validInp()) {
      dataToStruct(4, 0);
    }
  }
  return toStructCheck(4, 0);
}
/*------------------------------------------------------*/

void mmRead()
{
  EEPROM.begin(512);
  EEPROM.get( 0, data );
  EEPROM.end();
  delay(200);
}

void mmWrite()
{
  EEPROM.begin(512);
  EEPROM.put(0, data);
  delay(50);
  EEPROM.commit();
  delay(50);
}

//*********************************************************//
//*** Wifi and Net send recive data ***//

String userDataBind(){
  String post = "data=";
  post.concat(data.userData[2]);
  post.concat(",");
  post.concat(data.userData[3]);
  post.concat("\n");
  return post;
}

String sensorData(){
  String collecteData="collecteData=24,7.5,500";
  return collecteData;
}

boolean phpReq(String post)
{
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;
  unsigned long interval = 100000;

  while (true)
  {
    if (client.connect(server, 80))
    {
      client.println("POST /tstarduino2.php HTTP/1.1");
      client.print("Host: ");
      client.println(server);
      client.println("Content-Type: application/x-www-form-urlencoded");
      client.println("Connection: close");
      client.print("Content-Length: ");
      client.println(post.length());
      client.println();
      client.print(post);
      client.println();
      delay(1000);
      return true;
    }
    if ((currentMillis - previousMillis) > interval)
    {
      break;
    }
  }
  delay(9000);
  return false;
}

boolean phpAns()
{
  input = "";
  char c;
  while (client.connected() || client.available())
  {
    c = client.read(); //read first character
    while (c != '<') { //while < character is not coming yet, keep reading character
      c = client.read();
    }
    input.concat(c);
    c = client.read(); //read the '<' character, but not storing in array
    while (c != '>') { //while > character is not coming yet,
      input.concat(c); //store character in array
      c = client.read(); //read next character
    }
  }
  client.stop();  //stop connection
  if (input.length() > 0)
  {
    Serial.println(input);
    return true;
  }
  return false;
}

boolean wifiConnect()
{
  WiFi.mode(WIFI_STA);
  WiFi.begin(data.userData[0], data.userData[1]);
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;
  unsigned long interval = 5000;
  while (WiFi.status() != WL_CONNECTED) {

    if (currentMillis - previousMillis > interval) {
      break;
    }
    currentMillis = millis();
    delay(100);
  }
  if (WiFi.status() == WL_CONNECTED) {

    return true;
  }
  return false;
}

boolean phpEvantHandler()
{
  if (wifiConnect()) {
    if (phpReq(userDataBind())) {
      if (phpAns()) {
        dataToStruct(3, 4);
        if (toStructCheck(3, 4)) {
          return true;
        }
      }
    }
  }
  delay(999);
  return false;
}
//*********************************************************//
//----------------------------- FUNCTIONS END----------------------------//

void setup()
{
  Serial.begin(9600);

// if (Serial)
// {
//   if(serialAndDataHandlerEvent())
//   {
//     if(phpEvantHandler())
//     {
//       mmWrite();
//       Serial.println("OKEY");
//       monitorMode = true;
//       loop();
//     }
//    }
// }
// else 
// {
//   Serial.println("FALSE");
// }
}



void loop() {
  // delay(500000);
  //  if (data.userData[0].length() != 0)
  //  {
    mmRead();
            Serial.println(data.userData[0]);
             Serial.println(data.userData[1]);
             Serial.println(data.userData[2]);
             Serial.println(data.userData[3]);
            Serial.println(data.userData[4]);
              Serial.println(data.userData[5]);
              Serial.println(data.userData[6]);
  //  }
    
}

