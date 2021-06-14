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
require_once($CFG->dirroot.'/local/alias/edit_form.php');
require_once($CFG->dirroot.'/local/alias/lib.php');
require_once($CFG->dirroot.'/local/alias/locallib.php');

$aliasid       = optional_param('id', 0, PARAM_INT);
$returnto = optional_param('returnto', null, PARAM_ALPHA);
$sitecontext = context_system::instance();

require_login();
if (!is_siteadmin()) {
    return '';
}

$headingfullname    = get_string('headingfullname', 'local_alias');
$managealias        = get_string('managealias', 'local_alias');
$straliass          = get_string('modulenameplural', 'local_alias');
$pluginname         = get_string('pluginname', 'local_alias');

$PAGE->set_url('/local/alias/edit.php', array('id' => $aliasid));
$returnurl = new moodle_url('/local/alias/index.php');

$PAGE->set_context($sitecontext);
$PAGE->set_pagelayout('admin');
$PAGE->set_heading($headingfullname);
$PAGE->set_title($pluginname);
$PAGE->navbar->add($managealias, $returnurl);

if ($aliasid){
    if(!$alias = $DB->get_record('alias', array('id' => $aliasid))) {
        print_error('invalidaliasid','local_alias');
    }
    if (!has_capability('local/alias:edit', $sitecontext)) {
        print_error('cannoteditalias','local_alias');
    }
}
else if (!has_capability('local/alias:addinstance', $sitecontext)) {
    print_error('cannotaddalias','local_alias');
}

// create the alias filter form
$mform = new alias_edit_form(new moodle_url($PAGE->url, array('returnto' => $returnto)), array(
    'alias' => $alias));

if ($mform->is_cancelled()) {
    redirect($returnurl);
} else if ($data = $mform->get_data()) {
    if (empty($alias->id)) {
        alias_add_instance($data, $mform);
    }
    else {
        alias_update_instance($data, $mform);
    }
    redirect($returnurl);
}

echo $OUTPUT->header();

//display form
$mform->display();

echo $OUTPUT->footer();