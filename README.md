# PI_HT12D-E_IOT_Switch
Control relay through webpage by using Raspberry Pi and HT12D and HT12E

Instruction
1. Create web-server in RasperryPi
  sudo apt-get install apache2
  
2. Copy the files to /var/www/html/
  
3. Update the my_db.sql address with correct Pi pin. 

4. create user and grant privilege
  create user username@'ip_address' identified by 'password';
  grant all privileges on my_db.* to username@ip_address identified by 'password';
  flush privileges;


