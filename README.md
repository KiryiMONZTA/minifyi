# Kiryi's MINIFYI
A simple CSS merger and minifier. The minifier is extremely basic without any huge logic.

## Installation
```bash
git clone git@github.com:KiryiMONZTA/minifyi.git
cd minifyi
composer update
```

## Usage
- Create your [configuration file](#configuration-file).
- Open a command line.
- Navigate to `{YOURMINIFYIINSTALLATION}/bin`.
- Execute:
```bash
php minify.php {CONFIGFILEPATH} {RESULTFILEPATH}
```

### Parameters
**CONFIGFILEPATH**  
Optional filepath to your [configuration file](#configuration-file). Default is `config.txt`.

**RESULTFILEPATH**  
Optional filepath to your resulting merged and minified CSS file. Must end with `.css`. Default is `style.min.css`.

## Configuratuin File
Create a simple text file `{NAME}.txt`. Then add each of your CSS file's full filepaths to it - one per line.
