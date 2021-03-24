#!/bin/bash

ROOT=/home/pi/u.board

function wifi() {
    SSID=`php -f $ROOT/cron/get.php SSID`
    pass=`php -f $ROOT/cron/get.php pass`

    cat /etc/hostapd/hostapd.conf | grep -v -e ssid -e wpa_passphrase > _hostapd.conf
    [ -s _hostapd.conf ] || return

    echo 'ssid='$SSID >> _hostapd.conf
    echo 'wpa_passphrase='$pass >> _hostapd.conf

    mv _hostapd.conf /etc/hostapd/hostapd.conf
}

function rotate() {
    rotate=`php -f $ROOT/cron/get.php rotate`
    echo $rotate

    cat /boot/config.txt | grep -v -e display_rotate > _config.txt
    [ -s _config.txt ] || return

    echo 'display_rotate='$rotate >> _config.txt

    mv _config.txt /boot/config.txt
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
