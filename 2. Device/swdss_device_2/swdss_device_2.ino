#include "esp_camera.h"

#include <Arduino.h>
#include <WiFi.h>
#include <Wire.h>
#include "RTClib.h"
#include <Firebase_ESP_Client.h>
//#include <Adafruit_Sensor.h>
//#include "time.h"

#include "addons/TokenHelper.h" //Provide the token generation process info
#include "addons/RTDBHelper.h"  //Provide the RTDB payload printing info and other helper functions

const char* ntpServer = "pool.ntp.org";
const long  gmtOffset_sec = 19800;
const int   daylightOffset_sec = 0;
String datebuf;
String timebuf;

#define CAMERA_MODEL_AI_THINKER // Has PSRAM
#include "camera_pins.h"

//const char* ssid = "Weerasinghe fibre";
//const char* password = "PW2229619";
//const char* ssid = "Farmaan A10s";
//const char* password = "ptgp4252";
//const char* ssid = "SLT-4G-80C4";
//const char* password = "TA5GLQTF46T";
const char* ssid = "D03CDialog1-B1AA";
const char* password = "yllk12345";

#define API_KEY "AIzaSyB_6d2BsdiS_fJjrjUJGDknp_T67wIHzsc"

//Authorized Email and Password
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
String wasteDetect = "/detected";

// Parent Node (to be updated in every loop)
String parentPath;

int timestamp;
FirebaseJson json;

//define sound speed in cm/uS
#define SOUND_SPEED 0.034
#define bin_depth 100

const int trigPin = 13;
const int echoPin = 15;
const int ledPin = 33;  //LED BUILT_IN is GPIO 33 
const int buzzer = 14;
char value;
String detected = "False";

long duration;
float distanceCm;
float garbage_level_cm;
float bin_percentage;

// Timer variables (send new readings every 5 seconds)
unsigned long sendDataPrevMillis = 0;
unsigned long timerDelay = 5000;

void startCameraServer();

void setup() {
  Serial.begin(115200);
  Wifi_Init();
  Serial.setDebugOutput(true);
  Serial.println();

  pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
  pinMode(echoPin, INPUT); // Sets the echoPin as an Input
  pinMode(ledPin,  OUTPUT);
  pinMode(buzzer, OUTPUT);

  //digitalWrite(buzzer, LOW);

  Firebase_Init();

  configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
  printLocalTime();

  camera_config_t config;
  config.ledc_channel = LEDC_CHANNEL_0;
  config.ledc_timer = LEDC_TIMER_0;
  config.pin_d0 = Y2_GPIO_NUM;
  config.pin_d1 = Y3_GPIO_NUM;
  config.pin_d2 = Y4_GPIO_NUM;
  config.pin_d3 = Y5_GPIO_NUM;
  config.pin_d4 = Y6_GPIO_NUM;
  config.pin_d5 = Y7_GPIO_NUM;
  config.pin_d6 = Y8_GPIO_NUM;
  config.pin_d7 = Y9_GPIO_NUM;
  config.pin_xclk = XCLK_GPIO_NUM;
  config.pin_pclk = PCLK_GPIO_NUM;
  config.pin_vsync = VSYNC_GPIO_NUM;
  config.pin_href = HREF_GPIO_NUM;
  config.pin_sscb_sda = SIOD_GPIO_NUM;
  config.pin_sscb_scl = SIOC_GPIO_NUM;
  config.pin_pwdn = PWDN_GPIO_NUM;
  config.pin_reset = RESET_GPIO_NUM;
  config.xclk_freq_hz = 20000000;
  config.pixel_format = PIXFORMAT_JPEG;
  
  // if PSRAM IC present, init with UXGA resolution and higher JPEG quality
  //                      for larger pre-allocated frame buffer.
  if(psramFound()){
    config.frame_size = FRAMESIZE_UXGA;
    config.jpeg_quality = 10;
    config.fb_count = 2;
  } else {
    config.frame_size = FRAMESIZE_SVGA;
    config.jpeg_quality = 12;
    config.fb_count = 1;
  }

#if defined(CAMERA_MODEL_ESP_EYE)
  pinMode(13, INPUT_PULLUP);
  pinMode(14, INPUT_PULLUP);
#endif

  // camera init
  esp_err_t err = esp_camera_init(&config);
  if (err != ESP_OK) {
    Serial.printf("Camera init failed with error 0x%x", err);
    return;
  }

  sensor_t * s = esp_camera_sensor_get();
  // initial sensors are flipped vertically and colors are a bit saturated
  if (s->id.PID == OV3660_PID) {
    s->set_vflip(s, 1); // flip it back
    s->set_brightness(s, 1); // up the brightness just a bit
    s->set_saturation(s, -2); // lower the saturation
  }
  // drop down frame size for higher initial frame rate
  s->set_framesize(s, FRAMESIZE_QVGA);

#if defined(CAMERA_MODEL_M5STACK_WIDE) || defined(CAMERA_MODEL_M5STACK_ESP32CAM)
  s->set_vflip(s, 1);
  s->set_hmirror(s, 1);
#endif

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");

  startCameraServer();

  Serial.print("Camera Ready! Use 'http://");
  Serial.print(WiFi.localIP());
  Serial.println("' to connect");
}


void Wifi_Init(){
  WiFi.begin(ssid, password);
  Serial.println("Connecting to Wi-Fi");

  while (WiFi.status() != WL_CONNECTED)
  {
    Serial.print(".");
    delay(1000);
  }
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
  databasePath = "/UsersData/" + uid + "/readings" + "/Device2";
}

void loop() {
  read_print_sensors();
  //delay(10000);
}

void read_print_sensors(){
  garbage_level();
  waste_detect();
  printLocalTime();
  
  // Send new readings to database
  if (Firebase.ready() && (millis() - sendDataPrevMillis > timerDelay || sendDataPrevMillis == 0)){
    sendDataPrevMillis = millis();

   if(bin_percentage < 0)
    {
      bin_percentage = 0;
      garbage_level_cm = 0;
    }
    
    //Get current timestamp
    timestamp = getTime();
    Serial.print ("time: ");
    Serial.println (timestamp);
    Serial.print ("Garbage Level: ");
    Serial.println (bin_percentage);
    Serial.print ("Date: ");
    Serial.println (datebuf);
    Serial.print ("Time: ");
    Serial.println (timebuf);
    Serial.print ("Detected: ");
    Serial.println (detected);

    parentPath= databasePath + "/" + String(timestamp);

    json.set(distPath.c_str(), String(garbage_level_cm));
    json.set(percPath.c_str(), String(bin_percentage));
    json.set(timePath, String(timestamp));
    json.set(levelDate, String(datebuf));
    json.set(levelTime, String(timebuf));
    json.set(wasteDetect, String(detected));
    Serial.printf("Set json... %s\n", Firebase.RTDB.setJSON(&fbdo, parentPath.c_str(), &json) ? "ok" : fbdo.errorReason().c_str());
  
    Serial.println();
  }  
}

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
  //Serial.print("Distance to garbage (cm): ");
  //Serial.println(distanceCm);

  garbage_level_cm = bin_depth - distanceCm;
  bin_percentage = ((garbage_level_cm) / bin_depth) * 100;

  //Serial.print("Garbage fill percentage: ");
  //Serial.println(bin_percentage);
  printLocalTime();

  if (bin_percentage >= 85)
  {
    //Pin work with inverted logic
    //LOW to Turn on and HIGH to turn off
    digitalWrite (ledPin, LOW); //Turn on
  }
  else
  {
    digitalWrite (ledPin, HIGH);  //Turn off
  }
  
  delay(1000);
}

void printLocalTime() {
  time_t rawtime;
  struct tm timeinfo;
  if (!getLocalTime(&timeinfo))
  {
    Serial.println("Obtain time");
    return;
  }
  char level_date[50]; //50 chars should be enough
  char level_time[50];
  
  strftime(level_date, sizeof(level_date), "%d %m %Y", &timeinfo);
  strftime(level_time, sizeof(level_time), "%H:%M:%S", &timeinfo);
  
  datebuf = level_date;
  timebuf = level_time;

  //datebuf = "07.04.2022";
  //timebuf = "21:00";

  //Serial.println(datebuf);
  //Serial.println(timebuf);
}

void waste_detect(){
  //digitalWrite(buzzer, HIGH); 
  //while(Serial.available())
  if(Serial.available()>0)
  {
    value = Serial.read();
    Serial.println(value);
    if (value == '1'){
      digitalWrite(buzzer, HIGH);
      detected = "True";
    
    }
    else if (value == '0'){
      digitalWrite(buzzer, LOW);
      detected = "False";
    }
  }
}
