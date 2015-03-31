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
 * Class for loading/storing competency frameworks from the DB.
 *
 * @package    tool_learningplan
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_learningplan;

use stdClass;
use context_system;

/**
 * Class for doing things with competency frameworks.
 *
 * @copyright  2015 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class competency_api {

    /**
     * Create a competency from a record containing all the data for the class.
     *
     * Requires tool/learningplan:competencymanage capability at the system context.
     *
     * @param stdClass $record Record containing all the data for an instance of the class.
     * @return competency
     */
    public static function create_competency(stdClass $record) {
        // First we do a permissions check.
        require_capability('tool/learningplan:competencymanage', context_system::instance());

        // OK - all set.
        $competency = new competency(0, $record);
        $id = $competency->create();
        return $competency;
    }

    /**
     * Delete a competency by id.
     *
     * Requires tool/learningplan:competencymanage capability at the system context.
     *
     * @param int $id The record to delete. This will delete alot of related data - you better be sure.
     * @return boolean
     */
    public static function delete_competency($id) {
        // First we do a permissions check.
        require_capability('tool/learningplan:competencymanage', context_system::instance());

        // OK - all set.
        $competency = new competency();
        $competency->set_id($id);
        return $competency->delete();
    }

    /**
     * Update the details for a competency.
     *
     * Requires tool/learningplan:competencymanage capability at the system context.
     *
     * @param stdClass $record The new details for the competency. Note - must contain an id that points to the competency to update.
     * @return boolean
     */
    public static function update_competency($record) {
        // First we do a permissions check.
        require_capability('tool/learningplan:competencymanage', context_system::instance());

        // Some things should not be changed in an update - they should use a more specific method.
        $current = new competency($record->id);
        $record->sortorder = $current->get_sortorder();
        $record->parentid = $current->get_parentid();
        $record->competencyframeworkid = $current->get_competencyframeworkid();

        // OK - all set.
        $competency = new competency(0, $record);
        return $competency->update();
    }

    /**
     * Read a the details for a single competency and return a record.
     *
     * Requires tool/learningplan:competencyread capability at the system context.
     *
     * @param int $id The id of the competency to read.
     * @return stdClass
     */
    public static function read_competency($id) {
        // First we do a permissions check.
        $context = context_system::instance();
        if (!has_any_capability(array('tool/learningplan:competencyread', 'tool/learningplan:competencymanage'), $context)) {
             throw new required_capability_exception($context, 'tool/learningplan:competencyread', 'nopermission', '');
        }

        // OK - all set.
        return new competency($id);
    }

    /**
     * Perform a text search based and return all results and their parents.
     *
     * Requires tool/learningplan:competencyread capability at the system context.
     *
     * @param string $textsearch A string to search for.
     * @param int $competencyframeworkid The id of the framework to limit the search.
     * @return array of competencies
     */
    public static function search_competencies($textsearch, $competencyframeworkid) {
        // First we do a permissions check.
        $context = context_system::instance();
        if (!has_any_capability(array('tool/learningplan:competencyread', 'tool/learningplan:competencymanage'), $context)) {
             throw new required_capability_exception($context, 'tool/learningplan:competencyread', 'nopermission', '');
        }

        // OK - all set.
        $competency = new competency();
        return $competency->search($textsearch, $competencyframeworkid);
    }

    /**
     * Perform a search based on the provided filters and return a paginated list of records.
     *
     * Requires tool/learningplan:competencyread capability at the system context.
     *
     * @param array $filters A list of filters to apply to the list.
     * @param string $sort The column to sort on
     * @param string $order ('ASC' or 'DESC')
     * @param int $skip Number of records to skip (pagination)
     * @param int $limit Max of records to return (pagination)
     * @return array of competencies
     */
    public static function list_competencies($filters, $sort, $order, $skip, $limit) {
        // First we do a permissions check.
        $context = context_system::instance();
        if (!has_any_capability(array('tool/learningplan:competencyread', 'tool/learningplan:competencymanage'), $context)) {
             throw new required_capability_exception($context, 'tool/learningplan:competencyread', 'nopermission', '');
        }

        // OK - all set.
        $competency = new competency();
        return $competency->get_records($filters, $sort, $order, $skip, $limit);
    }

    /**
     * Perform a search based on the provided filters and return a paginated list of records.
     *
     * Requires tool/learningplan:competencyread capability at the system context.
     *
     * @param array $filters A list of filters to apply to the list.
     * @return int
     */
    public static function count_competencies($filters) {
        // First we do a permissions check.
        $context = context_system::instance();
        if (!has_any_capability(array('tool/learningplan:competencyread', 'tool/learningplan:competencymanage'), $context)) {
             throw new required_capability_exception($context, 'tool/learningplan:competencyread', 'nopermission', '');
        }

        // OK - all set.
        $competency = new competency();
        return $competency->count_records($filters);
    }

    /**
     * Create a competency framework from a record containing all the data for the class.
     *
     * Requires tool/learningplan:competencymanage capability at the system context.
     *
     * @param stdClass $record Record containing all the data for an instance of the class.
     * @return competency_framework
     */
    public static function create_framework(stdClass $record) {
        // First we do a permissions check.
        require_capability('tool/learningplan:competencymanage', context_system::instance());

        // OK - all set.
        $framework = new competency_framework(0, $record);
        $id = $framework->create();
        return $framework;
    }

    /**
     * Delete a competency framework by id.
     *
     * Requires tool/learningplan:competencymanage capability at the system context.
     *
     * @param int $id The record to delete. This will delete alot of related data - you better be sure.
     * @return boolean
     */
    public static function delete_framework($id) {
        // First we do a permissions check.
        require_capability('tool/learningplan:competencymanage', context_system::instance());

        // OK - all set.
        $framework = new competency_framework();
        $framework->set_id($id);
        return $framework->delete();
    }

    /**
     * Update the details for a competency framework.
     *
     * Requires tool/learningplan:competencymanage capability at the system context.
     *
     * @param stdClass $record The new details for the framework. Note - must contain an id that points to the framework to update.
     * @return boolean
     */
    public static function update_framework($record) {
        // First we do a permissions check.
        require_capability('tool/learningplan:competencymanage', context_system::instance());

        // OK - all set.
        $framework = new competency_framework(0, $record);
        return $framework->update();
    }

    /**
     * Read a the details for a single competency framework and return a record.
     *
     * Requires tool/learningplan:competencyread capability at the system context.
     *
     * @param int $id The id of the framework to read.
     * @return stdClass
     */
    public static function read_framework($id) {
        // First we do a permissions check.
        $context = context_system::instance();
        if (!has_any_capability(array('tool/learningplan:competencyread', 'tool/learningplan:competencymanage'), $context)) {
             throw new required_capability_exception($context, 'tool/learningplan:competencyread', 'nopermission', '');
        }

        // OK - all set.
        return new competency_framework($id);
    }

    /**
     * Move the competency framework up or down in the display list.
     *
     * Requires tool/learningplan:competencymanage capability at the system context.
     *
     * @param int $frameworkidfrom The framework we are moving.
     * @param int $frameworkidto Where we are moving to. If moving down, it will go after this framework,
     *                           If moving up, it will go before this framework.
     * @return boolean
     */
    public static function reorder_framework($frameworkidfrom, $frameworkidto) {
        require_capability('tool/learningplan:competencymanage', context_system::instance());
        $down = true;
        $frameworkfrom = new competency_framework($frameworkidfrom);
        $frameworkto = new competency_framework($frameworkidto);

        $all = self::list_frameworks(array(), 'sortorder', 'ASC', 0, 0);

        if ($frameworkfrom->get_sortorder() > $frameworkto->get_sortorder()) {
            // We are moving down, so put it after the "to" item.
            $down = false;
        }

        foreach ($all as $id => $framework) {
            $sort = $framework->get_sortorder();
            if ($down && $sort >  $frameworkfrom->get_sortorder() && $sort <= $frameworkto->get_sortorder()) {
                $framework->set_sortorder($framework->get_sortorder() - 1);
                $framework->update();
            } else if (!$down && $sort >=  $frameworkto->get_sortorder() && $sort < $frameworkfrom->get_sortorder()) {
                $framework->set_sortorder($framework->get_sortorder() + 1);
                $framework->update();
            }
        }
        $frameworkfrom->set_sortorder($frameworkto->get_sortorder());
        return $frameworkfrom->update();
    }

    /**
     * Perform a search based on the provided filters and return a paginated list of records.
     *
     * Requires tool/learningplan:competencyread capability at the system context.
     *
     * @param array $filters A list of filters to apply to the list.
     * @param string $sort The column to sort on
     * @param string $order ('ASC' or 'DESC')
     * @param int $skip Number of records to skip (pagination)
     * @param int $limit Max of records to return (pagination)
     * @return array of competency_framework
     */
    public static function list_frameworks($filters, $sort, $order, $skip, $limit) {
        // First we do a permissions check.
        $context = context_system::instance();
        if (!has_any_capability(array('tool/learningplan:competencyread', 'tool/learningplan:competencymanage'), $context)) {
             throw new required_capability_exception($context, 'tool/learningplan:competencyread', 'nopermission', '');
        }

        // OK - all set.
        $framework = new competency_framework();
        return $framework->get_records($filters, $sort, $order, $skip, $limit);
    }

    /**
     * Perform a search based on the provided filters and return a paginated list of records.
     *
     * Requires tool/learningplan:competencyread capability at the system context.
     *
     * @param array $filters A list of filters to apply to the list.
     * @return int
     */
    public static function count_frameworks($filters) {
        // First we do a permissions check.
        $context = context_system::instance();
        if (!has_any_capability(array('tool/learningplan:competencyread', 'tool/learningplan:competencymanage'), $context)) {
             throw new required_capability_exception($context, 'tool/learningplan:competencyread', 'nopermission', '');
        }

        // OK - all set.
        $framework = new competency_framework();
        return $framework->count_records($filters);
    }
}
