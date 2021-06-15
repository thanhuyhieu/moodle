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
 * local_alias generator tests
 *
 * @package    local_alias
 * @category   test
 * @copyright  2013 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Genarator tests class for local_alias.
 *
 * @package    local_alias
 * @category   test
 * @copyright  2013 Marina Glancy
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_alias_generator_testcase extends advanced_testcase {

    public function test_create_instance() {
        global $DB, $SITE;
        $this->resetAfterTest();
        $this->setAdminUser();
        
        $generator = $this->getDataGenerator()->get_plugin_generator('local_alias');

        $params = array('friendly' => 'http://example.com/home', 'destination' => 'http://example.com/okay?id=1');
        $alias = $generator->create_instance(array('course' => $SITE->id), $params);
        $records = $DB->get_records('alias', array('id' => $alias->id), 'id');
        $this->assertEquals(1, count($records));
        $this->assertTrue(array_key_exists($alias->id, $records));

        $params = array('friendly' => 'http://example.com/modhome', 'destination' => 'http://example.com/mod?id=1');
        $alias = $generator->create_instance(array('course' => $SITE->id), $params);
        $records = $DB->get_records('alias', array('id' => $alias->id), '*');
        $this->assertEquals(2, count($records));
        $this->assertEquals('http://example.com/modhome', $records[$alias->id]->friendly);
        $this->assertEquals('http://example.com/mod?id=1', $records[$alias->id]->destination);
    }

    public function test_deleting() {
        global $DB;
        $this->resetAfterTest(true);
        $this->setAdminUser();
        $DB->delete_records('alias');
        $this->assertEmpty($DB->get_records('alias'));
    }
}
