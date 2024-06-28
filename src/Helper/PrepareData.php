<?php

namespace Application\Helper;

class PrepareData 
{
    /**
     * Prepara os dados para serem usados no campo select.
     *
     * @param Array $collection 
     * @param string $value Nome do campo para o value 
     * @param string $label Nome do campo para o label
     * @return Array|null
     */
    public function prepareSelectOpt(Array $collection, string $value = 'id', string $label = 'name'): ?Array
    {
        if (empty($collection)) {
            return null;
        }

        $opt = [];
        foreach ($collection as $option) {
            $data = $option->data();
            $opt[] = [
                'value' => $data->$value,
                'label' => $data->$label
            ];
        }

        return $opt;
    }
}
