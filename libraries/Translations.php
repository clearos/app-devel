<?php

/**
 * Translation tool calls.
 *
 * @category   Apps
 * @package    Devel
 * @subpackage Libraries
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/devel/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Lesser General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// N A M E S P A C E
///////////////////////////////////////////////////////////////////////////////

namespace clearos\apps\devel;

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('devel');

///////////////////////////////////////////////////////////////////////////////
// D E P E N D E N C I E S
///////////////////////////////////////////////////////////////////////////////

// Classes
//--------

use \clearos\apps\base\Engine as Engine;
use \clearos\apps\base\Folder as Folder;
use \clearos\apps\base\Shell as Shell;
use \clearos\apps\tasks\Cron as Cron;

clearos_load_library('base/Engine');
clearos_load_library('base/Folder');
clearos_load_library('base/Shell');
clearos_load_library('tasks/Cron');

// Exceptions
//-----------

use \clearos\apps\base\Validation_Exception as Validation_Exception;

clearos_load_library('base/Validation_Exception');

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Translation tool calls.
 *
 * @category   Apps
 * @package    Devel
 * @subpackage Libraries
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/devel/
 */

class Translations extends Engine
{
    ///////////////////////////////////////////////////////////////////////////////
    // C O N S T A N T S
    ///////////////////////////////////////////////////////////////////////////////

    const FILE_CROND = 'app-devel-translations';
    const FOLDER_BASE_TRANSLATIONS = '/var/clearos/base/translations/base';
    const DEFAULT_CRONTAB_TIME = '*/5 * * * *';
    const COMMAND_GET_TRANSLATIONS = '/usr/sbin/get_translations';

    ///////////////////////////////////////////////////////////////////////////////
    // M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Translations constructor.
     */

    public function __construct()
    {
        clearos_profile(__METHOD__, __LINE__);
    }

    /**
     * Returns synchronization state.
     *
     * @return boolean state of synchronization
     * @throws Engine_Exception
     */

    public function get_sync_state()
    {
        clearos_profile(__METHOD__, __LINE__);

        $cron = new Cron();

        if ($cron->exists_configlet(self::FILE_CROND))
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Sets synchronization state.
     *
     * @param boolean $state state
     *
     * @return void
     * @throws Engine_Exception
     */

    public function set_sync_state($state)
    {
        clearos_profile(__METHOD__, __LINE__);

        Validation_Exception::is_valid($this->validate_sync_state($state));

        $cron = new Cron();

        if ($state && !$cron->exists_configlet(self::FILE_CROND)) {
            // Add cron job
            $payload = self::DEFAULT_CRONTAB_TIME . ' root ' . self::COMMAND_GET_TRANSLATIONS . ' -q';
            $cron->add_configlet(self::FILE_CROND, $payload);

            // Fire off an sync right away
            $options['background'] = TRUE;
            $shell = new Shell();
            $shell->execute(self::COMMAND_GET_TRANSLATIONS, '', TRUE, $options);
        } else if (!$state && $cron->exists_configlet(self::FILE_CROND)) {
            $cron->delete_configlet(self::FILE_CROND);

            // Clean out translations
            $folder = new Folder(self::FOLDER_BASE_TRANSLATIONS);
            $folder->delete(TRUE);
        }
    }

    ///////////////////////////////////////////////////////////////////////////////
    // V A L I D A T I O N   R O U T I N E S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Validation routine for synchronization state.
     *
     * @param boolean $state state
     *
     * @return string error message if synchronization state is invalid
     */

    public function validate_sync_state($state)
    {
        clearos_profile(__METHOD__, __LINE__);

        if (!clearos_is_valid_boolean($state))
            return lang('devel_synchronization_state_invalid');
    }
}
