<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إنشاء المستخدم
        $user = User::create([
            'name' => 'مهند عبد الوهاب',
            'email' => 'admin@gmail.com',
            'phone_number' => '0121496141',
            'password' => bcrypt('123456789'),
            'roles_name' => 'owner',
            'Status' => 'مفعل',
        ]);

        // إنشاء الأدوار
        $owner_role = Role::create(['name' => 'owner']);
        $user_role = Role::create(['name' => 'user']);

        // جلب الصلاحيات
        $permissions_owner = Permission::whereNotIn('id', ['54', '55','56'])->pluck('id');
        $permissions_user = Permission::whereIn('id', ['54', '55','56'])->pluck('id');

        // مزامنة الصلاحيات مع الأدوار
        $owner_role->syncPermissions($permissions_owner);
        $user_role->syncPermissions($permissions_user);

        // تعيين الدور للمستخدم
        $user->assignRole('owner');
    }
}
