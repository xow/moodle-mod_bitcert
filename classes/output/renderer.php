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

namespace mod_bitcert\output;

/**
 * Renderer for digital certificates.
 *
 * @package mod_bitcert
 * @copyright 2016 John Okely <john@moodle.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends \plugin_renderer_base {
    /**
     * Initialises the game and returns its HTML code
     *
     * @param stdClass $bitcert The bitcert to be added
     * @param context $context The context
     * @return string The HTML code of the game
     */
    function render_cert($bitcert, $context) {
        global $DB, $OUTPUT;

        $display = \html_writer::link(new \moodle_url('/mod/bitcert/schema.php', array('id' => $bitcert->id)), 'View schema');
        $certjson = \mod_bitcert\helper::get_certificate($bitcert);
        $cert = \json_decode($certjson);
        $display .= $this->render_from_template('mod_bitcert/certificate', $cert);

        $display .= '<pre>' . $certjson . '</pre>';

        return $display;
    }

}
