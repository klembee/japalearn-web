<?php


namespace App\Http\Controllers;


use App\Models\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('isRole:admin');
    }

    public function index(Request $request){
        $gifts = Gift::query()->paginate(10);

        return view('app.admin.gifts.index', compact('gifts'));
    }

    public function create(Request $request){
        return view('app.admin.gifts.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
        ]);

        $gift = new Gift([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image_url' => $request->input('image')
        ]);

        $gift->slug = strtolower(str_replace(' ', '-', $request->input('title')));

        $gift->save();

        if($request->has('gift1') && $request->input('gift1') != ''){
            $gift->documents()->create([
                'document_path' => $request->input('gift1')
            ]);
        }
        if($request->has('gift2') && $request->input('gift2') != ''){
            $gift->documents()->create([
                'document_path' => $request->input('gift2')
            ]);
        }
        if($request->has('gift3') && $request->input('gift3') != ''){
            $gift->documents()->create([
                'document_path' => $request->input('gift3')
            ]);
        }

        return redirect()->route('admin.gifts.index');

    }

    public function edit(Request $request, Gift $gift){
        return view('app.admin.gifts.edit', compact('gift'));
    }

    public function update(Request $request, Gift $gift){
        $this->validate($request, [
            'title' => 'required'
        ]);

        $gift->title = $request->input('title');
        $gift->description = $request->input('description');
        $gift->image_url = $request->input('image');
        $gift->save();

        $gift->documents()->delete();

        if($request->has('gift1') && $request->input('gift1') != ''){
            $gift->documents()->create([
                'document_path' => $request->input('gift1')
            ]);
        }
        if($request->has('gift2') && $request->input('gift2') != ''){
            $gift->documents()->create([
                'document_path' => $request->input('gift2')
            ]);
        }
        if($request->has('gift3') && $request->input('gift3') != ''){
            $gift->documents()->create([
                'document_path' => $request->input('gift3')
            ]);
        }

        return redirect()->route('admin.gifts.index');
    }
}
