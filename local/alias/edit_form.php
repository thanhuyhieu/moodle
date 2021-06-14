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

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->libdir.'/formslib.php');

/**
 * Class alias_edit_form.
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class alias_edit_form extends moodleform {

    /**
     * Form definition.
     */
    public function definition() {
        global $CFG;
        $mform = $this->_form;
        $alias = $this->_customdata['alias'];
        
        // Accessibility: "Required" is bad legend text.
        $strtextfileds  = get_string('textfields', 'local_alias');
        $strrequired = get_string('required');

        // Add some extra hidden fields.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        // Print the required moodle fields first.
        $mform->addElement('header', 'moodle', $strtextfileds);

        
        $mform->addElement('text', 'friendly', get_string('friendly','local_alias'), 'maxlength="254" size="30"');
        $mform->addRule('friendly', $strrequired, 'required', null, 'client');
        $mform->setType('friendly', PARAM_RAW_TRIMMED);

        $mform->addElement('text', 'destination', get_string('destination','local_alias'), 'maxlength="254" size="30"');
        $mform->addRule('destination', $strrequired, 'required', null, 'client');
        $mform->setType('destination', PARAM_RAW_TRIMMED);


        $this->add_action_buttons(true, get_string('savechanges'));

        $this->set_data($alias);
    }

    /**
     * Extend the form definition after the data has been parsed.
     */
    public function definition_after_data() {
        $mform = $this->_form;

        // Trim required name fields.
        $mform->applyFilter('friendly', 'trim');
        $mform->applyFilter('destination', 'trim');
    }

    

    function validation($data, $files) {
        $errors = parent::validation($data, $files);

        // Validating Entered url, we are looking for obvious problems only,
        // teachers are responsible for testing if it actually works.

        // This is not a security validation!! Teachers are allowed to enter "javascript:alert(666)" for example.

        // NOTE: do not try to explain the difference between URL and URI, people would be only confused...

        if (!empty($data['friendly'])) {
            $url = $data['friendly'];
            if (preg_match('|^/|', $url)) {
                // links relative to server root are ok - no validation necessary

            } else if (preg_match('|^[a-z]+://|i', $url) or preg_match('|^https?:|i', $url) or preg_match('|^ftp:|i', $url)) {
                // normal URL
                if (!url_appears_valid_url($url)) {
                    $errors['friendly'] = get_string('invalidurl', 'url');
                }

            } else if (preg_match('|^[a-z]+:|i', $url)) {
                // general URI such as teamspeak, mailto, etc. - it may or may not work in all browsers,
                // we do not validate these at all, sorry

            } else {
                // invalid URI, we try to fix it by adding 'http://' prefix,
                // relative links are NOT allowed because we display the link on different pages!
                if (!url_appears_valid_url('http://'.$url)) {
                    $errors['friendly'] = get_string('invalidurl', 'url');
                }
            }
        }
        if (!empty($data['destination'])) {
            $url = $data['destination'];
            if (preg_match('|^/|', $url)) {
                // links relative to server root are ok - no validation necessary

            } else if (preg_match('|^[a-z]+://|i', $url) or preg_match('|^https?:|i', $url) or preg_match('|^ftp:|i', $url)) {
                // normal URL
                if (!url_appears_valid_url($url)) {
                    $errors['destination'] = get_string('invalidurl', 'url');
                }

            } else if (preg_match('|^[a-z]+:|i', $url)) {
                // general URI such as teamspeak, mailto, etc. - it may or may not work in all browsers,
                // we do not validate these at all, sorry

            } else {
                // invalid URI, we try to fix it by adding 'http://' prefix,
                // relative links are NOT allowed because we display the link on different pages!
                if (!url_appears_valid_url('http://'.$url)) {
                    $errors['destination'] = get_string('invalidurl', 'url');
                }
            }
        }
        return $errors;
    }
}