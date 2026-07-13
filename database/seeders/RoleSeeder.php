<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionGroups = [
            'master-data' => ['view', 'create', 'update', 'delete'],
            'user-manage' => ['view', 'create', 'update', 'delete'],
            'standar-mutu' => ['view', 'create', 'update', 'delete', 'approve'],
            'dokumen' => ['view', 'create', 'update', 'delete', 'submit', 'review', 'approve', 'publish'],
            'ppepp' => ['view', 'create', 'update', 'upload-eviden'],
            'audit' => ['view', 'create', 'update', 'approve-final'],
            'tindak-lanjut' => ['view', 'update', 'verify'],
            'survei' => ['view', 'create', 'fill'],
            'laporan' => ['view', 'create', 'download'],
            'dashboard' => ['view'],
        ];

        $allPermissions = [];
        foreach ($permissionGroups as $group => $actions) {
            foreach ($actions as $action) {
                $perm = Permission::create([
                    'name' => "{$group}.{$action}",
                    'guard_name' => 'web',
                ]);
                $allPermissions[] = $perm;
            }
        }

        $roles = [
            'super_admin' => $allPermissions,

            'admin_spmi' => [
                'master-data.view', 'master-data.create', 'master-data.update',
                'user-manage.view', 'user-manage.create', 'user-manage.update',
                'standar-mutu.view', 'standar-mutu.create', 'standar-mutu.update', 'standar-mutu.approve',
                'dokumen.view', 'dokumen.create', 'dokumen.update', 'dokumen.submit', 'dokumen.review', 'dokumen.approve', 'dokumen.publish',
                'ppepp.view', 'ppepp.create', 'ppepp.update',
                'audit.view', 'audit.create', 'audit.update', 'audit.approve-final',
                'tindak-lanjut.view', 'tindak-lanjut.update', 'tindak-lanjut.verify',
                'survei.view', 'survei.create',
                'laporan.view', 'laporan.create', 'laporan.download',
                'dashboard.view',
            ],

            'kajur' => [
                'master-data.view',
                'standar-mutu.view',
                'dokumen.view', 'dokumen.create', 'dokumen.update', 'dokumen.submit',
                'ppepp.view', 'ppepp.create', 'ppepp.update', 'ppepp.upload-eviden',
                'audit.view',
                'tindak-lanjut.view', 'tindak-lanjut.update',
                'survei.view',
                'laporan.view', 'laporan.download',
                'dashboard.view',
            ],

            'kaprodi' => [
                'master-data.view',
                'standar-mutu.view',
                'dokumen.view', 'dokumen.create', 'dokumen.update', 'dokumen.submit',
                'ppepp.view', 'ppepp.create', 'ppepp.update', 'ppepp.upload-eviden',
                'audit.view',
                'tindak-lanjut.view', 'tindak-lanjut.update',
                'survei.view',
                'laporan.view', 'laporan.download',
                'dashboard.view',
            ],

            'gpm' => [
                'master-data.view',
                'standar-mutu.view', 'standar-mutu.create', 'standar-mutu.update',
                'dokumen.view', 'dokumen.create', 'dokumen.update', 'dokumen.submit', 'dokumen.review',
                'ppepp.view', 'ppepp.create', 'ppepp.update',
                'audit.view', 'audit.create', 'audit.update',
                'tindak-lanjut.view', 'tindak-lanjut.update', 'tindak-lanjut.verify',
                'survei.view', 'survei.create',
                'laporan.view', 'laporan.create', 'laporan.download',
                'dashboard.view',
            ],

            'auditor' => [
                'standar-mutu.view',
                'dokumen.view', 'dokumen.review',
                'ppepp.view',
                'audit.view', 'audit.create', 'audit.update',
                'tindak-lanjut.view',
                'survei.view',
                'laporan.view', 'laporan.download',
                'dashboard.view',
            ],

            'auditor_ketua' => [
                'standar-mutu.view',
                'dokumen.view', 'dokumen.review', 'dokumen.approve',
                'ppepp.view',
                'audit.view', 'audit.create', 'audit.update', 'audit.approve-final',
                'tindak-lanjut.view', 'tindak-lanjut.verify',
                'survei.view',
                'laporan.view', 'laporan.create', 'laporan.download',
                'dashboard.view',
            ],

            'dosen' => [
                'standar-mutu.view',
                'dokumen.view', 'dokumen.create', 'dokumen.update',
                'ppepp.view', 'ppepp.create', 'ppepp.upload-eviden',
                'tindak-lanjut.view',
                'survei.view', 'survei.fill',
                'dashboard.view',
            ],

            'tendik' => [
                'master-data.view',
                'dokumen.view', 'dokumen.create', 'dokumen.update',
                'ppepp.view', 'ppepp.upload-eviden',
                'survei.view', 'survei.fill',
                'dashboard.view',
            ],

            'pimpinan' => [
                'master-data.view',
                'user-manage.view',
                'standar-mutu.view', 'standar-mutu.approve',
                'dokumen.view', 'dokumen.approve',
                'ppepp.view',
                'audit.view',
                'tindak-lanjut.view',
                'survei.view',
                'laporan.view', 'laporan.create', 'laporan.download',
                'dashboard.view',
            ],

            'mahasiswa' => [
                'dokumen.view',
                'survei.view', 'survei.fill',
                'dashboard.view',
            ],

            'alumni' => [
                'survei.view', 'survei.fill',
                'dashboard.view',
            ],

            'mitra_industri' => [
                'survei.view', 'survei.fill',
                'dashboard.view',
            ],
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::create([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
            $role->syncPermissions($permissions);
        }
    }
}
