## Useful Commands

### Composer

Install dependencies:

```bash
composer install
```

Update dependencies:

```bash
composer update
```

Check outdated dependencies:

```bash
composer outdated
```

### Node

Install dependencies:

```bash
yarn install
```

Update dependencies:

```bash
yarn upgrade
```

Check outdated dependencies:

```bash
yarn outdated
```

Upgrade dependencies to latest minor versions:

```bash
yarn global add npm-check-updates
ncu -u -t minor
yarn
```

Upgrade dependencies to latest major versions:

```bash
yarn global add npm-check-updates
ncu -u -t latest
yarn
```
