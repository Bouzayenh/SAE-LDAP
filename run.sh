#!/bin/bash

Green='\033[0;32m'  #Green
NC='\033[0m' #No Color


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

#Demander a l'utilisateur s'il souhaite utiliser toutes les volumes
read -p "Voulez-vous supprimer tous les volumes Docker ? (y/n) " answer
case $answer in
    [Yy]* ) 
        echo "Suppression des volumes Docker..."
        echo 
        docker volume rm $(docker volume ls -q)
        ;;
    
* ) 
      echo 
      echo "Suppression des volumes ignorée.";;
esac

# Lancer les configurations Docker Compose
echo -e "${Green}Démarrage des services... ${NC}"
echo 

./convert_env.sh ./services NEXTCLOUD
./convert_env.sh ./services MYSQL

docker compose -f "$MAIN_FILE" up -d --build

# Lancement de fichier de config du keycloak
sudo ./main/Scripts/init-KeyC.sh

docker compose -f "$SERVICES_FILE" up -d --build

rm *.txt
rm ./services/*.txt
rm ./main/*.txt

echo 
echo -e "${Green}Les services ont été démarrés${NC}"
