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
 * This file contains the form add/update a competency framework.
 *
 * @package   tool_learningplan
 * @copyright 2015 Damyon Wiese
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_learningplan\form;

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');

use moodleform;
use tool_learningplan\competency_api;

require_once($CFG->libdir.'/formslib.php');

/**
 * Competency framework form.
 *
 * @package   tool_learningplan
 * @copyright 2015 Damyon Wiese
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class competency extends moodleform {

    /**
     * Define the form - called by parent constructor
     */
    public function definition() {
        $mform = $this->_form;
        $id = $this->_customdata['id'];
        $framework = $this->_customdata['competencyframework'];
        $parent = $this->_customdata['parent'];

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', 0);

        $mform->addElement('hidden', 'parentid');
        $mform->setType('parentid', PARAM_INT);
        if ($parent) {
            $mform->setDefault('parentid', $parent->get_id());
        } else {
            $mform->setDefault('parentid', 0);
        }

        $mform->addElement('hidden', 'competencyframeworkid');
        $mform->setType('competencyframeworkid', PARAM_INT);
        $mform->setDefault('competencyframeworkid', $framework->get_id());

        $mform->addElement('static',
                           'frameworkdesc',
                           get_string('competencyframework', 'tool_learningplan'),
                           s($framework->get_shortname()));
        if ($parent) {
            $mform->addElement('static',
                               'parentdesc',
                               get_string('parentcompetency', 'tool_learningplan'),
                               s($parent->get_shortname()));
        }

        $mform->addElement('text', 'shortname',
                           get_string('shortname', 'tool_learningplan'));
        $mform->setType('shortname', PARAM_TEXT);
        $mform->addRule('shortname', null, 'required', null, 'client');
        $mform->addElement('editor', 'description',
                           get_string('description', 'tool_learningplan'), array('rows'=>4));
        $mform->setType('description', PARAM_TEXT);
        $mform->addElement('text', 'idnumber',
                           get_string('idnumber', 'tool_learningplan'));
        $mform->setType('idnumber', PARAM_TEXT);
        $mform->addElement('selectyesno', 'visible',
                           get_string('visible', 'tool_learningplan'));
        $mform->setDefault('visible', true);
        $mform->addHelpButton('visible', 'visible', 'tool_learningplan');

        $this->add_action_buttons(true, get_string('savechanges', 'tool_learningplan'));

        if (!empty($id)) {
            if (!$this->is_submitted()) {
                $competency = competency_api::read_competency($id);
                $record = $competency->to_record();
                // Massage for editor API.
                $record->description = array('text'=>$record->description, 'format'=>$record->descriptionformat);
                $this->set_data($record);
            }
        }

    }
}
