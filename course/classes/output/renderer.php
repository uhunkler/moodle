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

defined('MOODLE_INTERNAL') || die;

use core_course_renderer;

/**
 * Renderer class for local_mustache_tests
 *
 * @package         local
 * @subpackage      mustache_tests
 * @copyright       2015 eFaktor
 * @author          Urs Hunkler {@link urs.hunkler@unodo.de}
 * @license         http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends core_course_renderer {

    /**
     * Defer to template.
     *
     * @param $page
     *
     * @return string html for the page
     */
    public function render_course_view_page(course_view_page $page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('course/course_view', $data);
    }
}
