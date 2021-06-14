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
 * @package    local_alias
 * @copyright  2021 NashTech
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir.'/formslib.php');

/**
 * Class alias_add_filter_form.
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class alias_add_filter_form extends moodleform {

    /**
     * Form definition.
     */
    public function definition() {
        global $CFG;
        $mform = $this->_form;
        $search = $this->_customdata['search'];

        //-------------------------------------------------------
        $mform->addElement('text', 'search', get_string('filter:lable','local_alias'));
        $mform->setType('search', PARAM_TEXT);
        $mform->addRule('search', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->setDefault('search', $search);

        // Add buttons.
        $addfilterbutton = $mform->createElement('submit', 'filtersbutton', get_string('filter:go', 'local_alias'));
        $buttons = array_filter([
            $addfilterbutton
        ]);

        $mform->addGroup($buttons);
    }

    function validation($data, $files) {
        return array();
    }
}