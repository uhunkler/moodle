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

namespace core_course\output;

use renderable;
use templatable;
use renderer_base;
use stdClass;

/**
 * Class containing data for the course page wrapper
 *
 * @package         course
 * @copyright       2015 eFaktor
 * @author          Urs Hunkler {@link urs.hunkler@unodo.de}
 * @license         http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class course_view_page implements renderable, templatable {

    protected $data;

    /**
     * Construct this renderable.
     */
    public function __construct() {
        $this->data = new stdClass();
    }

    public static function test() {
        echo 'course_view_page test';
    }

    /**
     * Add given data to the data object
     */
    public function add_data($name, $data) {
        $this->data->$name = $data;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        return $this->data;
    }
}
