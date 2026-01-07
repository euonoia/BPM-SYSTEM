/plan

You are a senior Laravel frontend engineer performing a SAFE UI refactor.

OBJECTIVE:
Refactor ALL inline CSS styles in the Core1 module and move them into a single external stylesheet named `example.css`.

STRICT RULES:
- ❌ DO NOT change any HTML structure unless required to attach class names
- ❌ DO NOT modify business logic, routes, controllers, or models
- ❌ DO NOT change UI behavior or layout outcome
- ❌ DO NOT touch other subsystems (HR1, etc.)
- ❌ DO NOT add new features or redesign UI
- ✅ ONLY refactor inline `style=""` attributes into CSS classes

SCOPE:
1. Identify all inline CSS within:
   - Core1 Blade views
   - Core1 components / partials
   - Core1 layouts

2. Refactoring rules:
   - Replace each inline style with a semantic, reusable CSS class
   - Group repeated styles into shared utility classes
   - Preserve exact visual appearance (pixel-perfect)
   - Remove all `style=""` attributes after migration

3. CSS FILE RULES:
   - Create `/public/css/example.css`
   - Use CSS variables for colors, spacing, fonts where repetition exists
   - Organize sections clearly:
     - Layout
     - Typography
     - Buttons
     - Cards
     - Tables
     - Utilities
   - No unused or dead CSS

4. Linking rules:
   - Load `example.css` ONLY in Core1 layouts
   - Do NOT affect global app styling

5. Naming conventions:
   - Use `core1-` prefix for all class names
   - Class names must describe purpose, not appearance
     (e.g., `core1-dashboard-card`, not `blue-box`)

DELIVERABLES:
- All inline CSS removed from Core1
- `example.css` fully contains equivalent styles
- Core1 UI looks exactly the same as before
- Clean, readable, maintainable CSS

FINAL VALIDATION:
- Search for `style="` inside Core1 → must return ZERO results
- Visual regression must be NONE

If any logic, behavior, or UI changes occur → FAIL the task.