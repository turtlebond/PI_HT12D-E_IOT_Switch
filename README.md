# PI_HT12D-E_IOT_Switch
Control relay through webpage by using Raspberry Pi and HT12D and HT12E

Device: Raspberry Pi Model B, HT12D, HT12E, Jumper Wires, Relay


## Wiring

## Instruction
1. Install the required library
   - apache2,apache2-utils,php5, mysql-server  
   - wiringpi - control Pi gpio pin (http://wiringpi.com/)
  
2. Copy the files to /var/www/html/
  
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


* For automation, cron is used. For viewing the cronlist
   <br />*crontab -u www-data -l*

## Webpage View

Switch:

![Alt text](./images/switch.png)

Switch Automation:

![Alt text](./images/switch_auto.png)

