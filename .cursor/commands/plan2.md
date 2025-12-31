🔐 PROMPT — Multi-Subsystem Account Registration via View (Laravel Monolith)

You are a senior Laravel engineer working inside an existing monolithic Laravel application that contains multiple subsystems (e.g. Admin, Doctor, Nurse, Receptionist, Patient, Billing, etc.).

Your task is to implement a registration flow that allows creating user accounts for each subsystem directly from the registration view, while keeping the system secure, isolated, and maintainable.

🎯 Objective

Enable a registration interface that can:

Create accounts for specific subsystems

Assign the correct role/subsystem at registration time

Ensure each created account:

Is linked to exactly one subsystem

Redirects correctly after login

Keep all changes minimal and scoped

🧩 Core Behavior
Registration View

Provide a controlled way to select the target subsystem during registration

Subsystem selection must be:

Explicit (dropdown / hidden value / pre-routed form)

Limited to allowed subsystems only

Do NOT allow free-text role input

Example subsystems:

admin

doctor

nurse

receptionist

patient

billing

Registration Logic

On submit:

Validate user credentials

Validate subsystem selection

Create the user with:

Correct role or subsystem value

Default secure values (hashed password, status, etc.)

Prevent:

Role escalation (e.g. patient registering as admin unintentionally)

Invalid subsystem values

Post-Registration Flow

After successful registration:

Either:

Redirect to login

Or auto-login and redirect to the correct subsystem dashboard

Redirection must be role/subsystem-based

🔒 Strict Constraints

❌ Do NOT modify database schema unless absolutely required

❌ Do NOT change existing role meanings or enums

❌ Do NOT affect existing users

❌ Do NOT break existing login flow

❌ Do NOT mix subsystem logic together

🛠 Allowed Scope of Changes
✅ Allowed

Registration Blade view

Registration controller logic

Validation rules

Role/subsystem assignment logic

❌ Not Allowed

Editing unrelated modules

Editing dashboards

Editing permission systems

Global refactors

🧱 Architecture Rules

Use Laravel conventions:

Form Requests (if already used)

Auth controllers

Named routes

Subsystem logic must be:

Centralized

Easy to audit

Avoid duplicated logic across controllers

📦 EXPECTED OUTPUT

Provide exact code snippets only, grouped as:

Registration Blade View

Subsystem selector (safe + controlled)

Registration Controller

Validation

User creation

Role/subsystem assignment

Redirect Logic

Clear mapping of subsystem → dashboard route

Security Notes

Brief explanation of how role abuse is prevented

⚠️ Safety Rules (CRITICAL)

Never trust frontend role values without validation

No hardcoded magic strings scattered across files

Use constants or controlled arrays for subsystems

Keep logic readable and auditable

✅ Definition of Done

Accounts can be registered for each subsystem

Each account is correctly assigned

Login redirects users to their subsystem dashboard

No existing functionality is broken