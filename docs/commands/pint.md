# Pint

Check and format Narsil CMS PHP files from the `narsil-app` DDEV container using the shared Pint configuration.

## Check

Check PHP formatting:

```sh
ddev exec -d /var/www/html ./vendor/bin/pint --test \
    --config=/var/www/narsil-skills/pint.json \
    /var/www/narsil-cms
```

## Fix

Format PHP files:

```sh
ddev exec -d /var/www/html ./vendor/bin/pint \
    --config=/var/www/narsil-skills/pint.json \
    /var/www/narsil-cms
```
