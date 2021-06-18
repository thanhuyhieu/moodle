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
require_once($CFG->dirroot.'/local/alias/alias_filter_form.php');
require_once($CFG->dirroot.'/local/alias/lib.php');
require_once($CFG->dirroot.'/local/alias/locallib.php');


$delete       = optional_param('delete', 0, PARAM_INT);
$confirm      = optional_param('confirm', '', PARAM_ALPHANUM);   //md5 confirmation hash
$search       = optional_param('search', '', PARAM_TEXT);
$sort         = optional_param('sort', 'friendly', PARAM_ALPHANUM);
$dir          = optional_param('dir', 'ASC', PARAM_ALPHA);
$page         = optional_param('page', 0, PARAM_INT);
$perpage      = optional_param('perpage', 10, PARAM_INT);

$sitecontext = context_system::instance();

require_login();
if (!is_siteadmin()) {
    return '';
}

$headingfullname    = get_string('headingfullname', 'local_alias');
$managealias        = get_string('managealias', 'local_alias');
$straliass          = get_string('modulenameplural', 'local_alias');
$pluginname         = get_string('pluginname', 'local_alias');

$baseurl = new moodle_url('/local/alias/index.php');

$PAGE->set_context($sitecontext);
$PAGE->set_url('/local/alias/index.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_heading($headingfullname);
$PAGE->set_title($pluginname);
$PAGE->navbar->ignore_active();
$PAGE->navbar->add($managealias, $baseurl);


$stredit            = get_string('edit');
$strdelete          = get_string('delete');
$strdeletecheck     = get_string('deletecheck');
$returnurl = new moodle_url('/local/alias/index.php', array('sort' => $sort, 'dir' => $dir, 'perpage' => $perpage, 'page'=>$page, 'search' => $search));


// Delete alias
if ($delete and confirm_sesskey()) {
    require_capability('local/alias:delete', $sitecontext);

    $alias = $DB->get_record('alias', array('id'=>$delete), '*', MUST_EXIST);

    if ($confirm != md5($delete)) {
        echo $OUTPUT->header();
        echo $OUTPUT->heading(get_string('deletealias', 'local_alias'));

        $optionsyes = array('delete'=>$delete, 'confirm'=>md5($delete), 'sesskey'=>sesskey());
        $deleteurl = new moodle_url($returnurl, $optionsyes);
        $deletebutton = new single_button($deleteurl, get_string('delete'), 'post');

        echo $OUTPUT->confirm(get_string('deletecheckfull', 'local_alias', "'$alias->friendly'"), $deletebutton, $returnurl);
        echo $OUTPUT->footer();
        die;
    } else if (data_submitted()) {
        if (delete_alias($alias)) {
            \core\session\manager::gc();
            redirect($returnurl);
        } else {
            \core\session\manager::gc();
            echo $OUTPUT->header();
            echo $OUTPUT->notification($returnurl, get_string('deletednot', '', $alias->friendly));
        }
    }
}

$aliases            = get_alias_listing($sort, $dir, $page*$perpage, $perpage, $search);
// $aliascount         = get_alias(false);
$aliassearchcount   = get_alias(false, $search, '', '', '', '*');

// Avoid deleting happens on the last page is empty
if($page > 0 and $aliassearchcount > 0 && count($aliases) == 0){
    $page--;
    $aliases = get_alias_listing($sort, $dir, $page*$perpage, $perpage, $search);
}


if (!$aliases) {
    $table = NULL;
} else {
    //Header
    $tableheader = array(
        get_string('friendly', 'local_alias'),
        get_string('destination', 'local_alias'),
        get_string('action')
    );

    // Create Table Fields.
    $table = new html_table();
    $table->head = $tableheader;
    $table->attributes['class'] = 'aliastable generaltable table-sm';
    $table->id = "alias";

    //Adding Data
    foreach($aliases as $key => $alias){
        $buttons = array();
        $row = array ();
        $alias_id = $alias->id;

        // edit button
        if (has_capability('local/alias:edit', $sitecontext)) {
            $url = new moodle_url('/local/alias/edit.php', array('id'=>$alias_id));
            $buttons[] = html_writer::link($url, $OUTPUT->pix_icon('t/edit', $stredit));
        }

        // delete button
        if (has_capability('local/alias:delete', $sitecontext)) {
            $url = new moodle_url($returnurl, array('delete'=>$alias_id, 'sesskey'=>sesskey()));
            $buttons[] = html_writer::link($url, $OUTPUT->pix_icon('t/delete', $strdelete));
        }
        
        $row[] = $alias->friendly;
        $row[] = $alias->destination;
        $row[] = implode(' ', $buttons);
        $table->data[] = $row;
    }
}



echo $OUTPUT->header();
echo $OUTPUT->heading($headingfullname);
echo $OUTPUT->heading(get_string('numberofaliasesavailable','local_alias').' '.$aliassearchcount);

// create the alias filter form
if(empty($search))
    $searchurl = $baseurl;
else 
    $searchurl = $returnurl;
$mform = new alias_add_filter_form($searchurl, array('search'=>$search));
$mform->display();

if (!empty($table)) {
    echo html_writer::start_tag('div', array('class'=>'no-overflow'));
    echo html_writer::table($table);
    echo html_writer::end_tag('div');
    echo $OUTPUT->paging_bar($aliassearchcount, $page, $perpage, $returnurl);
}
else {
    echo $OUTPUT->heading(get_string('noaliassfound','local_alias'));
}
//create button
if (has_capability('local/alias:addinstance', $sitecontext)) {
    $url = new moodle_url('/local/alias/edit.php', array('section' => 'local_alias'));
    echo $OUTPUT->single_button($url, get_string('createnewalias', 'local_alias'));
}

echo $OUTPUT->footer();