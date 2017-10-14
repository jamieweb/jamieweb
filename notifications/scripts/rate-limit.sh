#!/bin/bash
if [[ $(echo $1 | egrep "^(add|take)$") ]]; then
    count=$(cat storage/global-rate-limit.txt)
    sleep 0.1
    if ! [[ $(echo $count | grep [^0-9]) ]]; then
        if [ "$1" == "take" ]; then
            sed -i '1d' storage/ip-rate-limit.txt
            if [ "$count" == "0" ]; then
                exit
            elif (( "$count" > "0" )); then
                echo $(($count - 1)) > storage/global-rate-limit.txt
            else
                echo "1440" > storage/global-rate-limit.txt
                exit
            fi
        elif [ "$1" == "add" ]; then
            if ! (( "$count" >= "0" )); then
                echo "1440" > storage/global-rate-limit.txt
                exit
            else
                echo $(($count + 1)) > storage/global-rate-limit.txt
            fi
        else
            echo "1440" > storage/global-rate-limit.txt
            exit
        fi
    else
        echo "1440" > storage/global-rate-limit.txt
        exit
    fi
else
    echo "1440" > storage/global-rate-limit.txt
    sleep 0.1
    exit
fi
