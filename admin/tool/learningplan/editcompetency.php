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
 * This page lets users to manage site wide competencies.
 *
 * @package    tool_learningplan
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('toollearningplancompetencies');

$title = get_string('competencies', 'tool_learningplan');
$id = optional_param('id', 0, PARAM_INT);
$competencyframeworkid = required_param('competencyframeworkid', PARAM_INT);
$parentid = optional_param('parentid', 0, PARAM_INT);

if (empty($id)) {
    $pagetitle = get_string('addnewcompetency', 'tool_learningplan');
} else {
    $pagetitle = get_string('editcompetency', 'tool_learningplan');
}
// Set up the page.
$params = array('id'=>$id, 'competencyframeworkid'=>$competencyframeworkid, 'parentid'=>$parentid);
$url = new moodle_url("/admin/tool/learningplan/editcompetency.php", $params);
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);
$output = $PAGE->get_renderer('tool_learningplan');

$competencyframework = \tool_learningplan\competency_api::read_framework($competencyframeworkid);
$parent = null;
if ($parentid) {
    $parent = \tool_learningplan\competency_api::read_competency($parentid);
}

$form = new \tool_learningplan\form\competency(null, array('id' => $id, 'competencyframework' => $competencyframework, 'parent' => $parent));

if ($form->is_cancelled()) {
    redirect(new moodle_url('/admin/tool/learningplan/competencies.php', array('competencyframeworkid'=>$competencyframeworkid)));
}

echo $output->header();
echo $output->heading($pagetitle);

$data = $form->get_data();
if ($data) {
    // Save the changes and continue back to the manage page.
    // Massage the editor data.
    $data->descriptionformat = $data->description['format'];
    $data->description = $data->description['text'];
    if (empty($data->id)) {
        // Create new framework.
        require_sesskey();
        \tool_learningplan\competency_api::create_competency($data);
        echo $output->notification(get_string('competencycreated', 'tool_learningplan'), 'notifysuccess');
        echo $output->continue_button(new moodle_url('/admin/tool/learningplan/competencies.php', array('competencyframeworkid'=>$competencyframeworkid)));
    } else {
        require_sesskey();
        \tool_learningplan\competency_api::update_competency($data);
        echo $output->notification(get_string('competencyupdated', 'tool_learningplan'), 'notifysuccess');
        echo $output->continue_button(new moodle_url('/admin/tool/learningplan/competencies.php', array('competencyframeworkid'=>$competencyframeworkid)));
    }
} else {
    $form->display();
}


echo $output->footer();
