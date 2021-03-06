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
 * Prints a particular instance of bitcert
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_bitcert
 * @copyright  2014 John Okely <john@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Either course_module ID, or ...
$b  = optional_param('b', 0, PARAM_INT);  // ...bitcert instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('bitcert', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $bitcert  = $DB->get_record('bitcert', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($b) {
    $bitcert  = $DB->get_record('bitcert', array('id' => $b), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $bitcert->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('bitcert', $bitcert->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

// Print the page header.

$PAGE->set_url('/mod/bitcert/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($bitcert->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);
$PAGE->set_focuscontrol('mod_bitcert_game');
$renderer = $PAGE->get_renderer('mod_bitcert');

// Output starts here.
echo $OUTPUT->header();

if ($bitcert->intro) {
    echo $OUTPUT->box(format_module_intro('bitcert', $bitcert, $cm->id), 'generalbox mod_introbox', 'bitcertintro');
}

echo $OUTPUT->heading($bitcert->name);

echo $renderer->render_cert($bitcert, $context);

// Finish the page.
echo $OUTPUT->footer();
