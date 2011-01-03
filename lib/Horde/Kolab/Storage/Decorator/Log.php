<?php
/**
 * A log decorator for the Kolab storage handler.
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
 * A log decorator for the Kolab storage handler.
 *
 * Copyright 2004-2010 The Horde Project (http://www.horde.org/)
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
class Horde_Kolab_Storage_Decorator_Log
implements Horde_Kolab_Storage
{
    /**
     * The decorated storage handler.
     *
     * @var Horde_Kolab_Storage
     */
    private $_storage;

    /**
     * A log handler.
     *
     * @var mixed
     */
    private $_logger;

    /**
     * Constructor.
     *
     * @param Horde_Kolab_Storage $storage The storage handler.
     * @param mixed               $logger  The log handler. This instance
     *                                     must provide the info() method.
     */
    public function __construct(Horde_Kolab_Storage $storage, $logger)
    {
        $this->_storage = $storage;
        $this->_logger = $logger;
    }

    /**
     * Get the folder list object.
     *
     * @return Horde_Kolab_Storage_List The handler for the list of folders
     *                                  present in the Kolab backend.
     */
    public function getList()
    {
        return new Horde_Kolab_Storage_List_Decorator_Log(
            $this->_storage->getList(),
            $this->_logger
        );
    }

    /**
     * Get a Folder object.
     *
     * @param string $folder The folder name.
     *
     * @return Horde_Kolab_Storage_Folder The Kolab folder object.
     */
    public function getFolder($folder)
    {
        return $this->_storage->getFolder();
    }

    /**
     * Return a data handler for accessing data in the specified
     * folder.
     *
     * @param string $folder The name of the folder.
     * @param string $type   The type of data we want to
     *                       access in the folder.
     *
     * @return Horde_Kolab_Data The data object.
     */
    public function getData($folder, $type)
    {
        return $this->_storage->getData();
    }

}