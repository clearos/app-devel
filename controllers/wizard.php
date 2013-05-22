<?php

/**
 * Developer widget controller.
 *
 * @category   apps
 * @package    devel
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/devel/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Developer widget controller.
 *
 * @category   apps
 * @package    devel
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/devel/
 */

class Wizard extends ClearOS_Controller
{
    /**
     * Developer widget default controller.
     *
     * @return view
     */

    function index()
    {
        if ($this->session->userdata('wizard')) {
            $data['wizard_anchor'] = '/app/base/wizard/stop';
            $data['wizard_text'] = 'Stop Wizard Test';
        } else {
            $data['wizard_anchor'] = '/app/base/wizard/start';
            $data['wizard_text'] = 'Start Wizard Test';
        }

        $this->page->view_form('wizard', $data, lang('base_wizard'));
    }
}
