#!/bin/sh
cd /home/pi/openzwave-control-panel
screen -d -m -S server

screen -S server -X screen
screen -S server -X exec ./ozwcp -p 55555

sleep 2

screen -S server -X screen
screen -S server -X exec wget http://127.0.0.1:55555/devpost.html --post-data="dev=/dev/ttyUSB0&fn=open&usb=false"

screen -S server -X screen
screen -S server -X exec /home/pi/server.php
