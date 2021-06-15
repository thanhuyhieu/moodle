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
 * Mandatory public API of alias module
 *
 * @package    local_alias
 * @copyright  2021 NashTech
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * 
 */
function get_alias($get = true, $search='', $sort='friendly ASC', 
                    $page='', $recordsperpage='', $fields='*') {
    global $DB, $CFG;

    $params = array();
    $select = "";

    if(!empty($search)){
        $search = trim($search);
        $select .= $DB->sql_like('friendly', ':search1', false);
        // $select .= " OR ".$DB->sql_like('destination', ':search2', false);
        $params['search1'] = "%$search%";
        // $params['search2'] = "%$search%";
    }
    
    if ($sort) {
        $sort = " ORDER BY $sort $dir";
    }

    if ($get) {
        return $DB->get_records_select('alias', $select, $params, $sort, $fields, $page, $recordsperpage);
    } else {
        return $DB->count_records_select('alias', $select, $params);
    }

}

/**
 * 
 */
function get_alias_listing($sort='friendly', $dir='ASC', $page=0, 
                            $recordsperpage=0, $search='') {
    global $DB, $CFG;

    $select = "";
    $params = array();

    if (!empty($search)) {
        $search = trim($search);
        $select .= " WHERE ".$DB->sql_like('friendly', ':search1', false);
        // $select .= " OR ".$DB->sql_like('destination', ':search2', false);
        $params['search1'] = "%$search%";
        // $params['search2'] = "%$search%";
    }

    if ($sort) {
        $sort = " ORDER BY $sort $dir";
    }

    $sql = "SELECT *
            FROM {alias}
            $select
            $sort";

    return $DB->get_records_sql($sql, $params, $page, $recordsperpage);
}

/**
 * Add alias instance.
 * @param object $data
 * @param object $mform
 * @return int new alias instance id
 */
function alias_add_instance($data, $mform) {
    global $CFG, $DB;

    require_once($CFG->dirroot.'/local/alias/locallib.php');

    $data->friendly = alias_fix_submitted_url($data->friendly);
    $data->destination = alias_fix_submitted_url($data->destination);

    $data->timemodified = time();

    $data->id = $DB->insert_record('alias', $data);
    
    return $data->id;
}

/**
 * Update alias instance.
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function alias_update_instance($data, $mform) {
    global $CFG, $DB;

    require_once($CFG->dirroot.'/local/alias/locallib.php');

    $data->friendly = alias_fix_submitted_url($data->friendly);
    $data->destination = alias_fix_submitted_url($data->destination);

    $data->timemodified = time();

    $DB->update_record('alias', $data);

    return true;
}

/**
 * 
 */
function delete_alias($alias){
    global $DB;

    $DB->delete_records('alias', ['id' => $alias->id]);

    return true;
}