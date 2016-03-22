<?php

$header = <<<EOF
This is part of the webuni/srazy-api-client.

(c) Martin Hasoň <martin.hason@gmail.com>
(c) Webuni s.r.o. <info@webuni.cz>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in(array(__DIR__.'/src'))
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array(
        'header_comment',
        'newline_after_open_tag',
        'ordered_use',
        'short_array_syntax',
    ))
    ->finder($finder)
;
