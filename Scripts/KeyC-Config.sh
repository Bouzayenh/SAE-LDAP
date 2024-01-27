#!/bin/bash
# KeyC_Config.sh

KEYCLOAK_HOST_PORT=${1:-"localhost:8082"}
echo
echo "KEYCLOAK_HOST_PORT: $KEYCLOAK_HOST_PORT"
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

echo "Creating realm"
echo "=============="

curl -i -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"realm": "sae-services", "enabled": true}'

echo "Creating clients"
echo "==============="

CLIENT_NC=$(curl -si -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"clientId": "nextcloud", "directAccessGrantsEnabled": true, "redirectUris": ["http://127.0.0.1:8080//*"]}' \
  | grep -oE '[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}')

echo "CLIENT_NC=$CLIENT_NC"
echo

CLIENT_PHP=$(curl -si -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"clientId": "php-service", "directAccessGrantsEnabled": true, "redirectUris": ["https://localhost:8443/*"], "publicClient": true}' \
  | grep -oE '[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}')


echo "CLIENT_PHP=$CLIENT_PHP"
echo

echo "Getting client secret"
echo "====================="

NEXT_CLOUD_CLIENT_SECRET=$(curl -s -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_NC/client-secret" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq -r '.value')


echo "NEXT_CLOUD_CLIENT_SECRET=$NEXT_CLOUD_CLIENT_SECRET"
echo


PHP_SERVICE_CLIENT_SECRET=$(curl -s -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_PHP/client-secret" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq -r '.value')


echo "PHP_SERVICE_CLIENT_SECRET=$PHP_SERVICE_CLIENT_SECRET"
echo 

echo "Creating client roles"
echo "===================="

curl -i -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_NC/roles" \
-H "Authorization: Bearer $ADMIN_TOKEN" \
-H "Content-Type: application/json" \
-d '{"name": "USERNextcloud"}'


ROLE_ID=$(curl -s "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_NC/roles" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq -r '.[0].id')


curl -i -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_PHP/roles" \
-H "Authorization: Bearer $ADMIN_TOKEN" \
-H "Content-Type: application/json" \
-d '{"name": "php-service-role"}'


PHP_ROLE_ID=$(curl -s "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/clients/$CLIENT_PHP/roles" \
  -H "Authorization: Bearer $ADMIN_TOKEN" | jq -r '.[0].id')


echo "NEXCLOUD ROLE_ID=$ROLE_ID"
echo

echo "PHP ROLE_ID=$PHP_ROLE_ID"
echo

echo "Creating Client Mappings"
echo "========================"

sudo curl -s -X POST "$REALM/sae-services/clients/$CLIENT_NC/protocol-mappers/models" \
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

sudo curl -s -X POST "$REALM/sae-services/clients/$CLIENT_PHP/protocol-mappers/models" \
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
pwd
ls -l
 
LDAP_ID=$(curl -si -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/components" \
  -H "Authorization: Bearer $ADMIN_TOKEN" \
  -H "Content-Type: application/json" \
  -d '@Scripts/ldap-config.json' \
  | grep -oE '[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}')


echo "LDAP_ID=$LDAP_ID"
echo


echo "Sync LDAP Users"
echo "==============="


curl -i -s -X POST "http://$KEYCLOAK_HOST_PORT/admin/realms/sae-services/user-storage/$LDAP_ID/sync?action=triggerFullSync" \
  -H "Authorization: Bearer $ADMIN_TOKEN"

echo
echo "============="
