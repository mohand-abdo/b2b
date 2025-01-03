<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$permissions = [
'حملات الحج والعمرة',

'الحجاج',
'قائمة الحجاج',
'قائمة الحجاج غير المفعلين',
'دفعيات الحجاج',
'كشف حساب حاج',



'العقود',
'قائمة العقود',
'إضافة عقد جديد',

'مراحل الرحلة',

'إدارة الحسابات',
'القيود اليومية',
'القيود المركبة',
'إدارة قيود اليومية',
'الارصدة الافتتاحية',
'إدارة الأرصدة الأفتتاحية',



'التقارير المحاسبية',
'تقرير كشف حسابات',
'دفتر اليومية',
'تقرير قيد يومية',
'الدفاتر المحاسبية',

'الأنشطة المحــاسبية',
'المستوي الاول',
'المستوي الثاني',
'المستوي الثالث',
'المستوي الرابع',

'المستخدمين والصلاحيات',
'قائمة المستخدمين',
'صلاحيات المستخدمين',
'إعدادات النظام',
'الإعدادات العامة',

'إضافة حملة',
'حذف حملة',
'تعديل حملة',


'إضافة حاج',
'حذف حاج',
'تعديل حاج',

'حذف عقد',
'تعديل عقد',

'إضافة مرحلة',
'حذف مرحلة',
'تعديل مرحلة',
'إضافة حجاج للمرحلة',

'إضافة نشاط',
'حذف نشاط',
'تعديل نشاط',

'إضافة مستخدم',
'حذف مستخدم',
'تعديل مستخدم',

'عرض صلاحية',
'إضافة صلاحية',
'تعديل صلاحية',
'حذف صلاحية',

'اضافة وكيل',
'ادارة الوكلاء',
'اضافة حاج ل بياناته',
'اضافة مرفق',
'كشف حساب عميل',
'تعيين كلمة المرور',
'استعادة مستخدم'

];
foreach ($permissions as $permission) {
Permission::create(['name' => $permission]);
}
}
}