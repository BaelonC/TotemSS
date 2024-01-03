<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
class InitSeeder extends Seeder
{
    public function run()
    {
       $faker =Factory::create();
       $countries= [];
       
     
       
       
//       for ($i=0; $i <= 14 ; $i++) {
//           
//          $created_at= $faker->dateTime();
//          $updated_at= $faker->dateTimeBetween($created_at);
//           
//          $countries[] = [
//            'NAME'  => $faker-> country,
//            'CREATED_AT'=> $created_at->format('d-m-Y H:i:s'),
//            'UPDATED_AT'=> $updated_at->format('d-m-Y H:i:s')
//               
//               
//               
//           ];
//       
//       }
       
      d($countries);
      $builder = $this->db->table('COUNTRIES') ;
      // $builder->insertBatch($countries);
     
      $paso1='10984694-5';
       
       $data2= [
            'NAME'  => $paso1,
            'CREATED_AT'=> '',
            'UPDATED_AT'=> '',
           
           
           
       ];
      
       $builder->insert($data2);
       
//      $group =[ 
//          [  'name_group' => 'admin',
//              'created_at' => date('Y-m-d H:i:s'),
//              'update_at' => date('Y-m-d H:i:s')
//              
//              
//              ],
//          [  'name_group' => 'user',
//              'created_at' => date('Y-m-d H:i:s'),
//              'update_at' => date('Y-m-d H:i:s')
//              
//              
//              ]
//          
//          
//      ];
    }
}
