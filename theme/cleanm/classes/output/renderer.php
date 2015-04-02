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

namespace theme_cleanm\output;

defined('MOODLE_INTERNAL') || die;

use theme_bootstrapbase_core_renderer;

/**
 * Class containing data for mustache layouts
 *
 * @package         theme_cleanm
 * @copyright       2015 eFaktor
 * @author          Urs Hunkler {@link urs.hunkler@unodo.de}
 * @license         http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends theme_bootstrapbase_core_renderer {
    /**
     * Defer to template.
     *
     * @param $page
     *
     * @return string html for the page
     */
    public function render_embedded_layout(embedded_layout $page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('theme_cleanm/wrapper_layout', $data);
    }

    /**
     * Defer to template.
     *
     * @param $page
     *
     * @return string html for the page
     */
    public function render_maintenance_layout(maintenance_layout $page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('theme_cleanm/wrapper_layout', $data);
    }

    /**
     * Defer to template.
     *
     * @param $page
     *
     * @return string html for the page
     */
    public function render_columns1_layout(columns1_layout $page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('theme_cleanm/wrapper_layout', $data);
    }

    /**
     * Defer to template.
     *
     * @param $page
     *
     * @return string html for the page
     */
    public function render_columns2_layout(columns2_layout $page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('theme_cleanm/wrapper_layout', $data);
    }

    /**
     * Defer to template.
     *
     * @param $page
     *
     * @return string html for the page
     */
    public function render_columns3_layout(columns3_layout $page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('theme_cleanm/wrapper_layout', $data);
    }

    /**
     * Defer to template.
     *
     * @param $page
     *
     * @return string html for the page
     */
    public function render_secure_layout(secure_layout $page) {
        $data = $page->export_for_template($this);
        return parent::render_from_template('theme_cleanm/wrapper_layout', $data);
    }
}
