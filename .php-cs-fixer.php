<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR12' => true,
    'array_syntax' => [
        'syntax' => 'short',
    ],
    'blank_line_between_import_groups' => false,
    'binary_operator_spaces' => [
        'default' => 'single_space',
        'operators' => ['=>' => 'single_space'],
    ],
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => [
        'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
    ],
    'cast_spaces' => true,
    'class_attributes_separation' => [
        'elements' => [
            'const' => 'one',
            'method' => 'one',
        ],
    ],
    'class_definition' => [
        'multi_line_extends_each_single_line' => true,
        'single_item_single_line' => true,
        'single_line' => true,
    ],
    'clean_namespace' => true,
    'compact_nullable_type_declaration' => false,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'constant_case' => true,
    'declare_equal_normalize' => true,
    'elseif' => true,
    'encoding' => true,
    'full_opening_tag' => true,
    'function_declaration' => [
        'closure_function_spacing' => 'one',
    ],
    'include' => true,
    'linebreak_after_opening_tag' => true,
    'lowercase_cast' => true,
    'lowercase_keywords' => true,
    'lowercase_static_reference' => true,
    'magic_constant_casing' => true,
    'magic_method_casing' => true,
    'method_argument_space' => [
        'on_multiline' => 'ensure_fully_multiline',
        'keep_multiple_spaces_after_comma' => true,
    ],
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'no_multi_line',
    ],
    'native_function_casing' => true,
    'native_type_declaration_casing' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_closing_tag' => true,
    'no_empty_statement' => true,
    'no_extra_blank_lines' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_short_bool_cast' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_after_function_name' => true,
    'no_trailing_comma_in_singleline' => true,
    'no_trailing_whitespace_in_comment' => true,
    'no_unneeded_control_parentheses' => true,
    'no_useless_return' => true,
    'no_unset_cast' => true,
    'no_unused_imports' => true,
    'no_whitespace_before_comma_in_array' => true,
    'not_operator_with_successor_space' => true,
    'normalize_index_brace' => true,
    'object_operator_without_whitespace' => true,
    'ordered_imports' => [
        'sort_algorithm' => 'alpha',
    ],
    'operator_linebreak' => [
        'only_booleans' => false,
        'position' => 'beginning',
    ],
    'phpdoc_scalar' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_var_without_name' => true,
    'return_type_declaration' => true,
    'short_scalar_cast' => true,
    'blank_lines_before_namespace' => true,
    'single_class_element_per_statement' => true,
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,
    'single_line_comment_style' => [
        'comment_types' => ['hash'],
    ],
    'single_trait_insert_per_statement' => true,
    'space_after_semicolon' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline' => [
        'elements' => ['arrays'],
    ],
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'whitespace_after_comma_in_array' => true,
    'visibility_required' => [
        'elements' => ['method', 'property'],
    ],
];


$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
