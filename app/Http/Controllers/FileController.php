<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Tree4;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FileDelete;

class FileController extends Controller
{
    private $uploadPathLogo = 'image/file/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate(
            [
                'name' => 'required',
                'file' => 'required',
                'tree4_id' => 'required|exists:tree4s,id',
            ],
            [
                'name.required' => 'يرجي إدخال المرفق او الملف ',
                'file.required' => 'يجب ان لايكون حقل الملف فارغ ',
                'tree4_id.required' => 'يجب ان لايكون حقل الحاج او المعتمر فارغ ',
                'tree4_id.exists' => 'الحاج او المعتمر غير موحود',
            ],
        );
        $file = new File();
        $formFileName = 'file';
        $fileFinalName = '';
        if ($request->$formFileName != '') {
            $fileFinalName = time() . rand(1111, 9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
            $path = $this->uploadPathLogo;
            $request->file($formFileName)->move($path, $fileFinalName);
        }
        if ($fileFinalName != '') {
            $file->file = $fileFinalName;
        }
        $file->tree4_id = $request->tree4_id;
        $file->name = $request->name;
        $file->user_id = Auth::user()->id;
        $file->save();
        Session()->flash('file');

        if (Auth::user()->roles_name == 'user' || Auth::user()->roles_name == 'agent') {
            return to_route('Clients.pic');
        }

        return redirect('/Clients');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tree = Tree4::findOrFail($id);
        $files = File::where('tree4_id', $id)->get(); // جلب المرفقات المرتبطة بالحاج
        return view('clients.profile', compact('tree', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request)
    // {
    //     $validateData = $request->validate(
    //         [
    //             'tree4_id' => 'required',
    //             'name' => 'required',
    //         ],
    //         [
    //             'name.required' => 'يرجي إدخال المرفق او الملف ',
    //         ],
    //     );
    //     $file = File::findOrFail($request->id);
    //     // delete image
    //     $image_path = 'image/file/' . $file->file;
    //     if (FileDelete::exists($image_path)) {
    //         FileDelete::delete($image_path);
    //     }
    //     if($request->hasFile('file'))
    //         $formFileName = 'file';
    //         $fileFinalName = '';
    //         if ($request->$formFileName != '') {
    //             $fileFinalName = time() . rand(1111, 9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
    //             $path = $this->uploadPathLogo;
    //             $request->file($formFileName)->move($path, $fileFinalName);
    //         }
    //         if ($fileFinalName != '') {
    //             $file->file = $fileFinalName;
    //         }
    //     }

    //     $file->name = $request->name;
    //     $file->save();
    //     Session()->flash('file');

    //     return to_route('Clients.pic');
    // }

    public function update(Request $request)
    {
        // Validate request data
        $validateData = $request->validate(
            [
                'name' => 'required',
                'tree4_id' => 'required|exists:tree4s,id',
            ],
            [
                'name.required' => 'يرجي إدخال المرفق او الملف ',
                'tree4_id.required' => 'يجب ان لايكون حقل الحاج او المعتمر فارغ ',
                'tree4_id.exists' => 'الحاج او المعتمر غير موحود',
            ],
        );

        // Retrieve the file record
        $file = File::findOrFail($request->id);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old image if it exists
            $image_path = 'image/file/' . $file->file;
            if (FileDelete::exists($image_path)) {
                FileDelete::delete($image_path);
            }
            $formFileName = 'file';
            $fileFinalName = time() . rand(1111, 9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();

            // Ensure the directory exists
            $path = $this->uploadPathLogo ?? 'uploads/files/'; // Use a default path if `$this->uploadPathLogo` is not defined
            if (!FileDelete::exists($path)) {
                FileDelete::makeDirectory($path, 0755, true);
            }

            // Move the uploaded file
            $request->file($formFileName)->move($path, $fileFinalName);

            // Update the file name in the database
            $file->file = $fileFinalName;
        }

        // Update the file name
        $file->name = $request->name;

        // Save changes
        $file->save();

        // Flash a success message
        session()->flash('edit', 'File delete successfully.');

        // Redirect to a specific route
        return to_route('Clients.pic');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $file = File::findOrFail($request->id);
        $image_path = 'image/file/' . $file->file;
        if (FileDelete::exists($image_path)) {
            FileDelete::delete($image_path);
        }
        $file->delete();
        Session()->flash('delete');

        return to_route('Clients.pic');
    }
}
