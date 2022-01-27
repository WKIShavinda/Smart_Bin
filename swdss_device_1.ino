const int trigPin = 5;
const int echoPin = 18;
const int ledPin = 5;

//define sound speed in cm/uS
#define SOUND_SPEED 0.034
#define CM_TO_INCH 0.393701
#define bin_depth 100

long duration;
float distanceCm;
float distanceInch;
float bin_percentage;

void setup() {
  Serial.begin(115200); // Starts the serial communication
  pinMode(trigPin, OUTPUT); // Sets the trigPin as an Output
  pinMode(echoPin, INPUT); // Sets the echoPin as an Input
  pinMode (ledPin, OUTPUT);
}

void loop() {
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
  
  // Convert to inches
  distanceInch = distanceCm * CM_TO_INCH;
  
  // Prints the distance in the Serial Monitor
  Serial.print("Distance to garbage (cm): ");
  Serial.println(distanceCm);
  //Serial.print("Distance (inch): ");
  //Serial.println(distanceInch);

  bin_percentage = ((bin_depth-distanceCm) / bin_depth) * 100;

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
