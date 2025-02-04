<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Mail\Contact;
use App\Models\EmailConfig;
use App\Models\GeneralSetting;
use App\Models\TermsCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helper\MailHelper;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function aboutPage()
    {
        $aboutcontent = About::first();
        return view('frontend.pages.about', compact('aboutcontent'));
    }

    public function termsConditionPage()
    {
        $termsConditioncontent = TermsCondition::first();
        return view('frontend.pages.terms-condition', compact('termsConditioncontent'));
    }

    public function contactPage()
    {
        $contactinfo = GeneralSetting::first();
        $contactPage = TermsCondition::first();
        return view('frontend.pages.contact', compact('contactPage', 'contactinfo'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'max:200'],
            'message' => ['required', 'max:1000'],
        ]);

        $email = EmailConfig::first();
        MailHelper::setMailConfig();
        Mail::to($email->email)->send(new Contact($request->subject, $request->message, $request->email));
        return response(['status' => 'success', 'message' => 'Message Sent']);
    }

    public function blogdetailspage(string $slug)
    {
        $blog = Blog::with(['user', 'comments'])->where('slug', $slug)->where('status', 1)->firstOrFail();
        
        $recentblog = Blog::with('category')->where('slug', '!=', $slug)->where('category_id',$blog->category_id)->where('status', 1)->orderBy('id', 'DESC')->take(10)->get();
        $comments = $blog->comments()->paginate(5);
        $blogcategory = BlogCategory::where('status', 1)->get();
        $latestblog = Blog::where('slug', '!=', $slug)->where('status', 1)->take(5)->latest('created_at')->get();
        return view('frontend.pages.blog-details', compact('blog', 'recentblog', 'comments', 'latestblog', 'blogcategory'));
    }

    public function blogComment(Request $request)
    {
        $request->validate([
            'comment' => ['required', 'max:1000']
        ]);

        $blogcomment = new BlogComment();
        $blogcomment->user_id = Auth::user()->id;
        $blogcomment->blog_id = $request->blog_id;
        $blogcomment->comment = $request->comment;
        $blogcomment->save();

        toastr('Comment Added Successfully');
        return redirect()->back();
    }

    public function blog(Request $request)
    {
        if ($request->has('search')) {
            $blogs = Blog::where('title', 'like', '%' . $request->search . '%')
                ->orwhere('description', 'like', '%' . $request->search . '%')
                ->where('status', 1)->orderBy('id', 'DESC')->paginate(12);
        } else if ($request->has('category')) {
            $category = BlogCategory::where('slug', $request->category)->where('status', 1)->firstOrFail();
            $blogs = Blog::where('category_id', $category->id)->where('status', 1)->orderBy('id', 'DESC')->paginate(12);
        } else {
            $blogs = Blog::where('status', 1)->orderBy('id', 'DESC')->paginate(12);
        }
        return view('frontend.pages.blog', compact('blogs'));
    }
}
