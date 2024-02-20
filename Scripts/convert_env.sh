#!/bin/bash

# This programm let's you trasform each variable of a .env file at the ./ location. Into a .txt file with it's correponding value. 

# Purpose : Using docker secrets 

# Usage : convert_env.sh [destination] [KEY_WORD] 

createSecretsFile(){

dir=${1:-"./"}

while read line;
do
    if [[ $line != *"#"* ]] && [ ${#line} -gt 0 ]; then
       
        delimiter="="

        exec 3<<<"$line"

        read -r -d "$delimiter" var_name <&3

        var_value=""
        while read -r -d "$delimiter" token <&3; do
            var_value+="$token="
        done
        var_value+="$token"

        exec 3<&-

        if [[ $2 ]] && [[ $var_name == *$2* ]]; then
            
            echo -n $var_value > "$dir/$var_name.txt"

        elif [[ ${#2} == 0 ]]; then
            echo -n $var_value > "$dir/$var_name.txt"
        fi
       
    fi
    
done < .env

}

removeSecretsFiles(){
    rm *.txt
    rm ./services/*.txt
    rm ./main/*.txt
}

# This function creates a temporary file to export all found variables
# This tmp file has to be sourced and removed at the uppermost sh file
exportSecret(){

    [[ -z $1 ]] && echo "Usage : exportSecretFile [KEY_WORD]" && exit 1

    while read line;
    do

        if [[ $line == *"#"* ]] || [ ${#line} == 0 ]; then
            continue
        fi

        if [[ $line == *$1* ]]; then

            echo $line >> .tmp

            read -r -d "=" var_name <<< $line

            echo "export $var_name" >> .tmp

        fi

    done < .env

}
