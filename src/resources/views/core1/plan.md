You are a senior Laravel engineer working on a Hospital Management System.

Your task is to IMPROVE the **Receptionist Appointment Management** feature ONLY.
Do NOT modify other subsystems (billing, medical records, inpatient, OPD, auth, or UI design tokens).

PROJECT CONTEXT:
- Framework: Laravel (Blade + Controllers + Models)
- System: Hospital Management System
- Role: Receptionist
- Module: Doctor Appointment System

GOAL:
Enhance the receptionist’s ability to efficiently manage appointments with better flow, validation, and usability.

SCOPE (DO NOT GO OUTSIDE THIS):
1. Appointment creation by receptionist
2. Appointment rescheduling & cancellation
3. Doctor availability checking
4. Waiting list & no-show handling
5. Real-time appointment status updates

REQUIREMENTS:
- Use Laravel best practices (routes, controllers, request validation, models)
- Use Form Request validation (no inline validation)
- Use Eloquent relationships (Patient, Doctor, Appointment)
- Ensure collision-safe appointment IDs
- Prevent double-booking of doctors
- Respect doctor working hours & leave schedules
- Handle time slot conflicts correctly
- Record receptionist actions (basic audit trail)

FUNCTIONAL FLOW (RECEPTIONIST):
- Search or select existing patient
- Select doctor
- View doctor availability (date + time slots)
- Book / reschedule / cancel appointment
- Mark no-show
- Move patient to waiting list
- Notify next patient when slot opens

OUTPUT EXPECTATIONS:
- Updated Controller logic
- Clean, minimal Blade updates (no UI redesign)
- Route definitions (only if missing)
- Clear comments explaining receptionist-specific logic
- Database logic only where necessary (no migrations unless required)

STRICT RULES:
- Do NOT modify authentication or role system
- Do NOT change database schema unless unavoidable
- Do NOT refactor unrelated files
- Do NOT introduce new UI libraries
- Do NOT change other roles’ appointment flows

DELIVERABLE:
Provide production-ready Laravel code snippets and explanations focused ONLY on improving the receptionist appointment workflow.