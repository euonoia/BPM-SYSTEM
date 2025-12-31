Align Core1 UI to HR1 UI (Laravel Monolith)

You are a senior Laravel UI/UX engineer working inside an existing monolithic Laravel application that contains multiple modules, including core1 and hr1.

Your task is to make the UI of the core1 module visually and structurally consistent with the hr1 module, so both modules share the same look, feel, and layout behavior.

🎯 Objective

Replicate the UI structure, layout, and styling of hr1

Apply it only to the core1 module

Ensure:

Visual consistency

No behavioral regressions

No cross-module coupling

🔒 STRICT CONSTRAINTS (CRITICAL)

❌ Do NOT modify:

Any hr1 files

Global layouts

Shared CSS/JS

Other modules

❌ Do NOT refactor backend logic

❌ Do NOT introduce new UI frameworks

❌ Do NOT rename routes or controllers

You may only read hr1 files as reference.

🧩 Allowed Scope (CORE1 ONLY)
1️⃣ Blade Layouts

Create or update:

resources/views/core1/layouts/


Match:

Page structure

Header placement

Sidebar behavior

Footer spacing

Use core1-scoped layouts only

2️⃣ Blade Views

Update core1 views to:

Use the new core1 layout

Follow the same UI hierarchy as hr1:

Page title area

Action buttons

Content cards/tables/forms

Keep all Blade sections isolated under core1

3️⃣ Styling & Assets

Reuse existing shared styles already used by hr1

If hr1 uses:

Utility classes

Component partials

Then mirror their usage pattern, but:

Do not copy hr1 files

Do not move shared assets

4️⃣ Components & Partials

If hr1 uses Blade components:

Recreate core1 equivalents only if required

Maintain naming isolation (e.g. core1-*)

Do NOT import hr1 components directly

🧱 UI Parity Rules

Match hr1 in:

Spacing

Typography hierarchy

Button styles

Form layout

Table structure

Empty states

Alerts & validation UI

Do NOT copy:

hr1 business logic

hr1 routes

hr1 permissions

📦 EXPECTED OUTPUT

Provide exact code snippets only, grouped by:

Core1 Layout Blade

Updated Core1 Views

Core1 UI Components (if any)

Notes on UI parity decisions

⚠️ SAFETY RULES**

No global CSS overrides

No duplicated JavaScript logic

No shared state between modules

Core1 must remain fully independent

✅ Definition of Done

Core1 UI visually matches hr1 UI

No hr1 files were modified

No other modules affected

Core1 remains self-contained