<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Employee;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_employee_user()
    {
        $admin = \App\Models\Admin::create([
            'name' => 'Test Admin',
            'email' => 'testadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin'
        ]);
        $this->actingAs($admin, 'admin');

        $response = $this->post(route('hr.hr4.admin.users.store'), [
            'employee_id' => 'ABC123',
            'first_name' => 'Alice',
            'last_name' => 'Smith',
            'role' => 'hr_staff',
            'department' => 'HR',
            'position' => 'Clerk',
            'basic_salary' => 40000,
            'date_hired' => now()->format('Y-m-d'),
            'status' => 'active',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertRedirect(route('hr.hr4.admin.users.index'));
        $this->assertDatabaseHas('employees', ['employee_id' => 'ABC123', 'role' => 'hr_staff']);
    }
}
