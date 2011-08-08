<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4; */

/**
 * Admin routing test.
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

class NeatlineMaps_ServersTest extends Omeka_Test_AppTestCase
{

    public function setUp()
    {

        parent::setUp();
        $this->helper = new NeatlineMaps_Test_AppTestCase;
        $this->helper->setUpPlugin();
        $this->db = get_db();
        $this->serversTable = $this->db->getTable('NeatlineMapsServer');

    }

    /**
     * Test for existence and proper routing for servers browse.
     *
     * @return void.
     */
    public function testCanBrowseServers()
    {

        $this->dispatch('neatline-maps/servers');
        $this->assertModule('neatline-maps');
        $this->assertController('servers');
        $this->assertAction('browse');
        $this->assertResponseCode(200);

    }

    /**
     * Test for existence and proper routing for add server page.
     *
     * @return void.
     */
    public function testCanViewAddServerPage()
    {

        $this->dispatch('neatline-maps/servers/create');
        $this->assertModule('neatline-maps');
        $this->assertController('servers');
        $this->assertAction('create');
        $this->assertResponseCode(200);

    }

    /**
     * Test for correct form correction on failed server add attempt.
     *
     * @return void.
     */
    public function testAddServerFormCorrection()
    {

        // Test that the validation rejects the submission unless all
        // of the fields are filled out.
        $this->request->setMethod('POST')
            ->setPost(array(
                'name' => '',
                'url' => '',
                'username' => '',
                'password' => ''
            )
        );

        // Test that the form posts back to the same view function.
        $this->dispatch('neatline-maps/servers/create');
        $this->assertModule('neatline-maps');
        $this->assertController('servers');
        $this->assertAction('create');
        $this->assertResponseCode(200);

        $this->assertQueryCount('ul.errors', 4);

        $this->assertQueryContentContains('dd#name-element ul.errors li',
            'Value is required and can\'t be empty');
        $this->assertQueryContentContains('dd#url-element ul.errors li',
            'Value is required and can\'t be empty');
        $this->assertQueryContentContains('dd#username-element ul.errors li',
            'Value is required and can\'t be empty');
        $this->assertQueryContentContains('dd#password-element ul.errors li',
            'Value is required and can\'t be empty');

    }

    /**
     * Test for successful server add.
     *
     * @return void.
     */
    public function testAddServerSuccess()
    {

        // Enter valid data.
        $this->request->setMethod('POST')
            ->setPost(array(
                'name' => 'Test Server',
                'url' => 'http://www.geoserver.com/test',
                'username' => 'test',
                'password' => 'test'
            )
        );

        $this->dispatch('neatline-maps/servers/create');
        $serverCount = $this->serversTable->count();
        $server = $this->serversTable->find(1);

        // Test that the server was created.
        $this->assertEquals($serverCount, 1);
        $this->assertEquals($server->name, 'Test Server');
        $this->assertEquals($server->url, 'http://www.geoserver.com/test');
        $this->assertEquals($server->username, 'test');
        $this->assertEquals($server->password, 'test');

        // Test redirect back to browse.
        // Why does this not work?
        // $this->assertAction('browse');

        // For now, since the tests don't follow the redirect..
        $this->dispatch('neatline-maps/servers');
        $this->assertQueryContentContains('strong', 'Test Server');


    }

}
