import cv2
import numpy as np
import sys
from PIL import Image
from skimage.feature import graycomatrix, graycoprops
import imutils

def extract_features(gray_img):
    glcm = graycomatrix(gray_img, distances=[1], angles=[0], levels=256, symmetric=True, normed=True)
    contrast = graycoprops(glcm, 'contrast')[0, 0]
    dissimilarity = graycoprops(glcm, 'dissimilarity')[0, 0]
    homogeneity = graycoprops(glcm, 'homogeneity')[0, 0]
    energy = graycoprops(glcm, 'energy')[0, 0]
    correlation = graycoprops(glcm, 'correlation')[0, 0]
    asm = graycoprops(glcm, 'ASM')[0, 0]
    return [contrast, dissimilarity, homogeneity, energy, correlation, asm]

if len(sys.argv) < 5:
    print("Error: Parameter tidak lengkap")
    sys.exit(1)

image_path = sys.argv[1]
rotate_deg = float(sys.argv[2])
target_width = int(sys.argv[3])
target_height = int(sys.argv[4])
save_path = sys.argv[5]

img = Image.open(image_path).convert("RGB")
img_np = np.array(img)
gray = cv2.cvtColor(img_np, cv2.COLOR_RGB2GRAY)

# Rotasi
gray = imutils.rotate_bound(gray, rotate_deg)

# Scaling
gray = cv2.resize(gray, (target_width, target_height))

# Simpan hasil edit
cv2.imwrite(save_path, gray)

# Ekstraksi fitur
fitur = extract_features(gray)
print(f"{fitur[0]}|{fitur[1]}|{fitur[2]}|{fitur[3]}|{fitur[4]}|{fitur[5]}")
