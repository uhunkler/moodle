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

use renderable;
use templatable;
use renderer_base;
use stdClass;

/**
 * Class containing data for local_mustache_tests index page
 *
 * @package         local
 * @subpackage      mustache_tests
 * @copyright       2015 eFaktor
 * @author          Urs Hunkler {@link urs.hunkler@unodo.de}
 * @license         http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class base_layout implements renderable, templatable {

    protected $contextcourse = null;
    protected $doctype = null;

    /**
     * Construct this renderable.
     */
    public function __construct($contextcourse, $doctype) {
        $this->contextcourse = $contextcourse;
        $this->doctype = $doctype;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output) {
        global $CFG, $SITE, $PAGE;

        $data = new stdClass();

        // Add the page data from the theme settings
        $data->html_navbarclass = '';
        if (!empty($PAGE->theme->settings->invert)) {
            $data->html_navbarclass = ' navbar-inverse';
        }

        if (!empty($PAGE->theme->settings->logo)) {
            $data->html_heading = '<div class="logo"></div>';
        } else {
            $data->html_heading = $output->page_heading();
        }

        $data->html_footnote = '';
        if (!empty($PAGE->theme->settings->footnote)) {
            $data->html_footnote = '<div class="footnote text-center">' .
                format_text($PAGE->theme->settings->footnote) . '</div>';
        }

        // Add the other common page data
        $data->doctype = $this->doctype;
        $data->htmlattributes = $output->htmlattributes();
        $data->page_title = $output->page_title();
        $data->favicon = $output->favicon();
        $data->standard_head_html = $output->standard_head_html();
        $data->standard_top_of_body_html = $output->standard_top_of_body_html();
        $data->wwwroot = $CFG->wwwroot;
        $data->shortname = format_string($SITE->shortname, true,
            array('context' => $this->contextcourse));
        $data->user_menu = $output->user_menu();
        $data->custom_menu = $output->custom_menu();
        $data->page_heading_menu = $output->page_heading_menu();
        $data->navbar = $output->navbar();
        $data->page_heading_button = $output->page_heading_button();
        $data->course_header = $output->course_header();
        $data->course_content_header = $output->course_content_header();
        $data->main_content = $output->main_content();
        $data->course_content_footer = $output->course_content_footer();
        $data->course_footer = $output->course_footer();
        $data->page_doc_link = $output->page_doc_link();
        $data->login_info = $output->login_info();
        $data->home_link = $output->home_link();
        $data->standard_footer_html = $output->standard_footer_html();
        $data->standard_end_of_body_html = $output->standard_end_of_body_html();

        return $data;
    }
}
