#!/bin/bash

# Chemin vers les fichiers Docker Compose
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
echo "DIR=$DIR"
MAIN_FILE="${DIR}/main/main.yml"
SERVICES_FILE="${DIR}/services/services.yml"


docker network create sae

# Arrêter et supprimer les services existants
echo "Arrêt et suppression des services existants (si existants)..."
docker compose -f "$MAIN_FILE" down
docker compose -f "$SERVICES_FILE" down

# Lancer les configurations Docker Compose
echo "Démarrage des services... "
docker compose -f "$MAIN_FILE" up -d --build

# Lancement de fichier de config du keycloak
echo "before script"
./main/Scripts/init-KeyC.sh
echo "after script"

docker compose -f "$SERVICES_FILE" up -d --build




echo "Les services ont été démarrés."