#!/bin/bash
sed -i "s/return \$this->route('auth\.login', \$parameters);/return \$this->route('pages.login', \$parameters);/" vendor/filament/filament/src/Panel/Concerns/HasAuth.php
echo "Filament patched OK"
php artisan optimize:clear
