#!/bin/bash

# Vérification des dépendances
if ! command -v python3 &>/dev/null; then
    echo "Python3 n'est pas installé. Veuillez l'installer pour continuer."
    exit 1
fi

if ! command -v php &>/dev/null; then
    echo "PHP n'est pas installé. Veuillez l'installer pour activer le support PHP."
    exit 1
fi

# Variables
CONFIG_FILE="server.conf"

# Création d'un fichier de configuration par défaut s'il n'existe pas
if [ ! -f "$CONFIG_FILE" ]; then
    echo "Création du fichier de configuration par défaut : $CONFIG_FILE"
    cat <<EOL >"$CONFIG_FILE"
[server]
web_root = www
port = 4000
enable_php = True
EOL
fi

# Lancement du serveur avec Tkinter
python3 - <<'EOF'
import subprocess
import os
import configparser
from http.server import BaseHTTPRequestHandler, HTTPServer
from socketserver import ThreadingMixIn
from tkinter import Tk, Label, Button, Checkbutton, IntVar, StringVar, Entry
from datetime import datetime
import threading

# Charger la configuration
CONFIG_FILE = "server.conf"
config = configparser.ConfigParser()
config.read(CONFIG_FILE)

WEB_ROOT = config.get('server', 'web_root')
PORT = config.getint('server', 'port')
ENABLE_PHP = config.getboolean('server', 'enable_php')

# Fonction pour générer les en-têtes HTTP dynamiques
def generate_headers():
    # Date actuelle au format HTTP
    date_now = datetime.utcnow().strftime('%a, %d %b %Y %H:%M:%S GMT')
    last_modified = datetime.utcnow().strftime('%a, %d %b %Y %H:%M:%S GMT')  # Exemple pour last-modified
    etag = '"123456789abc"'  # Exemple d'ETag statique, peut être dynamique en fonction du fichier
    content_length = 348  # A remplacer par la taille réelle du contenu, dynamique selon la réponse

    headers = f"""
    HTTP/1.1 200 OK
    Date: {date_now}
    Connection: keep-alive
    Cache-Control: no-cache, no-store, must-revalidate
    Content-Type: text/html; charset=UTF-8
    Content-Length: {content_length}
    Content-Encoding: gzip
    Content-Language: en-US
    Last-Modified: {last_modified}
    ETag: {etag}
    Strict-Transport-Security: max-age=31536000; includeSubDomains
    Content-Security-Policy: default-src 'self'
    X-Content-Type-Options: nosniff
    X-Frame-Options: SAMEORIGIN
    Server: Apache/2.4.54 (Unix)
    """
    return headers

# Gestionnaire de requêtes
class SimpleHTTPRequestHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        """Gère les requêtes GET"""
        file_path = os.path.join(WEB_ROOT, self.path.lstrip('/'))

        # Affichage des entêtes HTTP dynamiques dans le terminal avant de répondre
        headers = generate_headers()
        print(headers)

        if os.path.isdir(file_path):
            index_html = os.path.join(file_path, 'index.html')
            index_php = os.path.join(file_path, 'index.php')
            if os.path.isfile(index_html):
                self._serve_file(index_html)
            elif os.path.isfile(index_php) and ENABLE_PHP:
                self._serve_php(index_php)
            else:
                self._list_directory(file_path)
        elif os.path.isfile(file_path):
            if file_path.endswith('.php') and ENABLE_PHP:
                self._serve_php(file_path)
            else:
                self._serve_file(file_path)
        else:
            self.send_error(404, "Fichier ou répertoire non trouvé")

    def _serve_file(self, file_path):
        """Servir un fichier HTML"""
        with open(file_path, 'rb') as file:
            content = file.read()
            self.send_response(200)
            self.send_header('Content-Type', 'text/html; charset=UTF-8')
            self.send_header('Content-Length', str(len(content)))
            self.end_headers()
            self.wfile.write(content)

    def _serve_php(self, php_file_path):
        """Exécuter un fichier PHP ou l'afficher en texte brut si PHP est désactivé"""
        if ENABLE_PHP:
            try:
                # Exécuter le fichier PHP
                result = subprocess.run(['php', php_file_path], capture_output=True, text=True)
                self.send_response(200)
                self.send_header('Content-Type', 'text/html; charset=UTF-8')
                self.send_header('Content-Length', str(len(result.stdout)))
                self.end_headers()
                self.wfile.write(result.stdout.encode('utf-8'))
            except Exception as e:
                self.send_error(500, f"Erreur lors de l'exécution du fichier PHP : {e}")
        else:
            # Si PHP est désactivé, afficher le fichier PHP en texte brut avec ses balises
            with open(php_file_path, 'r') as file:
                content = file.read()
                self.send_response(200)
                self.send_header('Content-Type', 'text/plain; charset=UTF-8')
                self.send_header('Content-Length', str(len(content)))
                self.end_headers()
                self.wfile.write(content.encode('utf-8'))

    def _list_directory(self, directory_path):
        """Lister le contenu du répertoire"""
        self.send_response(200)
        self.send_header('Content-Type', 'text/html; charset=UTF-8')
        self.end_headers()
        html_content = f"<html><body><h1>Liste des fichiers pour {self.path}</h1><ul>"
        for item in os.listdir(directory_path):
            item_path = os.path.join(directory_path, item)
            if os.path.isdir(item_path):
                html_content += f'<li><a href="{self.path.rstrip("/")}/{item}/">{item}/</a></li>'
            else:
                html_content += f'<li><a href="{self.path.rstrip("/")}/{item}">{item}</a></li>'
        html_content += "</ul></body></html>"
        self.wfile.write(html_content.encode('utf-8'))

# Classe serveur multithreadée
class ThreadingHTTPServer(ThreadingMixIn, HTTPServer):
    """ Serveur HTTP multithreadé """
    pass

# Fonction de démarrage du serveur
def start_server():
    server_address = ('', PORT)
    httpd = ThreadingHTTPServer(server_address, SimpleHTTPRequestHandler)
    print(f"Serveur démarré sur le port {PORT} avec Web Root {WEB_ROOT}, PHP activé: {ENABLE_PHP}")
    httpd.serve_forever()

# Fonction de redémarrage du serveur
def restart_server():
    os._exit(0)  # Quitte le processus Python actuel
    start_server()  # Redémarre le serveur dans un nouveau processus

# Interface Tkinter
def update_config():
    config['server']['web_root'] = web_root.get()
    config['server']['port'] = str(port.get())
    config['server']['enable_php'] = 'True' if enable_php.get() else 'False'
    with open(CONFIG_FILE, 'w') as configfile:
        config.write(configfile)
    print("Configuration mise à jour.")

def start_server_gui():
    update_config()
    threading.Thread(target=start_server).start()

def stop_server():
    print("Arrêt du serveur.")
    # Cette fonction peut être utilisée pour arrêter le serveur proprement
    os._exit(0)

def modify_configuration():
    print("Modification de la configuration et redémarrage du serveur.")
    update_config()
    root.quit()  # Ferme la fenêtre Tkinter
    start_server_gui()  # Redémarre le serveur

root = Tk()
root.title("Serveur HTTP")

Label(root, text="Répertoire Web Root:").grid(row=0, column=0)
web_root = StringVar(value=WEB_ROOT)
Entry(root, textvariable=web_root, width=40).grid(row=0, column=1)

Label(root, text="Port:").grid(row=1, column=0)
port = IntVar(value=PORT)
Entry(root, textvariable=port, width=10).grid(row=1, column=1)

enable_php = IntVar(value=1 if ENABLE_PHP else 0)
Checkbutton(root, text="Activer PHP", variable=enable_php).grid(row=2, column=1)

Button(root, text="Démarrer le Serveur", command=start_server_gui).grid(row=3, column=0, columnspan=2)
Button(root, text="Modifier et quitter pour appliquer", command=modify_configuration).grid(row=4, column=0, columnspan=2)

root.mainloop()
EOF
