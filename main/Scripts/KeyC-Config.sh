#!/bin/bash
# KeyC_Config.sh

KEYCLOAK_HOST_PORT=${1:-"http://localhost:8080"}
echo
echo "KEYCLOAK_HOST_PORT= $KEYCLOAK_HOST_PORT"
echo

echo "Getting admin access token"
echo "=========================="

TOKEN_RESPONSE=$(curl -s -k -X POST "$KEYCLOAK_HOST_PORT/realms/master/protocol/openid-connect/token" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "username=admin" \
  -d 'password=admin' \
  -d 'grant_type=password' \
  -d 'client_id=admin-cli')

ADMIN_TOKEN=$(echo $TOKEN_RESPONSE | jq -r '.access_token')

echo "ADMIN_TOKEN=$ADMIN_TOKEN"
echo

echo "Creating realm"
echo "=============="

curl -k  -i -X POST "$KEYCLOAK_HOST_PORT/admin/realms" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"realm": "sae-services", "enabled": true}'

echo "Creating clients"
echo "==============="

CLIENT_NC=$(curl -k  -si -X POST "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"clientId": "nextcloud", "directAccessGrantsEnabled": true, "redirectUris": ["http://localhost:8082/*"]}' \
  | grep -oE '[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}')

echo "CLIENT_NC=$CLIENT_NC"
echo

CLIENT_PHP=$(curl -k  -si -X POST "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"clientId": "php-service", "directAccessGrantsEnabled": true, "redirectUris": ["https://localhost:8443/*","https://php.sae.localhost/*"], "publicClient": true}' \
  | grep -oE '[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}')


echo "CLIENT_PHP=$CLIENT_PHP"
echo

# Create Rocket.Chat client
CLIENT_chat=$(curl -k  -i -X POST "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"clientId": "rocket-chat", "directAccessGrantsEnabled": true, "redirectUris": ["http://localhost:3000/*"]}' \
  | grep -oE '[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}')
echo
echo "CLIENT_chat=$CLIENT_chat"

# Fetch and store the Rocket.Chat client secret

ROCKET_CHAT_CLIENT_SECRET=$(curl -k  -s -X POST "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_RC/client-secret" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq -r '.value')

echo "ROCKET_CHAT_CLIENT_SECRET=$ROCKET_CHAT_CLIENT_SECRET"
echo
export ROCKET_CHAT_CLIENT_SECRET

echo "Getting client secret"
echo "====================="

NEXT_CLOUD_CLIENT_SECRET=$(curl -k  -s -X POST "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_NC/client-secret" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq -r '.value')


echo "NEXT_CLOUD_CLIENT_SECRET=$NEXT_CLOUD_CLIENT_SECRET"
echo

PHP_SERVICE_CLIENT_SECRET=$(curl -k  -s -X POST "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_PHP/client-secret" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq -r '.value')


echo "PHP_SERVICE_CLIENT_SECRET=$PHP_SERVICE_CLIENT_SECRET"
echo 

echo "Creating client roles"
echo "===================="

curl -k  -i -X POST "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_NC/roles" \
-H "Authorization: Bearer $ADMIN_TOKEN" \
-H "Content-Type: application/json" \
-d '{"name": "USERNextcloud"}'

ROLE_ID=$(curl -k  -s "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_NC/roles" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq -r '.[0].id')


PHP_ROLE_ID=$(curl -i -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_PHP/roles" \
-H "Authorization: Bearer $ADMIN_TOKEN" \
-H "Content-Type: application/json" \
-d '{"name": "php-service-role"}')


echo "NEXCLOUD ROLE_ID=$ROLE_ID"
echo

echo "PHP ROLE_ID=$PHP_ROLE_ID"
echo

echo "Creating Client Mappings"
echo "========================"

curl -s -X POST "$REALM/sae-services/clients/$CLIENT_NC/protocol-mappers/models" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '
  {
    "name":"client roles",
    "protocol":"openid-connect",
    "protocolMapper":"oidc-usermodel-client-role-mapper",
    "consentRequired":false,
    "config":
      {
        "introspection.token.claim":"true",
        "multivalued":"true",
        "user.attribute":"foo",
        "access.token.claim":"true",
        "claim.name":"permission",
        "jsonType.label":"String"
      }
  }'

curl -s -X POST "$REALM/sae-services/clients/$CLIENT_PHP/protocol-mappers/models" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '
  {
    "name":"client roles",
    "protocol":"openid-connect",
    "protocolMapper":"oidc-usermodel-client-role-mapper",
    "consentRequired":false,
    "config":
      {
        "introspection.token.claim":"true",
        "multivalued":"true",
        "user.attribute":"foo",
        "access.token.claim":"true",
        "claim.name":"permission",
        "jsonType.label":"String"
      }
  }'



echo "Configuring LDAP"
echo "================"


LDAP_ID=$(curl -k  -si -X POST "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/components" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '@main/Scripts/ldap-config.json' \
  | grep -oE '[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}')


echo "LDAP_ID=$LDAP_ID"
echo


echo "Sync LDAP Users"
echo "==============="

curl -k  -i -X POST "$KEYCLOAK_HOST_PORT/admin/realms/sae-services/user-storage/$LDAP_ID/sync?action=triggerFullSync" \
  -H "Authorization: Bearer $ADMIN_TOKEN"

echo
echo "============="
