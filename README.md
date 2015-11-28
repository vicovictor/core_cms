CORE CMS v1.21

Be sure to check the LICENSE file if you haven't.

To begin installation, copy the contents of the folder "Core" (or the whole folder itself if you'd like) to your server.

(NOTE: There has been reported errors when putting the directory named "core" in another directory named "core". Try avoid this; putting it in a directory named "Core" (capitalized first letter) works fine.)

Then navigate to yourserver.com/whatever/directory/core/install/ and start the installation.

If you are upgrading from version 1.0 - 1.21, just replace everything except you user folder (core/user) and upload to your server. (You can save your theme).

I've supplied a htaccess file with this package, just put a dot infront of "htaccess" (.htaccess) and put it on your server in the same folder as the core index file and folder is and you can enable "nice permalinks" in the configuration later on.

HINT: If you're upgrading from v06 or v05 and want to keep your old Core version intact that is absolutely no problem. Just put this core folder somewhere where it doesn't replace your old one. For example, if your current website is www.yourwebsite.com, your current core folder is at www.yourwebsite.com/core, put the new one at something like www.yourwebsite.com/new-core/core.

__________________________________________

Changes from Core v1.2 to 1.21

Some structural changes to the admin panel.
Fix in all themes to make sure IE users can browse the site without problems.

__________________________________________

Changes from Core v1.1 to 1.2

You can now edit the index head by using the admin panel, so basically, other than uploading Core to your server, now interaction outside a browser is needed.

Upgraded themes blackthumb (now "darkthumbs") and simple (now "simple2) which now support Safari 4 amongst other browsers.

Added two new commands, CORE(TAG:TITLE:URL) and CORE(PAGE:TITLE:URL) which returns url friendly versions of the variables, as demonstrated by all three supplied themes.

Changing a file in the admin panel doesn't redirect you back one step, this was ineffective when working with css and scripts.

Added better security for front-end interaction with the database.

Quotes doesn't get backslashes in front of them when adding new files with code.

--------------------------------

Changes from Core v1.0 to 1.1

Core is now not limited to the root. So if you have your core directory in: http://www.yourserver.com/core/ and you don't want it there, just move it to wherever you like. For example: www.yourserver.com/corecms/core/.

New functionality and looks of the admin panel. It's just better.

A new and better installer which also works as an upgrader for Core v06 or v05.

There's a lot more the admin panel can do and I won't bother to write a list of things, just try it! :)
________________