<?php

namespace Application\Helper;

class FilesManipulation
{
    const DIRECTORY_PATH = '/home/bruno/projects/stores';

    public function removeStoreFolder(string $storeName)
    {
        exit($storeName);
        if ($this->isStoreInstalled($storeName)) {
            
        }
    }

    protected function isStoreInstalled(string $storeName): bool        
    {
        $filepath = $this->getFilepath($storeName);
        if (!is_dir($filepath)) {
            return false;
        }

        return true;
    }

    protected function getFilepath(string $storeName)
    {
        return self::DIRECTORY_PATH . '/' . $storeName;
    }
}
