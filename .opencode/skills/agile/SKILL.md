---
name: agile
description: Run this project Scrum/Kanban-style — sprints, backlog grooming, standup-style status summaries. Use when planning work, prioritizing the backlog, or reporting progress to the user.
---

# Agile

Manage `tasks/board.md` as a lightweight Kanban/Scrum backlog instead of just a
flat to-do list.

## When to use
- Before assigning work: groom the backlog (split large tasks, size them, order
  by priority).
- When asked for a status update: summarize as a standup ("done since last
  update / in progress / blocked / next up"), not a raw file dump.
- When a new feature request comes in: break it into small `T-XXX` tasks with
  a one-line acceptance criterion each, instead of one big task.

## How to run
1. Read `tasks/board.md` and `.agents/*.status`.
2. Keep tasks small (a few hours of work each). If a task in "To Do" looks
   bigger than that, split it into multiple `T-XXX:` entries before assigning.
3. When assigning, order "To Do" by priority (top = next).
4. When reporting status, group by: **Done since last check-in**, **In
   progress**, **Blocked**, **Up next** — one line per task.

## Notes
- Don't invent new file formats — everything still lives in `tasks/board.md`
  and `.agents/<role>.status`; Agile here just changes *how* you plan and
  report, not the underlying protocol.
