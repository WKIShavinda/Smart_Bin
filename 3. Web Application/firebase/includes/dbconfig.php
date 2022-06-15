<?php
   require __DIR__.'/vendor/autoload.php';

   use Kreait\Firebase\Factory;
   use Kreait\Firebase\ServiceAccount;

   // This assumes that you have placed the Firebase credentials in the same directory
   // as this PHP file.
   /*$serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/yourjsonfile.json');
   $firebase = (new Factory)
      ->withServiceAccount($serviceAccount)
      ->withDatabaseUri('yourdatabaseproject.firebaseio.com')
      ->create();
      
   $database = $firebase->getDatabase();*/

   $factory = (new Factory)
   ->withServiceAccount(__DIR__ . '/swdss-e57ff-firebase-adminsdk-2weok-4c6d0b7c97.json')
   ->withDatabaseUri('https://swdss-e57ff-default-rtdb.asia-southeast1.firebasedatabase.app/');

   $database = $factory->createDatabase();
?>