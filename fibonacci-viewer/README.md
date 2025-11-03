# Fibonacci Viewer

Small Python project to view/work with Fibonacci numbers.

## Getting Started (recommended: using `pyproject.toml`)
This repo ships with a `pyproject.toml`. The easiest way to install is an editable install.

1) **Enter the folder**
```bash
cd fibonacci-viewer
```

2) **Create and activate a virtual environment**
```bash
python3 -m venv .venv
# macOS / Linux
source .venv/bin/activate
# Windows (PowerShell)
# .venv\Scripts\Activate.ps1
```

3) **Install dependencies**
- If you want to use the `pyproject.toml` (preferred):
```bash
pip install -e .
```
- Or, if you prefer a classic install with `requirements.txt`:
```bash
pip install -r requirements.txt
```

4) **Run the app**
```bash
python app.py
```
> If the project exposes a module entry point, you can also try:
```bash
python -m fibonacci_viewer
```

## Project Layout
```
src/
  fibonacci_viewer/   # package source
app.py                # script entry point
pyproject.toml        # metadata, dependencies (PEP 621)
requirements.txt      # alternative dependency list for pip
```

## Common Issues
- **`python` points to an older version**  
  Use `python3` everywhere or install Python 3.10+.

- **Virtual environment didn’t activate**  
  Ensure you ran `source .venv/bin/activate` (macOS/Linux) or `.venv\Scripts\Activate.ps1` (Windows PowerShell).

- **Module not found: `fibonacci_viewer`**  
  Make sure you installed with `pip install -e .` from the project root while the venv is active.

## Development Tips
- Freeze an explicit lockfile if you need deterministic installs:
```bash
pip freeze > requirements.txt
```
- Run formatter/linter/tests here if you add them.
