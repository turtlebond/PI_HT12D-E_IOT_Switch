# PI_HT12D-E_IOT_Switch

## Intro
This project is developed so that a device can be powered up/down using webpage, thus making it easier to control from any part of the world. 
Rapberry Pi with Raspbian OS is used as the gateway for user to control a device. User can turn on/off a device using the webpage hosted by Pi. The webpage uses sql database for displaying info related to a switch.
<br /> 
<br /> HT12E with XY-MK-5V and HT12D with XD-FST used as a remote control to transmit and receive RF signal (refer HT12D/HT12E documentation). HT12D with a defined address is connected to target device at one of data output. Each address can drive up to 4 data output (Refer Wiring section). HT12E which is wired to the Pi, encode RF signal with the values from the webpage (ex:address and data) and transmit via XY-MK-5V. The info about the target device, address and data line is stored in the sql database. The XD-FST receive the transmitted signal and decode using HT12D and if the address matches will drive the data output. For controlling the target device for automation, cronjob is utilised.
<br /> 
<br />The HT12E and HT12D are supplied with 5V voltage. Targetted frequency(fEnc) for HT12E is 3KHz. Hence, 1MOhm resistor is used based on the HT12E datasheet. As for HT12D, targetted frequency is 50*fEnC=150KHz, thus 51KOhm resistor is used. 

![Alt text](./images/intro.png) 

## Wiring
#### Parts
Raspberry Pi Model B, HT12D, HT12E,  XY-MK-5V, XD-FST

#### HT12D ( Freq=150KHz )

![Alt text](./images/ht12d.png)


|  Label | Value/Connection |
| ------------- | ------------- |
| R5  | 33K Ohm  |
| R2  | 51K Ohm  |
| JP6  | XD-FST  |
| JP7-1  | Target device ex: Relay, electric solenoid .etc |
| JP7-2  | Target device  |
| JP7-3  | Target device  |
| JP7-4  | Target device  |

#### HT12E ( Freq=3KHz )
![Alt text](./images/ht12e.png)

|  Label | Value/Connection |
| ------------- | ------------- |
| R1  | 1M Ohm  |
| JP3  | XY-MK-5V  |
| JP2-1  | Pi - GPIO0 (H:11) |
| JP2-2  | Pi - GPIO1 (H:12)|
| JP2-3  | Pi - GPIO2 (H:13) |
| JP2-4  | Pi - GPIO3  (H:15) |
| JP5-2  | Pi - GPIO4  (H:16)|
| JP5-4  | Pi- GPIO5  (H:18) |
| JP5-6  | Pi - GPIO6 (H:22) |
| JP1  | Pi - GPIO7  (H:7) |

## Instruction
1. Install the required library
   - apache2,apache2-utils,php5, mysql-server  
   - wiringpi - control Pi gpio pin (http://wiringpi.com/)
  
2. Copy the files from web to /var/www/html/
  
3. Store my_sql.db database to current machine
   - *mysql -u root -p my_db <my_db.sql*

4. Create user and grant privilege
   - *mysql -u username -p my_db*
   - *create user username@'ip_address' identified by 'password';*
   - *grant all privileges on my_db.* to username@ip_address identified by 'password';*
   - *flush privileges;*

5. Update the my_db.sql address with correct Pi pin address corresponding to area id

6. Update the *user* and *pwd* in *auto_switch.sh* and *access_sql.sh* as created in #4

7. Using browser,enter the IP address of the Pi hosting the webpage 
   <br />*make sure the Pi IP address is  included in router port forwarding if accessing the page from external network (not local network)
   
 8. Incase no electricity and want to reinitalize the switch after power up
    <br /> either add *\<path\>/reboot access_sql.sh* in crontab -e OR
    <br /> add *\<path\>/access_sql.sh* in /etc/rc.local


* For automation, cron is used. For viewing the cronlist
   <br />*crontab -u www-data -l*

## Webpage View

Switch:

![Alt text](./images/switch.png)

Switch Automation:

![Alt text](./images/switch_auto.png)

