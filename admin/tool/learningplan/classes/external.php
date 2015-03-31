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
 * This is the external API for this tool.
 *
 * @package    tool_learningplan
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_learningplan;

require_once("$CFG->libdir/externallib.php");

use external_api;
use external_function_parameters;
use external_value;
use external_format_value;
use external_single_structure;
use external_multiple_structure;
use invalid_parameter_exception;

/**
 * This is the external API for this tool.
 *
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class external extends external_api {

    /**
     * Returns description of a generic list() parameters.
     *
     * @return external_function_parameters
     */
    protected static function list_parameters_structure() {
        $filters = new external_multiple_structure(new external_single_structure(
            array(
                'column' => new external_value(PARAM_ALPHANUMEXT, 'Column name to filter by'),
                'value' => new external_value(PARAM_TEXT, 'Value to filter by. Must be exact match')
            )
        ));
        $sort = new external_value(
            PARAM_ALPHANUMEXT,
            'Column to sort by.',
            VALUE_DEFAULT,
            ''
        );
        $order = new external_value(
            PARAM_ALPHA,
            'Sort direction. Should be either ASC or DESC',
            VALUE_DEFAULT,
            ''
        );
        $skip = new external_value(
            PARAM_INT,
            'Skip this number of records before returning results',
            VALUE_DEFAULT,
            0
        );
        $limit = new external_value(
            PARAM_INT,
            'Return this number of records at most.',
            VALUE_DEFAULT,
            0
        );

        $params = array(
            'filters' => $filters,
            'sort' => $sort,
            'order' => $order,
            'skip' => $skip,
            'limit' => $limit
        );
        return new external_function_parameters($params);
    }

    /**
     * Returns description of a generic count_x() parameters.
     *
     * @return external_function_parameters
     */
    public static function count_parameters_structure() {
        $filters = new external_multiple_structure(new external_single_structure(
            array(
                'column' => new external_value(PARAM_ALPHANUMEXT, 'Column name to filter by'),
                'value' => new external_value(PARAM_TEXT, 'Value to filter by. Must be exact match')
            )
        ));

        $params = array(
            'filters' => $filters,
        );
        return new external_function_parameters($params);
    }

    /**
     * Returns the external structure of a full competency_framework record.
     *
     * @return external_single_structure
     */
    protected static function get_competency_framework_external_structure() {
        $id = new external_value(
            PARAM_INT,
            'Database record id'
        );
        $shortname = new external_value(
            PARAM_TEXT,
            'Short name for the competency framework'
        );
        $idnumber = new external_value(
            PARAM_TEXT,
            'If provided, must be a unique string to identify this competency framework'
        );
        $description = new external_value(
            PARAM_RAW,
            'Description for the framework'
        );
        $descriptionformat = new external_format_value(
            'Description format for the framework'
        );
        $descriptionformatted = new external_value(
            PARAM_RAW,
            'Description that has been formatted for display'
        );
        $visible = new external_value(
            PARAM_BOOL,
            'Is this framework visible?'
        );
        $sortorder = new external_value(
            PARAM_INT,
            'Relative sort order of this framework'
        );
        $timecreated = new external_value(
            PARAM_INT,
            'Timestamp this record was created'
        );
        $timemodified = new external_value(
            PARAM_INT,
            'Timestamp this record was modified'
        );
        $usermodified = new external_value(
            PARAM_INT,
            'User who modified this record last'
        );

        $returns = array(
            'id' => $id,
            'shortname' => $shortname,
            'idnumber' => $idnumber,
            'description' => $description,
            'descriptionformat' => $descriptionformat,
            'descriptionformatted' => $descriptionformatted,
            'visible' => $visible,
            'sortorder' => $sortorder,
            'timecreated' => $timecreated,
            'timemodified' => $timemodified,
            'usermodified' => $usermodified,
        );
        return new external_single_structure($returns);
    }

    /**
     * Returns description of create_competency_framework() parameters.
     *
     * @return external_function_parameters
     */
    public static function create_competency_framework_parameters() {
        $shortname = new external_value(
            PARAM_TEXT,
            'Short name for the competency framework.',
            VALUE_REQUIRED
        );
        $idnumber = new external_value(
            PARAM_TEXT,
            'If provided, must be a unique string to identify this competency framework.',
            VALUE_DEFAULT,
            ''
        );
        $description = new external_value(
            PARAM_RAW,
            'Optional description for the framework',
            VALUE_DEFAULT,
            ''
        );
        $descriptionformat = new external_format_value(
            'Optional description format for the framework',
            VALUE_DEFAULT,
            FORMAT_HTML
        );
        $visible = new external_value(
            PARAM_BOOL,
            'Is this framework visible?',
            VALUE_DEFAULT,
            true
        );

        $params = array(
            'shortname' => $shortname,
            'idnumber' => $idnumber,
            'description' => $description,
            'descriptionformat' => $descriptionformat,
            'visible' => $visible,
        );
        return new external_function_parameters($params);
    }

    /**
     * Create a new competency framework
     *
     * @param string $component The component that holds the template.
     * @param string $templatename The name of the template.
     * @return string the template
     */
    public static function create_competency_framework($shortname, $idnumber, $description, $descriptionformat, $visible) {
        $params = self::validate_parameters(self::create_competency_framework_parameters(),
                                            array(
                                                'shortname' => $shortname,
                                                'idnumber' => $idnumber,
                                                'description' => $description,
                                                'descriptionformat' => $descriptionformat,
                                                'visible' => $visible,
                                            ));

        $params = (object) $params;

        $result = competency_api::create_framework($params);
        return $result->to_record();
    }

    /**
     * Returns description of create_competency_framework() result value.
     *
     * @return external_description
     */
    public static function create_competency_framework_returns() {
        return self::get_competency_framework_external_structure();
    }

    /**
     * Returns description of read_competency_framework() parameters.
     *
     * @return external_function_parameters
     */
    public static function read_competency_framework_parameters() {
        $id = new external_value(
            PARAM_INT,
            'Data base record id for the framework',
            VALUE_REQUIRED
        );

        $params = array(
            'id' => $id,
        );
        return new external_function_parameters($params);
    }

    /**
     * Read a competency framework by id.
     *
     * @param int $id The id of the framework.
     * @return stdClass
     */
    public static function read_competency_framework($id) {
        $params = self::validate_parameters(self::read_competency_framework_parameters(),
                                            array(
                                                'id' => $id,
                                            ));

        $result = competency_api::read_framework($params['id']);
        return $result->to_record();
    }

    /**
     * Returns description of read_competency_framework() result value.
     *
     * @return external_description
     */
    public static function read_competency_framework_returns() {
        return self::get_competency_framework_external_structure();
    }

    /**
     * Returns description of delete_competency_framework() parameters.
     *
     * @return external_function_parameters
     */
    public static function delete_competency_framework_parameters() {
        $id = new external_value(
            PARAM_INT,
            'Data base record id for the framework',
            VALUE_REQUIRED
        );

        $params = array(
            'id' => $id,
        );
        return new external_function_parameters($params);
    }

    /**
     * Delete a competency framework
     *
     * @param int $id The competency framework id
     * @return boolean
     */
    public static function delete_competency_framework($id) {
        $params = self::validate_parameters(self::delete_competency_framework_parameters(),
                                            array(
                                                'id' => $id,
                                            ));

        return competency_api::delete_framework($params['id']);
    }

    /**
     * Returns description of delete_competency_framework() result value.
     *
     * @return external_description
     */
    public static function delete_competency_framework_returns() {
        return new external_value(PARAM_BOOL, 'True if the delete was successful');
    }

    /**
     * Returns description of update_competency_framework() parameters.
     *
     * @return external_function_parameters
     */
    public static function update_competency_framework_parameters() {
        $id = new external_value(
            PARAM_INT,
            'Data base record id for the framework',
            VALUE_REQUIRED
        );
        $shortname = new external_value(
            PARAM_TEXT,
            'Short name for the competency framework.',
            VALUE_REQUIRED
        );
        $idnumber = new external_value(
            PARAM_TEXT,
            'If provided, must be a unique string to identify this competency framework.',
            VALUE_REQUIRED
        );
        $description = new external_value(
            PARAM_RAW,
            'Description for the framework',
            VALUE_REQUIRED
        );
        $descriptionformat = new external_format_value(
            'Description format for the framework',
            VALUE_REQUIRED
        );
        $visible = new external_value(
            PARAM_BOOL,
            'Is this framework visible?',
            VALUE_REQUIRED
        );

        $params = array(
            'id' => $id,
            'shortname' => $shortname,
            'idnumber' => $idnumber,
            'description' => $description,
            'descriptionformat' => $descriptionformat,
            'visible' => $visible,
        );
        return new external_function_parameters($params);
    }

    /**
     * Update an existing competency framework
     *
     * @param int $id The competency framework id
     * @param string $shortname
     * @param string $idnumber
     * @param string $description
     * @param int $descriptionformat
     * @param boolean $visible
     * @return boolean
     */
    public static function update_competency_framework($id,
                                                       $shortname,
                                                       $idnumber,
                                                       $description,
                                                       $descriptionformat,
                                                       $visible) {

        $params = self::validate_parameters(self::update_competency_framework_parameters(),
                                            array(
                                                'id' => $id,
                                                'shortname' => $shortname,
                                                'idnumber' => $idnumber,
                                                'description' => $description,
                                                'descriptionformat' => $descriptionformat,
                                                'visible' => $visible
                                            ));
        $params = (object) $params;

        return competency_api::update_framework($params);
    }

    /**
     * Returns description of update_competency_framework() result value.
     *
     * @return external_description
     */
    public static function update_competency_framework_returns() {
        return new external_value(PARAM_BOOL, 'True if the update was successful');
    }

    /**
     * Returns description of list_competency_frameworks() parameters.
     *
     * @return external_function_parameters
     */
    public static function list_competency_frameworks_parameters() {
        return self::list_parameters_structure();
    }

    /**
     * List the existing competency frameworks
     *
     * @return boolean
     */
    public static function list_competency_frameworks($filters, $sort, $order, $skip, $limit) {
        $params = self::validate_parameters(self::list_competency_frameworks_parameters(),
                                            array(
                                                'filters' => $filters,
                                                'sort' => $sort,
                                                'order' => $order,
                                                'skip' => $skip,
                                                'limit' => $limit
                                            ));

        if ($params['order'] !== '' && $params['order'] !== 'ASC' && $params['order'] !== 'DESC') {
            throw new invalid_parameter_exception('Invalid order param. Must be ASC, DESC or empty.');
        }

        $safefilters = array();
        $validcolumns = array('id', 'shortname', 'description', 'sortorder', 'idnumber', 'visible');
        foreach ($params['filters'] as $filter) {
            if (!in_array($filter->column, $validcolumns)) {
                throw new invalid_parameter_exception('Filter column was invalid');
            }
            $safefilters[$filter->column] = $filter->value;
        }

        $results = competency_api::list_frameworks($safefilters,
                                               $params['sort'],
                                               $params['order'],
                                               $params['skip'],
                                               $params['limit']);
        $records = array();
        foreach ($results as $result) {
            $record = $result->to_record();
            array_push($records, $record);
        }
        return $records;
    }

    /**
     * Returns description of list_competency_frameworks() result value.
     *
     * @return external_description
     */
    public static function list_competency_frameworks_returns() {
        return new external_multiple_structure(self::get_competency_framework_external_structure());
    }

    /**
     * Returns description of count_competency_frameworks() parameters.
     *
     * @return external_function_parameters
     */
    public static function count_competency_frameworks_parameters() {
        $filters = new external_multiple_structure(new external_single_structure(
            array(
                'column' => new external_value(PARAM_ALPHANUMEXT, 'Column name to filter by'),
                'value' => new external_value(PARAM_TEXT, 'Value to filter by. Must be exact match')
            )
        ));

        $params = array(
            'filters' => $filters,
        );
        return new external_function_parameters($params);
    }

    /**
     * Count the existing competency frameworks
     *
     * @return boolean
     */
    public static function count_competency_frameworks($filters) {
        $params = self::validate_parameters(self::count_competency_frameworks_parameters(),
                                            array(
                                                'filters' => $filters
                                            ));

        $safefilters = array();
        $validcolumns = array('id', 'shortname', 'description', 'sortorder', 'idnumber', 'visible');
        foreach ($params['filters'] as $filter) {
            if (!in_array($filter->column, $validcolumns)) {
                throw new invalid_parameter_exception('Filter column was invalid');
            }
            $safefilters[$filter->column] = $filter->value;
        }

        return competency_api::count_frameworks($safefilters);
    }

    /**
     * Returns description of count_competency_frameworks() result value.
     *
     * @return external_description
     */
    public static function count_competency_frameworks_returns() {
        return new external_value(PARAM_INT, 'The number of competency frameworks found.');
    }

    /**
     * Returns description of data_for_competency_frameworks_manage_page() parameters.
     *
     * @return external_function_parameters
     */
    public static function data_for_competency_frameworks_manage_page_parameters() {
        // No params required.
        $params = array();
        return new external_function_parameters($params);
    }

    /**
     * Loads the data required to render the competency_frameworks_manage_page template.
     *
     * @return boolean
     */
    public static function data_for_competency_frameworks_manage_page() {
        global $PAGE;

        $renderable = new \tool_learningplan\output\manage_competency_frameworks_page();
        $renderer = $PAGE->get_renderer('tool_learningplan');

        $data = $renderable->export_for_template($renderer);

        return $data;
    }

    /**
     * Returns description of data_for_competency_frameworks_manage_page() result value.
     *
     * @return external_description
     */
    public static function data_for_competency_frameworks_manage_page_returns() {
        return new external_single_structure(array (
            'canmanage' => new external_value(PARAM_BOOL, 'True if this user has permission to manage competency frameworks'),
            'competencyframeworks' => new external_multiple_structure(
                self::get_competency_framework_external_structure()
            ),
            'pluginbaseurl' => new external_value(PARAM_LOCALURL, 'Url to the tool_learningplan plugin folder on this Moodle site'),
            'navigation' => new external_multiple_structure(
                new external_value(PARAM_RAW, 'HTML for a navigation item that should be on this page')
            )
        ));

    }

    /**
     * Move a competency framework and adjust sort order of all affected.
     *
     * @return external_function_parameters
     */
    public static function reorder_competency_framework_parameters() {
        $from = new external_value(
            PARAM_INT,
            'Framework id to reorder.',
            VALUE_REQUIRED
        );
        $to = new external_value(
            PARAM_INT,
            'Framework id to move to.',
            VALUE_REQUIRED
        );
        $params = array(
            'from' => $from,
            'to' => $to
        );
        return new external_function_parameters($params);
    }

    /**
     * Move this competency_framework to a new relative sort order.
     *
     * @param int $from
     * @param int $to
     * @return boolean
     */
    public static function reorder_competency_framework($from, $to) {
        $params = self::validate_parameters(self::reorder_competency_framework_parameters(),
                                            array(
                                                'from' => $from,
                                                'to' => $to
                                            ));
        return competency_api::reorder_framework($params['from'], $params['to']);
    }

    /**
     * Returns description of reorder_competency_framework return value.
     *
     * @return external_description
     */
    public static function reorder_competency_framework_returns() {
        return new external_value(PARAM_BOOL, 'True if this framework was moved.');
    }

    /**
     * Returns the external structure of a full competency record.
     *
     * @return external_single_structure
     */
    protected static function get_competency_external_structure() {
        $id = new external_value(
            PARAM_INT,
            'Database record id'
        );
        $shortname = new external_value(
            PARAM_TEXT,
            'Short name for the competency'
        );
        $idnumber = new external_value(
            PARAM_TEXT,
            'If provided, must be a unique string to identify this competency'
        );
        $description = new external_value(
            PARAM_RAW,
            'Description for the competency'
        );
        $descriptionformat = new external_format_value(
            'Description format for the competency'
        );
        $descriptionformatted = new external_value(
            PARAM_RAW,
            'Description formatted for display'
        );
        $visible = new external_value(
            PARAM_BOOL,
            'Is this competency visible?'
        );
        $sortorder = new external_value(
            PARAM_INT,
            'Relative sort order of this competency'
        );
        $competencyframeworkid = new external_value(
            PARAM_INT,
            'Competency framework id that this competency belongs to'
        );
        $parentid = new external_value(
            PARAM_INT,
            'Parent competency id. 0 means top level node.'
        );
        $timecreated = new external_value(
            PARAM_INT,
            'Timestamp this record was created'
        );
        $timemodified = new external_value(
            PARAM_INT,
            'Timestamp this record was modified'
        );
        $usermodified = new external_value(
            PARAM_INT,
            'User who modified this record last'
        );
        $parentid = new external_value(
            PARAM_INT,
            'The id of the parent competency.'
        );
        $path = new external_value(
            PARAM_RAW,
            'The path of parents all the way to the root of the tree.'
        );

        $returns = array(
            'id' => $id,
            'shortname' => $shortname,
            'idnumber' => $idnumber,
            'description' => $description,
            'descriptionformat' => $descriptionformat,
            'descriptionformatted' => $descriptionformatted,
            'visible' => $visible,
            'sortorder' => $sortorder,
            'timecreated' => $timecreated,
            'timemodified' => $timemodified,
            'usermodified' => $usermodified,
            'parentid' => $parentid,
            'competencyframeworkid' => $competencyframeworkid,
            'path' => $path,
        );
        return new external_single_structure($returns);
    }

    /**
     * Returns description of create_competency() parameters.
     *
     * @return external_function_parameters
     */
    public static function create_competency_parameters() {
        $shortname = new external_value(
            PARAM_TEXT,
            'Short name for the competency framework.',
            VALUE_REQUIRED
        );
        $idnumber = new external_value(
            PARAM_TEXT,
            'If provided, must be a unique string to identify this competency framework.',
            VALUE_DEFAULT,
            ''
        );
        $description = new external_value(
            PARAM_RAW,
            'Optional description for the framework',
            VALUE_DEFAULT,
            ''
        );
        $descriptionformat = new external_format_value(
            'Optional description format for the framework',
            VALUE_DEFAULT,
            FORMAT_HTML
        );
        $visible = new external_value(
            PARAM_BOOL,
            'Is this competency visible?',
            VALUE_DEFAULT,
            true
        );
        $competencyframeworkid = new external_value(
            PARAM_INT,
            'Which competency framework does this competency belong to?'
        );
        $parentid = new external_value(
            PARAM_INT,
            'The parent competency. 0 means this is a top level competency.'
        );

        $params = array(
            'shortname' => $shortname,
            'idnumber' => $idnumber,
            'description' => $description,
            'descriptionformat' => $descriptionformat,
            'visible' => $visible,
            'competencyframeworkid' => $competencyframeworkid,
            'parentid' => $parentid,
        );
        return new external_function_parameters($params);
    }

    /**
     * Create a new competency framework
     *
     * @param string $shortname
     * @param string $idnumber
     * @param string $description
     * @param int $descriptionformat
     * @param bool $visible
     * @param int $competencyframeworkid
     * @param int $parentid
     * @return string the template
     */
    public static function create_competency($shortname,
                                             $idnumber,
                                             $description,
                                             $descriptionformat,
                                             $visible,
                                             $competencyframeworkid,
                                             $parentid) {
        $params = self::validate_parameters(self::create_competency_parameters(),
                                            array(
                                                'shortname' => $shortname,
                                                'idnumber' => $idnumber,
                                                'description' => $description,
                                                'descriptionformat' => $descriptionformat,
                                                'visible' => $visible,
                                                'competencyframeworkid' => $competencyframeworkid,
                                                'parentid' => $parentid,
                                            ));

        $params = (object) $params;

        $result = competency_api::create_competency($params);
        return $result->to_record();
    }

    /**
     * Returns description of create_competency() result value.
     *
     * @return external_description
     */
    public static function create_competency_returns() {
        return self::get_competency_external_structure();
    }

    /**
     * Returns description of read_competency() parameters.
     *
     * @return external_function_parameters
     */
    public static function read_competency_parameters() {
        $id = new external_value(
            PARAM_INT,
            'Data base record id for the competency',
            VALUE_REQUIRED
        );

        $params = array(
            'id' => $id,
        );
        return new external_function_parameters($params);
    }

    /**
     * Read a competency by id.
     *
     * @param int $id The id of the competency
     * @return stdClass
     */
    public static function read_competency($id) {
        $params = self::validate_parameters(self::read_competency_parameters(),
                                            array(
                                                'id' => $id,
                                            ));

        $result = competency_api::read_competency($params['id']);
        return $result->to_record();
    }

    /**
     * Returns description of read_competency() result value.
     *
     * @return external_description
     */
    public static function read_competency_returns() {
        return self::get_competency_external_structure();
    }

    /**
     * Returns description of delete_competency() parameters.
     *
     * @return external_function_parameters
     */
    public static function delete_competency_parameters() {
        $id = new external_value(
            PARAM_INT,
            'Data base record id for the competency',
            VALUE_REQUIRED
        );

        $params = array(
            'id' => $id,
        );
        return new external_function_parameters($params);
    }

    /**
     * Delete a competency
     *
     * @param int $id The competency id
     * @return boolean
     */
    public static function delete_competency($id) {
        $params = self::validate_parameters(self::delete_competency_parameters(),
                                            array(
                                                'id' => $id,
                                            ));

        return competency_api::delete_competency($params['id']);
    }

    /**
     * Returns description of delete_competency() result value.
     *
     * @return external_description
     */
    public static function delete_competency_returns() {
        return new external_value(PARAM_BOOL, 'True if the delete was successful');
    }

    /**
     * Returns description of update_competency() parameters.
     *
     * @return external_function_parameters
     */
    public static function update_competency_parameters() {
        $id = new external_value(
            PARAM_INT,
            'Data base record id for the competency',
            VALUE_REQUIRED
        );
        $shortname = new external_value(
            PARAM_TEXT,
            'Short name for the competency.',
            VALUE_REQUIRED
        );
        $idnumber = new external_value(
            PARAM_TEXT,
            'If provided, must be a unique string to identify this competency.',
            VALUE_REQUIRED
        );
        $description = new external_value(
            PARAM_RAW,
            'Description for the framework',
            VALUE_REQUIRED
        );
        $descriptionformat = new external_format_value(
            'Description format for the framework',
            VALUE_REQUIRED
        );
        $visible = new external_value(
            PARAM_BOOL,
            'Is this framework visible?',
            VALUE_REQUIRED
        );

        $params = array(
            'id' => $id,
            'shortname' => $shortname,
            'idnumber' => $idnumber,
            'description' => $description,
            'descriptionformat' => $descriptionformat,
            'visible' => $visible,
        );
        return new external_function_parameters($params);
    }

    /**
     * Update an existing competency
     *
     * @param int $id The competency id
     * @param string $shortname
     * @param string $idnumber
     * @param string $description
     * @param int $descriptionformat
     * @param boolean $visible
     * @return boolean
     */
    public static function update_competency($id,
                                             $shortname,
                                             $idnumber,
                                             $description,
                                             $descriptionformat,
                                             $visible) {

        $params = self::validate_parameters(self::update_competency_parameters(),
                                            array(
                                                'id' => $id,
                                                'shortname' => $shortname,
                                                'idnumber' => $idnumber,
                                                'description' => $description,
                                                'descriptionformat' => $descriptionformat,
                                                'visible' => $visible
                                            ));
        $params = (object) $params;

        return competency_api::update_competency($params);
    }

    /**
     * Returns description of update_competency_framework() result value.
     *
     * @return external_description
     */
    public static function update_competency_returns() {
        return new external_value(PARAM_BOOL, 'True if the update was successful');
    }

    /**
     * Returns description of list_competencies() parameters.
     *
     * @return external_function_parameters
     */
    public static function list_competencies_parameters() {
        return self::list_parameters_structure();
    }

    /**
     * List the existing competency frameworks
     *
     * @return boolean
     */
    public static function list_competencies($filters, $sort, $order, $skip, $limit) {
        $params = self::validate_parameters(self::list_competencies_parameters(),
                                            array(
                                                'filters' => $filters,
                                                'sort' => $sort,
                                                'order' => $order,
                                                'skip' => $skip,
                                                'limit' => $limit
                                            ));

        if ($params['order'] !== '' && $params['order'] !== 'ASC' && $params['order'] !== 'DESC') {
            throw new invalid_parameter_exception('Invalid order param. Must be ASC, DESC or empty.');
        }

        $safefilters = array();
        $validcolumns = array('id', 'shortname', 'description', 'sortorder', 'idnumber', 'visible', 'parentid', 'competencyframeworkid');
        foreach ($params['filters'] as $filter) {
            if (!in_array($filter->column, $validcolumns)) {
                throw new invalid_parameter_exception('Filter column was invalid');
            }
            $safefilters[$filter->column] = $filter->value;
        }

        $results = competency_api::list_competencies($safefilters,
                                                     $params['sort'],
                                                     $params['order'],
                                                     $params['skip'],
                                                     $params['limit']);
        $records = array();
        foreach ($results as $result) {
            $record = $result->to_record();
            array_push($records, $record);
        }
        return $records;
    }

    /**
     * Returns description of list_competencies() result value.
     *
     * @return external_description
     */
    public static function list_competencies_returns() {
        return new external_multiple_structure(self::get_competency_external_structure());
    }

    /**
     * Returns description of search_competencies() parameters.
     *
     * @return external_function_parameters
     */
    public static function search_competencies_parameters() {
        $searchtext = new external_value(
            PARAM_RAW,
            'Text to search for',
            VALUE_REQUIRED
        );
        $frameworkid = new external_value(
            PARAM_INT,
            'Competency framework id',
            VALUE_REQUIRED
        );

        $params = array(
            'searchtext' => $searchtext,
            'competencyframeworkid' => $frameworkid
        );
        return new external_function_parameters($params);
    }

    /**
     * List the existing competency frameworks
     *
     * @return boolean
     */
    public static function search_competencies($searchtext, $competencyframeworkid) {
        $params = self::validate_parameters(self::search_competencies_parameters(),
                                            array(
                                                'searchtext' => $searchtext,
                                                'competencyframeworkid' => $competencyframeworkid
                                            ));

        $results = competency_api::search_competencies($searchtext, $competencyframeworkid);
        $records = array();
        foreach ($results as $result) {
            $record = $result->to_record();
            array_push($records, $record);
        }
        return $records;
    }

    /**
     * Returns description of search_competencies() result value.
     *
     * @return external_description
     */
    public static function search_competencies_returns() {
        return new external_multiple_structure(self::get_competency_external_structure());
    }


    /**
     * Returns description of count_competencies() parameters.
     *
     * @return external_function_parameters
     */
    public static function count_competencies_parameters() {
        return self::count_parameters_structure();
    }

    /**
     * Count the existing competency frameworks
     *
     * @return boolean
     */
    public static function count_competencies($filters) {
        $params = self::validate_parameters(self::count_competencies_parameters(),
                                            array(
                                                'filters' => $filters
                                            ));

        $safefilters = array();
        $validcolumns = array('id', 'shortname', 'description', 'sortorder', 'idnumber', 'visible', 'parentid', 'competencyframeworkid');
        foreach ($params['filters'] as $filter) {
            if (!in_array($filter->column, $validcolumns)) {
                throw new invalid_parameter_exception('Filter column was invalid');
            }
            $safefilters[$filter->column] = $filter->value;
        }

        return competency_api::count_competencies($safefilters);
    }

    /**
     * Returns description of count_competencies() result value.
     *
     * @return external_description
     */
    public static function count_competencies_returns() {
        return new external_value(PARAM_INT, 'The number of competencies found.');
    }

    /**
     * Returns description of data_for_competencies_manage_page() parameters.
     *
     * @return external_function_parameters
     */
    public static function data_for_competencies_manage_page_parameters() {
        $competencyframeworkid = new external_value(
            PARAM_INT,
            'The competency framework id',
            VALUE_REQUIRED
        );
        $params = array(
            'competencyframeworkid' => $competencyframeworkid
        );
        return new external_function_parameters($params);
    }

    /**
     * Loads the data required to render the competencies_manage_page template.
     *
     * @return boolean
     */
    public static function data_for_competencies_manage_page($competencyframeworkid) {
        global $PAGE;
        $params = self::validate_parameters(self::data_for_competencies_manage_page_parameters(),
                                            array(
                                                'competencyframeworkid' => $competencyframeworkid
                                            ));

        $framework = new \tool_learningplan\competency_framework($params['competencyframeworkid']);

        $renderable = new \tool_learningplan\output\manage_competencies_page($framework);
        $renderer = $PAGE->get_renderer('tool_learningplan');

        $data = $renderable->export_for_template($renderer);

        return $data;
    }

    /**
     * Returns description of data_for_competencies_manage_page() result value.
     *
     * @return external_description
     */
    public static function data_for_competencies_manage_page_returns() {
        return new external_single_structure(array (
            'framework' => self::get_competency_framework_external_structure(),
            'canmanage' => new external_value(PARAM_BOOL, 'True if this user has permission to manage competency frameworks'),
            'competencies' => new external_multiple_structure(
                self::get_competency_external_structure()
            )
        ));

    }

}
