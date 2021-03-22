#!/bin/bash

ROOT=/home/pi/u.board

function wifi() {
    SSID=`php -f $ROOT/cron/get.php SSID`
    pass=`php -f $ROOT/cron/get.php pass`

    cat /etc/hostapd/hostapd.conf | grep -v -e ssid -e wpa_passphrase > /tmp/hostapd.conf
    echo 'ssid='$SSID >> /tmp/hostapd.conf
    echo 'wpa_passphrase='$pass >> /tmp/hostapd.conf

    mv /tmp/hostapd.conf /etc/hostapd/hostapd.conf


    #a=`cat $ROOT/config.json | jq '.[]' | select".u.board.data.SSID.value" | sed 's/\"//g'`
    #echo $a
}

function rotate() {
    rotate=`php -f $ROOT/cron/get.php rotate`
    echo $rotate

    cat /boot/config.txt | grep -v -e display_rotate > /tmp/config.txt
    echo 'display_rotate='$rotate >> /tmp/config.txt

    mv /tmp/config.txt /boot/config.txt
}

if [ -f /home/pi/u.board/flag/reload ]; then
    wifi
    rotate

    rm -f /home/pi/u.board/flag/reload
    /usr/sbin/reboot
fi

if [ -f /home/pi/u.board/flag/power ]; then
    wifi
    rotate

    rm -f /home/pi/u.board/flag/power
    /usr/sbin/poweroff
fi
