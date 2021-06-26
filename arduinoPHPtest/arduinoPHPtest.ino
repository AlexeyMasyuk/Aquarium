#include <EEPROM.h>
#include <ESP8266WiFi.h>

typedef String userData[4];

userData data = {     ""    , "" , "", ""};
// [      [0]              [1]                 [2]                 [3]         ]
// {     "SSID"    , "SSID Password" , "AquaSite UserName", "AquaSite Password"};
// {"HOTBOX 4-4618",  "00548048023"  ,        "ard"        ,     "qweqwe123123"    };

String input = "";         // a string to hold incoming data
boolean strComplete = false;  // whether the string is complete
boolean pushData = false;
boolean WIFIorPHPfail[2] = {false, false};

WiFiClient client;
String server = "192.168.1.23";
void(* resetFunc)(void) = 0;

void setup() {
  Serial.begin(9600);
  delay(2000);
  //  EEPROM.begin(512);
  //  delay(500);
  //  WiFi.disconnect();
  //  delay(500);
  //  mmRead();
  //  Serial.println(data.userData[0]);
  //  Serial.println(data.userData[1]);
  //  Serial.println(data.userData[2]);
  //  Serial.println(data.userData[3]);
  //  wifiConnect();
  //  resetFunc();
  userData cred = {     ""    , "" , "", ""};

  if (Serial) {
    delay(550);
    if (serialAndDataHandlerEvent(cred)) {
      if (phpEvantHandler(cred)) {
        mmWrite(cred);
        delay(550);
        mmWrite(cred);
        for (int i = 0; i < 4; i++) {
          data[i] = cred[i];
        }
        Serial.println(data[0]);
        Serial.println(data[1]);
        Serial.println(data[2]);
        Serial.println(data[3]);
        Serial.print("OKEY");
        resetFunc();
      }
      else {
        if (WIFIorPHPfail[0]) {
          Serial.print("FALSEwifi");
        } else {
          Serial.print("FALSEuser");
        }
      }
    }
    else {
      Serial.print("FALSEser");
    }

    // unsigned long currentMillis = millis();
    // unsigned long previousMillis = currentMillis;
    // int interval = 8000;
    // while (true) {

    //   if (currentMillis - previousMillis > interval) {
    //     break;
    //   }
    //   currentMillis = millis();
    //   delay(1000);
    // }
  }
  mmRead(cred);
  delay(550);
  mmRead(cred);
  if (wifiConnect(cred)) {
    Serial.println("JumpToLoop");
    pushData = true;
    Serial.println(pushData);
    loop();
  }
}



void loop() {
  userData cred = {     ""    , "" , "", ""};
  for (int i = 0; i < 4; i++) {
    cred[i] = data[i];
  }
  if (pushData) {
    phpReq(DataToPHPreq(0, cred));
    delay(5000);
  }
  if (!wifiConnect(cred)) {
    resetFunc();
  }
  else {
    pushData = true;
  }
}

//--------------------------- FUNCTIONS ------------------------//
String DataToSQL(userData cred) {
  return "push=26,0.7,500," + cred[2];
}


String CUT(String str)
{
  String newStr;
  for (int i = 0; str.charAt(i) != ',' && str.charAt(i) != '>'; i++) {
    newStr.concat(str.charAt(i));
  }
  //newStr.concat('\0');                  // if deleating as length changing need to adjust dataToStruct ->Line: newStr = newStr.substring(tmpData.userData[i].length());
  Serial.print("CUT_newStr: *");
  Serial.print(newStr);
  Serial.print("*");
  return newStr;
}


void dataToStruct(int count, int startIndex, userData cred)
{
  String newStr = input.substring(5);
  userData tmpData = {     ""    , "" , "", ""};
  Serial.print("DTS_newStr: *");
  Serial.print(newStr);
  Serial.print("*");
  for (int i = startIndex; i < (startIndex + count); i++) {
    tmpData[i] = CUT(newStr.substring(0));
    Serial.print(i);
    Serial.print("DTS_data.userData: *");
    Serial.print(tmpData[i]);
    Serial.print("*LEN*");
    Serial.print(tmpData[i].length());
    Serial.print("*LEN");
    if (i < (startIndex + count) - 1) {
      newStr = newStr.substring(tmpData[i].length() + 1);
    }

    Serial.print("DTS_newStrAfterSubstring: *");
    Serial.print(newStr);
    Serial.print("*");
  }
  for (int i = 0; i < 4; i++) {
    cred[i] = tmpData[i];
  }
  Serial.print("After TS--");
  Serial.println(cred[0]);
  Serial.println(cred[1]);
  Serial.println(cred[2]);
  Serial.println(cred[3]);
  Serial.print("--");
}

// boolean toStructCheck(int count, int startIndex)
// {
//   for (int i = startIndex; i < (startIndex + count); i++) {
//     if (data.userData[i].length() == 0) {
//       return false;
//     }
//   }
//   return true;
// }

//***              serialAndDataHandlerEvent()              ***//

void serialEvent()
{
  while (Serial.available() && !strComplete) {
    delay(20);
    char inChar = (char)Serial.read();
    input += inChar;
    if (inChar == '>') {
      strComplete = true;
      input += '\0';
    }
  }
}

boolean serialAndDataHandlerEvent(userData cred)
{
  if (Serial) {
    Serial.print("Serial");

    delay(100);
    serialEvent();

    delay(50);

    if (validInp()) {
      Serial.print("ValidInput");
      dataToStruct(4, 0, cred);
      return true;

    }
  }
  return false;
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

void mmRead(userData cred)
{
  userData TmpCred = {"", "", "", ""};
  Serial.println("Readed");
  EEPROM.begin(256);
  int CredSize[4], CopyIndex = 4, CopySize = 0;
  char c;
  delay(50);
  for (int i = 0; i < 4; i++) {

    CredSize[i] = EEPROM.read(i);
    Serial.println(CredSize[i]);
    delay(30);
  }

  Serial.println("ReadStart");
  for (int i = 0; i < 4; i++) {
    CopySize += CredSize[i];
    for (int j = CopyIndex; j < (CopySize + 4); j++) {
      c = EEPROM.read(j);
      TmpCred[i].concat(c);
      CopyIndex++;
    }

  }
  for (int i = 0; i < 4; i++) {
    cred[i] = TmpCred[i];
  }

  //EEPROM.get( 0, cred );
  delay(1000);
  Serial.println("*R*******************R*");
  Serial.println(cred[0]);
  Serial.println(cred[1]);
  Serial.println(cred[2]);
  Serial.println(cred[3]);
  Serial.println("*R*******************R*");
  EEPROM.end();
}

void mmWrite(userData cred)
{
  EEPROM.begin(256);
  int CredSize = 0, WriteIndex = 4;
  for (int i = 0; i < 4; i++) {
    EEPROM.write(i, cred[i].length());
    CredSize += cred[i].length();
    delay(30);
  }
  //cred[0]="TESTtest";
  for (int i = 0; i < 4; i++) {
    for (int j = 0; j < cred[i].length(); j++) {
      EEPROM.write(WriteIndex, cred[i].charAt(j));
      delay(30);
      WriteIndex++;

    }
  }
  //EEPROM.put(0, cred);
  delay(1000);
  EEPROM.commit();
  Serial.println("Write");
  Serial.println("*********************");
  Serial.println(cred[0]);
  Serial.println(cred[1]);
  Serial.println(cred[2]);
  Serial.println(cred[3]);
  Serial.println("*********************");

  delay(150);
}

//*********************************************************//
//*** Wifi and Net send recive data ***//

boolean phpEvantHandler(userData cred)
{
  if (wifiConnect(cred)) {
    if (phpReq(DataToPHPreq(1, cred))) {
      if (phpAns()) {
        Serial.println("After phpAns");
        return true;
      }
    }
  }
  delay(999);
  return false;
}

String DataToPHPreq(int act, userData cred) {
  String post;
  if (act == 1) {
    post = "data=";
    post.concat(cred[2]);
    post.concat(",");
    post.concat(cred[3]);
    Serial.print("*");
    Serial.print(post);
    Serial.print("*");
  } else {
    post = DataToSQL(cred);
  }
  Serial.println(post);
  return post;
}

boolean phpReq(String post)
{
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;
  int interval = 10000;

  Serial.println(post);
  while (true) {
    if (client.connect(server, 80))
    {
      Serial.println("--PostStart--");
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
  delay(5000);
  return false;
}

boolean phpAns()
{
  Serial.println("Start AnsReas");
  input = "";
  char c;
  while (client.connected() || client.available())
  {
    Serial.println("readPHPanS");
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
    Serial.println("ReadAnsEnded");
    delay(0);
  }
  client.stop();  //stop connection
  if (input.length() > 0)
  {
    if (input.indexOf("NUF") >= 0) {
      Serial.println("NUF");
      WIFIorPHPfail[1] = true;
      return false;
    }
    WIFIorPHPfail[1] = false;
    return true;
  }
  return false;
}

boolean wifiConnect(userData cred)
{
  Serial.println("wifi");
  WiFi.mode(WIFI_STA);
  WiFi.begin(cred[0], cred[1]);
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;
  int interval = 10000;
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
    WIFIorPHPfail[0] = false;
    return true;
  }
  WIFIorPHPfail[0] = true;
  return false;
}
//*********************************************************//
//----------------------------- FUNCTIONS END----------------------------//
