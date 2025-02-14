<?php

namespace Application\Helper;

class FilesManipulation
{
    const DIRECTORY_PATH = '/shared/httpd';
    const DIRECTORY_BACKUP = '/shared/backups';

    public function removeStoreFolder(string $storeName)
    {
        $path = self::DIRECTORY_PATH . '/' . $storeName;
        if (!is_dir($path)) {
            throw new \Exception("Erro: '$path' não é um diretório válido.");
        }

        // Dando permissão total para todos os arquivos e diretórios do projeto
        exec("chmod 0777 -Rf " . escapeshellarg($path));

        // Removendo todos os links simbólicos do projeto
        exec("find " . escapeshellarg($path) . " -xtype l -delete");
    
        // Mapeamento do diretório do projeto
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        
        // Removendo todos os arquivos e diretórios do projeto
        foreach ($iterator as $fileinfo) {  
            if ($fileinfo->isDir()) {
                // Removendo o dieretório
                exec("rm -rf " . $fileinfo->getRealPath());
            }
            if (is_file($fileinfo->getRealPath())) {
                // Removendo o arquivo
                unlink($fileinfo->getRealPath());
            }
        }

        // Removendo o diretório do projeto
        rmdir($path);
    
        return true;
    }

    public function removeWorkspaceVSCode(string $workspaceName)
    {
        if (!$this->workspaceFileExists($workspaceName)) {
            throw new \Exception("Os arquivo de espaço de trabalho não foram encontrados.");
        }

        $filename = $workspaceName . '.code-workspace';
        $filepath = $this->getFilepath($filename);
        $removeWorkspace = unlink($filepath);
        if (!$removeWorkspace) {
            throw new \Exception("Não foi possivel remover o arquivo de espaço de trabalho.");
        }

        return true;
    }

    public function removeDatabaseBackup(string $storeName): bool
    {
        if (empty($storeName)) {
            return false;
        }

        $flag = false;
        $files = $this->getListFilesDirectoryByExtension(self::DIRECTORY_BACKUP, '.sql.gz');
        foreach ($files as $file) {
            if (strpos($file, $storeName) !== false) {
                unlink($file);
                $flag = true;
            }
        }

        return $flag;
    }

    public function getListFilesDirectoryByExtension(string $directory = '', string $extension = '.txt')
    {
        if (empty($directory) || !is_dir($directory)) {
            return [];
        }
        return glob($directory . '/*' . $extension);
    }

    protected function isStoreInstalled(string $storeName): bool        
    {
        $filepath = $this->getFilepath($storeName);
        return is_dir($filepath);
    }

    public function workspaceFileExists(string $workspaceName)
    {
        $filename = $workspaceName . '.code-workspace';
        $filepath = $this->getFilepath($filename);
        return is_file($filepath);
    }

    protected function getFilepath(string $storeName)
    {
        return self::DIRECTORY_PATH . '/' . $storeName;
    }
}
