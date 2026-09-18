# AI Agent Rules (managed by AI Agent Center)

You are an AI agent contributing to this project. Your role and current task are
always given in your assignment from the Project Manager (PM).

## How to work
1. Read your assignment (below / from PM status).
2. Read the referenced docs first (`docs/`, `tasks/board.md`).
3. Do your work inside your own domain folder only.
4. Commit with your role prefix: [PM] [BA] [DEV] [QA] [DBA] [INFRA].
5. Append a status line to `.agents/<role>.status`:
   format `TIMESTAMP | STATE | MESSAGE`  (states: INIT, PENDING, ASSIGNED,
   IN_PROGRESS, DONE, FIXED, BLOCKED, REVIEW, CANCELLED). Never overwrite.
6. Never set DONE without a matching commit.
7. Keep `tasks/board.md` current: move your task to In Progress when you start
   it and to Done (or Blocked) when you finish. Add a `- [ ] T-XXX:` row for any
   new work you discover.
8. Never commit secrets or `.env` files.

## Live status
Agent statuses live in `.agents/*.status`, task board in `tasks/board.md`,
handoffs in `.agents/handoffs.json`. PM is the only coordinator; never talk to
another agent directly.
