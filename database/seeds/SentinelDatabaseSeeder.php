<?php

use Illuminate\Database\Seeder;

class SentinelDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Users
        DB::table('users')->truncate();

        $admin = Sentinel::getUserRepository()->create(array(
            'email'    => 'admin@admin.com',
            'password' => 'password',
            'first_name' => 'admin',
            'last_name' => 'admin'
        ));

        $user = Sentinel::getUserRepository()->create(array(
            'email'    => 'bernard@user.com',
            'password' => 'password',
            'first_name' => 'bernard',
            'last_name' => 'chaussette'
        ));

        $doc = Sentinel::getUserRepository()->create(array(
            'email'    => 'doc@doc.com',
            'password' => 'password',
            'first_name' => 'zoidberg',
            'last_name' => 'homard'
        ));

        $doc2 = Sentinel::getUserRepository()->create(array(
            'email'    => 'doc2@doc.com',
            'password' => 'password',
            'first_name' => 'chopper',
            'last_name' => 'maniac'
        ));

        $expert = Sentinel::getUserRepository()->create(array(
            'email'    => 'winston@expert.com',
            'password' => 'password',
            'first_name' => 'winston',
            'last_name' => 'antilope'
        ));

        $expert2 = Sentinel::getUserRepository()->create(array(
            'email'    => 'houston@expert.com',
            'password' => 'password',
            'first_name' => 'houston',
            'last_name' => 'hoxton'
        ));

        // Create Activations
        DB::table('activations')->truncate();
        $code = Activation::create($admin)->code;
        Activation::complete($admin, $code);
        $code = Activation::create($user)->code;
        Activation::complete($user, $code);
        $code = Activation::create($expert)->code;
        Activation::complete($expert, $code);
        $code = Activation::create($expert2)->code;
        Activation::complete($expert2, $code);
        $code = Activation::create($doc)->code;
        Activation::complete($doc, $code);
        $code = Activation::create($doc2)->code;
        Activation::complete($doc2, $code);

        // Create Roles
        $administratorRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Administrateur',
            'slug' => 'administrateur',
            'permissions' => array(
                'users.create' => true,
                'users.update' => true,
                'users.view' => true,
                'users.destroy' => true,
                'roles.create' => true,
                'roles.update' => true,
                'roles.view' => true,
                'roles.delete' => true
            )
        ));
        $expertRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Expert',
            'slug' => 'expert',
            'permissions' => array()
        ));
        $docRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'Praticien',
            'slug' => 'praticien',
            'permissions' => array(
                'users.update' => true,
                'users.view' => true,
            )
        ));
        $subscriberRole = Sentinel::getRoleRepository()->create(array(
            'name' => 'User',
            'slug' => 'user',
            'permissions' => array()
        ));

        // Assign Roles to Users
        $administratorRole->users()->attach($admin);
        $subscriberRole->users()->attach($user);
        $expertRole->users()->attach($expert);
        $expertRole->users()->attach($expert2);
        $docRole->users()->attach($doc);
        $docRole->users()->attach($doc2);

        $data = array(
            array('name'=>'Alimentation'),
            array('name'=>'Acupuncture'),
            array('name'=>'Anthropologie'),
            array('name'=>'Aromathérapie'),
            array('name'=>'Auriculo-réflexologie'),
            array('name'=>'Chiropraxie'),
            array('name'=>'Diététique'),
            array('name'=>'EFT'),
            array('name'=>'EMDR'),
            array('name'=>'Ethnomédecines'),
            array('name'=>'Feng Shui'),
            array('name'=>'Fleurs de Bach'),
            array('name'=>'Gemmothérapie'),
            array('name'=>'Herboristerie'),
            array('name'=>'Homéopathie'),
            array('name'=>'Hypnose'),
            array('name'=>'Magnétisme'),
            array('name'=>'Massage traditionnel Thaï'),
            array('name'=>'Masseurs-kinésithérapeutes'),
            array('name'=>'Médecine Ayurvédique'),
            array('name'=>'Médecine Energétique'),
            array('name'=>'Médecine traditionnelle chinoise'),
            array('name'=>'Mycothérapie'),
            array('name'=>'Naturopathie'),
            array('name'=>'Nutrithérapie'),
            array('name'=>'Olfactothérapie'),
            array('name'=>'Oligothérapie'),
            array('name'=>'Ostéopathie'),
            array('name'=>'Phytothérapie'),
            array('name'=>'Posturologie'),
            array('name'=>'Qi Gong'),
            array('name'=>'Réflexologie plantaire Thaïe'),
            array('name'=>'Réflexologie plantaire'),
            array('name'=>'relaxation'),
            array('name'=>'Rhinoréflexologie'),
            array('name'=>'Shiatsu'),
            array('name'=>'Rhinoréflexologie'),
            array('name'=>'Somato émotionnel'),
            array('name'=>'Rhinoréflexologie'),
            array('name'=>'Sophrologie'),
        );

        DB::table('skills')->insert($data);

    }
}