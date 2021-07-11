import RPi.GPIO as GPIO
import time
import os
import json


GPIO.setmode(GPIO.BCM)
GPIO.setup(18, GPIO.IN, pull_up_down=GPIO.PUD_UP)

data = json.load(open('/home/pi/u.board/config.json'))
file1 = data["file1"]
file2 = data["file2"]

def my_callback(channel):
    # print('You pressed the button')
    GPIO.remove_event_detect(18)
    os.system('/home/pi/dbuscontrol.sh pause')
    os.system('/usr/bin/omxplayer --no-osd /home/pi/u.board/data/'+file2)
    os.system('/home/pi/dbuscontrol.sh pause')
    GPIO.add_event_detect(18, GPIO.FALLING, callback=my_callback, bouncetime = 200) 

GPIO.add_event_detect(18, GPIO.FALLING, callback=my_callback, bouncetime = 200) 
os.system('/usr/bin/omxplayer --no-osd --loop /home/pi/u.board/data/'+file1)
