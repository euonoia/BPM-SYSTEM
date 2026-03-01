<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // run necessary migrations
        $this->artisan('migrate');
    }

    private function createUserWithRole(string $role)
    {
        return Employee::create([
            'employee_id' => strtoupper(substr($role,0,2)).rand(100,999),
            'first_name' => ucfirst($role),
            'last_name' => 'User',
            'email' => $role.'@example.com',
            'password' => bcrypt('password'),
            'role' => $role,
            'date_hired' => now(),
        ]);
    }

    public function test_hr_staff_cannot_access_payroll_or_compensation()
    {
        $staff = $this->createUserWithRole('hr_staff');
        $this->actingAs($staff, 'user');

        $this->get('/hr/hr4/payroll')->assertStatus(403);
        $this->get('/hr/hr4/compensation')->assertStatus(403);
        // should still access others
        $this->get('/hr/hr4/human-capital')->assertStatus(200);
        $this->get('/hr/hr4/analytics')->assertStatus(200);
    }

    public function test_hr_head_can_access_all_user_modules()
    {
        $head = $this->createUserWithRole('hr_head');
        $this->actingAs($head, 'user');

        $this->get('/hr/hr4/payroll')->assertStatus(200);
        $this->get('/hr/hr4/compensation')->assertStatus(200);
        $this->get('/hr/hr4/human-capital')->assertStatus(200);
        $this->get('/hr/hr4/analytics')->assertStatus(200);
    }

    public function test_admin_can_access_modules_even_without_user_role()
    {
        // create a dummy admin-style employee record
        $admin = Employee::create([
            'employee_id' => 'AD'.rand(100,999),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'date_hired' => now(),
        ]);
        $this->actingAs($admin, 'admin');

        $this->get('/hr/hr4/payroll')->assertStatus(200);
        $this->get('/hr/hr4/compensation')->assertStatus(200);
        $this->get('/hr/hr4/human-capital')->assertStatus(200);
        $this->get('/hr/hr4/analytics')->assertStatus(200);
    }
}
