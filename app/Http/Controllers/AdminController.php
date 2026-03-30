<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseType;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Result;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'schools' => School::count(),
            'students' => User::where('role', 'student')->count(),
            'courses' => Course::count(),
            'results' => Result::count(),
        ];

        $recentResults = Result::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $schoolsWithCount = School::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(5)
            ->get();

        $recentStudents = User::where('role', 'student')
            ->with('school')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentResults', 'schoolsWithCount', 'recentStudents'));
    }

    // School Management
    public function schools()
    {
        $schools = School::all();

        return view('admin.schools.index', compact('schools'));
    }

    public function storeSchool(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        School::create($request->all());

        return back()->with('success', 'School created successfully');
    }

    public function updateSchool(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $school = School::findOrFail($id);
        $school->update($request->all());

        return back()->with('success', 'School updated successfully');
    }

    public function destroySchool($id)
    {
        $school = School::findOrFail($id);
        $school->delete();

        return back()->with('success', 'School deleted successfully');
    }

    // Student Management
    public function students()
    {
        $students = User::where('role', 'student')->with('school')->get();
        $schools = School::all();

        return view('admin.students.index', compact('students', 'schools'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:4', // NISN
            'school_id' => 'required|exists:schools,id',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'school_id' => $request->school_id,
            'role' => 'student',
        ]);

        return back()->with('success', 'Student created successfully');
    }

    public function updateStudent(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,'.$user->id,
            'password' => 'nullable|string|min:4',
            'school_id' => 'required|exists:schools,id',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'school_id' => $request->school_id,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Student updated successfully');
    }

    public function destroyStudent($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Student deleted successfully');
    }

    // Course Management
    public function courses()
    {
        $courses = Course::with(['school', 'type'])->get();
        $schools = School::all();
        $courseTypes = CourseType::all();

        return view('admin.courses.index', compact('courses', 'schools', 'courseTypes'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_type_id' => 'required|exists:course_types,id',
            'label' => 'nullable|string|max:50',
            'school_id' => 'nullable|exists:schools,id',
            'description' => 'nullable|string|max:2000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['title', 'description', 'school_id', 'course_type_id', 'label']);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create($data);

        return back()->with('success', 'Course created successfully');
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'course_type_id' => 'required|exists:course_types,id',
            'label' => 'nullable|string|max:50',
            'school_id' => 'nullable|exists:schools,id',
            'description' => 'nullable|string|max:2000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['title', 'description', 'school_id', 'course_type_id', 'label']);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($data);

        return back()->with('success', 'Course updated successfully');
    }

    public function destroyCourse($id)
    {
        $course = Course::findOrFail($id);
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        $course->delete();

        return back()->with('success', 'Course deleted successfully');
    }

    // Lesson Management
    public function lessons($course_id)
    {
        $course = Course::findOrFail($course_id);
        $lessons = $course->lessons;

        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function storeLesson(Request $request, $course_id)
    {
        if ($request->input('video_url') === '') {
            $request->merge(['video_url' => null]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order_number' => 'required|integer',
        ]);

        Lesson::create([
            'course_id' => $course_id,
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'order_number' => $request->order_number,
        ]);

        return back()->with('success', 'Lesson created successfully');
    }

    public function updateLesson(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        if ($request->input('video_url') === '') {
            $request->merge(['video_url' => null]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order_number' => 'required|integer',
        ]);

        $lesson->update($request->only(['title', 'content', 'video_url', 'order_number']));

        return back()->with('success', 'Lesson updated successfully');
    }

    public function destroyLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return back()->with('success', 'Lesson deleted successfully');
    }

    // Question Management
    public function questions($course_id)
    {
        $course = Course::findOrFail($course_id);
        $questions = Question::where('course_id', $course_id)->where('type', 'post')->get();
        return view('admin.questions.index', compact('course', 'questions'));
    }

    public function preQuestions($course_id)
    {
        $course = Course::findOrFail($course_id);
        $questions = Question::where('course_id', $course_id)->where('type', 'pre')->get();
        return view('admin.pre_questions.index', compact('course', 'questions'));
    }

    public function storeQuestion(Request $request, $course_id)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        Question::create(array_merge($request->all(), ['course_id' => $course_id, 'type' => 'post']));

        return back()->with('success', 'Question added successfully');
    }

    public function storePreQuestion(Request $request, $course_id)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        Question::create(array_merge($request->all(), ['course_id' => $course_id, 'type' => 'pre']));

        return back()->with('success', 'Question added successfully');
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $question->update($request->only(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer']));

        return back()->with('success', 'Question updated successfully');
    }

    public function destroyQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return back()->with('success', 'Question deleted successfully');
    }

    public function destroyPreQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return back()->with('success', 'Question deleted successfully');
    }

    // Result Monitoring
    public function results()
    {
        $results = Result::with(['user', 'course'])->latest()->get();

        return view('admin.results.index', compact('results'));
    }
}
