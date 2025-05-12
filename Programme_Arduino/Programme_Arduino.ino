#include "grove_two_rgb_led_matrix.h"
#include <HCSR04.h>

HCSR04 hc1(3, 2); // Capteur 1 (trig, echo)
HCSR04 hc2(5, 4); // Capteur 2 (trig, echo)

GroveTwoRGBLedMatrixClass matrix1(GROVE_TWO_RGB_LED_MATRIX_DEF_I2C_ADDR, 1);
GroveTwoRGBLedMatrixClass matrix2(GROVE_TWO_RGB_LED_MATRIX_DEF_I2C_ADDR + 1, 1);

int compteur = 0;
bool hc1_detect = false;
bool hc2_detect = false;
bool passage_fini = false;  // Indique qu'une personne vient de passer

unsigned long dernier_temps = 0;
const int delai_reset = 1000; //500ms pour éviter un double comptage

void setup() {
    Wire.begin();
    Serial.begin(9600);

    uint16_t VID1 = matrix1.getDeviceVID();
    uint16_t VID2 = matrix2.getDeviceVID();
    
    if (VID1 != 0x2886) {
        Serial.println("Can not detect led matrix 1 !!!");
    }
    delay(1000);
    
    if (VID2 != 0x2886) {
        Serial.println("Can not detect led matrix 2 !!!");
    }
    delay(1000);
    
    Serial.println("Matrix init success!!!");

}

void loop() {
    unsigned long temps_actuel = millis();
    
    // Lire une seule fois les distances
    int dist1 = hc1.dist();
    int dist2 = hc2.dist();

    Serial.print("Capteur 1: "); Serial.print(dist1); Serial.print(" cm - ");
    Serial.print("Capteur 2: "); Serial.print(dist2); Serial.print(" cm - ");
    Serial.print("Compteur: "); Serial.print(compteur); Serial.print(" | ");
    Serial.print("hc1_detect: "); Serial.print(hc1_detect); Serial.print(" - ");
    Serial.print("hc2_detect: "); Serial.print(hc2_detect); Serial.print(" - ");
    Serial.print("Passage en cours : "); Serial.println(passage_fini);

    // Affichage du compteur sur les matrices LED
    matrix1.displayNumber(compteur / 10, 3000, true, 0xbdbed8);
    matrix2.displayNumber(compteur % 10, 3000, true, 0xbdbed8);

    if (!passage_fini) {
        // Détection initiale par un capteur
        if (dist1 <= 50 && !hc1_detect && !hc2_detect) {
            hc1_detect = true;
        }

        if (dist2 <= 50 && !hc2_detect && !hc1_detect) {
            hc2_detect = true;
        }

        // Validation du passage (dans le bon ordre)
        if (hc1_detect && dist2 <= 50) {
            compteur++;  // Personne entrée
            passage_fini = true;
            dernier_temps = temps_actuel;
            Serial.println("Personne entrée, compteur augmenté !");
            Serial.println("ENTREE");
        } 

        if (hc2_detect && dist1 <= 50) {
            if (compteur > 0) compteur--;  // Personne sortie
            passage_fini = true;
            dernier_temps = temps_actuel;
            Serial.println("Personne sortie, compteur diminué !");
            Serial.println("SORTIE");
        }
    }

    // Réinitialisation après un passage
    if (temps_actuel - dernier_temps > delai_reset) {
        passage_fini = false;
        hc1_detect = false;
        hc2_detect = false;
        dernier_temps = temps_actuel;
        Serial.println("Passage terminé, réinitialisation.");
    }

    delay(50); // Petite pause pour éviter une surcharge
}
