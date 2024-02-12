#!/bin/bash
# init-keycloak.sh

# Function to check if Keycloak is up
wait_for_keycloak() {
  until $(curl --output /dev/null -k --silent --head --fail http://localhost:8080/); do
    printf '.'
    sleep 5
  done
}


echo "Waiting for Keycloak to be ready..."
wait_for_keycloak
echo "Keycloak is up. Running configuration script."

# Now run your existing script
./main/Scripts/KeyC-Config.sh
