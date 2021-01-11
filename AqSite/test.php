<?php

Class File
{

    /**
     * Use to store fOpen connection
     * @type bool
     * @access private
     */
    private $handle;

    /**
     * To store the file URL/location
     * @type string
     * @access private
     */
    private $file;

    /**
     * Used to initialize the file
     * @access public
     * @param string $file_url
     * File location/url
     * @example 'dir/mytext.txt'
     * @return bool
     */
    public function load($file_url)
    {
        $this->file = $file_url;
        if ($this->handle = fopen("MessageBank.txt", 'r'))
        {
            return $this;
        }
    }

    /**
     * To read the contents of the file
     * @access public
     * @param bool $nl2br
     * By default set to false, if set to true will return
     * the contents of the file by preserving the data.
     * @example (true)
     * @return string|bool
     */
    public function read($nl2br = false)
    {
        if ($read = fread($this->handle, filesize($this->file)))
        {
            if ($nl2br == true)
            {
                fclose($this->handle);
                return nl2br($read);
            }

            fclose($this->handle);
            return $read;
        }
        else
        {
            fclose($this->handle);
            return false;
        }
    }
}
?>