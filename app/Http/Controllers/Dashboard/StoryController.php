<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Story;
use App\StoryImage;
use App\Translate;
use Image;
use File;

class StoryController extends Controller {

    public function ajaxPostImagesDelete(Request $request, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $id         = $request->input('id');

        if ($id)
        {
            $image = StoryImage::find($id);

            if ($image && $image->imageid == $imageid)
            {
                if ($image->delete())
                {
                    $refresh = false;

                    File::delete([
                        public_path("app/ourstory/{$imageid}.png"),
                        public_path("app/ourstory/{$imageid}_t.png")
                    ]);

                    if (StoryImage::count() < 1){
                        $refresh = true;
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['payload']['refresh'] = $refresh;
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostImagesUpload(Request $request)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];

        if ($request->hasFile('image'))
        {
            $response['message'] = trans('error.general');

            $files  = $request->file('image');
            $valid  = true;

            foreach ($files as $file)
            {
                $ext = $file->getClientOriginalExtension();
                if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png'])){
                    $valid = false;
                }
            }

            if ($valid)
            {
                if (count($files) <= 10)
                {
                    $interrupt = false;

                    foreach ($files as $file)
                    {
                        $id     = StoryImage::createId();
                        $image  = Image::make($file);

                        if ($image->save(public_path("app/ourstory/{$id}.png"), 100))
                        {
                            $image  = Image::make(public_path("app/ourstory/{$id}.png"));
                            $width	= $image->width();
                            $height	= $image->height();

                            if ($height > $width){
                                $image->resize(622, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                                if ($image->height() < 415){
                                    $image->resize(null, 415, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }
                            }
                            else if ($height == $width)
                            {
                                $image->resize(622, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }
                            else
                            {
                                $image->resize(null, 415, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                                if ($image->width() < 622){
                                    $image->resize(622, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                }
                            }

                            $image->crop(622, 415, 0, 0);

                            if ($image->save(public_path("app/ourstory/{$id}_t.png"), 100))
                            {
                                $newImage = new StoryImage;
                                $newImage->imageid = $id;

                                if (!$newImage->save()){
                                    $interrupt = true;
                                }
                            }
                            else {
                                $interrupt = true;
                            }
                        }
                        else {
                            $interrupt = true;
                        }
                    }

                    if (!$interrupt)
                    {
                        $response['status']     = 'ok';
                        $response['message']    = 'success';
                    }
                }
                else {
                    $response['message'] = trans('gallery.Upload images up to 10 files at a time.');
                }
            }
            else {
                $response['message'] = trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.');
            }
        }

        return response()->json($response);
    }

    public function getImages(Request $request)
    {
        $items = StoryImage::orderBy('created_at', 'desc')->get();

        $this->params['items']      = $items;
	    $this->params['request']	= $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'ourstory';
        $this->params['itemmenu']   = 'images';

        return view('dashboard.docs.ourstory.images', $this->params);
    }

    public function postArticle(Request $request)
    {
        $eMessage   = trans('error.procedure');
        $story      = Story::first();
        $detail     = $request->input('detail');

        if ($story && $detail)
        {
            $valid = true;
            foreach ($this->locales as $locale){
                if (!isset($detail[$locale['code']])){
                    $valid = false;
                }
            }

            if ($valid)
            {
                $eMessage = trans('error.general');

                foreach ($this->locales as $locale){
                    $trans = $story->getDetail($locale['code'], true);
                    if ($trans){
                        $trans->text = trim($detail[$locale['code']]);
                        $trans->save();
                    }
                    else {
                        $trans = new Translate;
                        $trans->model       = 'story';
                        $trans->model_id    = $story->id;
                        $trans->field       = 'detail';
                        $trans->locale      = $locale['code'];
                        $trans->text        = trim($detail[$locale['code']]);
                        $trans->save();
                    }
                }

                return redirect()->back()->with('sMessage', trans('_.Save changes successfully.'));
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getArticle(Request $request)
    {
        $story = Story::first();

        $this->params['story']      = $story;
	    $this->params['request']	= $request;
        $this->params['menu']       = 'doc';
        $this->params['submenu']    = 'ourstory';
        $this->params['itemmenu']   = 'article';

        return view('dashboard.docs.ourstory.article', $this->params);
    }
}
