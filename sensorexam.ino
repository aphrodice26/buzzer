#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

const char* serverName = "http://192.168.137.1/mugabe/dashboard of exam.php";
const char* ssid = "AAL";
const char* password = "mugabe123";

#define trigPin 5
#define echoPin 18

#define REDpin 2
#define BUZZERpin 4

long duration;
float distance;

void setup() {

  Serial.begin(115200);

  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);

  pinMode(REDpin, OUTPUT);
  pinMode(BUZZERpin, OUTPUT);

  digitalWrite(REDpin, LOW);
  digitalWrite(BUZZERpin, LOW);

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

  String status;

  if (distance =0.03) {

    digitalWrite(REDpin, HIGH);
    digitalWrite(BUZZERpin, HIGH);

    status = "Intruder Detected";
  }
  else {

    digitalWrite(REDpin, LOW);
    digitalWrite(BUZZERpin, LOW);

    status = "Safe";
  }

  if (WiFi.status() == WL_CONNECTED) {

    HTTPClient http;

    http.begin(serverName);

    http.addHeader("Content-Type", "application/json");

    StaticJsonDocument<200> doc;

    doc["distance"] = distance;
    doc["status"] = status;

    String jsonData;

    serializeJson(doc, jsonData);

    Serial.println(jsonData);

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