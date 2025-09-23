# Contributing to KingPanda BET API

## 📝 Commit Convention

We follow the [Conventional Commits](https://www.conventionalcommits.org/) specification.

### Format
```
<type>(<scope>): <subject>

[optional body]

[optional footer(s)]
```

### Types
- **feat**: New feature
- **fix**: Bug fix
- **docs**: Documentation changes
- **style**: Code style changes (formatting, semicolons, etc)
- **refactor**: Code refactoring without adding features or fixing bugs
- **test**: Adding or updating tests
- **chore**: Build process or auxiliary tool changes
- **perf**: Performance improvements
- **ci**: CI/CD configuration changes

### Examples
```bash
feat(odds): add suspend endpoint for bet management
fix(migration): correct decimal precision for odds values
docs: update API documentation for bet endpoints
test(odds): add integration tests for suspend functionality
```

## 🌳 Branch Naming Convention

- `feature/` - New features (e.g., `feature/bet-odds-crud`)
- `bugfix/` - Bug fixes (e.g., `bugfix/odds-calculation`)
- `hotfix/` - Urgent production fixes
- `release/` - Release preparation branches
- `chore/` - Maintenance tasks

## 🔄 Git Workflow

1. **Create feature branch from develop**
   ```bash
   git checkout develop
   git checkout -b feature/your-feature
   ```

2. **Make atomic commits**
   - Each commit should represent one logical change
   - Use conventional commit format

3. **Keep commits clean**
   ```bash
   # Interactive rebase if needed
   git rebase -i develop
   ```

4. **Push and create Pull Request**
   ```bash
   git push origin feature/your-feature
   ```

5. **PR Review Process**
   - All PRs must be reviewed
   - Tests must pass
   - Documentation must be updated

## ✅ Pull Request Checklist

- [ ] Code follows project coding standards
- [ ] Commits follow conventional commits specification
- [ ] Tests written and passing
- [ ] Documentation updated
- [ ] No sensitive data exposed
- [ ] OpenAPI spec regenerated if needed
- [ ] Migration rollback tested

## 🧪 Testing

Before submitting PR:
```bash
# Run tests
docker compose -f docker-compose-dev.yml exec rest composer run test

# Check code style
docker compose -f docker-compose-dev.yml exec rest composer run phpcs

# Regenerate OpenAPI if needed
docker compose -f docker-compose-dev.yml exec rest composer run openapi
```

## 📋 Code Review Guidelines

### Reviewers should check:
- Code correctness and efficiency
- Test coverage
- Security considerations
- Documentation completeness
- Commit message quality

### Authors should:
- Respond to all comments
- Update code based on feedback
- Squash commits before merge if requested

## 🚀 Release Process

1. Create release branch from develop
2. Update version numbers
3. Update CHANGELOG.md
4. Create PR to main
5. Tag release after merge

```bash
git tag -a v1.0.0 -m "Release version 1.0.0"
git push origin v1.0.0
```