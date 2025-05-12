import serial
import mysql.connector
import time

# === Configuration ===
PORT_SERIE = "COM6"
VITESSE = 9600

DB_HOST = "localhost"
DB_USER = "root"
DB_PASSWORD = "root"
DB_NAME = "compte_personnes"
ID_SALLE = 1
PORT_MYSQL = 8889  # Si tu es sur MAMP

# === Connexion série ===
try:
    arduino = serial.Serial(PORT_SERIE, VITESSE, timeout=1)
    print("✅ Port série ouvert :", PORT_SERIE)
except Exception as e:
    print("❌ Erreur Arduino :", e)
    arduino = None

# === Connexion base de données ===
try:
    db = mysql.connector.connect(
        host=DB_HOST,
        user=DB_USER,
        password=DB_PASSWORD,
        database=DB_NAME,
        port=PORT_MYSQL
    )
    cursor = db.cursor()
    print("✅ Connexion MySQL réussie")
except Exception as e:
    print("❌ Erreur MySQL :", e)
    cursor = None

# === Fonction d'insertion ===
def enregistrer_mouvement(nb_entree, nb_sortie):
    try:
        cursor.execute(
            "INSERT INTO personnes (nb_entrée, nb_sortie, salle_id) VALUES (%s, %s, %s)",
            (nb_entree, nb_sortie, ID_SALLE)
        )
        db.commit()
        print("✅ Insertion en BDD :", nb_entree, "entrée(s),", nb_sortie, "sortie(s)")
    except Exception as e:
        print("❌ Erreur d'insertion :", e)

# === Boucle principale ===
while arduino and cursor:
    try:
        ligne = arduino.readline().decode('utf-8').strip()
        if not ligne:
            continue
        if "ENTREE" in ligne:
            print("📥 Une personne est entrée")
            enregistrer_mouvement(1,0)

        elif "SORTIE" in ligne:
            print("📦 Personne est sortie")
            enregistrer_mouvement(0, 1)

        time.sleep(0.2)

    except Exception as e:
        print("❌ Erreur pendant la lecture :", e)
        time.sleep(1)