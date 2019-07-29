<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\course;
use App\User;
use App\category;
use App\Uabout;
use App\skill;
use App\userskill;
use Auth;
use Session;


class UserController extends Controller
{
    public function enroll($id)
    {
    	$course = course::find($id);
        $course->users()->sync(Auth::user()->id, false);
        Session::flash('success', 'Enrolled successfully');
    	//return view('enrolled.greeting');
    	return redirect()->back();
    }

    public function enrolledCourse($id)
    {
    	$cat = category::whereNull('parent_id')->get();
    	$user = User::find($id);

        return view('enrolled.enrolled', compact('user','cat'));

    }

    public function about($id)
    {
        $user = User::find($id);
        $about = Uabout::where('user_id', $id)->first();

        return view('user.profileabout', compact('user','about'));
    }
    public function aboutcreate($id)
    {
        $user  = User::find($id);
        return view('user.profilecreate', compact('user'));
    }
    public function aboutstore(Request $request, $id)
    {
        $this->validate($request,[

          'fname' => 'required',
          'desig' => 'required',
          'add' => 'required',
          'number' => 'required',
          'about' => 'required',
          'fb' => 'required',
          'linked' => 'required',
          'git' => 'required'
        ]);

        $about = new Uabout;
        $about->user_id = $id;
        $about->fullName = $request->fname;
        $about->designation = $request->desig;
        $about->address = $request->add;
        $about->number = $request->number;
        $about->about = $request->about;
        $about->image = $request->add;
        $about->facebook = $request->fb;
        $about->linkedin = $request->linked;
        $about->git = $request->git;
        $about->save();

        return redirect(route('user.about',$id));


    }

    public function aboutedit($id)
    {
        $user  = User::find($id);
        $about = Uabout::where('user_id', $id)->first();
        return view('user.profileupdate' , compact('user','about'));
    }
    public function aboutupdate(Request $request, $id)
    {
        $this->validate($request,[

          'fname' => 'required',
          'desig' => 'required',
          'add' => 'required',
          'number' => 'required',
          'about' => 'required',
          'fb' => 'required',
          'linked' => 'required',
          'git' => 'required'
        ]);
        // return $request->all();
        $update = Uabout::
        $update->fullName = $request->fname;
        $update->designation = $request->desig;
        $update->address = $request->add;
        $update->number = $request->number;
        $update->about = $request->about;
        $update->facebook = $request->fb;
        $update->linkedin = $request->linked;
        $update->git = $request->git;

        $update->save();
        return redirect(route('user.about',$id));
    }

    public function skills($id)
    {
        $about = Uabout::where('user_id', $id)->first();
        $skills = skill::all();
        return view('user.profileskills', compact('about','skills'));
    }
    public function skillscreate(Request $request , $id)
    {
            $user = User::find($id);
            $user->skills()->sync($request->skills, false);
            return redirect(route('user.skills', $id));
    }
}
