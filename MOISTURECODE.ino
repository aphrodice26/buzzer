#include <WiFi.h>
#include <Wire.h>
#include <I2CSoilMoistureSensor.h>

#define RED_LED 2
#define BLUE_LED 4

I2CSoilMoistureSensor sensor;

char ssid[] = "AAL";
char pass[] = "mugabe123";

WiFiClient client;

void connectWiFi();
void sendData(int moisture);

void setup() {

  Wire.begin();

  Serial.begin(115200);

  pinMode(RED_LED, OUTPUT);
  pinMode(BLUE_LED, OUTPUT);

  sensor.begin();

  delay(1000);

  connectWiFi();

  Serial.println("Soil Moisture Project Ready");
}

void loop() {

  while (sensor.isBusy()) {
    delay(50);
  }

  int moisture = sensor.getCapacitance();

  Serial.print("Moisture: ");
  Serial.println(moisture);

  // Soil Dry
  if (moisture < 400) {

    digitalWrite(RED_LED, HIGH);
    digitalWrite(BLUE_LED, LOW);

    Serial.println("Soil is Dry");

  }

  // Soil Wet
  else {

    digitalWrite(RED_LED, LOW);
    digitalWrite(BLUE_LED, HIGH);

    Serial.println("Soil is Wet");
  }

  sendData(moisture);

  sensor.sleep();

  delay(5000);
}

void connectWiFi() {

  WiFi.begin(ssid, pass);

  while (WiFi.status() != WL_CONNECTED) {

    delay(1000);

    Serial.println("Connecting...");
  }

  Serial.println("WiFi Connected");
}

void sendData(int moisture) {

  if (client.connect("192.168.137.1", 80)) {

    client.print("GET /soil/insert.php?moisture=");
    client.print(moisture);
    client.println(" HTTP/1.1");

    client.println("Host: 192.168.137.1");
    client.println("Connection: close");
    client.println();

    client.stop();

    Serial.println("Data Sent");
  }
}
