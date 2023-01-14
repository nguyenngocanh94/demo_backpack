<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'var',
        'vendor',
        'public',
    ])
    ->name('*.php')
    ->notName('*.html.twig')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'align_multiline_comment' => true,
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'clean_namespace' => true,
        'concat_space' => [
            'spacing' => 'none',
        ],
        'constant_case' => ['case' => 'lower'],
        'line_ending' => true,
        'list_syntax' => true,
        'lowercase_cast' => true,
        'lowercase_keywords' => true,
        'no_unused_imports' => true,
        'single_quote' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'trim_array_spaces' => true,
    ])
    ->setFinder($finder);
