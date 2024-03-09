#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <Keypad_I2C.h>
#include <Keypad.h>
#include <WiFi.h>
#include <string.h>
#include <HTTPClient.h>

#define I2CADDR 0x20
#define WIFI_STA_NAME "Get"
#define WIFI_STA_PASS "4561237899"

const String URL = "https://HOST/server/arduino/post.php"; //My project host is: mwit-laundry.000webhostapp.com

const byte ROWS = 4;
const byte COLS = 4;

char keys[ROWS][COLS] = {
    {'D', 'C', 'B', 'A'},
    {'#', '9', '6', '3'},
    {'0', '8', '5', '2'},
    {'*', '7', '4', '1'}};

byte rowPins[ROWS] = {0, 1, 2, 3};
byte colPins[COLS] = {4, 5, 6, 7};

LiquidCrystal_I2C lcd(0x27, 20, 4);
Keypad_I2C keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS, I2CADDR, PCF8574);

void ConnectWifi();
bool Checknum(char key);
bool CheckKey(char key);

void setup()
{
    Serial.begin(115200);
    Wire.begin();

    pinMode(2, OUTPUT);
    pinMode(18, INPUT_PULLUP);
    pinMode(17, INPUT_PULLUP);
    lcd.init();

    lcd.setCursor(0, 0);
    keypad.begin(makeKeymap(keys));

    ConnectWifi();
}
void loop()
{

    char id[10] = "";

    if (WiFi.status() != WL_CONNECTED)
    {
        ConnectWifi();
    }

    while (digitalRead(18) == HIGH)
    {
        digitalWrite(2, HIGH);
    }
    digitalWrite(2, LOW);

    Serial.println("pressed black already");

    lcd.backlight();

    lcd.setCursor(0, 0);
    lcd.print("WELCOME");

    lcd.setCursor(0, 1);
    lcd.print("ENTER ID : ");

    lcd.setCursor(0, 3);
    lcd.print("C = clear, D = enter");

    Serial.println("ready to recieve id");

    lcd.setCursor(11, 1);

    lcd.blink();
    while (true)
    {

        char key = keypad.getKey();

        if (CheckKey(key))
        {
            if (key == 'C')
            {
                strcpy(id, "");

                lcd.setCursor(11, 1);
                lcd.print("          ");
                lcd.setCursor(11, 1);
            }
            else if (key == 'D' && strlen(id) == 5)
            {
                lcd.clear();

                lcd.setCursor(0, 0);
                lcd.print("PRESS BLUE TO START");

                lcd.setCursor(0, 2);
                lcd.print("ID is : ");
                lcd.print(id);

                lcd.noBlink();

                Serial.println("break");
                break;
            }
            else if (Checknum(key) && strlen(id) < 5)
            {
                lcd.print(key);
                Serial.println(key);

                strncat(id, &key, 1);

                Serial.print("ID = ");
                Serial.println(id);
            }
            else
            {
                strcpy(id, "");

                lcd.setCursor(11, 1);
                lcd.print("      ");
                lcd.setCursor(11, 1);
            }
        }
    }
    Serial.println("finish recive id");

    while (digitalRead(17) == HIGH)
    {
        digitalWrite(2, HIGH);
    }
    digitalWrite(2, LOW);
    Serial.println("pressed blue already");

    lcd.clear();
    lcd.setCursor(0, 1);
    lcd.print("START WASHING");
    Serial.println("finish");

    char postData[100] = "{\"machineID\":\"2\",\"stdID\":\"";
    strcat(postData, id);
    strcat(postData, "\"}");

    String Data = postData;

    HTTPClient http;
    // WiFiClient client;
    http.begin(URL);

    int httpCode = http.POST(Data);
    String payload = http.getString();
    http.addHeader("Content-Type", "application/json"); /// x-www-form-urlencoded

    Serial.print("URL : ");
    Serial.println(URL);

    Serial.print("Data : ");
    Serial.println(Data);

    Serial.print("httpCode : ");
    Serial.println(httpCode);

    Serial.print("payload : ");
    Serial.println(payload);
    Serial.println("----------------------------------");

    delay(500);
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print(payload);

    lcd.setCursor(0, 3);
    lcd.print("httpcode : ");
    lcd.print(httpCode);
    http.end();

    delay(3000);
    lcd.clear();
    lcd.setCursor(0, 1);
    lcd.print("THANK YOU");
    delay(3000);

    lcd.clear();
    lcd.noBacklight();
}

void ConnectWifi()
{
    Serial.print("Connecting to ");
    Serial.println(WIFI_STA_NAME);

    WiFi.mode(WIFI_STA);
    WiFi.begin(WIFI_STA_NAME, WIFI_STA_PASS);

    while (WiFi.status() != WL_CONNECTED)
    {
        delay(500);
        Serial.print(".");
    }

    Serial.println("");
    Serial.println("WiFi connected");
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
}

bool Checknum(char key)
{
    if (key - '0' >= 0 && key - '0' <= 9)
    {
        return true;
    }
    else
        return false;
}

bool CheckKey(char key)
{
    if (Checknum(key) || key == 'C' || key == 'D')
    {
        return true;
    }
    else
        return false;
}
