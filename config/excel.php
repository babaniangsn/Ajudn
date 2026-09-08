<?php

return [
    'exports' => [
        'chunk_size' => 1000,
        'pre_calculate_formulas' => false,
        'strict_null_comparison' => false,
        'csv' => [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => PHP_EOL,
            'use_bom' => false,
            'include_separator_line' => false,
            'excel_compatibility' => false,
        ],
        'properties' => [
            'creator' => 'AJUDN',
            'lastModifiedBy' => 'AJUDN',
            'title' => 'Export Cotisations',
            'description' => '',
            'subject' => '',
            'keywords' => '',
            'category' => '',
            'manager' => '',
            'company' => 'AJUDN',
        ],
    ],

    'imports' => [
        'read_only' => true,
        'ignore_empty' => false,
        'heading_row' => [
            'formatter' => 'slug',
        ],
        'csv' => [
            'delimiter' => null,
            'enclosure' => '"',
            'escape_character' => '\\',
            'contiguous' => false,
            'input_encoding' => 'guess',
        ],
        'properties' => [
            'creator' => 'AJUDN',
        ],
    ],

    'extension_detector' => [
        'xlsx' => \Maatwebsite\Excel\Excel::XLSX,
        'xlsm' => \Maatwebsite\Excel\Excel::XLSX,
        'xltx' => \Maatwebsite\Excel\Excel::XLSX,
        'xltm' => \Maatwebsite\Excel\Excel::XLSX,
        'xls' => \Maatwebsite\Excel\Excel::XLS,
        'xlt' => \Maatwebsite\Excel\Excel::XLS,
        'csv' => \Maatwebsite\Excel\Excel::CSV,
    ],

    'value_binder' => [
        'default' => \Maatwebsite\Excel\DefaultValueBinder::class,
    ],
];
