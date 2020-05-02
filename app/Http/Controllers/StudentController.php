<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Student::get();

        return response()->json([
            "students" => $all,
            "error" => false,
            "message" => "All Students Data"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obj = new Student();
        $obj->name = $request->name;

        $imageName = time().'.'.$request->image->extension();  
        $request->image->move(public_path('uploads'), $imageName);
        
        $obj->image = $imageName;
        $obj->description = $request->description;
        if($obj->save())
            return response()->json([
                "data" => $obj,
                "error" => false,
                "message" => "Student Stored Succesfully"
            ]);
        else
            return response()->json([
                "error" => true,
                "message" => "Student Cannot be Stored!"
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getData($id)
    {

        $obj = new Student();
        $obj = $obj->find($id);

        return response()->json([
            "student" => $obj,
            "error" => false,
            "message" => "Student Data retrieved"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obj = new Student();
        $obj = $obj->find($id);
        $deleted = 0;


        if($obj->image == $request->removeImage)
        {
            // $imageDir = public_path('uploads').'\\'.$request->image;


           if (file_exists(public_path('uploads\\'.$request->removeImage)))
           {
            unlink(public_path('uploads\\'.$request->removeImage));
                $deleted = 1;
           }
            
           $imageName = time().'.'.$request->image->extension();  
           $request->image->move(public_path('uploads'), $imageName);


        
         $obj->image = $imageName; 
        }
        


        $obj->name = $request->name;
        $obj->description = $request->description;

        if($obj->save())
            return response()->json([
                "data" => $obj,
                "error" => false,
                "message" => "Student Updated Succesfully "
            ]);
        else
            return response()->json([
                "error" => true,
                "message" => "Student Update Error!"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obj = new Student();
        $obj = $obj->find($id);

           if (file_exists(public_path('uploads\\'.$obj->image)))
           {
            unlink(public_path('uploads\\'.$obj->image));
                $deleted = 1;
           }
        
        if($obj->delete())
            return response()->json([
                "data" => $obj,
                "error" => false,
                "message" => "Student Deleted Succesfully "
            ]);
        else
            return response()->json([
                "error" => true,
                "message" => "Student Delete Error!"
            ]);
    }

    public function uploadImage(Request $request)
    {
          $imageName = time().'.'.$request->image->extension();  
        

        if($request->image->move(public_path('uploads'), $imageName))
            return response()->json([
                "data" => $imageName,
                "error" => false,
                "message" => "Image Uploaded Successfully!"
            ]);
        else
            return response()->json([
                "error" => true,
                "message" => "Image Upload Error!"
            ]);    
    }

    public function editImage(Request $request)
    {
          $imageName = time().'.'.$request->image->extension();  
            


            
            if (file_exists(public_path('uploads\\'.$request->removeImage)))
           {
            unlink(public_path('uploads\\'.$request->removeImage));
                $deleted = 1;
           }




        if($request->image->move(public_path('uploads'), $imageName))
            return response()->json([
                "data" => $imageName,
                "error" => false,
                "message" => "Image Uploaded Successfully!"
            ]);
        else
            return response()->json([
                "error" => true,
                "message" => "Image Upload Error!"
            ]);    
    }




    public function test(Request $request)
    {
        $a = "test.jpeg";
        // dd(file_exists(public_path('uploads').'\\'.$a));
        dd($request->image);
    }
}
