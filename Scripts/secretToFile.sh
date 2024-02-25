#!/bin/bash  

#This file adds the secrets needed to the ldap-config.json file. 
#This shell script can be expanded to add a secret to any .jsonFile if needed

# Usage: addSecrets [target_file]
#      : hideSecrets 

#target_file default to "./main/Scripts/ldap-config.json" 
source ./Scripts/convert_env.sh

addSecretsJSON(){
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
hideSecretsJSON(){
    target_file=${1:-"./main/Scripts/ldap-config.json"}

    jq '.config.bindDn = ["[HIDDEN]"] | .config.bindCredential = ["[HIDDEN]"]' \
    ./Scripts/ldap-config.json \
    > $target_file
}
addSecretsLDIF(){
    i=0
    while read line;
    do 
        i=$((i+1))
        
        if [[ $line == *"userPassword"* ]]; then
            
            exportSecret "LDAP_USER_PASS_$uid"
            source .tmp
            rm .tmp
            tmpPass="LDAP_USER_PASS_$uid"
            
            sed "${i} s/\[\[HIDDEN\]\]/${!tmpPass}/" ./main/Scripts/bootstrap.ldif > temp_file.txt && mv temp_file.txt ./main/Scripts/bootstrap.ldif

        fi
        if [[ $line == *"uid:"* ]]; then
            uid=$(awk '{print $2}' <<< $line)
            
            uid="$(tr [a-z] [A-Z] <<< $uid)"
            uid="$uid"
        fi
        
        
    done < ./main/Scripts/bootstrap.ldif

}
hideSecretsLDIF(){
    oldLine="userPassword"
    newLine="userPassword: [[HIDDEN]]"
    
    sed "/$oldLine/c\\
$newLine
" ./main/Scripts/bootstrap.ldif > temp_file.txt && mv temp_file.txt ./main/Scripts/bootstrap.ldif

}
