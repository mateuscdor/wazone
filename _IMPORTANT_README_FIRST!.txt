This readme file will be the special instruction.
Please open this file everytime you want to do fresh install or update.
Because each major version might have changes on the procedure.

**Special instruction for version 0.9.x and up:
==============================================
"https://mydomain.com" and "https://api.mydomain.com" are just for illustration purpose.
if https://mydomain.com is not available, you can use sub-domain for admin panel.
Example: https://admin.mydomain.com

Fresh install (Admin panel):
***************************
1. upload wazone_admin_panel_0.9.x.zip to https://mydomain.com, then extract.

2. open browser to https://mydomain.com (no "/public")

3. then follow everything else like in the https://visimisi.net/docs

Upgrade install (Admin panel + Nodejs server):
**********************************************
NOW PHP8.1 is REQUIRED! PLEASE CHECK IF YOUR SERVER SUPPORT PHP8.1

**************************************************************************
* BEFORE UPDATE/UPGRADE, PLEASE CLEAR CACHE FIRST!                       *
* Login as any admin role user, go to menu "Settings"->"Clear app cache" *
**************************************************************************

1. Extract "waz_v0.9.xx-extract_on_computer_first.zip" on your computer first!

2a. Upload wazone_admin_panel_0.9.x.zip to https://mydomain.com, then extract.
2b. Upload wazone_node_server_0.9.x.zip to https://api.mydomain.com, then extract.
    OR if you install in 1 subdomain, just extract both in the same place.

3. Open browser to https://mydomain.com (no "/public")

   This version RC3 require database update. Just click "next" on update wizard.

   If you get error "App/Helpers/Helper::settings() page, go to menu "Settings"->"Clear app cache"
   If you cannot open your website,
   ====> cPanel->File Manager->"/storage/framework/view/"
   ====> delete everything in that folder. 

4. Open menu "Rest API", please activate your license.
   (if already activated, no need to activate again).
   Please login to https://visimisi.net/my-account/ to de-activate license first

5. Open/create .env on nodejs side (https://api.mydomain.com),
   if you install panel+nodejs in 1 subdomain, NO NEED do this step,
   because panel+nodejs sharing 1 .env file.

################ START EDIT ENV FILE ################
# Server configs
APP_URL=https://my-admin-panel.com
APP_PORT=8000

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your-database-name
DB_USERNAME=your-database-username
DB_PASSWORD=your-database-password

TIMER_REFRESH=true

################# END EDIT ENV FILE #################

6. cPanel->Setup Node.js Apps -> STOP -> START Nodejs App

7. New feature is the Whatsapp verification when new user register on your admin panel.
   https://visimisi.net/docs/wazone-whatsapp-verification-and-reset-password/

8. One more new feature, Add, Edit, and Delete contact inside phonebook.
   https://visimisi.net/docs/wazone-add-edit-and-delete-contact-inside-phonebook/

**Included language files are in /lang folder.
Copy paste the file to your wazone server in /lang folder

