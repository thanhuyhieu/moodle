This file is part of Moodle - http://moodle.org/

Moodle is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Moodle is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

copyright 2021 NashTech
license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later


Alias module
=============

Alias module is one of the successors to original 'file' type plugin of Resource module.


TODO:
 * implement portfolio support (MDL-20084)
 * new backup/restore and old restore transformation (MDL-20085)


Add menu item:
1. Click Home > Site administration > Appearance > Theme settings
2. Scroll down to the Custom menu items field.
3. Enter: Alias|/local/alias/index.php
4. Scroll to the bottom of the page and click Save changes

Sitemap:
* User interface: http://localhost/moodle/alias
* Create alias: http://localhost/moodle/alias/edit.php or click Create new alias button
* Edit alias: http://localhost/moodle/alias/edit.php?id=xx (xx is number of alias id) or Click Edit alias
* Delete alias: Click delete button
* Search alias: Enter keyword and Click Go button
* Pagination: 10 records for each page. Click number page to view.

Run PHPUnit9:
1. Add a new "phpu_moodledata" directory, according to config.php
2. Go to moodle root directory
3. Run this to install phpunit
    * php admin/tool/phpunit/cli/init.php
4. Run testcase
    * vendor/bin/phpunit --testsuite local_alias_testsuite