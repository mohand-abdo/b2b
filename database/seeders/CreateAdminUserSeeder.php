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
            'name' => 'صديق الجالب',
            'email' => 'info@b2btravelsudan.com',
            'phone_number' => '0121496141',
            'password' => bcrypt('123456789'),
            'roles_name' => 'owner',
            'Status' => 'مفعل',
        ]);

        // إنشاء الأدوار
        $owner_role = Role::create(['name' => 'owner']);
        $agent_role = Role::create(['name' => 'agent']);
        $user_role = Role::create(['name' => 'user']);

        // جلب الصلاحيات
        $permissions_owner = Permission::whereNotIn('id', ['56', '57','58'])->pluck('id');
        $permissions_user = Permission::whereIn('id', ['56', '57','58'])->pluck('id');
        $permissions_agent = Permission::whereIn('id', ['2','3','5','6','10','35','36','37','40','41','42','43'])->pluck('id');

        // مزامنة الصلاحيات مع الأدوار
        $owner_role->syncPermissions($permissions_owner);
        $user_role->syncPermissions($permissions_user);
        $agent_role->syncPermissions($permissions_agent);

        // تعيين الدور للمستخدم
        $user->assignRole('owner');
    }
}
