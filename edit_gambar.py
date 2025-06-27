import sys
from PIL import Image
import os

file_path = sys.argv[1]
rotasi = int(sys.argv[2])
lebar = int(sys.argv[3])
tinggi = int(sys.argv[4])

try:
    img = Image.open(file_path)
    img = img.rotate(-rotasi, expand=True)
    img = img.resize((lebar, tinggi))

    filename = os.path.basename(file_path)
    output_path = f"uploads/edited_{filename}"
    img.save(output_path)

    print(output_path)
except Exception as e:
    print("Error:", str(e))
