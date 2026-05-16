#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

// ===== Server =====
const char* serverName = "http://192.168.137.1/mugabe/connection.php";
const char* ssid = "AAL";
const char* password = "mugabe";

// ===== Sensor =====
#define trigPin 17
#define echoPin 16

// ===== LEDs =====
#define GREENpin 22
#define REDpin 21
#define BLUEpin 23

long duration;
float distance;

void setup() {

  Serial.begin(115200);

  // ===== Sensor Pins =====
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);

  // ===== LED Pins =====
  pinMode(GREENpin, OUTPUT);
  pinMode(REDpin, OUTPUT);
  pinMode(BLUEpin, OUTPUT);

  // ===== WiFi Connection =====
  WiFi.begin(ssid, password);

  Serial.print("Connecting to WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("\nConnected successfully!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
}

void loop() {

  // ===== Ultrasonic Sensor =====
  digitalWrite(trigPin, LOW);
  delayMicroseconds(2);

  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);

  digitalWrite(trigPin, LOW);

  duration = pulseIn(echoPin, HIGH);

  distance = duration * 0.034 / 2;

  Serial.print("Distance: ");
  Serial.print(distance);
  Serial.println(" cm");

  // ===== LED Control =====
  if (distance < 10) {

    digitalWrite(REDpin, HIGH);
    digitalWrite(BLUEpin, LOW);
    digitalWrite(GREENpin, LOW);

  }
  else if (distance <= 20) {

    digitalWrite(REDpin, LOW);
    digitalWrite(BLUEpin, HIGH);
    digitalWrite(GREENpin, LOW);

  }
  else {

    digitalWrite(REDpin, LOW);
    digitalWrite(BLUEpin, LOW);
    digitalWrite(GREENpin, HIGH);
  }

  // ===== Send Data to Server =====
  if (WiFi.status() == WL_CONNECTED) {

    HTTPClient http;

    http.begin(serverName);

    http.addHeader("Content-Type", "application/json");

    StaticJsonDocument<200> doc;

    doc["distance"] = distance;

    String jsonData;

    serializeJson(doc, jsonData);

    int httpResponseCode = http.POST(jsonData);

    Serial.print("HTTP Response Code: ");
    Serial.println(httpResponseCode);

    http.end();
  }
  else {

    Serial.println("WiFi disconnected");
  }

  delay(2000);
}
