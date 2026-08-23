<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Arr;

Route::get('/', function () {
    return view('welcome');
});


route::get('/students',function()
{
    $students = [
        ["id" => 1, "name" => "Ali", "email" => "ali@gmail.com"],
        ["id" => 2, "name" => "Abdelrahman", "email" => "abdelrahman@gmail.com"],
        ["id" => 3, "name" => "Hassan", "email" => "hassan@gmail.com"],
        ["id" => 4, "name" => "Mohammed", "email" => "mohammed@gmail.com"],
    ];

return view('allStudents',compact("students"));
});



Route::get('/students/{id}', function ($id) {
    $students = [
        ["id" => 1, "name" => "Ali", "email" => "ali@gmail.com"],
        ["id" => 2, "name" => "Abdelrahman", "email" => "abdelrahman@gmail.com"],
        ["id" => 3, "name" => "Hassan", "email" => "hassan@gmail.com"],
        ["id" => 4, "name" => "Mohammed", "email" => "mohammed@gmail.com"],
    ];

    // Find student by ID
    $student = Arr::first($students, fn ($item) => $item['id'] == $id);

    // Set error message if student does not exist
    $error = $student ? null : "Student with ID {$id} was not found.";

    return view('student', compact('student', 'error'));
});