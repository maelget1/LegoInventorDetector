import cv2
import numpy as np
import os
import sys
def extractRawFeatures(imagePath, imageSize=(128, 128)):
    # vérifie si le fichier existe
    if not os.path.exists(imagePath):
        print("image pas trouvee")
        sys.exit(1)

    # Récupère l'image
    image = cv2.imread(imagePath)
    if image is None:
        print("image non chargee")
        sys.exit(1)

    # passe BGR en RGB (OpenCV charge les images en BGR)
    imageRgb = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)

    # Redimensionne l'image comme pour l'impulse
    resizedImage = cv2.resize(imageRgb, imageSize, interpolation=cv2.INTER_LINEAR)

    # Convertir chaque pixel en hexa 
    rawFeatures = []
    for row in resizedImage:
        for pixel in row:
            r, g, b = pixel
            hexValue = f"0x{r:02X}{g:02X}{b:02X}"  # Convert to hex format
            rawFeatures.append(hexValue)
    return rawFeatures

if __name__ == "__main__":
    # récupère le chemin de l'image qui est passé en paramètre
    imagePath = sys.argv[1]

    # Appel ma fonction en donnant le chemin de l'image
    rawFeatures = extractRawFeatures(imagePath)

    # mets les résultats dans le bon format puis dans un fichier texte
    output = ",".join(rawFeatures)
    with open("raw.txt", 'w') as file:
        file.write(output)

    #Appel notre IA avec node.js
    print(os.system('node "C:\\dev\\run-impulse.js" raw.txt'))

    #Supprime l'image et le fichier texte
    os.remove(sys.argv[1])
    os.remove("raw.txt")