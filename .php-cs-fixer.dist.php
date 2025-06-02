<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfig;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude([
        '.git',
        '.github',
        'bin',
        'var',
        'vendor',
    ]);

return (new Config())
    ->setRiskyAllowed(true)
    ->setParallelConfig(new ParallelConfig(10, 15))
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setHideProgress(true)
    ->setRules([
        '@Symfony' => true,
        '@PhpCsFixer' => true,

        // general
        'declare_strict_types' => true,
        'dir_constant' => true,
        'date_time_immutable' => true,
        'new_with_parentheses' => true,

        // code style
        'array_push' => true,
        'cast_spaces' => false,
        'concat_space' => ['spacing' => 'one'],

        // class and imports
        'class_attributes_separation' => [
            'elements' => [
                'case' => 'none',
                'const' => 'none',
                'property' => 'none',
                'method' => 'one',
                'trait_import' => 'none',
            ],
        ],
        'class_definition' => [
            'multi_line_extends_each_single_line' => false,
        ],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
            ],
        ],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],

        // phpdoc and comments
        'comment_to_phpdoc' => true,

        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_order' => true,
        'phpdoc_to_comment' => [
            'ignored_tags' => ['var'],
        ],

        // PHPUnit
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false,

        // other
        'combine_nested_dirname' => true,
        'function_declaration' => [
            'closure_fn_spacing' => 'none',
        ],
        'global_namespace_import' => true,
        'logical_operators' => true,
        'multiline_whitespace_before_semicolons' => true,
        'no_alias_functions' => true,
        'no_extra_blank_lines' => [
            'tokens' => [
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'switch',
                'throw',
                'use',
            ],
        ],
        'no_mixed_echo_print' => ['use' => 'echo'],
        'no_useless_sprintf' => true,
        'single_line_empty_body' => false,
        'single_space_around_construct' => false,
        'spaces_inside_parentheses' => false,
        'void_return' => true,
        'yoda_style' => false,
    ]);
