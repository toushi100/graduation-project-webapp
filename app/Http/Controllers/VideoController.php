<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Iman\Streamer\VideoStreamer;
use Illuminate\Support\Str;
use App\Video;
use App\Objects;
use Dotenv\Result\Success;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
///use Response;

class VideoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$videos = Video::paginate(4);
        //$video = DB::table('videos')->Paginate(4);
        //return view('videos.index')->with('video', $video);
    
        $videos = Video::orderBy('created_at','desc')->paginate(4);
        
        return view('videos.index')->with('videos', $videos);
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'path' => 'required'
        ]);

        // video upload 
        if ($request->hasFile('path')) {
            $filenameWithExt = $request->file('path')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('path')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // file name to be passed to python script
            $filenameforpython = $filename . '_' . time();
            // Upload video
            $path = $request->file('path')->storeAs('public/videos', $fileNameToStore);
        }

        $video = new Video;
        $video->name = $request->input('name');
        $video->description = $request->input('description');
        $video->path = $fileNameToStore;
        $video->user_id = auth()->user()->id;
        $video->save();


        $videoname = $filenameforpython;
        $output = shell_exec("/home/ahmed/Desktop/cocov1/mainweb.py $videoname");
        $data = json_decode($output, true);
        $count = 0;

        if ($data == 0 || $data == null) {
            $video->delete();
            $base_directory = '/home/ahmed/Desktop/blog/storage/app/public/videos/' . $fileNameToStore;
            unlink($base_directory);
            return 'somthing went wrong';
        } else {
            foreach ($data as $val) {
                $object = new Objects;
                $object->object = $data[$count]['object'];
                $object->frame = $data[$count]['frame'];
                $object->video_id = $video->id;
                $object->save();
                $count++;
            }
            return redirect('/videos');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $video = video::find($id);

        $path = public_path($video->path);
        



        /*VideoStreamer::streamFile($path);
        return view('videos.show')->with('video', $video);
       */
        return $path;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::find($id);

        //Check if post exists before deleting
        if (!isset($video)) {
            return redirect('/videos');
        }

        // Check for correct user
        if (auth()->user()->id !== $video->user_id) {
            return redirect('/videos');
        }

        $videoname = str_replace(".mp4","",$video->path);


        $video->delete();
        $base_directory = '/home/ahmed/Desktop/blog/storage/app/public/videos/' . $video->path;
        $base_directory_annotated = '/home/ahmed/Desktop/blog/storage/app/public/videos/' . $videoname . '_annotated.mp4';

        unlink($base_directory);
        unlink($base_directory_annotated);

        return redirect('/home');
    }

    public function search(Request $request, $id)
    {

        $video = video::find($id);
        $object = $request->input('object');
        $result = DB::table('objects')->where('object', $object)->where('video_id', $id)->value('frame');
       
        $seconds = ($result / 30);
        (float)$total =  ($result % 30)*0.0333;
        (float)$result = (float)$seconds+(float)$total;

        return view('videos.show')->with('video', $video)->with('result', (float)$result);
    }

    public function renderVideo(Request $request, $id)
    {

        $video = video::find($id);
        $path = public_path('storage/videos/' . $video->path);
        VideoStreamer::streamFile($path);
    }
    public function renderAnnotated (Request $request, $id)
    {
        $video = video::find($id);
        $path = $video->path;
        $annotated = str_replace(".mp4","_annotated.mp4",$path);
        
        $path = public_path('storage/videos/' . $annotated);
        VideoStreamer::streamFile($path);
    }
}
