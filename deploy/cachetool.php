<?php
/* (c) Samuel Gordalina <samuel.gordalina@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer;

set('cachetool', '');

/**
 * Clear opcache cache
 */
desc('Clearing OPcode cache');
task('cachetool:clear:opcache', function () {
    $releasePath = get('release_path');
    $options = get('cachetool');

    if (strlen($options)) {
        $options = "--fcgi={$options}";
    }

    cd($releasePath);
    $hasCachetool = run("if [ -e $releasePath/cachetool.phar ]; then echo 'true'; fi");

    if ('true' !== $hasCachetool) {
        run("curl -sO https://gordalina.github.io/cachetool/downloads/cachetool.phar");
    }

    run("sudo {{bin/php}} cachetool.phar opcache:reset {$options}");
});
