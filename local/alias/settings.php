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
 * Settings
 *
 * @package    local_alias
 * @copyright  2021 NashTech
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$systemcontext = \context_system::instance();

if ($hassiteconfig) { // Admin
    $settingspage = new admin_category('local_alias_settings', new lang_string('pluginname', 'local_alias'));
    $ADMIN->add('localplugins', $settingspage);

    $settingspage = new admin_externalpage('local_alias', new lang_string('managealias', 'local_alias'),
        new moodle_url('/local/alias/index.php'));
    $ADMIN->add('localplugins', $settingspage);
}
else if(has_capability('local/alias:config', $systemcontext)) { //Manager
    $settingspage = new admin_category('local_alias_settings', new lang_string('pluginname', 'local_alias'));
    $ADMIN->add('modules', $settingspage);

    $settingspage = new admin_externalpage('local_alias', new lang_string('managealias', 'local_alias'),
        new moodle_url('/local/alias/index.php'), 'local/alias:config');
    $ADMIN->add('local_alias_settings', $settingspage);
}