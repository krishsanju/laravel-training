<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Models\User;
use App\Models\Address;
use App\Models\Post;
use App\Models\Role;
use App\Models\Staff;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');


//One to one
        Route::get('/insertAddress', function () {
            $user = User::findorFail(1);
            $address = new Address(['name'=>'56-89, srinagar, vsp']);
            $user->address()->save($address);
        });
        //to access the data (tinker) use -->>   $user->address->name;


//One to Many
        Route::get('/insertPost', function () {
            $user = User::findorFail(2);

            $post = new Post(['title' => 'twp Post' , 'description' => 'There is ntg is there to tell']);
            $user->posts()->save($post);
        });

        Route::get('/readPost', function () {
            $user = User::findorFail(1);
            // return $user->posts; //returns a collection
            foreach ($user->posts as $post) {
                echo $post->title.'<br>';
            }

            // --------------- N+1 problem -----------------
            $users = User::with('posts')->get();
            foreach ($users as $user) {
                foreach ($user->posts as $post) {
                    echo $post->user->name.'<br>'; // Uh-oh! More queries here!
                }
            }
        });

//Many to Many
        Route::get('/createRole', function () {
            $user = User::findOrFail(1);
            $user->roles()->save(new Role(['name'=> 'Administrator']));
        });

        Route::get('/read', function () {
            $user = User::findOrFail(1);
            // return $user->roles;
            foreach ($user->roles as $role) {
                echo $role->name.'<br>';
            }
        });


        // Route::get('/user/{id}', function ($id) {
        //     $user = User::find($id);
        //     $user->name = 'xxxx'.$user->name.'0000';
        //     $user->save();
        //     return $user;
        // });

        Route::get('/attach', function () {
            $user = User::findOrFail(1);
            $user->roles()->attach(3);
        });

        Route::get('/detach', function () {
            $user = User::findOrFail(1);
            $user->roles()->detach(3);
        });

        Route::get('/sync', function () {
            $user = User::findOrFail(2);
            $user->roles()->sync([1,3]);
        });


// Polymorphic relationships

    Route::get('/create', function () {
        $staff = Staff::findOrFail(1);

        $staff->photos()->create(['path' => 'image2.png']);
    });

    Route::get('/read', function () {
        $staff = Staff::findOrFail(1);
        $staff->photos;
    });