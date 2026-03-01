Count lines:

```bash
git ls-files | grep -E '\.php$|\.js$|\.ts$|\.tsx' | xargs grep -v -E '^\s*(//|#|/\*|\*|<!--|#region|#endregion)?\s*$' | wc -l
```
