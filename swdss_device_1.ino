#include <Arduino.h>
#include <WiFi.h>
#include <Firebase_ESP_Client.h>
#include <Wire.h>
//#include <Adafruit_Sensor.h>
#include "time.h"

#include "addons/TokenHelper.h" // Provide the token generation process info
#include "addons/RTDBHelper.h"  // Provide the RTDB payload printing info and other helper functions

//WiFi
#define WIFI_SSID "Farmaan A10s"
#define WIFI_PASSWORD "ptgp4252"

#define API_KEY "AIzaSyB_6d2BsdiS_fJjrjUJGDknp_T67wIHzsc"

//Authorized Email and Corresponding Password
#define USER_EMAIL "croods.ssdnnf@gmail.com"
#define USER_PASSWORD "ssdnnf_01"

//RTDB URLefine the RTDB URL
#define DATABASE_URL "https://swdss-e57ff-default-rtdb.asia-southeast1.firebasedatabase.app/"

// Defining Firebase objects
FirebaseData fbdo;
FirebaseAuth auth;
FirebaseConfig config;

// Variable to save USER UID
String uid;

// Database main path (to be updated in setup with the user UID)
String databasePath;
// Database child nodes
String distPath = "/level";
String percPath = "/percentage";
String timePath = "/timestamp";
String levelDate = "/date";
String levelTime = "/time";

// Parent Node (to be updated in every loop)
String parentPath;

int timestamp;
FirebaseJson json;

const char* ntpServer = "pool.ntp.org";

//define sound speed in cm/uS
#define SOUND_SPEED 0.034
#define bin_depth 100

const int trigPin = 5;
const int echoPin = 18;
const int ledPin = 19;
const int buzzer = 5;

long duration;
float distanceCm;
float garbage_level_cm;
float bin_percentage;

// Timer variables (send new readings every 5 seconds)
unsigned long sendDataPrevMillis = 0;
unsigned long timerDelay = 5000;

void setup() {
  Serial.begin(115200); // Starts the serial communication
  Wifi_Init();
  pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
  pinMode(echoPin, INPUT); // Sets the echoPin as an Input
  pinMode(ledPin, OUTPUT);
  pinMode(buzzer, OUTPUT);

  Firebase_Init();
}

void Wifi_Init(){
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.print("Connecting to Wi-Fi");

  while (WiFi.status() != WL_CONNECTED)
  {
    Serial.print(".");
    delay(1000);
  }
  Serial.println();
  Serial.print("Connected with IP: ");
  Serial.println(WiFi.localIP());
  Serial.println();
}

void Firebase_Init(){
  configTime(0, 0, ntpServer);

  // Assign the api key (required)
  config.api_key = API_KEY;

  // Assign the user sign in credentials
  auth.user.email = USER_EMAIL;
  auth.user.password = USER_PASSWORD;

  // Assign the RTDB URL (required)
  config.database_url = DATABASE_URL;

  Firebase.reconnectWiFi(true);
  fbdo.setResponseSize(4096);

  // Assign the callback function for the long running token generation task */
  config.token_status_callback = tokenStatusCallback; //see addons/TokenHelper.h

  // Assign the maximum retry of token generation
  config.max_token_generation_retry = 5;

  // Initialize the library with the Firebase authen and config
  Firebase.begin(&config, &auth);

  // Getting the user UID might take a few seconds
  Serial.println("Getting User UID");
  while ((auth.token.uid) == "") {
    Serial.print('.');
    delay(1000);
  }
  // Print user UID
  uid = auth.token.uid.c_str();
  Serial.print("User UID: ");
  Serial.println(uid);

  // Update database path
  databasePath = "/UsersData/" + uid + "/readings";
}

void loop() {
  read_print_sensors();
}

void read_print_sensors(){
  garbage_level();
  DateTime();

  // Send new readings to database
  if (Firebase.ready() && (millis() - sendDataPrevMillis > timerDelay || sendDataPrevMillis == 0)){
    sendDataPrevMillis = millis();

    //Get current timestamp
    timestamp = getTime();
    Serial.print ("time: ");
    Serial.println (timestamp);

    parentPath= databasePath + "/" + String(timestamp);

    json.set(distPath.c_str(), String(garbage_level_cm));
    json.set(percPath.c_str(), String(bin_percentage));
    json.set(timePath, String(timestamp));
    json.set(levelDate, String(__DATE__));
    json.set(levelTime, String(__TIME__));
    Serial.printf("Set json... %s\n", Firebase.RTDB.setJSON(&fbdo, parentPath.c_str(), &json) ? "ok" : fbdo.errorReason().c_str());
  }
}

// Function that gets current epoch time
unsigned long getTime() {
  time_t now;
  struct tm timeinfo;
  if (!getLocalTime(&timeinfo)) {
    //Serial.println("Failed to obtain time");
    return(0);
  }
  time(&now);
  return now;
}

void garbage_level(){
  // Clears the trigPin
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);
  // Sets the trigPin on HIGH state for 10 micro seconds
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);
  
  // Reads the echoPin, returns the sound wave travel time in microseconds
  duration = pulseIn(echoPin, HIGH);
  
  // Calculate the distance
  distanceCm = duration * SOUND_SPEED/2;
  
  // Prints the distance in the Serial Monitor
  Serial.print("Distance to garbage (cm): ");
  Serial.println(distanceCm);

  garbage_level_cm = bin_depth - distanceCm;
  bin_percentage = ((garbage_level_cm) / bin_depth) * 100;

  Serial.print("Garbage fill percentage: ");
  Serial.println(bin_percentage);

  if (bin_percentage >= 85)
  {
    digitalWrite (ledPin, HIGH);
  }
  else
  {
    digitalWrite (ledPin, LOW);
  }
  
  delay(1000);
}

void buzzer_ring(){
  digitalWrite (buzzer, HIGH); //turn buzzer on
  delay(1000);
  digitalWrite (buzzer, LOW);  //turn buzzer off
  delay(1000);
}

void DateTime(){
  //#define currentDate = __DATE__;
  //#define currentTime = __TIME__;
}
