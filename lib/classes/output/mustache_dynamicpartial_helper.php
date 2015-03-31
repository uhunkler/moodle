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
 * Mustache helper.
 *
 * @package    core
 * @category   output
 * @copyright  2015 Urs Hunkler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\output;

/**
 * Dynamic partial.
 *
 * @copyright  2015 Urs Hunkler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      2.9
 */
class mustache_dynamicpartial_helper {
    /**
     * Handle a dynamic partial. The text is a variable which is rendered into a partial.
     *
     * Example {{#dyn}}{{varwithpartialname}}{{/dyn}}
     *
     * @param string                 $text   The script content of the section.
     * @param \Mustache_LambdaHelper $helper Used to render the content of this block.
     *
     * @return string
     */
    public function dyn($text, \Mustache_LambdaHelper $helper) {
        return '{{>' . $helper->render($text) . '}}';
    }
}
