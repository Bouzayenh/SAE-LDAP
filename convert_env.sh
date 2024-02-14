#!/bin/bash

# This programm let's you trasform each variable of a .env file at the ./ location. Into a .txt file with it's correponding value. 

# Usage : Using docker secrets 

dir="./"

if [[ $1 ]]; then 

    dir=$1

fi


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

        var_value="${var_value# }"

        exec 3<&-

        if [[ $2 ]] && [[ $var_name == *$2* ]]; then
            
            echo $var_value > "$dir/$var_name.txt"

        elif [[ ${#2} == 0 ]]; then
            echo $var_value > "$dir/$var_name.txt"
        fi
       
    fi
    
done < .env

