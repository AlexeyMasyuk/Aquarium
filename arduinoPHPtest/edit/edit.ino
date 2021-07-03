#include <EEPROM.h>
#include <ESP8266WiFi.h>

//--------DefinSizeOfCredArrders--------//
const int SizeOfCredArr = 4;
typedef String userData[SizeOfCredArr];



// userData Data Location
int wifiSSID = 0;
int ssidPASS = 1;
int SiteUser = 2;
int SitePass = 3;

// WIFIorPHPfail Fails Location
int PHP_Fail = 1;
int WIFI_Fail = 0;

int Serial_ValidationSignSize = 5;

// DataToPHPreq Actions
int PushData = 0;
int ValidCred = 1;

// Serial And PHP Read Signs
char ReadStartSign = '<';
char ReadEndSign = '>';

char WordSep = ',';

// Serial and PHP Answers
String ValidInput = "OKEY";
String noUserFound_PHP = "NUF";

// PHP Send data PreFix
String CredValidPre = "data=";
String DataPushPre = "push=";

int WaitingInterval = 10000;

int MemmoryCycle = 2;

// PHP connection server
String server = "192.168.1.40";
//--------Definders Ends--------//
userData data = { "" , "" , "" , "" };
// [      [0]              [1]                 [2]                 [3]         ]
// {     "SSID"    , "SSID Password" , "AquaSite UserName", "AquaSite Password"};
// {"HOTBOX 4-4618",  "00548048023"  ,        "ard"        ,     "qweqwe123123"    };

boolean strComplete = false;  // whether the string is complete
boolean pushData = false;
boolean WIFIorPHPfail[2] = {false, false};
WiFiClient client;

void(* resetFunc)(void) = 0;

void setup() {
  Serial.begin(9600);
  delay(2000);
  userData cred = {"", "" , "", ""};
  if (Serial) {
    delay(550);
    if (serialAndDataHandlerEvent(cred)) {
      if (phpEvantHandler(cred)) {
        ReadOrWrite(false,cred);
        CredCopy(data, cred);
        Serial.print(ValidInput);  // OKEY
      }
      else {
        if (WIFIorPHPfail[WIFI_Fail]) {
          Serial.print("FALSEwifi");
        } else {
          Serial.print("FALSEuser");
        }
      }
    }
    else {
      Serial.print("FALSEser");
    }
  }
ReadOrWrite(true,cred);
  CredCopy(data, cred);
  if (wifiConnect(cred)) {
    pushData = true;
    loop();
  }
}



void loop() {
  userData cred = { "" , "" , "", "" };
  CredCopy(cred, data);
  if (pushData) {
    phpReq(DataToPHPreq(PushData, cred));
    delay(5000);
  }
  if (!wifiConnect(cred)) {
    pushData = false;
    resetFunc();
  }
  else {
    pushData = true;
  }
}

//--------------------------- FUNCTIONS ------------------------//
String DataToSQL(userData cred) {
  String ParamStr = "";
  char sep = WordSep;
  float PH = ((float)random(1, 100) / 100) + random(5, 8);
  int level = random(500, 550), Temper = random(23, 27);

  ParamStr.concat(DataPushPre);
  ParamStr.concat(Temper);
  ParamStr.concat(sep);
  ParamStr.concat(PH);
  ParamStr.concat(sep);
  ParamStr.concat(level);
  ParamStr.concat(sep);
  ParamStr.concat(cred[SiteUser]);
  return ParamStr;
}

void CredCopy(userData CopyTo, userData CopyFrom) {
  for (int i = 0; i < SizeOfCredArr; i++) {
    CopyTo[i] = CopyFrom[i];
  }
}

String CUT(String str)
{
  String newStr;
  for (int i = 0; str.charAt(i) != WordSep && str.charAt(i) != ReadEndSign; i++) {
    newStr.concat(str.charAt(i));
  }
  //newStr.concat('\0');                  // if deleating as length changing need to adjust dataToStruct ->Line: newStr = newStr.substring(tmpData.userData[i].length());
  return newStr;
}


void dataToStruct( userData cred, String input)
{
  String newStr = input.substring(5);
  userData tmpData = {     ""    , "" , "", ""};
  for (int i = 0; i < SizeOfCredArr; i++) {
    tmpData[i] = CUT(newStr.substring(0));
    if (i < SizeOfCredArr - 1) {
      newStr = newStr.substring(tmpData[i].length() + 1);
    }
  }
  CredCopy(cred, tmpData);
}

//***              serialAndDataHandlerEvent()              ***//

String serialEvent()
{
  String input;
  while (Serial.available() && !strComplete) {
    delay(20);
    char inChar = (char)Serial.read();
    input += inChar;
    if (inChar == ReadEndSign) {
      strComplete = true;
      input += '\0';
    }
  }
  return input;
}

boolean serialAndDataHandlerEvent(userData cred)
{
  String input;
  if (Serial) {
    Serial.print("Serial");

    delay(100);
    input = serialEvent();
    delay(50);

    if (input.indexOf(ValidInput) >= 0) {
      Serial.print("ValidInput");
      dataToStruct(cred, input);
      return true;

    }
  }
  return false;
}
/*------------------------------------------------------*/

void ReadOrWrite(boolean Read,userData cred){
  for(int i=0;i<MemmoryCycle;i++){
    if(Read){
      mmRead(cred);
    }else{
      mmWrite(cred);
    }
    delay(550);
  }
}

void mmRead(userData cred)
{
  userData TmpCred = {"", "", "", ""};

  EEPROM.begin(256);
  int CredSize[SizeOfCredArr], CopyIndex = SizeOfCredArr, CopySize = 0;
  char c;
  delay(50);
  for (int i = 0; i < SizeOfCredArr; i++) {
    CredSize[i] = EEPROM.read(i);
    delay(30);
  }

  Serial.println("ReadStart");
  for (int i = 0; i < SizeOfCredArr; i++) {
    CopySize += CredSize[i];
    for (int j = CopyIndex; j < (CopySize + SizeOfCredArr); j++) {
      c = EEPROM.read(j);
      TmpCred[i].concat(c);
      CopyIndex++;
    }
  }
  CredCopy(cred, TmpCred);
  delay(1000);
  EEPROM.end();
}

// First 4 cell writen is length of each of credential
void mmWrite(userData cred)
{
  EEPROM.begin(256);
  Serial.println("Write");
  int WriteIndex = SizeOfCredArr;
  for (int i = 0; i < SizeOfCredArr; i++) {
    EEPROM.write(i, cred[i].length());
    delay(30);
  }

  for (int i = 0; i < SizeOfCredArr; i++) {
    for (int j = 0; j < cred[i].length(); j++) {
      EEPROM.write(WriteIndex, cred[i].charAt(j));
      delay(30);
      WriteIndex++;
    }
  }

  delay(1000);
  EEPROM.commit();
  delay(150);
}

//*********************************************************//
//*** Wifi and Net send recive data ***//

boolean phpEvantHandler(userData cred)
{
  if (wifiConnect(cred)) {
    if (phpReq(DataToPHPreq(ValidCred, cred))) {
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
  String post = "";
  if (act == 1) {
    post.concat(CredValidPre);
    post.concat(cred[SiteUser]);
    post.concat(WordSep);
    post.concat(cred[SitePass]);
  } else {
    post = DataToSQL(cred);
  }
  return post;
}

boolean phpReq(String post)
{
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;

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
    if (currentMillis - previousMillis > WaitingInterval) {
      break;
    }
    delay(0);
  }
  delay(5000);
  return false;
}

String phpAns_ReadingSeq(char ActChar, String input) {
  char c;
  c = client.read(); //read first character
  while (c != ActChar) { //while > or < character is not coming yet,
    if (ActChar == ReadEndSign) {
      input.concat(c); //store character in array
    }
    c = client.read(); //read next character
    delay(0);
  }
  return input;
}

boolean phpAns()
{
  String input = "";
  char c;
  while (client.connected() || client.available())
  {
    Serial.println("readPHPanS");
    input = phpAns_ReadingSeq(ReadStartSign, input);
    input = phpAns_ReadingSeq(ReadEndSign, input);
    Serial.println("ReadAnsEnded");
    delay(0);
  }
  client.stop();  //stop connection
  if (input.length() > 0)
  {
    boolean PHP_Ans = (input.indexOf(ValidInput) >= 0);
    WIFIorPHPfail[PHP_Fail] = !PHP_Ans;
    return PHP_Ans;
  }
  WIFIorPHPfail[PHP_Fail] = true;
  return false;
}

boolean wifiConnect(userData cred)
{
  Serial.println("wifi");
  WiFi.mode(WIFI_STA);
  WiFi.begin(cred[wifiSSID], cred[ssidPASS]);
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;

  while (WiFi.status() != WL_CONNECTED) {
    if (currentMillis - previousMillis > WaitingInterval) {
      break;
    }
    currentMillis = millis();
    delay(100);
    Serial.print(".");
  }
  boolean ConnectionStatus =  (WiFi.status() == WL_CONNECTED);
  Serial.print("wifi ");
  Serial.println(ConnectionStatus);
  WIFIorPHPfail[WIFI_Fail] = !ConnectionStatus;
  return ConnectionStatus;
}
//*********************************************************//
//----------------------------- FUNCTIONS END----------------------------//
