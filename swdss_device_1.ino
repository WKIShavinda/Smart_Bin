//WiFi
#define WIFI_SSID "Farmaan A10s"
#define WIFI_PASSWORD "ptgp4252"

//define sound speed in cm/uS
#define SOUND_SPEED 0.034
#define bin_depth 100

#include <WiFi.h>

const int trigPin = 5;
const int echoPin = 18;
const int ledPin = 5;
const int buzzer=5;

long duration;
float distanceCm;
float bin_percentage;

void setup() {
  Serial.begin(115200); // Starts the serial communication
  Wifi_Init();
  pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
  pinMode(echoPin, INPUT); // Sets the echoPin as an Input
  pinMode(ledPin, OUTPUT);
  pinMode(buzzer, OUTPUT);
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

void loop() {
  garbage_level();
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
  
  bin_percentage = ((bin_depth-distanceCm) / bin_depth) * 100;

  Serial.print("Garbage fill percentage: ");
  Serial.println(bin_percentage);

  if (bin_percentage >= 85)
  {
    digitalWrite (ledPin, HIGH);
    buzzer_ring();////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
