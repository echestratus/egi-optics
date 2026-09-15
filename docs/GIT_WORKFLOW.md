# Git Workflow for egi-optics.com

This document is the long form of the rule in `.cursor/rules/git-workflow.mdc`. It describes how code
changes travel from a developer laptop to production and what is (and is not) tracked in Git.

## 1. What is versioned

WordPress is a *content management system*: content belongs in the database, code belongs in Git.

| Tracked in Git                                     | Not tracked (server / generated)                       |
| -------------------------------------------------- | ------------------------------------------------------ |
| `wp-content/themes/egi-optics/**`                  | WordPress core (`wp-admin`, `wp-includes`, `wp-*.php`) |
| `wp-content/plugins/egi-optics-core/**`            | Third-party plugins & themes (declared in `composer.json`) |
| `wp-content/mu-plugins/egi-*.php` (if any)         | `wp-content/uploads/**` (media)                         |
| `scripts/**` (server + content + dev scripts)      | Database, `wp-config.php`, salts, `.env`, SSH keys      |
| `.github/**`, `docs/**`, `.cursor/rules/**`        | Cache directories (`wp-content/litespeed`, `upgrade`)   |
| `composer.json`, `package.json`, lockfiles, configs | `node_modules/`, `vendor/`, build output                |
| `assets/` is **ignored**: internal documents and source media stay local |                                          |

The `.gitignore` is written as an allow-list for `wp-content` so a new third-party plugin can never be
committed by accident.

## 2. Branch model

```
main ──●──────●──────●──────●───▶ production (every merge deploys)
        \    /        \    /
         feat/x        fix/y      short-lived branches, 1 concern each
```

- `main` is protected: pull request required, status checks required, linear history, no force-push.
- Branch names: `feat/<topic>`, `fix/<topic>`, `chore/<topic>`, `content/<topic>`, `docs/<topic>`, `hotfix/<topic>`.
- Rebase (or merge `main` into) your branch before requesting review to keep CI meaningful.
- Delete branches after merge.

### Hotfixes

Branch `hotfix/<topic>` from `main`, open a PR like any other change (CI still runs), squash-merge,
tag a patch release (`v1.0.1`). Because deploys are automated there is no separate hotfix pipeline.

## 3. Commit messages (Conventional Commits)

```
<type>(<scope>): <imperative summary, max 72 chars>

[optional body: what and why, not how]
[optional footer: BREAKING CHANGE: ..., Refs #12]
```

| type       | use for                                                   |
| ---------- | --------------------------------------------------------- |
| `feat`     | new user-visible capability (template, pattern, CPT)      |
| `fix`      | bug fix                                                   |
| `content`  | content migration scripts under `scripts/content`         |
| `style`    | CSS/visual-only changes                                   |
| `refactor` | code change without behaviour change                      |
| `perf`     | performance                                               |
| `docs`     | documentation and rules                                   |
| `ci`       | GitHub Actions / deploy scripts                           |
| `chore`    | tooling, dependencies, housekeeping                       |

Scopes: `theme`, `core`, `scripts`, `ci`, `docs`, `deps`.

## 4. Pull request checklist

- [ ] Branch is up to date with `main`.
- [ ] `npm run lint` and `npm run validate` pass locally.
- [ ] Visual changes: before/after screenshots at 1440px and 390px widths.
- [ ] Content scripts are idempotent (safe to run twice) and were tested in `wp-env`.
- [ ] URL/slug changes include a 301 redirect in `egi-optics-core` and a note in the CHANGELOG.
- [ ] No secrets, dumps, media or vendor code in the diff (`git diff --stat` reviewed).

Merge strategy: **squash and merge**; the squash title must itself be a valid Conventional Commit.

## 5. Releases and versioning

- Semantic versioning. `MAJOR` = URL structure / data model changes, `MINOR` = new features or pages,
  `PATCH` = fixes and content-script tweaks.
- Release PR bumps `Version:` in `wp-content/themes/egi-optics/style.css` and in
  `wp-content/plugins/egi-optics-core/egi-optics-core.php`, and adds a `CHANGELOG.md` section.
- After merge: `git tag -a vX.Y.Z -m "vX.Y.Z" && git push origin vX.Y.Z`. The deploy already ran on
  merge; the tag exists for traceability and rollback (`workflow_dispatch` on the tag).

## 6. Content changes

Editors change content in wp-admin; this is normal and not versioned. Developers who need to create
or transform content in bulk (new CPT entries, menus, option changes) write a script in
`scripts/content/` executed on the server with `wp eval-file`. Scripts must:

1. Be idempotent (look up by slug before creating; update in place).
2. Log what they did (`WP_CLI::log`).
3. Be reviewed through a normal PR before running in production.

## 7. Secrets policy

Secrets never enter Git. Production credentials exist only in `wp-config.php` on the server and in
GitHub Actions secrets. If a secret leaks into a commit: rotate it first, then remove it from history
(`git filter-repo`) and force-push only after informing the team.
