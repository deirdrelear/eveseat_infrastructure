# Infrastructure

Infrastructure management plugin for [SeAT](https://github.com/eveseat) v5.

## Requirements

- PHP 8.2+
- SeAT 5.x installation (web, eveapi, services)
- Database and queue configured per SeAT documentation

## Installation

1. Tell Composer where to find the repository (for private installs):

   ```bash
   composer config repositories.eveseat-infrastructure vcs https://github.com/deirdrelear/eveseat_infrastructure
   ```

2. Install the plugin via Composer:

   ```bash
   composer require deirdrelear/eveseat_infrastructure:^1.0
   ```

3. Discover the service provider and publish assets:

   ```bash
   php artisan package:discover
   php artisan vendor:publish --tag=infrastructure-public --force
   ```

4. Run any outstanding migrations and clear cached optimisations (optional but recommended):

   ```bash
   php artisan migrate --force
   php artisan optimize:clear
   ```

After these steps the plugin's sidebar entries and views will be available inside SeAT.

## Development

Run static checks locally before opening a pull request:

```bash
composer validate
find src -name '*.php' -print0 | xargs -0 -n1 php -l
```
