<?php
/**
 * Test the Kolab mock driver.
 *
 * PHP version 5
 *
 * @category   Kolab
 * @package    Kolab_Storage
 * @subpackage UnitTests
 * @author     Gunnar Wrobel <wrobel@pardus.de>
 * @license    http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link       http://pear.horde.org/index.php?package=Kolab_Storage
 */

/**
 * Prepare the test setup.
 */
require_once dirname(__FILE__) . '/../../Autoload.php';

/**
 * Test the Kolab mock driver.
 *
 * Copyright 2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @category   Kolab
 * @package    Kolab_Storage
 * @subpackage UnitTests
 * @author     Gunnar Wrobel <wrobel@pardus.de>
 * @license    http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link       http://pear.horde.org/index.php?package=Kolab_Storage
 */
class Horde_Kolab_Storage_Unit_Driver_ImapTest
extends PHPUnit_Framework_TestCase
{
    public function testGetNamespaceReturnsNamespaceHandler()
    {
        $driver = new Horde_Kolab_Storage_Driver_Imap(
            $this->_getNamespaceMock(),
            array()
        );
        $this->assertType(
            'Horde_Kolab_Storage_Driver_Namespace',
            $driver->getNamespace()
        );
    }

    public function testGetNamespaceReturnsExpectedNamespaces()
    {
        $driver = new Horde_Kolab_Storage_Driver_Imap(
            $this->_getNamespaceMock(),
            array()
        );
        $namespaces = array();
        foreach ($driver->getNamespace() as $namespace) {
            $namespaces[$namespace->getName()] = array(
                'type' => $namespace->getType(),
                'delimiter' => $namespace->getDelimiter(),
            );
        }
        $this->assertEquals(
            array(
                'INBOX' => array(
                    'type' => 'personal',
                    'delimiter' => '/',
                ),
                'user' => array(
                    'type' => 'other',
                    'delimiter' => '/',
                ),
                '' => array(
                    'type' => 'shared',
                    'delimiter' => '/',
                ),
            ),
            $namespaces
        );
    }

    private function _getNamespaceMock()
    {
        $imap = $this->getMock('Horde_Imap_Client_Socket', array(), array(), '', false, false);
        $imap->expects($this->once())
            ->method('queryCapability')
            ->with('NAMESPACE')
            ->will($this->returnValue(true));
        $imap->expects($this->once())
            ->method('getNamespaces')
            ->will(
                $this->returnValue(
                    array(
                        array(
                            'type' => 'personal',
                            'name' => 'INBOX',
                            'delimiter' => '/',
                        ),
                        array(
                            'type' => 'other',
                            'name' => 'user',
                            'delimiter' => '/',
                        ),
                        array(
                            'type' => 'shared',
                            'name' => '',
                            'delimiter' => '/',
                        ),
                    )
                )
            );
        return $imap;
    }
}