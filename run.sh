#!/bin/bash

Green='\033[0;32m'  #Green
NC='\033[0m' #No Color

source ./Scripts/convert_env.sh
source ./Scripts/secretToFile.sh
source ./Scripts/encrypt_keys_management.sh

createSecretsFiles(){

    echo -e "${Green} Exporting Docker Secrets ${NC}"
    # Docker Secrets Files for main 
    createSecretsFile ./main LDAP_ADMIN
    createSecretsFile ./main MYSQL
    exportSecret KEYCLOAK
    exportSecret MARIADB
    
    

    # Docker Secrets Files for service
    createSecretsFile ./services NEXTCLOUD
    createSecretsFile ./services MARIADB
    exportSecret MARIADB
    exportSecret ROCKET
    exportSecret LDAP_USER
    
    source .tmp
    rm .tmp

}
sourceTmp(){
    source .tmp
    sudo rm .tmp
}

#decryptEnv

#if [[ $? == 0 ]]; then echo -e "${Green} Le déchiffrement s'est effectué correctement ${NC}"; fi


# Chemin vers les fichiers Docker Compose
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
echo "DIR=$DIR"
MAIN_FILE="${DIR}/main/main.yml"
SERVICES_FILE="${DIR}/services/services.yml"

addSecretsJSON

read -p "Voulez vous réinitialiser l'arborescence LDAP ? (y/n) " ldap_restart
case $ldap_restart in
    [Yy]* )
        addSecretsLDIF
        rm -rf ./main/data
        ;;
* )
    echo "L'arborescence n'a pas été réinitialisée"
esac

createSecretsFiles

# Arrêter et supprimer les services existants
echo -e "${Green}Arrêt et suppression des services existants (si existants)...${NC}"

docker compose -f "$MAIN_FILE" down > /dev/null
docker compose -f "$SERVICES_FILE" down > /dev/null

docker network rm sae
docker network create sae

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
echo -e "${Green} Démarrage des services... ${NC}"
echo 

docker compose -f "$MAIN_FILE" up -d --build > /dev/null

# Lancement de fichier de config du keycloak
echo 

./main/Scripts/init-KeyC.sh

sourceTmp

docker compose -f "$SERVICES_FILE" up -d --build > /dev/null

hideSecretsJSON
hideSecretsLDIF
# hideEnv

echo -e "${Green}Installation des applications nextcloud ${NC}"

echo "NEXTCLOUD_SECRET=$NEXTCLOUD_CLIENT_SECRET"
sleep 3

docker-compose -f ./services/services.yml exec nextcloud apt-get update
docker-compose -f ./services/services.yml exec nextcloud apt-get install sudo
docker-compose -f ./services/services.yml exec nextcloud sudo -u www-data php occ app:install 'sociallogin'
docker-compose -f ./services/services.yml exec -e NEXTCLOUD_CLIENT_SECRET="$NEXTCLOUD_CLIENT_SECRET" nextcloud sudo -u www-data php occ config:app:set 'sociallogin' custom_providers --value='{"custom_oidc":[{"name": "NextCloud", "title": "nextcloud", "authorizeUrl": "http://localhost:8080/realms/sae-services/protocol/openid-connect/auth", "tokenUrl": "http://keycloak:8080/realms/sae-services/protocol/openid-connect/token", "clientId": "nextcloud", "clientSecret": "'$NEXTCLOUD_CLIENT_SECRET'", "scope": "openid", "button": "Keycloak", "defaultGroup": ""}]}'

# echo -e "${Green}Installation des application Rocket Chat ${NC}"

echo 
echo -e "${Green}Les services ont été démarrés${NC}"
echo 
echo -e "${Green}Gestion du fichier chiffré ${NC}"

# gpg-connect-agent reloadagent /bye
