import os
from PIL import Image

def trim_and_resize(img_path, output_size=(256, 256)):
    try:
        img = Image.open(img_path)
        img = img.convert("RGBA")
        
        # Get bounding box of non-transparent pixels
        bbox = img.getbbox()
        if bbox:
            # Crop to bounding box
            img_cropped = img.crop(bbox)
            
            # Create a new blank transparent image
            new_img = Image.new("RGBA", output_size, (255, 255, 255, 0))
            
            # Calculate ratio to fit inside output_size with a small padding (e.g., 10px)
            padding = 10
            target_w = output_size[0] - padding * 2
            target_h = output_size[1] - padding * 2
            
            ratio = min(target_w / img_cropped.width, target_h / img_cropped.height)
            new_size = (int(img_cropped.width * ratio), int(img_cropped.height * ratio))
            
            img_resized = img_cropped.resize(new_size, Image.Resampling.LANCZOS)
            
            # Paste into center
            paste_x = (output_size[0] - new_size[0]) // 2
            paste_y = (output_size[1] - new_size[1]) // 2
            new_img.paste(img_resized, (paste_x, paste_y), img_resized)
            
            new_img.save(img_path)
            print(f"Processed: {os.path.basename(img_path)}")
    except Exception as e:
        print(f"Error processing {img_path}: {e}")

icon_dir = r"c:\laragon\www\ZCal\public\images\icon"
for filename in os.listdir(icon_dir):
    if filename.endswith(".png"):
        trim_and_resize(os.path.join(icon_dir, filename))
        
print("All icons have been trimmed and normalized!")
