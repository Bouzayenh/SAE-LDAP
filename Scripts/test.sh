#!/bin/bash
# KeyC_Config.sh

get_json_name_and_id(){
  json=$@
  echo "json=$json"
  ID=$(echo $json | jq '.[]."id"')
  NAME=$(echo $json | jq '.[]."name"')
}

KEYCLOAK_HOST_PORT=${1:-"localhost:8082"}
REALM="http://$KEYCLOAK_HOST_PORT/admin/realms"



CLIENT_PHP="aabf31a4-b4d5-4ab4-add0-6672aa5f1560"
CLIENT_NC="d550b58d-16f4-4483-be73-e96b098ebeee"

echo "KEYCLOAK_HOST_PORT:$KEYCLOAK_HOST_PORT"
echo



echo "Getting admin access token"
echo "=========================="

ADMIN_TOKEN=$(curl -s -X POST "http://$KEYCLOAK_HOST_PORT/realms/master/protocol/openid-connect/token" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "username=admin" \
  -d 'password=admin' \
  -d 'grant_type=password' \
  -d 'client_id=admin-cli' | jq -r '.access_token')

echo "ADMIN_TOKEN=$ADMIN_TOKEN"
echo

echo "Creating Administrator Realm Role"
echo "================================"

sudo curl -s -X POST "$REALM/sae-services/roles"\
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"name":"Administrator"}'

NC_ROLES=$(curl -s "$REALM/sae-services/clients/$CLIENT_NC/roles/" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq '.' )

echo "NC_ROLES=$NC_ROLES"

PHP_ROLES=$(curl -s "$REALM/sae-services/clients/$CLIENT_PHP/roles/" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq '.' )
echo "PHP_ROLES=$PHP_ROLES"

ADMINISTRATOR=$(curl -s "$REALM/sae-services/roles/" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq '.[] | select(."name" == "Administrator")' | jq '.id' )

echo "ADMIN=$ADMINISTRATOR"
echo 

get_json_name_and_id $PHP_ROLES
PHP_ID=$ID
PHP_NAME=$NAME

get_json_name_and_id $NC_ROLES
NC_ID=$ID
NC_NAME=$NAME

RESULT=$(curl -s -X POST "$REALM/sae-services/roles/roles-by-id/$ADMINISTRATOR/composites/" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d "[
    {'id':$PHP_ID, "name": $PHP_NAME},
    {'id':$NC_ID, "name": $NC_NAME}
  ]")

echo "RESULT=$RESULT"

RESULT=$(curl -X POST "$REALM/sae-services/roles/roles-by-id/$ADMINISTRATOR/composites" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d "[
    {"id":"5d8f5177-9afd-43b9-9e20-a1aa4f478c6f","name":"USERNextcloud"},
    {"id":"849dd3d9-14fd-482b-8445-e912ee451441","name":"php-service-role","description":""}
  ]")

echo "RESULT=$RESULT"

#http://localhost:8082/admin/realms/sae-services/roles-by-id/b289aed9-8f53-4f3b-9cb7-e7c0a5576cc5/composites

#[
#  {"id":"5d8f5177-9afd-43b9-9e20-a1aa4f478c6f","name":"USERNextcloud"},
#  {"id":"849dd3d9-14fd-482b-8445-e912ee451441","name":"php-service-role","description":""}
#]
