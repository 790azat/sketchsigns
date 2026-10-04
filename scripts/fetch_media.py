"""Download every catalog image listed in database/media-map.json into public/media,
scaled down to at most 1200px, keeping each file's storage path."""
import io
import json
import pathlib
import sys
import urllib.request

from PIL import Image

MAX_SIDE = 1200
root = pathlib.Path(__file__).resolve().parent.parent
items = json.loads((root / "database" / "media-map.json").read_text())
failed = 0

for item in items:
    target = root / "public" / "media" / item["path"]
    try:
        request = urllib.request.Request(item["source"], headers={"User-Agent": "Mozilla/5.0 (sketchsigns media sync)"})
        data = urllib.request.urlopen(request, timeout=60).read()
        image = Image.open(io.BytesIO(data))
        fmt = image.format
        if max(image.size) > MAX_SIDE:
            image.thumbnail((MAX_SIDE, MAX_SIDE), Image.LANCZOS)
        out = io.BytesIO()
        if fmt == "JPEG":
            image.convert("RGB").save(out, "JPEG", quality=80, optimize=True, progressive=True)
        elif fmt == "PNG":
            image.save(out, "PNG", optimize=True)
        elif fmt == "WEBP":
            image.save(out, "WEBP", quality=80)
        else:
            out = io.BytesIO(data)
        result = out.getvalue() if len(out.getvalue()) < len(data) else data
        target.parent.mkdir(parents=True, exist_ok=True)
        target.write_bytes(result)
        print(f"ok   {item['path']}  {len(data)//1024} KB -> {len(result)//1024} KB")
    except Exception as error:  # keep going; report at the end
        failed += 1
        print(f"FAIL {item['source']}: {error}", file=sys.stderr)

print(f"{len(items)} images, {failed} failed")
sys.exit(1 if failed else 0)
