#!/usr/bin/env python3
import os, re, sys

ROOT = "/home/xinreal/egar"
SKIP_DIRS = {".git", "node_modules", "storage", "test/upload", "cache"}
pattern = re.compile(r'(\$[A-Za-z_]\w*(?:->[A-Za-z_]\w*)*)\{([^{}]*)\}')

changed_files = 0
total_repl = 0
for dirpath, dirnames, filenames in os.walk(ROOT):
    dirnames[:] = [d for d in dirnames if d not in SKIP_DIRS and not d.startswith(".")]
    for fn in filenames:
        if not fn.endswith(".php"):
            continue
        path = os.path.join(dirpath, fn)
        try:
            with open(path, "r", encoding="utf-8", errors="replace") as f:
                src = f.read()
        except OSError:
            continue
        new_src, n = pattern.subn(r'\1[\2]', src)
        if n:
            with open(path, "w", encoding="utf-8", errors="replace") as f:
                f.write(new_src)
            changed_files += 1
            total_repl += n

print(f"Files changed: {changed_files}")
print(f"Total replacements: {total_repl}")