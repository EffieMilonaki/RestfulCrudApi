<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CourseController extends Controller
{
    /**
     * Display a listing of the courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();

        return CourseResource::collection($courses);
    }

    /**
     * Store a newly created course.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'status' => [
                'required', 
                Rule::in(['Published','Pending']),
            ],
            'is_premium' => 'required|boolean',
        ]);

        $courses = Course::create($request->all());

        return new CourseResource($courses);
    }

    /**
     * Display the specified course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return response()->json($course);
    }

    /**
     * Update the specified course.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|text|max:255',
            'status' => [
                'required', 
                Rule::in(['Published','Pending']),
            ],
            'is_premium' => 'required|boolean',
        ]);

        $course->update($request->all());
       
        
        return new CourseResource($course);
    }

    /**
     * Remove the specified course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        
        return response(null, 202);
    }
}
