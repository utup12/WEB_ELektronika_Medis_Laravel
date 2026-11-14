#!/usr/bin/env python3
"""Export public Laravel pages into project-relative static GitHub Pages paths."""
from pathlib import Path
import re
import shutil
import subprocess
import urllib.error
import urllib.request

BASE = "http://127.0.0.1:8000"
OUT = Path("dist")
ROUTES = [
    "", "materi", "jobsheet", "praktikum", "panduan-praktikum",
    "evaluasi", "laporan", "monitor-trainer", "asisten-ai",
    "profil-dosen", "profil-mahasiswa", "tentang", "pilot/heart-rate",
]
# These endpoints require Laravel backend or authenticated sessions; avoid implying
# they work in a static snapshot.
UNSUPPORTED = {"asisten-ai/chat", "dashboard", "login", "register", "settings"}

def convert(html: str, depth: int) -> str:
    prefix = "../" * depth
    # Laravel emits absolute root paths; GitHub project Pages lives under /REPO/.
    html = re.sub(
        r'(?P<attr>\b(?:href|src|action)\s*=\s*["\'])/(?P<path>[^"\']*)',
        lambda m: m.group("attr") + prefix + m.group("path"),
        html,
        flags=re.IGNORECASE,
    )
    # Convert internal route URLs into directory-style static paths.
    # External URLs, anchors, and data URIs are not changed.
    for route in sorted(ROUTES[1:], key=len, reverse=True):
        html = re.sub(
            r'(?P<attr>\b(?:href|action)\s*=\s*["\'])'
            + re.escape(prefix + route)
            + r'(?P<end>["\'?#])',
            lambda m: m.group("attr") + prefix + route + "/" + m.group("end"),
            html,
        )
    return html

def main():
    OUT.mkdir(exist_ok=True)
    for folder in ("css", "js", "assets"):
        shutil.copytree(Path("public") / folder, OUT / folder, dirs_exist_ok=True)
    for name in ("favicon.ico", "favicon.svg", "robots.txt", "apple-touch-icon.png"):
        source = Path("public") / name
        if source.exists():
            shutil.copy2(source, OUT / name)
    (OUT / ".nojekyll").write_text("", encoding="utf-8")
    for route in ROUTES:
        target = OUT / route / "index.html" if route else OUT / "index.html"
        target.parent.mkdir(parents=True, exist_ok=True)
        url = BASE + "/" + route
        try:
            with urllib.request.urlopen(url, timeout=20) as response:
                html = response.read().decode("utf-8")
        except (urllib.error.URLError, UnicodeError) as error:
            raise RuntimeError(f"Could not export {url}: {error}") from error
        if "<html" not in html.lower():
            raise RuntimeError(f"Expected HTML for {route or '/'}")
        target.write_text(convert(html, len(Path(route).parts) if route else 0), encoding="utf-8")
        print("Exported", route or "/")
    # Override Laravel candidate page with standalone JS simulation for Pages.
    source = Path("pilot-heart-rate/index.html")
    (OUT / "pilot/heart-rate/index.html").write_text(
        source.read_text(encoding="utf-8").replace('href="../"', 'href="../../"'),
        encoding="utf-8",
    )
    # Legacy static pilot path remains usable.
    legacy = OUT / "pilot-heart-rate" / "index.html"
    legacy.parent.mkdir(parents=True, exist_ok=True)
    shutil.copy2(source, legacy)
    print("Static PPG pilot copied")

if __name__ == "__main__":
    main()
