<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
use App\User;
use App\Models\Photo;

class UploadController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    public function test(Request $request)
    {
        $image = "testing-update.jpg";

        $user = Auth::user();
        
        $primaryPhoto = Photo::where('user_id', $user->id)->where('is_primary', 1);

        if ($primaryPhoto->exists() === true) {
            $primaryPhoto->update([
                'filename' => $image
            ]);
        } else {
            Photo::create([
                'album_id' => 1,
                'user_id' => $user->id,
                'filename' => $image,
                'is_primary' => true,
                'url' => 'http://',
                'cdn_url' => 'http://',
                'privacy_id' => 1
            ]);
        }
    }


    public function save(Request $request)
    {
        $user = Auth::user();


        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       ]);
       
        if ($files = $request->file('image')) {
           
          // for save original image
            $ImageUpload = Image::make($files);

            $originalPath = 'storage/uploads/photos/';
            $newFilename = $originalPath.time().$files->getClientOriginalName();
           
           
            /*  The format of ImageUpload
            [mime] => image/jpeg
            [dirname] => storage/uploads/photos
            [basename] => 15843460303191_1474_popup.jpg
            [extension] => jpg
            [filename] => 15843460303191_1474_popup
            */            
            
            //resize

            $thumbnailUpload = Image::make($files);
            $thumbnailPath = 'storage/uploads/photos/thumbs/';
            $thumbnailUpload->resize(75, 75);
            $thumbFilename = $thumbnailPath.time().$files->getClientOriginalName();
            
            
            $thumbnailUpload->save($thumbFilename);  
            $ImageUpload->save($newFilename);          

            //Retrieve the saved file to confir it is in database
            $primaryPhoto = Photo::where('user_id', $user->id)->where('is_primary', 1);        

            if ($primaryPhoto->exists() === true) {

                $primaryPhoto->update([
                    'filename' => $newFilename,
                    'thumbnail' => $thumbFilename
                ]);
                               
            } else {
                Photo::create([
                    'album_id' => 1,
                    'user_id' => $user->id,
                    'filename' => $newFilename,
                    'thumbnail' => $thumbFilename,
                    'is_primary' => true,
                    'url' => 'http://',
                    'cdn_url' => 'http://',
                    'privacy_id' => 1
                ]);
            }
    

            return Response()->json([
                "success" => true,
                "image" => $newFilename,
                "thumbnail" => $thumbFilename
            ]);

        }



    }

  

    /*
    public function save(Request $request)
    {
        $user = Auth::user();

        if ($request->file('image')) {


            $image = $request->file('image')->store('uploads/photos', 'public');
            $primaryPhoto = Photo::where('user_id', $user->id)->where('is_primary', 1);

            if ($primaryPhoto->exists() === true) {
                $primaryPhoto->update([
                    'filename' => $image
                ]);
            } else {
                Photo::create([
                    'album_id' => 1,
                    'user_id' => $user->id,
                    'filename' => $image,
                    'is_primary' => true,
                    'url' => 'http://',
                    'cdn_url' => 'http://',
                    'privacy_id' => 1
                ]);
            }




            // now you are able to resize the instance
            $image->resize(150, 150);

            // and insert a watermark for example
            $image->insert('images/photos/watermark.png');

            // finally we save the image as a new file
            $image->save('uploads/photos/bar.jpg');



            return Response()->json([
                "success" => true,
                "image" => $image
            ]);




        } else {
            return Response()->json([
                "success" => false,
                "image" => ""
            ]);
        }
    }
    */

    
    /*
     public function save(Request $request)
     {


         request()->validate([
             'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         ]);

         if ($request->file('image')) {
             $image = $request->file('image')->store('uploads/photos', 'public');
         }

         //Update Primary Photo
         if ($request->file('image')) {

             $user = Auth::user();

             $primaryPhoto = Photo::where('user_id', $user->id)->where('is_primary', 1);

             if ($primaryPhoto->exists() === true) {
                 $primaryPhoto->update([
                     'filename' => $image
                 ]);
             } else {
                 Photo::create([
                     'album_id' => 1,
                     'user_id' => $user->id,
                     'filename' => $image,
                     'is_primary' => true,
                     'url' => 'http://',
                     'cdn_url' => 'http://',
                     'privacy_id' => 1
                 ]);
             }

             return Response()->json([
                 "success" => true,
                 "image" => $image,
             ]);
         }

         return Response()->json([
                 "success" => false,
                 "image" => ''
             ]);
     }*/
}
