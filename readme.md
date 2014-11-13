Om de website te runnen, volg de volgende stappen:

Stap 1)
Run je MySQL database en vul de connectiegegevens in bij "app/config/database.php" bij lijn 55.
Importeer de digitalwaste.sql in the database

Stap 2)
Run de website in de terminal met "php artisan serve"

Stap 3)
Gebruik de volgende routes voor het navigeren rond de site:

- / (home directory)	- Voor het raten van data
- /overview 		- De best beoordeelde data
- /overview/{xx}	- De specifieke data
- /setlimit/{xx}	- Zet het limiet van de aantal data die geshowt wordt