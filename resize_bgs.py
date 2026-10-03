import os
from PIL import Image, ImageOps

base_dir = r"c:\laragon\www\ZCal\public\images\assets"
targets = {
    "bg-hijau.png": (170, 75),
    "bg-pink.png": (170, 75),
    "bg-uang.png": (350, 75),
    "bg-daun.png": (350, 75),
}

for filename, size in targets.items():
    filepath = os.path.join(base_dir, filename)
    if os.path.exists(filepath):
        try:
            with Image.open(filepath) as img:
                # Crop and resize exactly to the target size without stretching
                resized_img = ImageOps.fit(img, size, method=Image.Resampling.LANCZOS)
                resized_img.save(filepath)
                print(f"Resized {filename} to {size}")
        except Exception as e:
            print(f"Error on {filename}: {e}")
    else:
        print(f"File not found: {filepath}")
