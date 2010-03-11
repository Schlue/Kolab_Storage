<?php
/**
 * Test the handling of namespaces.
 *
 * PHP version 5
 *
 * @category Kolab
 * @package  Kolab_Storage
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Storage
 */

/**
 * Prepare the test setup.
 */
require_once 'Autoload.php';

/**
 * Test the handling of namespaces.
 *
 * Copyright 2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @category Kolab
 * @package  Kolab_Storage
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Storage
 */
class Horde_Kolab_Storage_NamespaceTest extends PHPUnit_Framework_TestCase
{
    public function testFolderTitleIsEmptyForInbox()
    {
        $this->markTestIncomplete('This expectation currently does not hold as we are not using the namespace handler yet.');
        $folder = new Horde_Kolab_Storage_Folder(
            'INBOX',
            new Horde_Kolab_Storage_Namespace()
        );
        $this->assertEquals('', $folder->getTitle());
    }

    public function testFolderTitleDoesNotContainInbox()
    {
        $folder = new Horde_Kolab_Storage_Folder(
            'INBOX/test',
            new Horde_Kolab_Storage_Namespace()
        );
        $this->assertEquals('test', $folder->getTitle());
    }

    public function testFolderTitleOfOtherUserDoesNotContainUserPrefixAndOtherUserName()
    {
        $this->markTestIncomplete('This expectation currently does not hold as we are not using the namespace handler yet.');
        $folder = new Horde_Kolab_Storage_Folder(
            'user/test/his_folder',
            new Horde_Kolab_Storage_Namespace()
        );
        $this->assertEquals('his_folder', $folder->getTitle());
    }

    public function testFolderTitleReplacesSeparatorWithDoubleColon()
    {
        $folder = new Horde_Kolab_Storage_Folder(
            'INBOX/test/sub',
            new Horde_Kolab_Storage_Namespace()
        );
        $this->assertEquals('test:sub', $folder->getTitle());
    }

    public function testFolderTitleConvertsUtf7()
    {
        Horde_String::setDefaultCharset('UTF8');
        $name = Horde_String::convertCharset('äöü', 'UTF8', 'UTF7-IMAP');
        $folder = new Horde_Kolab_Storage_Folder(
            'INBOX/' . $name,
            new Horde_Kolab_Storage_Namespace()
        );
        $this->assertEquals('äöü', $folder->getTitle());
    }

}