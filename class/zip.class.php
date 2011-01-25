<?php
/**
 * Add a dir in a zip file
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * Add a dir in a zip file
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class ANEZip extends ZipArchive
{
    /**
     *
     * Adds a directory recursively.
     *
     * @param string $filename The path to the file to add.
     *
     * @param string $localname Local name inside ZIP archive.
     *
     */
    public function addDir($filename, $localname)
    {
        $this->addEmptyDir($localname);
        $iter = new RecursiveDirectoryIterator($filename);

        foreach ($iter as $fileinfo) {
            if (! $fileinfo->isFile() && !$fileinfo->isDir()) {
                continue;
            }

            $method = $fileinfo->isFile() ? 'addFile' : 'addDir';
            $this->$method($fileinfo->getPathname(), $localname . '/' .
                $fileinfo->getFilename());
        }
    }
}
?>