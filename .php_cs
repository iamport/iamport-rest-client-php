<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->notPath('bootstrap/cache')
    ->notPath('storage')
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

// 기본룰은 PSR2를 기본으로 하되 그외 추가적인 옵션들만 배열에 추가
// 옵션참고 URL
// https://github.com/FriendsOfPHP/PHP-CS-Fixer
// https://mlocati.github.io/php-cs-fixer-configurator

$config = Config::create()
    ->setRules([
        '@Symfony'                => true,
        '@PSR2'                   => true,
        'array_syntax'            => ['syntax' => 'short'],     // array() -> [], 단축형 배열 문법 사용
        'align_multiline_comment' => [
            'comment_type'=> 'phpdocs_only',                    // 주석을 phpdocs 규격에 맞게 정렬
        ],
        'array_indentation'       => true,                      // 배열을 가독성 좋게 배열 (closuer 내의 배열은 정렬이 잘안되는 문제가 있음)
        'no_unused_imports'       => true,                      // 사용하지 않는 import 자동 삭제
        'binary_operator_spaces'  => [                          // 연산자 정렬
            'align_double_arrow' => true,
            'align_equals'       => true,
        ],
        'blank_line_after_opening_tag' => true,                 // php 오픈태그 이후 한줄 띄우기
        'concat_space'                 => ['spacing' => 'one'], // 문자열과 변수 concat 시 제대로 적용이 안되는경우가 있다..(확인필요)
        'yoda_style'                   => false,
        'ordered_imports'              => [
            'sort_algorithm' => 'alpha',                        //import 구문 알파벳 순으로 정렬
        ],
        'no_superfluous_phpdoc_tags'   => [
            'allow_mixed' => true
        ]
    ])
    ->setFinder($finder)
    ->setUsingCache(true);

return $config;
