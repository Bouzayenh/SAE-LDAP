#!/bin/bash  

#This file adds the secrets needed to the ldap-config.json file. 
#This shell script can be expanded to add a secret to any .jsonFile if needed

# Usage: addSecrets [target_file]
#      : hideSecrets 

#target_file default to "./main/Scripts/ldap-config.json" 

addSecrets(){
    target_file=${1:-"./main/Scripts/ldap-config.json"}

    source .env
    if [[ $? == 1 ]]; then

        echo "The env file is not set"
        exit 1

    fi

    bindDn=$LDAP_ADMIN_CN
    bindCredential=$LDAP_ADMIN_PASSWORD

    jq '.config.bindDn = [$ARGS.positional[0]] | .config.bindCredential = [$ARGS.positional[1]]' \
    ./Scripts/ldap-config.json --args "$bindDn" "$bindCredential"\
    > $target_file  
}


hideSecrets(){
    target_file=${1:-"./main/Scripts/ldap-config.json"}

    jq '.config.bindDn = ["[HIDDEN]"] | .config.bindCredential = ["[HIDDEN]"]' \
    ./Scripts/ldap-config.json \
    > $target_file
}
