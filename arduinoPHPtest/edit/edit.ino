#include <EEPROM.h>
#include <ESP8266WiFi.h>

//-------- Define --------//
const int SizeOfCredArr = 4;             // size of cred array.
typedef String userData[SizeOfCredArr];  // define custom type for credential store.
// Note: as pointer of custom type passed to function, copy saved after function ends.


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
int indexOf_ValidInput = 1;
int indexOf_ValidInputPHP = 0;

// PHP Send data PreFix
String CredValidPre = "data=";
String DataPushPre = "push=";

int WaitingInterval = 10000;

int MemmoryCycle = 2;

// Echo answers
String wifiFailMsg = "FALSEwifi";
String phpValidFailMsg = "FALSEuser";
String serialFailMsg = "FALSEser";

// PHP connection server
String server = "192.168.1.17";
//--------Definders Ends--------//
userData data = { "" , "" , "" , "" };
// [      [0]              [1]                 [2]                 [3]         ]
// {     "SSID"    , "SSID Password" , "AquaSite UserName", "AquaSite Password"};
// {"HOTBOX 4-4618",  "00548048023"  ,        "ard"        ,     "qweqwe123123"    };


boolean pushData = false;
boolean WIFIorPHPfail[2] = {false, false};
WiFiClient client;

void(* resetFunc)(void) = 0;


void setup() {
  Serial.begin(9600);
  delay(2000);

  if (Serial) {
    if (ValidationEvent()) {
      return;
    }
  }
  userData cred = {"", "" , "", ""};
  ReadOrWrite(true, cred);
  CredCopy(data, cred);
  if (wifiConnect(cred)) {
    pushData = true;
    return;
  }
}



void loop() {
  userData cred = { "" , "" , "", "" };
  CredCopy(cred, data);
  if (pushData) {
    phpReq(DataToPHPreq(PushData, cred));
    delay(50000);
    return;
  }
  if (!wifiConnect(cred)) {
    pushData = false;
    ValidationEvent();
    delay(50000);
  }
  else {
    pushData = true;
    ReadOrWrite(true, cred);
    CredCopy(data, cred);
  }
}

//---------------------------- FUNCTIONS --------------------------//

//======================= Control Events =======================//

// Function handling validation and saving user credential sent via Windows Application.
// Return true or false depends on serialAndDataHandler and phpEvantHandler returns.
// Echo relevans answer to be cached by Windows Application for transperent arduino status.
boolean ValidationEvent() {
  userData cred = {"", "" , "", ""};
  delay(550);
  if (serialAndDataHandler(cred)) {
    if (phpEvantHandler(cred)) {
      ReadOrWrite(false, cred);
      CredCopy(data, cred);      // Saves data in global variable for use later in loop()
      Serial.print(ValidInput);  // Secced to connect to wifi, valid site cred and saved to memmory.
      pushData = true;
      return true;
    }
    else {
      if (WIFIorPHPfail[WIFI_Fail]) {
        Serial.print(wifiFailMsg);      // Failed to connect to wifi
      } else {
        Serial.print(phpValidFailMsg);  // Failed to connect to site
      }
    }
  }
  else {
    Serial.print(serialFailMsg);       // Failed to read valid data from serial read event
  }
  return false;
}

// Function handling serial read and crop data if valid data readed.
// Get cred for saving readed credential.
// Return true or false depends on data readed, true if readed str starts with "OKEY".
boolean serialAndDataHandler(userData cred)
{
  String input;
  if (Serial) {
    delay(100);
    input = serialRead();
    delay(50);

    if (input.indexOf(ValidInput) == indexOf_ValidInput) {
      dataToStruct(cred, input);
      return true;
    }
  }
  return false;
}

// Function handling PHP and network event.
// Get cred array used for wifi connection and site credential validation
// Connecting to WIFI, sending cred to site PHP server "Arduino Port"
// and reading answer from site.
// Return true or false depending to site credential validation.
boolean phpEvantHandler(userData cred)
{
  if (wifiConnect(cred)) {
    Serial.println("phpEvantHandler");
    if (phpReq(DataToPHPreq(ValidCred, cred))) {
      if (phpAns()) {
        return true;
      }
    }
  }
  delay(999);
  return false;
}
//====================== Control events end =====================//

//======================== Data handlers ========================//

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

// Function copy credential custom arrays one to enother.
void CredCopy(userData CopyTo, userData CopyFrom) {
  for (int i = 0; i < SizeOfCredArr; i++) {
    CopyTo[i] = CopyFrom[i];
  }
}

// Function cutting words seperated by WordSep or ends by ReadEndSign.
// The function getting string parameter needed to be cut
// and returning the word that was cut.
String CUT(String str)
{
  String newStr;
  for (int i = 0; str.charAt(i) != WordSep && str.charAt(i) != ReadEndSign; i++) {
    newStr.concat(str.charAt(i));
  }
  return newStr;
}

// Function cropping and saving credential saved in string to custom array.
// Avoiding first 5 chars as they contain validation word,
// using CUT() function to seperate credential string
// and save it in dedicated custom array cred using CredCopy().
void dataToStruct(userData cred, String input)
{
  String newStr = input.substring(5);
  userData tmpData = { "", "", "", ""};
  for (int i = 0; i < SizeOfCredArr; i++) {
    tmpData[i] = CUT(newStr.substring(0));
    if (i < SizeOfCredArr - 1) {
      newStr = newStr.substring(tmpData[i].length() + 1);
    }
  }
  CredCopy(cred, tmpData);
}

// Function prepering data to be sent to PHP server.
// Getting act for deciding what data to prepare asd cred used for prepare the data.
// Depending on act (act=1) parameter prepered dara is for validation or (act=0) to be saved as sensor data.
String DataToPHPreq(int act, userData cred) {
  String post = "";
  if (act == ValidCred) {
    post.concat(CredValidPre);
    post.concat(cred[SiteUser]);
    post.concat(WordSep);
    post.concat(cred[SitePass]);
  } else if (act == PushData) {
    post = DataToSQL(cred);
  }
  return post;
}
//======================= Data handlers end ======================//

//======================== Serial handler ========================//

// Function reading data from serial (USB) port,
// stores it in input parameter untill ReadEndSign found
// and return the input.
String serialRead()
{
  String input;
  boolean strComplete = false;
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
//====================== Serial handler end ======================//

//==================== EEPROM memmory handler ====================//

// Function reading or writing cred parameter to EEPROM memmory.
// If given read parameter is true function will read from memmory and save it to cred parameter,
// else function will write to eeprom from cred parameter.
void ReadOrWrite(boolean Read, userData cred) {
  for (int i = 0; i < MemmoryCycle; i++) {
    if (Read) {
      mmRead(cred);
    } else {
      mmWrite(cred);
    }
    delay(550);
  }
}

// Function reading from eeprom and save in cred.
// first read is SizeOfCredArr (4) ints representing size of each string,
// 4 strings containing wifi and site credential.
// Second read is the strings that contains credentials.
void mmRead(userData cred)
{
  userData TmpCred = {"", "", "", ""};

  EEPROM.begin(256);
  int CredSize[SizeOfCredArr], CopyIndex = SizeOfCredArr, CopySize = 0;
  char c;
  delay(50);
  // First read.
  for (int i = 0; i < SizeOfCredArr; i++) {                          // Loop for reading credential length.
    CredSize[i] = EEPROM.read(i);
    delay(30);
  }
  // Second read.
  for (int i = 0; i < SizeOfCredArr; i++) {                          // Outer loop, words iterator.
    CopySize += CredSize[i];
    for (int j = CopyIndex; j < (CopySize + SizeOfCredArr); j++) {   // Inner loop, characters iterator.
      c = EEPROM.read(j);
      TmpCred[i].concat(c);
      CopyIndex++;
    }
  }
  CredCopy(cred, TmpCred);
  delay(1000);
  EEPROM.end();
}

// Function writing to eeprom from given cred parameter.
// First 4 writs is ints representing length of 4 credential strings will be saved after.
// Then credential strings saved.
// EEPROM Memmory-> .....913913WIFI_SSIDwifi_passwordSITE_USERsite_password.....
//              9 | 13 | 9 | 13 | WIFI_SSID | wifi_password | SITE_USER | site_password
void mmWrite(userData cred)
{
  EEPROM.begin(256);
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
Serial.println("CharWriten"+WriteIndex);
  delay(1000);
  EEPROM.commit();
  delay(150);
}
//================== EEPROM memmory handler ends ==================//

//================== WIFI and PHP server handler ==================//

// Function sends POST request to dedicated "Arduino Port".
// Sending validation string from given post parameter.
// returning true if connection to server secced,
// or false if WaitingInterval time passed and connection failed
boolean phpReq(String post)
{
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;
  while (true) {
    if (client.connect(server, 80))
    {
      Serial.println("PHPclientConnected reqSent" + post);
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

// Function reading chars from PHP server echo untill given char in ActChar is readed.
// Function used for filter "garbage chars" if '<' pased in ActChar,
// or save the data echoed from PHP server if '>' passed.
// Return input.
String phpAns_ReadingSeq(char ActChar, String input) {
  char c;
  c = client.read();
  while (c != ActChar) {
    if (ActChar == ReadEndSign) {
      input.concat(c);
    }
    c = client.read();
    delay(0);
  }
  return input;
}

// Function controling reading action from PHP server.
// Using phpAns_ReadingSeq() for reading chars,
// rise flag through WIFIorPHPfail if credential validation failed
// or readed answer is empty or not match to needed string "<OKEY>".
boolean phpAns()
{
  String input = "";
  char c;
  while (client.connected() || client.available())
  {
    input = phpAns_ReadingSeq(ReadStartSign, input);   // "Garbage chars" filter.
    input = phpAns_ReadingSeq(ReadEndSign, input);     // Reading data
    delay(0);

  }
  client.stop();
  if (input.length() > 0)
  {
    boolean PHP_Ans = (input.indexOf(ValidInput) >= indexOf_ValidInputPHP);
    WIFIorPHPfail[PHP_Fail] = !PHP_Ans;
    Serial.println("PHPanswer Readed");
    return PHP_Ans;
  }
  WIFIorPHPfail[PHP_Fail] = true;
  return false;
}

// Function connecting to wifi using credential given in cred parameter.
// Rising flag via WIFIorPHPfail array if connection failed or WaitingInterval time passed.
boolean wifiConnect(userData cred)
{
  WiFi.mode(WIFI_STA);
  WiFi.begin(cred[wifiSSID], cred[ssidPASS]);
  Serial.println(cred[wifiSSID]); Serial.println(cred[ssidPASS]);
  unsigned long currentMillis = millis();
  unsigned long previousMillis = currentMillis;

  while (WiFi.status() != WL_CONNECTED) {
    if (currentMillis - previousMillis > WaitingInterval) {
      break;
    }
    currentMillis = millis();
    delay(100);
  }
  boolean ConnectionStatus =  (WiFi.status() == WL_CONNECTED);
  Serial.println(ConnectionStatus);
  WIFIorPHPfail[WIFI_Fail] = !ConnectionStatus;
  return ConnectionStatus;
}
//================= WIFI and PHP server handler ends =================//
//----------------------------- FUNCTIONS END----------------------------//
