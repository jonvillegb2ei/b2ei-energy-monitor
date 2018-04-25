# [B2EI](http://www.b2ei.com) energy monitor

An open source project to monitor easily your energy consumption on your building.

Developed by  [B2EI](http://www.b2ei.com) with Laravel, angularjs and some other open source frameworks and libraries.

Don't use B2EI energy monitor at the moment, it's a beta version with some bugs, we will correct them as soon as possible.


### Next steps : 
 - Bug correction, interface finalisation and tests creation.
 - Add a charts module to create custom charts with one or many equipments.
 - Add translation support (All texts are in english, we want to add french, german and spanish support)
 - Support product from XLS (actually product elements are stored on PHP class files, we will create a custom product that load all it parameters from an xls file to provide a simple way to add equipments)
 - Notification support (add toggleable notification on equipment fault)
 - Generate an image for raspberry pi (based on Raspbian).
 - Integrate Modbus server, MQTT support for AWS support and maybe an OPC server.
 - Integrate blockchain support (we are looking on ethereum smart contract to provide a smart, secure and decentralized logging provider for your data).


 ## Raspberry Pi Installation
 
 
 You can download a Rasberry pi Image based on raspbian : http://www.b2ei.com/public/b2ei-energy-monitor.img.gz
 
 To install it on your SD card use the following command (don't forget to replace /dev/mmcblk0 with the correct devise path): 
 ```bash
 gunzip --stdout b2ei-energy-monitor.img.gz | dd bs=4M of=/dev/mmcblk0
 ```
 
 ##### Raspberry Pi
 - Brand: Raspberry Pi
 - Model: Raspberry Pi 3 Model B+ 
 - Part No: Raspberry Pi 3 Model B+ 
 - Part No RS Components: 137-3331


 ##### Pi Case
 - Brand: Phoenix Contact
 - Model: RPI-BC Raspberry Pi Case
 - Part No: 2202874
 - Part No RS Components: 122-4298


 ##### Main Shield
 - Brand: 	MikroElektronika
 - Model: Shield Pi 2 Click Raspberry Pi
 - Part No: MIKROE-2756
 - Part No RS Components: 162-3385


 ##### RTC sub shield
 - Brand: MikroElektronika
 - Model: RTC2 Click Board 
 - Part No: MIKROE-948
 - Part No RS Components: 882-9086	


 ##### Power supply
 - Brand: Raspberry Pi 
 - Model: Raspberry Pi, 13W Plug In Power Supply 5.1V, 2.5A
 - Part No: T5875DV
 - Part No RS Components: 909-8126


 ##### SD card
 - Brand: 	Verbatim
 - Model: 64 GB SD Card
 - Part No: 44034
 - Part No RS Components: 123-9684


 
 ##### Pictures
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0072.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0073.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0074.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0075.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0076.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0077.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0078.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0079.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0080.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0081.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0082.jpg)
 ![Raspberry Pi](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/photos/IMG_0083.jpg)

 

 
 ## Screenshots
![Dashboard screenshot](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/dashboard.png)

![Detail equipment screenshot](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/detail-equipment.png)

![technician equipment screenshot](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/technician-equipment.png)

![settings screenshot](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/settings.png)

![technician screenshot](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/technician.png)

![users screenshot](https://github.com/jonvillegb2ei/b2ei-energy-monitor/raw/master/readme/users.png)
