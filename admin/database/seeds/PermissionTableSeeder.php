<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->insert([
            ['permission' => 'show-users', 'title' => 'Melihat daftar user CTI'],
            ['permission' => 'add-user', 'title' => 'Menambah user CTI baru'],
            ['permission' => 'edit-user', 'title' => 'Merubah data user CTI'],
            ['permission' => 'delete-user', 'title' => 'Menghapus user CTI'],
            ['permission' => 'upload-users', 'title' => 'Upload daftar user CTI'],

            ['permission' => 'show-groups', 'title' => 'Melihat daftar group'],
            ['permission' => 'add-member', 'title' => 'Menambah anggota group'],
            ['permission' => 'delete-member', 'title' => 'Menghapus anggota group'],
            ['permission' => 'upload-groups', 'title' => 'Upload anggota group'],

            ['permission' => 'show-statuses', 'title' => 'Melihat daftar status'],
            ['permission' => 'add-status', 'title' => 'Menambah status baru'],
            ['permission' => 'edit-status', 'title' => 'Merubah status'],
            ['permission' => 'delete-status', 'title' => 'Menghapus status'],
            
            ['permission' => 'show-dispositions', 'title' => 'Melihat daftar disposition'],
            ['permission' => 'add-disposition', 'title' => 'Menambah disposition baru'],
            ['permission' => 'edit-disposition', 'title' => 'Merubah disposition'],
            ['permission' => 'delete-disposition', 'title' => 'Menghapus disposition'],

            ['permission' => 'show-campaigns', 'title' => 'Melihat daftar campaign autodialer'],
            ['permission' => 'add-campaign', 'title' => 'Menambah campaign autodialer baru'],
            ['permission' => 'edit-campaign', 'title' => 'Merubah data campaign autodialer'],
            ['permission' => 'delete-campaign', 'title' => 'Menghapus campaign autodialer'],
            ['permission' => 'upload-campaign', 'title' => 'Upload data campaign autodialer'],
            ['permission' => 'distribute-campaign', 'title' => 'Distribusi data campaign autodialer'],
            ['permission' => 'start-campaign', 'title' => 'Start/stop campaign autodialer'],

            ['permission' => 'show-context', 'title' => 'Melihat daftar context dialplan'],
            ['permission' => 'add-context', 'title' => 'Menambah context dialplan baru'],
            ['permission' => 'edit-context', 'title' => 'Merubah context dialplan'],
            ['permission' => 'delete-context', 'title' => 'Menghapus context dialplan'],
            ['permission' => 'add-extension', 'title' => 'Menambah extension context dialplan'],
            ['permission' => 'edit-extension', 'title' => 'Merubah extension context dialplan'],
            ['permission' => 'delete-extension', 'title' => 'Menghapus extension context dialplan'],
            ['permission' => 'add-include', 'title' => 'Menambah include context dialplan'],
            ['permission' => 'delete-include', 'title' => 'Menghapus include context dialplan'],

            ['permission' => 'show-trunk', 'title' => 'Melihat daftar trunk SIP'],
            ['permission' => 'add-trunk', 'title' => 'Menambah trunk SIP baru'],
            ['permission' => 'edit-trunk', 'title' => 'Merubah data trunk SIP'],
            ['permission' => 'delete-trunk', 'title' => 'Menghapus trunk SIP'],

            ['permission' => 'show-peer', 'title' => 'Melihat daftar peer SIP'],
            ['permission' => 'add-peer', 'title' => 'Menambah peer SIP baru'],
            ['permission' => 'edit-peer', 'title' => 'Merubah data peer SIP'],
            ['permission' => 'delete-peer', 'title' => 'Menghapus peer SIP'],
            ['permission' => 'generate-peer', 'title' => 'Generate daftar peer SIP'],

            ['permission' => 'show-queue', 'title' => 'Melihat daftar queue'],
            ['permission' => 'add-queue', 'title' => 'Menambah queue baru'],
            ['permission' => 'edit-queue', 'title' => 'Merubah data queue'],
            ['permission' => 'delete-queue', 'title' => 'Menghapus queue'],
            ['permission' => 'add-queue-member', 'title' => 'Menambah anggota queue'],
            ['permission' => 'delete-queue-member', 'title' => 'Menghapus anggota queue'],

            ['permission' => 'show-session-report', 'title' => 'Melihat report detail session user'],
            ['permission' => 'show-status-report', 'title' => 'Melihat report detail status user'],
            ['permission' => 'show-call-log', 'title' => 'Melihat log record telepon'],
            ['permission' => 'show-favorite-report', 'title' => 'Melihat report nomor favorite'],
            ['permission' => 'show-chat-log', 'title' => 'Melihat log record chat '],
        ]);
    }
}
