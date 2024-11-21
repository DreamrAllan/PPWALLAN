<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;


class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'id' => 'posts',
            'menu' => 'Gallery',
            'galleries' => Post::where('picture', '!=', '')
                            ->whereNotNull('picture')
                            ->orderBy('created_at', 'desc')
                            ->paginate(30)
        ];

        return view('gallery.index')->with($data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameToSave = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameToSave);
        } else {
            $filenameToSave = 'noimage.png';
        }

        $post = new Post;
        $post->picture = $filenameToSave;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery = Post::findOrFail($id);
        return view('gallery.edit', compact('gallery'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        // Temukan post yang akan diupdate
        $gallery = Post::findOrFail($id);

        // Jika ada gambar baru
        if ($request->hasFile('picture')) {
            // Hapus gambar lama jika ada
            if ($gallery->picture != 'noimage.png' && Storage::exists('public/posts_image/' . $gallery->picture)) {
                Storage::delete('public/posts_image/' . $gallery->picture);
            }

            // Proses upload gambar baru
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $filenameSimpan = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            // Jika tidak ada gambar baru, tetap menggunakan gambar lama
            $filenameSimpan = $gallery->picture;
        }

        // Update data
        $gallery->title = $request->input('title');
        $gallery->description = $request->input('description');
        $gallery->picture = $filenameSimpan;  // Simpan gambar baru atau lama
        $gallery->save();

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gallery = Post::findOrFail($id);

        if ($gallery->picture != 'noimage.png') {
            Storage::delete('public/posts_image/' . $gallery->picture);
        }

        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil dihapus');
    }
    /**
     * API: Get gallery items with images
     */
    /**
     * @OA\Get(
     *     path="/api/gallery",
     *     tags={"Gallery"},
     *     summary="Get gallery items with images",
     *     description="Returns a list of gallery items that have images",
     *     operationId="getGallery",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Beautiful Sunset"),
     *                 @OA\Property(property="description", type="string", example="A stunning view of the sunset"),
     *                 @OA\Property(property="picture", type="string", example="http://example.com/images/sunset.jpg"),
     *                 @OA\Property(property="created_at", type="string", example="2024-11-21 10:00:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2024-11-21 12:00:00")
     *             )
     *         )
     *     )
     * )
     */
    public function apiIndex()
    {
        $galleries = Post::where('picture', '!=', '')
                        ->whereNotNull('picture')
                        ->orderBy('created_at', 'desc')
                        ->paginate(30);

        return response()->json([
            'message' => 'Gallery data fetched successfully',
            'success' => true,
            'data' => $galleries,
        ], 200);
    }


}
