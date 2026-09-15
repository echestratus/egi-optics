<!-- Title must be a Conventional Commit, e.g. "feat(theme): add downloads pattern" -->

## What and why

<!-- One or two sentences. Link the issue/request if any. -->

## Type of change

- [ ] Theme (templates, patterns, styles)
- [ ] Plugin (`egi-optics-core`: CPT, redirects, hardening)
- [ ] Content script (`scripts/content`)
- [ ] CI/CD or tooling
- [ ] Documentation / rules

## Screenshots (required for visual changes)

| Desktop 1440px | Mobile 390px |
| -------------- | ------------ |
|                |              |

## Checklist

- [ ] Branch is rebased on `main`
- [ ] `npm run lint` and `npm run validate` pass locally
- [ ] Tested in `wp-env` (`npm run env:start`)
- [ ] No secrets, DB dumps, uploads, core or third-party plugin code in the diff
- [ ] URL/slug changes have a 301 redirect in `egi-optics-core` and a CHANGELOG note
- [ ] Content scripts are idempotent (safe to run twice)
- [ ] CHANGELOG.md updated under **Unreleased** (if user-visible)

## Deployment notes

<!-- Anything the deployer must know: run a content script, purge cache, update a plugin, etc. -->
