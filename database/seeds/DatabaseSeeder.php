<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('users')->insert([
            'full_name'     	=> 'Admin Admin',
            'email'         	=> 'admin@gmail.com',
            'password'      	=> bcrypt('123456'),
            'last_login'    	=> Carbon::now()->format('Y-m-d H:i:s'),
            'status'        	=> 1,
            'is_admin'      	=> 1,
            'email_confirmed'   => 1,
            'created_at'    	=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    	=> Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'full_name'         => 'Master',
            'email'             => 'master@gmail.com',
            'password'          => bcrypt('123456'),
            'last_login'        => Carbon::now()->format('Y-m-d H:i:s'),
            'status'            => 1,
            'is_admin'          => 1,
            'email_confirmed'   => 1,
            'type'              => 33,
            'created_at'        => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'        => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'full_name'     	=> 'User User',
            'email'         	=> 'user@gmail.com',
            'password'      	=> bcrypt('123456'),
            'last_login'    	=> Carbon::now()->format('Y-m-d H:i:s'),
            'status'        	=> 1,
            'is_admin'      	=> 0,
            'email_confirmed'   => 1,
            'type'              => 1,
            'created_at'    	=> Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    	=> Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'full_name'         => 'Assistant',
            'email'             => 'assistant@gmail.com',
            'password'          => bcrypt('123456'),
            'last_login'        => Carbon::now()->format('Y-m-d H:i:s'),
            'status'            => 1,
            'is_admin'          => 0,
            'email_confirmed'   => 1,
            'type'              => 2,
            'created_at'        => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'        => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('settings')->insert([
            'project'               => 'CMS',
            'route_login_panel'     => 'panel',
            'maintenance_mode'      => 0,
            'coming_soon_mode'      => 0,
            'email_notification'    => 'admin@gmail.com',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        //-----------------------------------------------------------------------------
        
        DB::table('roles')->insert([
            'title'         => 'Administrador',
            'name'          => 'admin',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('roles')->insert([
            'title'         => 'Asistente',
            'name'          => 'assistant',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('permissions')->insert([
            'title'         => 'Crear',
            'name'          => 'create-action',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('permissions')->insert([
            'title'         => 'Editar',
            'name'          => 'edit-action',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('permissions')->insert([
            'title'         => 'Eliminar',
            'name'          => 'delete-action',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('permissions')->insert([
            'title'         => 'M&oacute;dulo - Blog',
            'name'          => 'blog-module',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('permissions')->insert([
            'title'         => 'M&oacute;dulo - Clientes',
            'name'          => 'users-module',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('permissions')->insert([
            'title'         => 'M&oacute;dulo - Asistentes',
            'name'          => 'assistants-module',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('permissions')->insert([
            'title'         => 'M&oacute;dulo - Roles & Permisos',
            'name'          => 'security-module',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('permissions')->insert([
            'title'         => 'M&oacute;dulo - Ajustes',
            'name'          => 'settings-module',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('permissions')->insert([
            'title'         => 'Sesi&oacute;n en Panel',
            'name'          => 'login-panel',
            'guard_name'    => 'web',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('role_has_permissions')->insert([
            'role_id'       => 1,
            'permission_id' => 1
        ]);

        DB::table('role_has_permissions')->insert([
            'role_id'       => 1,
            'permission_id' => 2
        ]);

        DB::table('role_has_permissions')->insert([
            'role_id'       => 1,
            'permission_id' => 3
        ]);

        DB::table('role_has_permissions')->insert([
            'role_id'       => 1,
            'permission_id' => 4
        ]);

        DB::table('role_has_permissions')->insert([
            'role_id'       => 1,
            'permission_id' => 5
        ]);        

        DB::table('role_has_permissions')->insert([
            'role_id'       => 1,
            'permission_id' => 6
        ]);

        DB::table('role_has_permissions')->insert([
            'role_id'       => 1,
            'permission_id' => 7
        ]);

        DB::table('role_has_permissions')->insert([
            'role_id'       => 1,
            'permission_id' => 8
        ]);

        DB::table('role_has_permissions')->insert([
            'role_id'       => 1,
            'permission_id' => 9
        ]);

        //-----------------------------------------------------------------------------

        DB::table('languages')->insert([
            'title'         => 'Espa&ntilde;ol',
            'lang'          => 'es',
            'status'        => 1,
            'main'          => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('languages')->insert([
            'title'         => 'Ingles',
            'lang'          => 'en',
            'status'        => 1,
            'main'          => 0,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        //-----------------------------------------------------------------------------

        DB::table('responsibilities')->insert([
            'code'          => 1,
            'title'         => 'Aporte especial para la administraci&oacute;n de justicia.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 2,
            'title'         => 'Gravamen a los movimientos financieros.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 3,
            'title'         => 'Impuesto al patrimonio.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 4,
            'title'         => 'Impuesto renta y complementario r&eacute;gimen especial.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 5,
            'title'         => 'Impuesto renta y complementario r&eacute;gimen ordinario.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 6,
            'title'         => 'Ingresos y patrimonio.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 7,
            'title'         => 'Retenci&oacute;n en la fuente a t&iacute;tulo de renta.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 8,
            'title'         => 'Retenci&oacute;n timbre nacional.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 9,
            'title'         => 'Retenci&oacute;n en la fuente en el impuesto sobre las ventas.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 10,
            'title'         => 'Obligado aduanero.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 13,
            'title'         => 'Gran contribuyente.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 14,
            'title'         => 'Informante de ex&oacute;gena.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 15,
            'title'         => 'Autorretenedor.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 16,
            'title'         => 'Obligaci&oacute;n facturar por ingresos bienes y/o servicios excluidos.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 17,
            'title'         => 'Profesionales de compra y venta de divisas.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 18,
            'title'         => 'Precios de transferencia.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 19,
            'title'         => 'Productor de bienes y/o servicios exentos.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 20,
            'title'         => 'Obtención NIT.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 21,
            'title'         => 'Declarar ingreso o salida del pa&iacue;s de divisas o moneda l.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 22,
            'title'         => 'Obligado a cumplir deberes formales a nombre de terceros.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 23,
            'title'         => 'Agente de retenci&oacute;n en ventas.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 24,
            'title'         => 'Declaraci&oacute;n consolidada precios de transferencia.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 26,
            'title'         => 'Declaraci&oacute;n individual precios de transferencia.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 32,
            'title'         => 'Impuesto nacional a la gasolina y al ACPM.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 33,
            'title'         => 'Impuesto nacional al consumo.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 36,
            'title'         => 'Establecimiento Permanente.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 37,
            'title'         => 'Obligado a Facturar Electrónicamente.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 38,
            'title'         => 'Facturación Electrónica Voluntaria.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 39,
            'title'         => 'Proveedor de Servicios Tecnológicos PST.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 41,
            'title'         => 'Declaración anual de activos en el exterior.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('responsibilities')->insert([
            'code'          => 45,
            'title'         => 'Autorretenedor de rendimientos financieros.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 46,
            'title'         => 'IVA Prestadores de Servicios desde el Exterior.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 47,
            'title'         => 'R&eacute;gimen Simple de Tributaci&oacute;n - SIMPLE.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 48,
            'title'         => 'Impuesto sobre las ventas - IVA.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 49,
            'title'         => 'No responsable de IVA.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 50,
            'title'         => 'No responsable de Consumo restaurantes y bares.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 51,
            'title'         => 'Agente retenci&oacute;n impoconsumo de bienes inmuebles.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 52,
            'title'         => 'Facturador electr&oacute;nico.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('responsibilities')->insert([
            'code'          => 53,
            'title'         => 'Persona Jur&iacute;dica No Responsable de IVA.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        //================================================================================================================

        DB::table('sectionals')->insert([
            'code'          => "00",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Armenia',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('sectionals')->insert([
            'code'          => "02",
            'title'         => 'Dirección Seccional de Impuestos de Barranquilla',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "03",
            'title'         => 'Dirección Seccional de Aduanas de Bogotá',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "04",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Bucaramanga',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "05",
            'title'         => 'Dirección Seccional de Impuestos de Cali',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "06",
            'title'         => 'Dirección Seccional de Impuestos de Cartagena',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "07",
            'title'         => 'Dirección Seccional de Impuestos de Cúcuta',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "08",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Girardot',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "09",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Ibagué',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "10",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Manizales',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "11",
            'title'         => 'Dirección Seccional de Impuestos de Medellín',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "12",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Montería',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "13",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Neiva',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "14",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Pasto',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "15",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Palmira',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "16",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Pereira',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "17",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Popayán',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "18",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Quibdó',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "18",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Santa Marta',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "20",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Tunja',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "21",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Tuluá',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "22",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Villavicencio',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);



        DB::table('sectionals')->insert([
            'code'          => "23",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Sincelejo',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "24",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Valledupar',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "25",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Riohacha',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "26",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Sogamoso',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "27",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de San Andrés',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "28",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Florencia',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('sectionals')->insert([
            'code'          => "29",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Barrancabermeja',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('sectionals')->insert([
            'code'          => "31",
            'title'         => 'Dirección Seccional de Impuestos de Grandes Contribuyentes',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('sectionals')->insert([
            'code'          => "32",
            'title'         => 'Dirección Seccional de Impuestos de Bogotá',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('sectionals')->insert([
            'code'          => "34",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Arauca',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "35",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Buenaventura',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "36",
            'title'         => 'Dirección Seccional Delegada de Impuestos y Aduanas de Cartago',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "37",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Ipiales',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "38",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Leticia',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "39",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Maicao',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "40",
            'title'         => 'Dirección Seccional Delegada de Impuestos y Aduanas de Tumaco',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "41",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Urabá',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "42",
            'title'         => 'Dirección Seccional Delegada de Impuestos y Aduanas de Puerto Carreño',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "43",
            'title'         => 'Dirección Seccional Delegada de Impuestos y Aduanas de Inírida',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "44",
            'title'         => 'Dirección Seccional de Impuestos y Aduanas de Yopal',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "45",
            'title'         => 'Dirección Seccional Delegada de Impuestos y Aduanas Mitú',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "46",
            'title'         => 'Dirección Seccional Delegada de Impuestos y Aduanas de Puerto Asís',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "48",
            'title'         => 'Dirección Seccional de Aduanas de Cartagena',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "78",
            'title'         => 'Dirección Seccional Delegada de Impuestos y Aduanas de San José de Guaviare',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "86",
            'title'         => 'Dirección Seccional Delegada de Impuestos y Aduanas de Pamplona',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "87",
            'title'         => 'Dirección Seccional de Aduanas de Barranquilla',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "88",
            'title'         => 'Dirección Seccional de Aduanas de Cali',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "89",
            'title'         => 'Dirección Seccional de Aduanas de Cúcuta',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('sectionals')->insert([
            'code'          => "90",
            'title'         => 'Dirección Seccional de Aduanas de Medellín',
            'status'        => 1,
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        //=========================================================================================================

        DB::table('banks')->insert([
            'code'          => "01",
            'name'          => 'BANCO DE BOGOTÁ',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "02",
            'name'          => 'BANCO POPULAR',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "06",
            'name'          => 'ITAÚ CORPBANCA COLOMBIA S.A',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "07",
            'name'          => 'BANCOLOMBIA S.A.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "09",
            'name'          => 'CITIBANK COLOMBIA',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "12",
            'name'          => 'BANCO GNB SUDAMERIS COLOMBIA',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "13",
            'name'          => 'BBVA COLOMBIA',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "19",
            'name'          => 'RED MULTIBANCA COLPATRIA S.A.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('banks')->insert([
            'code'          => "23",
            'name'          => 'BANCO DE OCCIDENTE',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "32",
            'name'          => 'BANCO CAJA SOCIAL - BCSC S.A.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "40",
            'name'          => 'BANCO AGRARIO DE COLOMBIA S.A.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "51",
            'name'          => 'BANCO DAVIVIENDA S.A.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "52",
            'name'          => 'BANCO AV VILLAS',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "53",
            'name'          => 'BANCO W S.A.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "58",
            'name'          => 'BANCO PROCREDIT',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "59",
            'name'          => 'BANCAMIA',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "60",
            'name'          => 'BANCO PICHINCHA S.A.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "61",
            'name'          => 'BANCOOMEVA',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "62",
            'name'          => 'BANCO FALABELLA S.A.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "63",
            'name'          => 'BANCO FINANDINA S.A.',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "66",
            'name'          => 'BANCO COOPERATIVO COOPCENTRAL',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "67",
            'name'          => 'BANCO COMPARTIR S.A',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "99",
            'name'          => 'TIDIS (Deceval)',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('banks')->insert([
            'code'          => "9A",
            'name'          => 'SCOTIABANK',
            'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


    }
}