### Add/Edit Logic

Example is (`logbook.blade.php`) is connected to (`AddLogbookModal.php`) that handles add, edit
Another Example is (`to-do-list.blade.php`) is connected to (`AddToDoModal.php`) that handles add, edit, finish

add, edit, finish is code for the mode for what each modal do and this must not be changed to anything like add to adding or this will break the flow

Example in logbook.blade.php
- Clicking “Add” dispatches the `add-logbook`.
- Clicking “Edit” dispatches the `edit-logbook` event with a logbook ID.
This is received in (`AddLogbookModal.php`) in
#[On('add-logbook')]
#[On('edit-logbook')]
which will run the function to prep the modal for the mode

Example in to-do-list.blade.php
- Clicking “Add” dispatches the `add-to-do`.
- Clicking “Edit” dispatches the `edit-to-do` event with a to do list ID.
- Clicking “Finish” dispatches the `finish-to-do` event with a to do list ID.
This is received in (`AddToDoModal.php`) in
#[On('add-to-do')]
#[On('edit-to-do')]
#[On('finish-to-do')]
which will run the function to prep the modal for the mode

### Form submit() behavior

This function uses `$mode` to switch between create and edit behavior.

Example for logbook 

- `add` mode:
  - Creates a new logbook entry
  - `company_id` and `created_by` are derived from the authenticated user

- `edit` mode:
  - Updates an existing logbook entry
  - Entry must belong to the same company AND creator
  - `created_by` is intentionally immutable

`$mode` is set on function with 
#[On('add-logbook')]
#[On('edit-logbook')]
which this is triggere by UI actions (Add button or Edit event)

Example for to do list 

- `add` mode:
  - Creates a new to do list entry
  - `company_id` and `created_by` are derived from the authenticated user

- `edit` mode:
  - Updates an existing to do list entry
  - Entry must belong to the same company AND creator
  - `created_by` is intentionally immutable

`$mode` is set on function with 
#[On('add-to-do')]
#[On('edit-to-do')]
which this is triggere by UI actions (Add button or Edit event)

This architecture is chosen to prevent duplicate coding for add, edit, finish action.

⚠️ When modifying Modal component, remember that `$mode` is supposed to universally to be
`add`
`edit`
`finish`
some menu like logbook have no finsih mode and it's ok, but don't change the naming that already exists without replacing it everywhere

⚠️ For new mode that is going to be created, always reset validation, set mode, set naming for the modal