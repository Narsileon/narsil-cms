## Useful Commands

### Composer

Install dependencies:

```bash
ddev composer install
```

Update dependencies:

```bash
ddev composer update
```

Check outdated dependencies:

```bash
ddev composer outdated
```

### Node

Install dependencies:

```bash
npm install
```

Update dependencies:

```bash
npm update
```

Check outdated dependencies:

```bash
npm outdated
```

Upgrade dependencies to latest minor versions:

```bash
npm install -g npm-check-updates
ncu -u -t minor
npm install
```

# Upgrade dependencies to latest major versions:

```bash
npm install -g npm-check-updates
ncu -u -t minor
npm install
```
