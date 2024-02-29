#!/bin/bash

# Usage: decryptEnv [VOlUME] [Private Key NAME]
decryptEnv(){
    if [[ -d "/Volumes/KINGSTON" ]]; then 

        echo "USB Connected ! "

    else 

        echo -n "Waiting for the USB key "
        while [ ! -d "/Volumes/KINGSTON" ]; do
        echo -n "."
        sleep 3
        done
        echo -e "\nUSB Connected ! "
        sleep 1
    fi

    if [[ ! -f "/Volumes/KINGSTON/Keys/alfonso.key" ]]; then

        if [[ ! -f "/Volumes/KINGSTON/Keys/alfonso.key.gpg" ]]; then 

            echo "Missing private key"
            exit 1

        fi

        gpg --output /Volumes/KINGSTON/Keys/alfonso.key --decrypt /Volumes/KINGSTON/Keys/alfonso.key.gpg

    fi

    gpg --import /Volumes/KINGSTON/Keys/alfonso.key

    gpg --output .env --decrypt .env.gpg

    gpg --yes --delete-secret-key JIMENEZ

    diskutil eject /Volumes/KINGSTON

}
hideEnv(){
    rm .env
}
