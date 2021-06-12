#include <EEPROM.h>
#include <ESP8266WiFi.h>

typedef struct {
  String userData[4];
} userData_type;
userData_type data = {     ""    , "" , "", ""};
// [      [0]              [1]                 [2]                 [3]         ]
// {     "SSID"    , "SSID Password" , "AquaSite UserName", "AquaSite Password"};
// {"HOTBOX 4-4618",  "00548048023"  ,        "ar"        ,     "qweqwe123"    };

String input = "";         // a string to hold incoming data
boolean strComplete = false;  // whether the string is complete
boolean pushData = false;
boolean WIFIorPHPfail[2]={false,false};

WiFiClient client;
String server = "192.168.1.45";
void(* resetFunc)(void) = 0;

void setup() {
  Serial.begin(9600);
  
// Serial.println("--SetupStart--");
// WiFi.disconnect();
// mmWrite();
//
  //  mmRead();
  //  Serial.println(data.userData[0]);
  //  Serial.println(data.userData[1]);
  //  Serial.println(data.userData[2]);
  //  Serial.println(data.userData[3]);

  if (Serial) {
    delay(550);
    if (serialAndDataHandlerEvent()) {
      if (phpEvantHandler()) {
        mmWrite();
        Serial.print("OKEY");
      }
      else {
        if(WIFIorPHPfail[0]){
          Serial.print("FALSEwifi");
        }else{
          Serial.print("FALSEuser");
        }
      }
    }
    else {
      Serial.print("FALSEser");
    }

    unsigned long currentMillis = millis();
    unsigned long previousMillis = currentMillis;
    int interval = 8000;
    while (true) {

      if (currentMillis - previousMillis > interval) {
        break;
      }
      currentMillis = millis();
      delay(1000);
    }
  }
  else {
    mmRead();
    if (wifiConnect()) {
      pushData = true;
    }
  }
}



void loop() {
  if (pushData) {
    phpReq(DataToPHPreq(0));
    delay(5000);
  }
  if (!wifiConnect()) {
    resetFunc();
  }
}

//--------------------------- FUNCTIONS ------------------------//
String DataToSQL() {
  return "push=26,0.7,500," + data.userData[2];
}


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
  while (Serial.available()&&!strComplete) {
    delay(20);
    char inChar = (char)Serial.read();
    input += inChar;
    if (inChar == '\n') {
      strComplete = true;
    }
  }
}

boolean serialAndDataHandlerEvent()
{
  if (Serial) {
    delay(100);
      serialEvent();
      delay(50);

    if (validInp()) {
      dataToStruct(4, 0);
    }
  }
  return toStructCheck(4, 0);
}
/*------------------------------------------------------*/
boolean validInp()
{
  String tmp = input.substring(1, 5);
  if (tmp == "OKEY") {
    return true;
  }
  return false;
}

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

boolean phpEvantHandler()
{
  if (wifiConnect()) {
    if (phpReq(DataToPHPreq(1))) {
      if (phpAns()) {
        Serial.println("After phpAns");
        return true;
      }
    }
  }
  delay(999);
  return false;
}

String DataToPHPreq(int act) {
  String post;
  if (act == 1) {
    post = "data=";
    post.concat(data.userData[2]);
    post.concat(",");
    post.concat(data.userData[3]);

  } else {
    post = DataToSQL();
  }
  Serial.println(post);
  return post;
}

boolean phpReq(String post)
{
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;
  int interval = 100000;

  Serial.println(post);
  while (true) {
    if (client.connect(server, 80))
    {
      client.println("POST /AqSite/PageActClasses/ArdPort.php HTTP/1.1");
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
      Serial.println("After Post");
      return true;
    }
    if (currentMillis - previousMillis > interval) {
      break;
    }
    delay(0);
  }
  delay(9000);
  return false;
}

boolean phpAns()
{
  Serial.println("Start AnsReas");
  input = "";
  char c;
  while (client.connected() || client.available())
  {
    Serial.println("readS");
    c = client.read(); //read first character
    while (c != '<') { //while < character is not coming yet, keep reading character
      c = client.read();
      delay(0);
    }
    c = client.read(); //read the '<' character, but not storing in array
    while (c != '>') { //while > character is not coming yet,
      input.concat(c); //store character in array
      c = client.read(); //read next character
      delay(0);
    }
    delay(0);
  }
  client.stop();  //stop connection
  if (input.length() > 0)
  {
    if(input.indexOf("NUF") >= 0){
      Serial.println("NUF");
      WIFIorPHPfail[1]=true;
      return false;
    }
    WIFIorPHPfail[1]=false;
    return true;
  }
  return false;
}

boolean wifiConnect()
{
  Serial.println("wifi");
  WiFi.mode(WIFI_STA);
  WiFi.begin(data.userData[0], data.userData[1]);
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;
  int interval = 8000;
  while (WiFi.status() != WL_CONNECTED) {
    if (currentMillis - previousMillis > interval) {
      break;
    }
    currentMillis = millis();
    delay(100);
    Serial.print(".");
  }
  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("true");
    WIFIorPHPfail[0]=false;
    return true;
  }
  WIFIorPHPfail[0]=true;
  return false;
}
//*********************************************************//
//----------------------------- FUNCTIONS END----------------------------//
