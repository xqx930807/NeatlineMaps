<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Map file record class tests.
 *
 * PHP version 5
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at http://www.apache.org/licenses/LICENSE-2.0 Unless required by
 * applicable law or agreed to in writing, software distributed under the
 * License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS
 * OF ANY KIND, either express or implied. See the License for the specific
 * language governing permissions and limitations under the License.
 *
 * @package     omeka
 * @subpackage  neatlinemaps
 * @author      Scholars' Lab <>
 * @author      Bethany Nowviskie <bethany@virginia.edu>
 * @author      Adam Soroka <ajs6f@virginia.edu>
 * @author      David McClure <david.mcclure@virginia.edu>
 * @copyright   2010 The Board and Visitors of the University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html Apache 2 License
 * @version     $Id$
 */
?>

<?php

class NeatlineMaps_MapFileTest extends Omeka_Test_AppTestCase
{

    public function setUp()
    {

        parent::setUp();
        $this->helper = new NeatlineMaps_Test_AppTestCase;
        $this->helper->setUpPlugin();
        $this->db = get_db();
        $this->mapFileTable = $this->db->getTable('NeatlineMapsMapFile');

    }

    /**
     * Test getFile().
     *
     * @return void.
     */
    public function testGetFile()
    {

        // Create a map file.
        $mapFile = $this->helper->_createMapFile();

        // Retrieve its Omeka file.
        $omekaFile = $mapFile->getFile();

        // Test.
        $this->assertEquals($omekaFile->original_filename, 'TestFile0.jpg');
        $this->assertEquals($omekaFile->archive_filename, 'ArchiveTestFile0.jpg');

    }

    /**
     * Test getMap().
     *
     * @return void.
     */
    public function testGetMap()
    {

        // Create a map file.
        $mapFile = $this->helper->_createMapFile();

        // Retrieve its Omeka file.
        $map = $mapFile->getMap();

        // Test.
        $this->assertEquals($map->name, 'Test Map');
        $this->assertEquals($map->namespace, 'Test_Namespace');

    }



}
