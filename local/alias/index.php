<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * List of alias
 *
 * @package    local_alias
 * @copyright  2021 NashTech
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

if ($CFG->forcelogin) {
    require_login();
}

$PAGE->set_pagelayout('incourse');

$headingfullname    = get_string('headingfullname', 'local_alias');
$managealias        = get_string('managealias', 'local_alias');
$straliass          = get_string('modulenameplural', 'local_alias');

$PAGE->set_url('/local/alias/index.php');
$PAGE->set_title($straliass);
$PAGE->set_heading($headingfullname);
$PAGE->navbar->add($managealias, '');
echo $OUTPUT->header();
echo $OUTPUT->heading($straliass);
