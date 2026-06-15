<?php

namespace Application\Helpers;

class Data
{
    public function prepareDataTables(array $data, array $fields): array
    {
        $response = [];
        $domain = URL_BASE;
        foreach ($data as $datalayer) {
            $record = (array) $datalayer->data();
            $record['name'] = "<div class=\"d-flex align-items-center justify-content-start gap-2\">
                    <img src=\"{$domain}/{$record['picture']}\" class=\"rounded\" alt=\"{$record['name']}\" height=\"32\" width=\"32\">
                    <span class=\"fw-medium ms-2\">{$record['name']}</span>
                </div>
            ";
            $record['created_at'] = date('d/m/Y', strtotime($record['created_at']));
            $record['actions'] = "
                <a href=\"?action=update&id={$record['reporter_id']}\" class=\"me-1 text-body-secondary\" title=\"Editar o registro\">
                    <span class=\"mdi mdi-text-box-edit fs-3\"></span>
                </a>
                <a href=\"?action=delete&id={$record['reporter_id']}\" class=\"text-body-secondary\" title=\"Deletar o registro\">
                    <span class=\"mdi mdi-delete fs-3\"></span>
                </a>
            ";
            array_push($response, $record);
        }

        return $response;
    }

    public function formatPhone(string $phone): mixed 
    {
        $number = $this->removeNonNumericCharacter($phone);
        if ($this->isValidNumberPhone($number)) {
            $length = strlen($number);
            if ($length == 10) {
                return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $number);
            }
    
            if ($length == 11) {
                return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $number);
            }
        }
        
        return null;
    }

    public function removeNonNumericCharacter(string $string): string
    {
        return preg_replace('/\D/', '', $string);
    }

    public function isValidNumberPhone(string $numberPhone): bool
    {
        return is_numeric($numberPhone) && (strlen($numberPhone) === 10 || strlen($numberPhone) === 11);
    }
}