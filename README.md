# Customer Couning App


---------------------------- Customer Counter ----------------------------

I've got an updated version running at:
	http://stevencumming.io/clicker
	
	USE STORE NUMBER '1234' FOR TESTING


### SUMMARY
- Currently, all basic functionality is implemented.
- The infrastructure for high level reporting is implemented,
	however I still need to write some scripts for fetching
	and managing the data.
- I will be able to report:
	- The total number of customers entering AND exiting over a 
		given period (15 minute intervals, daily summary, etc..)
	- Automatically emailing the data overnight.
	- Analytics page for live numbers
- All store numbers have been added into the testing database with the
	limits.


### SCALABILITY
- To scale the application up, a dedicated web host will be necessary:
	- PHP, MySQL, and IIS / Apache
	- I'd probably trial a mid-tier host that can sustain 
- A domain would need to be purchased or used too. (to access it)


### MY CONCERNS
- Initial surges of traffic around beginning of trade:
	- The actual web content is very light.
	- All images are vectors, and amount to about 12KB
	- I'm more concerned about the MySQL qps (queries per second)
		- on a dedicated machine with enough RAM and CPU it should
			be easily able to sustain >2000 qps (I hope)
		- The fetch interval can be extended to ease congestion
** Scalability
	- Using MySQL and PHP scripts updating hundreds of times every second
		(worst case, if all stores used this) is unchartered territory for
		me as a developer. I'd be looking for other opinions and tips for
		optimization.


### Q/A 
- What devices can this run on?
	- I've tested it on Apple ios devices throughout development
	- Any device with a reasonably up-to-date web browser (almost all of
		them) should work fine.
	- Scaling might be an issue on some older / uncommon devices
	- The store iPad should work flawlessly
	- The newer RF guns ~should~ work too (if the WiFi reaches).
- How much mobile data would this use?
	- Hardly any, while doing a data request every few seconds the actual
		data transfer amounts to hardly anything.
- How quickly can this be migrated onto a dedicated host?
	- I think very quickly, in the order of hours.
	- The application files are pretty light and are all relatively 
		addressed.
- Data Security
	- The whole thing is scratch built. So there goes A LOT of security
		and protection. I've tried to make the system robust.
	- There are a few modifications I'd like to make to hinder the 
		unlikely event of an attack (an hour of work to prevent injection
		attacks for example)
	- There is no authentication.
		That would be nearly impossible given all of the different devices
		and networks. If anyone with the web address puts in ANY store 
		number they can adjust the counts.
		- I have implemented a function to log the IP addresses, and can 
			looking into implementing a blacklist (banning them) if 
			necessary.
	
	
	

### ASSETS
- I have purchased licences for all three images for unrestricted use
    - exit.svg (OUT button)
    - entry.svg (IN button)
    - crowd.svg	(favicon, front page icon)
	







### MySQL credentials
	user: customercounter
	pass: doncaster3128



### MySQL Tables

CREATE TABLE `customercounter`.`counts` (
  `store` INT NOT NULL,
  `count` INT NULL DEFAULT 0,
  `total_in` INT NULL DEFAULT 0,
  `total_out` INT NULL DEFAULT 0,
  `min` INT NULL DEFAULT 99,
  `recommended` INT NULL DEFAULT 110,
  `max` INT NULL DEFAULT 121,
  PRIMARY KEY (`store`));

CREATE TABLE `customercounter`.`log` (
  `id_log` INT NOT NULL AUTO_INCREMENT,
  `store` INT NULL,
  `time` DATETIME NULL DEFAULT now(),
  `ip` VARCHAR(45) NULL,
  PRIMARY KEY (`id_log`));
  







