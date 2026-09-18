---
name: security-checklist
description: Run an OWASP-style checklist before marking infra/security work done. Use when reviewing code for deployment or writing security-report.md.
---

# Security checklist

Before writing `security-report.md` or marking a security task Done, walk
through this checklist against the current code.

## When to use
- Before deployment-related tasks are marked Done.
- Whenever asked to "review security" or "check for vulnerabilities".

## Checklist
1. **Injection** — SQL/command/template injection in any user input path.
2. **Auth** — broken access control, missing auth checks on routes.
3. **Secrets** — API keys, passwords, tokens committed to the repo or logged.
4. **Dependencies** — known-vulnerable packages (check lockfile versions).
5. **Config** — debug mode, verbose errors, or admin panels exposed in prod
   config.
6. **Transport** — sensitive data sent over plain HTTP, missing HTTPS
   redirects.

## How to run
1. Go through each item against the diff or full codebase (whichever the task
   asks for).
2. Record every finding in `infra/security-report.md` with severity
   (HIGH/MED/LOW), location, and a one-line fix suggestion.
3. If any HIGH finding exists, set `.agents/infra.status` to BLOCKED and add a
   `T-XXX:` task for the fix instead of marking Done.
