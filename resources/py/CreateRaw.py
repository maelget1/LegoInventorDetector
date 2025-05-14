import cv2
import numpy as np
import os
import sys
def extract_raw_features_hex(image_path, img_size=(128, 128)):
    # vérifie si le fichier existe
    if not os.path.exists(image_path):
        print("image pas trouvee")
        sys.exit(1)

    # Récupère l'image
    image = cv2.imread(image_path)
    if image is None:
        print("image non chargee")
        sys.exit(1)

    # passe BGR en RGB (OpenCV charge les images en BGR)
    image_rgb = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)

    # Redimensionne l'image comme pour l'impulse
    resized_image = cv2.resize(image_rgb, img_size, interpolation=cv2.INTER_LINEAR)

    # Convertir chaque pixel en hexa 
    raw_features_hex = []
    for row in resized_image:
        for pixel in row:
            r, g, b = pixel
            hex_value = f"0x{r:02X}{g:02X}{b:02X}"  # Convert to hex format
            raw_features_hex.append(hex_value)

    return raw_features_hex

if __name__ == "__main__":
    # récupère le chemin de l'image qui est passé en paramètre
    image_path = sys.argv[1]

    # Appel ma fonction en donnant le chemin de l'image
    raw_features_hex = extract_raw_features_hex(image_path)

    # mets les résultats dans le bon format puis dans un fichier texte
    output = ",".join(raw_features_hex)
    with open("raw.txt", 'w') as file:
        file.write(output)

    #Appel notre IA avec node.js
    print(os.system('node "C:\\dev\\run-impulse.js" raw.txt'))

    #Supprime l'image et le fichier texte
    os.remove(sys.argv[1])
    os.remove("raw.txt")