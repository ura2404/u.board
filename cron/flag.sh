#!/bin/bash

if [ -f /home/pi/u.board/flag/reload ]; then
    rm -f /home/pi/u.board/flag/reload
    /usr/sbin/reboot
fi


if [ -f /home/pi/u.board/flag/power ]; then
    rm -f /home/pi/u.board/flag/power
    /usr/sbin/poweroff
fi

