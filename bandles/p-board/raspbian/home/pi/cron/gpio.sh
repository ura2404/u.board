#!/bin/bash

GPIO=`cat /boot/u.board/config.json | grep 'gpio' |  awk -F: '{ gsub(/ |,|\"/,""); print $2}'`
echo $GPIO

sudo echo $GPIO > /sys/class/gpio/export
sudo echo out > /sys/class/gpio/gpio$GPIO/direction
sudo chmod 777 /sys/class/gpio/gpio$GPIO/value