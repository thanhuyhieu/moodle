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
 * Unit tests for some mod URL lib stuff.
 *
 * @package    local_alias
 * @category   phpunit
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * local_alias tests
 *
 * @package    local_alias
 * @category   phpunit
 * @copyright  2011 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_alias_lib_testcase extends advanced_testcase {

    /**
     * Prepares things before this test case is initialised
     * @return void
     */
    public static function setUpBeforeClass(): void {
        global $CFG;
        require_once($CFG->dirroot . '/local/alias/lib.php');
        require_once($CFG->dirroot . '/local/alias/locallib.php');
    }

    /**
     * Tests the alias_appears_valid_url function
     * @return void
     */
    public function test_alias_appears_valid_url() {
        $this->assertTrue(alias_appears_valid_url('http://example'));
        $this->assertTrue(alias_appears_valid_url('http://www.example.com'));
        $this->assertTrue(alias_appears_valid_url('http://www.google.com'));

        $this->assertFalse(alias_appears_valid_url('http:example.com'));
        $this->assertFalse(alias_appears_valid_url('http:/example.com'));
        $this->assertFalse(alias_appears_valid_url('http://'));

        $this->assertTrue(alias_appears_valid_url('https://nashtechglobal.com'));
    }
}