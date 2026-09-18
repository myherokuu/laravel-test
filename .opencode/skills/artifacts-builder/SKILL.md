---
name: artifacts-builder
description: Suite of tools for creating elaborate, multi-component single-file HTML artifacts using modern frontend web technologies (React, Tailwind CSS, shadcn/ui). Use for complex artifacts requiring state management, routing, or shadcn/ui components - not for simple single-file HTML/JSX artifacts.
license: Complete terms in LICENSE.txt
---

# Artifacts Builder

To build powerful frontend artifacts, follow these steps:
1. Initialize the frontend repo using `scripts/init-artifact.sh`
2. Develop your artifact by editing the generated code
3. Bundle all code into a single HTML file using `scripts/bundle-artifact.sh`
4. Display artifact to user
5. (Optional) Test the artifact

**Stack**: React 18 + TypeScript + Vite + Parcel (bundling) + Tailwind CSS + shadcn/ui

## myagents note

The scripts in `scripts/` ship with this skill (they are copied into the
project's `.opencode/skills/artifacts-builder/`). Concepts work the same as the
upstream Claude skill, but the output is a self-contained `bundle.html` saved
into the project — hand that file path back to the user so they can open it,
or embed it in the AI Agent Center portal as the deliverable.

## Design & Style Guidelines

VERY IMPORTANT: To avoid what is often referred to as "AI slop", avoid using excessive centered layouts, purple gradients, uniform rounded corners, and Inter font.

## Quick Start

### Step 1: Initialize Project

Run the initialization script to create a new React project:
```bash
bash scripts/init-artifact.sh <project-name>
cd <project-name>
```

This creates a fully configured project with:
- ✅ React + TypeScript (via Vite)
- ✅ Tailwind CSS 3.4.1 with shadcn/ui theming system
- ✅ Path aliases (`@/`) configured
- ✅ 40+ shadcn/ui components pre-installed
- ✅ All Radix UI dependencies included
- ✅ Parcel configured for bundling (via .parcelrc)
- ✅ Node 18+ compatibility (auto-detects and pins Vite version)

### Step 2: Develop Your Artifact

To build the artifact, edit the generated files. See **Common Development Tasks** below for guidance.

### Step 3: Bundle to Single HTML File

To bundle the React app into a single HTML artifact:
```bash
bash scripts/bundle-artifact.sh
```

This creates `bundle.html` - a self-contained artifact with all JavaScript, CSS, and dependencies inlined. This file can be directly shared as the deliverable.

**Requirements**: Your project must have an `index.html` in the root directory.

**What the script does**:
- Installs bundling dependencies (parcel, @parcel/config-default, parcel-resolver-tspaths, html-inline)
- Creates `.parcelrc` config with path alias support
- Builds with Parcel (no source maps)
- Inlines all assets into single HTML using html-inline

### Step 4: Share Artifact with User

Finally, present the bundled HTML file to the user (open it in the portal or point them at the file path) so they can view it.

### Step 5: Testing/Visualizing the Artifact (Optional)

Note: This is a completely optional step. Only perform if necessary or requested.

To test/visualize the artifact, use available tools (including other Skills or built-in tools like Playwright or Puppeteer). In general, avoid testing the artifact upfront as it adds latency between the request and when the finished artifact can be seen. Test later, after presenting the artifact, if requested or if issues arise.

## Common Development Tasks

### Adding a new component

Add new shadcn/ui components by copying them from `components/ui/` prefixed files or running `npx shadcn@latest add <component>`. Components are available in both `@/*` and `./*` import styles.

### Navigation & Routing

Identify the routing structure in `App.tsx` or page components: a single-page app may not need routing; for more pages use React Router in single-page mode (`createHashRouter` or `BrowserRouter`), Note: For single page manifests hash router is recommended.

### State Management

Use React Context or Zustand/create for state
- Context is appropriate for simpler state sharing
- Zustand is ideal for more complex state management

### Local data persistence

Use localStorage OR the browser's FileSystem API in the artifact runtime. Only use localStorage directly (no third-party libraries).

### Form Handling

Use React hooks for form state and validation, handling errors client-side. Use the standard HTML5 input elements (input, select, textarea). Two-column layouts for mobile are not necessary for desktop-focused artifacts.

### Icons

Artifacts should use SVG icons - either inline SVG or import from a library like lucide-react.

## Reference

- **shadcn/ui components**: https://ui.shadcn.com/docs/components