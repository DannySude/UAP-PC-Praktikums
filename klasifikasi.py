import cv2
import numpy as np
import joblib
import sys
from PIL import Image
from skimage.feature import graycomatrix, graycoprops

# Model, Scaler, dan Label Encoder
model = joblib.load("model_knn.pkl")
scaler = joblib.load("scaler.pkl")
le = joblib.load("label_encoder.pkl")

# Fungsi Ekstraksi Fitur GLCM + Warna 
def extract_features(image_path):
    img_color = Image.open(image_path).convert('RGB')
    img_color = img_color.resize((128, 128))  
    img_np = np.array(img_color)

    # Mean warna RGB
    mean_r = np.mean(img_np[:, :, 0])
    mean_g = np.mean(img_np[:, :, 1])
    mean_b = np.mean(img_np[:, :, 2])

    # GLCM dari grayscale
    img_gray = cv2.cvtColor(img_np, cv2.COLOR_RGB2GRAY)
    glcm = graycomatrix(img_gray, distances=[1], angles=[0], levels=256, symmetric=True, normed=True)
    fitur_glcm = [
        graycoprops(glcm, 'contrast')[0, 0],
        graycoprops(glcm, 'dissimilarity')[0, 0],
        graycoprops(glcm, 'homogeneity')[0, 0],
        graycoprops(glcm, 'energy')[0, 0],
        graycoprops(glcm, 'correlation')[0, 0],
        graycoprops(glcm, 'ASM')[0, 0]
    ]

    return fitur_glcm + [mean_r, mean_g, mean_b]


image_path = sys.argv[1]

try:
    fitur = extract_features(image_path)
    fitur_scaled = scaler.transform([fitur])
    prediksi = model.predict(fitur_scaled)
    hasil = le.inverse_transform(prediksi)[0]

    # Cetak hasil klasifikasi + fitur ke PHP 
    print(f"{hasil}|{fitur[0]}|{fitur[1]}|{fitur[2]}|{fitur[3]}|{fitur[4]}|{fitur[5]}|{fitur[6]}|{fitur[7]}|{fitur[8]}")

except Exception as e:
    print(f"Error: {str(e)}")
