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
 * Learning plan webservice functions.
 *
 *
 * @package    tool_learningplan
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$functions = array(

    // Learning plan related functions.

    'tool_learningplan_create_competency_framework' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'create_competency_framework',
        'classpath'   => '',
        'description' => 'Creates new competency frameworks.',
        'type'        => 'write',
        'capabilities'=> 'tool/learningplan:competencymanage',
    ),
    'tool_learningplan_read_competency_framework' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'read_competency_framework',
        'classpath'   => '',
        'description' => 'Load a summary of a competency framework.',
        'type'        => 'read',
        'capabilities'=> 'tool/learningplan:competencyview',
    ),
    'tool_learningplan_delete_competency_framework' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'delete_competency_framework',
        'classpath'   => '',
        'description' => 'Delete a competency framework.',
        'type'        => 'write',
        'capabilities'=> 'tool/learningplan:competencymanage',
    ),
    'tool_learningplan_update_competency_framework' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'update_competency_framework',
        'classpath'   => '',
        'description' => 'Update a competency framework.',
        'type'        => 'write',
        'capabilities'=> 'tool/learningplan:competencymanage',
    ),
    'tool_learningplan_list_competency_frameworks' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'list_competency_frameworks',
        'classpath'   => '',
        'description' => 'Load a list of a competency frameworks.',
        'type'        => 'read',
        'capabilities'=> 'tool/learningplan:competencyview',
    ),
    'tool_learningplan_count_competency_frameworks' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'count_competency_frameworks',
        'classpath'   => '',
        'description' => 'Count a list of a competency frameworks.',
        'type'        => 'read',
        'capabilities'=> 'tool/learningplan:competencyview',
    ),
    'tool_learningplan_data_for_competency_frameworks_manage_page' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'data_for_competency_frameworks_manage_page',
        'classpath'   => '',
        'description' => 'Load the data for the competency frameworks manage page template',
        'type'        => 'read',
        'capabilities'=> 'tool/learningplan:competencyview',
    ),
    'tool_learningplan_reorder_competency_framework' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'reorder_competency_framework',
        'classpath'   => '',
        'description' => 'Move a competency framework to a new relative sort order.',
        'type'        => 'write',
        'capabilities'=> 'tool/learningplan:competencymanage',
    ),
    'tool_learningplan_create_competency' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'create_competency',
        'classpath'   => '',
        'description' => 'Creates new competencies.',
        'type'        => 'write',
        'capabilities'=> 'tool/learningplan:competencymanage',
    ),
    'tool_learningplan_read_competency' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'read_competency',
        'classpath'   => '',
        'description' => 'Load a summary of a competency.',
        'type'        => 'read',
        'capabilities'=> 'tool/learningplan:competencyview',
    ),
    'tool_learningplan_delete_competency' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'delete_competency',
        'classpath'   => '',
        'description' => 'Delete a competency.',
        'type'        => 'write',
        'capabilities'=> 'tool/learningplan:competencymanage',
    ),
    'tool_learningplan_update_competency' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'update_competency',
        'classpath'   => '',
        'description' => 'Update a competency.',
        'type'        => 'write',
        'capabilities'=> 'tool/learningplan:competencymanage',
    ),
    'tool_learningplan_list_competencies' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'list_competencies',
        'classpath'   => '',
        'description' => 'Load a list of a competencies.',
        'type'        => 'read',
        'capabilities'=> 'tool/learningplan:competencyview',
    ),
    'tool_learningplan_count_competencies' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'count_competencies',
        'classpath'   => '',
        'description' => 'Count a list of a competencies.',
        'type'        => 'read',
        'capabilities'=> 'tool/learningplan:competencyview',
    ),
    'tool_learningplan_search_competencies' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'search_competencies',
        'classpath'   => '',
        'description' => 'Search a list of a competencies.',
        'type'        => 'read',
        'capabilities'=> 'tool/learningplan:competencyview',
    ),
    'tool_learningplan_data_for_competencies_manage_page' => array(
        'classname'   => 'tool_learningplan\external',
        'methodname'  => 'data_for_competencies_manage_page',
        'classpath'   => '',
        'description' => 'Load the data for the competencies manage page template',
        'type'        => 'read',
        'capabilities'=> 'tool/learningplan:competencyview',
    ),

);

