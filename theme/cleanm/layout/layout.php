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
 * Moodle's Cleanm theme, an example of how to make a Bootstrap theme
 *
 * DO NOT MODIFY THIS THEME!
 * COPY IT FIRST, THEN RENAME THE COPY AND MODIFY IT INSTEAD.
 *
 * For full information about creating Moodle themes, see:
 * http://docs.moodle.org/dev/Themes_2.0
 *
 * @package   theme_cleanm
 * @copyright 2015 eFaktor
 * @author    Urs Hunkler {@link urs.hunkler@unodo.de}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Get the renderer for this plugin
$output = $PAGE->get_renderer('theme_cleanm');

$contextcourse = context_course::instance(SITEID);
$doctype = $OUTPUT->doctype();

// Define the renderable for the layout page
$renderable = '\\theme_cleanm\\output\\' .
    $PAGE->theme->layouts[$PAGE->pagelayout]['renderable'];
$page = new $renderable($contextcourse, $doctype);

echo $output->render($page);
