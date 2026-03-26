<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('array_to_csv'))
{
    function array_to_csv($array, $filename = "export.csv")
    {
        $CI =& get_instance();
        
        if (empty($array)) {
            // Lida com o caso de não haver dados para exportar
            echo "Não há dados para exportar.";
            exit;
        }

        // Define os cabeçalhos para forçar o download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        // Cria um ponteiro para o output do PHP
        $output = fopen('php://output', 'w');
        
        // Coloca o BOM (Byte Order Mark) para garantir a compatibilidade com Excel em português (acentos)
        fputs($output, "\xEF\xBB\xBF");

        // Pega os cabeçalhos (nomes das colunas) da primeira linha do resultado
        $first_line = $array[0];
        if (is_object($first_line)) {
            $first_line = get_object_vars($first_line);
        }
        fputcsv($output, array_keys($first_line), ';');

        // Itera sobre os dados e escreve no CSV
        foreach ($array as $row)
        {
            if (is_object($row)) {
                $row = get_object_vars($row);
            }
            fputcsv($output, $row, ';');
        }

        fclose($output);
        exit();
    }
}