<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\BlogCategory;
use App\Models\EmailTemplate;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Media;
use App\Models\NewsletterSubscriber;
use App\Models\Quote;
use App\Models\SeoMeta;
use App\Models\TeamMember;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class VideoController extends Controller
{
    public function index() { $videos = Video::latest()->paginate(15); return view('admin.common.index', ['title' => 'Videos', 'items' => $videos]); }
    public function destroy($id) { Video::findOrFail($id)->delete(); return back()->with('success', 'Video deleted.'); }
}

class AwardController extends Controller
{
    public function index() { $awards = Award::latest()->paginate(15); return view('admin.common.index', ['title' => 'Awards', 'items' => $awards]); }
    public function destroy($id) { Award::findOrFail($id)->delete(); return back()->with('success', 'Award deleted.'); }
}

class TeamController extends Controller
{
    public function index() { $team = TeamMember::latest()->paginate(15); return view('admin.common.index', ['title' => 'Team Members', 'items' => $team]); }
    public function destroy($id) { TeamMember::findOrFail($id)->delete(); return back()->with('success', 'Team member deleted.'); }
}

class BlogCategoryController extends Controller
{
    public function index() { $cats = BlogCategory::latest()->paginate(15); return view('admin.common.index', ['title' => 'Blog Categories', 'items' => $cats]); }
}

class FaqController extends Controller
{
    public function index() { $faqs = Faq::latest()->paginate(15); return view('admin.common.index', ['title' => 'FAQs', 'items' => $faqs]); }
    public function destroy($id) { Faq::findOrFail($id)->delete(); return back()->with('success', 'FAQ deleted.'); }
}

class FaqCategoryController extends Controller
{
    public function index() { $cats = FaqCategory::latest()->paginate(15); return view('admin.common.index', ['title' => 'FAQ Categories', 'items' => $cats]); }
}

class QuoteController extends Controller
{
    public function index() { $quotes = Quote::latest()->paginate(15); return view('admin.common.index', ['title' => 'Quotes', 'items' => $quotes]); }
    public function destroy($id) { Quote::findOrFail($id)->delete(); return back()->with('success', 'Quote deleted.'); }
}

class NewsletterController extends Controller
{
    public function index() { $subs = NewsletterSubscriber::latest()->paginate(20); return view('admin.common.index', ['title' => 'Newsletter Subscribers', 'items' => $subs]); }
    public function destroy($id) { NewsletterSubscriber::findOrFail($id)->delete(); return back()->with('success', 'Subscriber deleted.'); }
    public function send(Request $request) { return back()->with('success', 'Newsletter sent.'); }
    public function export() { return back()->with('success', 'Subscribers exported.'); }
}

class MediaController extends Controller
{
    public function index() { $media = Media::latest()->paginate(24); return view('admin.common.index', ['title' => 'Media Manager', 'items' => $media]); }
    public function upload(Request $request) { return response()->json(['success' => true]); }
    public function destroy($id) { Media::findOrFail($id)->delete(); return back()->with('success', 'Media file deleted.'); }
}

class UserController extends Controller
{
    public function index() { $users = User::latest()->paginate(15); return view('admin.common.index', ['title' => 'System Users', 'items' => $users]); }
    public function destroy($id) { User::findOrFail($id)->delete(); return back()->with('success', 'User deleted.'); }
}

class RoleController extends Controller
{
    public function index() { $roles = Role::all(); return view('admin.common.index', ['title' => 'Roles & Permissions', 'items' => $roles]); }
}

class SeoController extends Controller
{
    public function index() { $seos = SeoMeta::all(); return view('admin.common.index', ['title' => 'SEO Meta Settings', 'items' => $seos]); }
    public function update(Request $request, $page) { return back()->with('success', 'SEO settings updated.'); }
}

class EmailTemplateController extends Controller
{
    public function index() { return view('admin.common.index', ['title' => 'Email Templates', 'items' => collect([])]); }
    public function preview(Request $request) { return response()->json(['html' => '']); }
}

class ReportController extends Controller
{
    public function index() { return view('admin.common.index', ['title' => 'Reports & Analytics', 'items' => collect([])]); }
    public function data() { return response()->json([]); }
    public function export($type) { return back()->with('success', 'Report exported.'); }
}

class ActivityLogController extends Controller
{
    public function index() { return view('admin.common.index', ['title' => 'Activity Logs', 'items' => collect([])]); }
}

class ProfileController extends Controller
{
    public function index() { return view('admin.common.index', ['title' => 'My Profile', 'items' => collect([])]); }
    public function update(Request $request) { return back()->with('success', 'Profile updated.'); }
}
