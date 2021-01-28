<?php
namespace App\Http\Controllers;
use App\Student;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getAllStudents() {
      // logic to get all students goes here
        try
        {
          $student = Student::get()->toJson(JSON_PRETTY_PRINT);
          //dd($student);
          //print_r($student);
          return response($student,200);  
        }
        catch(\Exception $e)
        {
           return response()->json([
               "message" => "error".$e->getFile()."-".$e->getMessage()."-".$e->getLine(),
           ],201);
        }
        
    }

    public function createStudent(Request $request) {
        try{
            // dd($request->all());
            $student = new Student();
            $student->name = $request->name;
            $student->course = $request->course;
            $student->save();

            return response()->json([
                "message" => "student record created"
            ], 201);
        } catch(\Exception $e){
            return response()->json([
                "message" => "error".$e->getFile()."-".$e->getMessage()."-".$e->getLine(),
            ], 201);
        }
    }

    public function getStudent($id) {
      // logic to get a student record goes here
        //print_r($id); die;
        try {
            if(Student::where("id",$id)->exists()){
                $student = Student::where("id",$id)->get()->toJson(JSON_PRETTY_PRINT);
                return response($student, 200);
            } else {
                return response()->json([
                  "message" => "Student not found"
                ], 404);
            }  
        } catch(\Exception $e)
        {
            return responce()->json([
               "message" => "error".$e->getFile()."-".$e->getMessage()."-".$e->getLine(), 
            ],201);
        }
    }

    public function updateStudent(Request $request, $id) {
      // logic to update a student record goes here
        //print_r($id); die;
        try{
            if(Student::where("id",$id)->exists()){
                $student = Student::find($id);
                //print_r($student); die;

                $student->name = is_null($request->name) ? $student->name : $request->name;
                print_r($request->name); die;
                $student->course = is_null($request->course) ? $student->course : $request->course;
                $student->save();
                return response()->json([
                    "message" => "records updated successfully"
                ],201);
            } else {
                return response()->json([
                    "message" => "Student not found"
                ],404);
            }
        } catch(\Exception $e){
            return responce()->json([
               "message" => "error".$e->getFile()."-".$e->getMessage()."-".$e->getLine(), 
            ],201);
        }
    }

    public function deleteStudent ($id) {
      // logic to delete a student record goes here
        try{
            if(Student::where('id', $id)->exists()) {
            $student = Student::find($id);
            $student->delete();

            return response()->json([
              "message" => "records deleted"
            ], 202);
              } else {
                return response()->json([
                  "message" => "Student not found"
                ], 404);
              }
        } catch(\Exception $e){
            return responce()->json([
               "message" => "error".$e->getFile()."-".$e->getMessage()."-".$e->getLine(), 
            ],201);
        }
    }
}
