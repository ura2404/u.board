#!/bin/bash

/usr/bin/xmodmap -e "keycode 64 = "

/usr/bin/chromium-browser --kiosk http://localhost/u.board
