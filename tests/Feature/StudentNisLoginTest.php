<?php

namespace Tests\Feature;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StudentNisLoginTest extends TestCase
{
    use RefreshDatabase;

    private function createStudentAsAdmin(array $overrides = []): TestResponse
    {
        $admin = User::factory()->admin()->create();
        $school = School::create(['name' => 'SMA Uji']);

        return $this->actingAs($admin)->post('/admin/students', array_merge([
            'name' => 'Rina Sehat',
            'username' => '0051234567',
            'nis' => '0421',
            'school_id' => $school->id,
        ], $overrides));
    }

    private function login(string $identity, string $password): TestResponse
    {
        return $this->post('/login', ['identity' => $identity, 'password' => $password]);
    }

    public function test_student_logs_in_with_name_and_nis_not_nisn(): void
    {
        $this->createStudentAsAdmin()->assertSessionHasNoErrors();
        auth()->logout();

        $student = User::where('username', '0051234567')->sole();
        $this->assertSame('0421', $student->nis);

        $this->login('Rina Sehat', '0051234567')->assertSessionHasErrors(['identity' => 'Nama atau NIS tidak valid.']);
        $this->assertGuest();

        $this->login('Rina Sehat', '0421')->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($student);
    }

    public static function invalidNis(): array
    {
        return [
            'missing' => [''],
            'three digits' => ['123'],
            'five digits' => ['12345'],
            'letters' => ['12ab'],
        ];
    }

    #[DataProvider('invalidNis')]
    public function test_nis_must_be_exactly_four_digits(string $nis): void
    {
        $this->createStudentAsAdmin(['nis' => $nis])->assertSessionHasErrors('nis');
        $this->assertSame(0, User::where('role', 'student')->count());
    }

    public function test_admin_can_change_nis_and_blank_nis_keeps_password(): void
    {
        $admin = User::factory()->admin()->create();
        $school = School::create(['name' => 'SMA Uji']);
        $student = User::factory()->create(['name' => 'Budi Gizi', 'nis' => '1111', 'password' => Hash::make('1111'), 'school_id' => $school->id]);
        $payload = ['name' => 'Budi Gizi', 'username' => $student->username, 'school_id' => $school->id];

        $this->actingAs($admin)->put("/admin/students/{$student->id}", $payload + ['nis' => ''])->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('1111', $student->refresh()->password));

        $this->actingAs($admin)->put("/admin/students/{$student->id}", $payload + ['nis' => '2222'])->assertSessionHasNoErrors();
        $student->refresh();
        $this->assertSame('2222', $student->nis);
        $this->assertTrue(Hash::check('2222', $student->password));

        $this->actingAs($admin)->put("/admin/students/{$student->id}", $payload + ['nis' => '22'])->assertSessionHasErrors('nis');
    }

    public function test_existing_student_without_nis_can_still_log_in_with_old_password(): void
    {
        User::factory()->create(['name' => 'Siswa Lama', 'nis' => null, 'password' => Hash::make('0099887766')]);

        $this->login('Siswa Lama', '0099887766')->assertRedirect('/dashboard');
    }

    public function test_admin_login_is_unchanged(): void
    {
        User::factory()->admin()->create(['username' => 'adminlms', 'password' => Hash::make('rahasia-panjang')]);

        $this->login('adminlms', 'rahasia-panjang')->assertRedirect('/admin');
    }

    public function test_nis_is_not_exposed_when_serialized(): void
    {
        $student = User::factory()->create(['nis' => '0421']);

        $this->assertArrayNotHasKey('nis', $student->toArray());
    }

    public function test_repeated_wrong_nis_is_throttled_per_student_not_per_school_network(): void
    {
        User::factory()->create(['name' => 'Target Siswa', 'nis' => '4321', 'password' => Hash::make('4321')]);
        User::factory()->create(['name' => 'Teman Sekelas', 'nis' => '8765', 'password' => Hash::make('8765')]);

        foreach (range(1, 5) as $guess) {
            $this->login('Target Siswa', sprintf('%04d', $guess))->assertSessionHasErrors('identity');
        }

        // Even the correct NIS is refused while the account is throttled...
        $this->login('Target Siswa', '4321')
            ->assertSessionHasErrors(['identity' => 'Terlalu banyak percobaan masuk. Coba lagi dalam 1 menit.']);
        $this->assertGuest();

        // ...but a classmate on the same IP can still log in.
        $this->login('Teman Sekelas', '8765')->assertRedirect('/dashboard');
    }
}
