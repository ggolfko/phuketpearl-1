<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Category;
use App\Translate;

class CategoryController extends Controller {

	public function ajaxPostRemoveImage(Request $request, $categoryid)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => ''];

        $id = $request->input('id');
        if ($id)
        {
            $category = Category::find($id);
            if ($category && $category->categoryid == $categoryid)
            {
                $response['message'] = trans('error.general');

				$category->imageid = '';

				if ($category->save())
				{
					if (\File::exists(public_path("app/category/{$category->categoryid}"))){
						\File::deleteDirectory(public_path("app/category/{$category->categoryid}"));
					}

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

	public function ajaxPostImage(Request $request, $categoryid)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => ''];

        $id = $request->input('id');

        if ($id)
        {
            $category = Category::find($id);

            if ($category && $category->categoryid == $categoryid)
            {
				if ($request->hasFile('file'))
	            {
					$file	= $request->file('file');
					$ext	= $file->getClientOriginalExtension();

                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
					{
						$response['message'] = trans('error.general');

						if (!\File::isDirectory(public_path("app/category/{$category->categoryid}"))){
							\File::makeDirectory(public_path("app/category/{$category->categoryid}"));
						}

						$id     = Category::createId();
						$image  = \Image::make($file);

						if ($image->save(public_path("app/category/{$category->categoryid}/{$id}.png"), 100))
						{
							$category->imageid = $id;

							if ($category->save()){
								$response['status']     = 'ok';
	                            $response['message']    = 'success';
							}
						}
                    }
					else {
						$response['message'] = trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.');
					}
				}
            }
        }

        return response()->json($response);
    }

	public function getImage(Request $request, $categoryid)
    {
        $category = Category::where('categoryid', $categoryid)->first();

        if ($category)
        {
            $this->params['request']    = $request;
            $this->params['category']   = $category;
            $this->params['menu']       = 'products';

            return view('dashboard.products.category.image', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostDelete(Request $request, $categoryid)
    {
        $response = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => ''];

        $id = $request->input('id');
        if ($id)
        {
            $category = Category::find($id);
            if ($category && $category->categoryid == $categoryid)
            {
                $response['message'] = trans('error.general');

				/*
                $category->products()->each(function($map){
                    $map->delete();
                });*/

                $translates = Translate::where('model', 'category')
                    ->where('model_id', $category->id)
                    ->get()
                    ->each(function($item){
                        $item->delete();
                    });

                if ($category->delete())
				{
					if (\File::exists(public_path("app/category/{$categoryid}"))){
						\File::deleteDirectory(public_path("app/category/{$categoryid}"));
					}

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postEdit(Request $request, $categoryid)
    {
        $category = Category::where('categoryid', $categoryid)->first();

        if ($category)
        {
            $title      = $request->input('title');
            $url        = $request->input('url');
            $eMessage   = trans('error.procedure');

            if ($title && $url && preg_match("/^[a-zA-Z0-9-]+$/", $url))
            {
                $exists = Category::where('url', $url)->first();

                if ($exists && $exists->categoryid != $category->categoryid){
                    $eMessage = trans('category.This url is already exists, please choose another one.');
                }
                else
                {
                    $valid = true;
                    foreach ($this->locales as $locale){
                        if (!isset($title[$locale['code']])){
                            $valid = false;
                        }
                    }

                    if ($valid)
                    {
                        $eMessage = trans('error.general');
                        $category->url = $url;

                        if ($category->save())
                        {
                            foreach ($this->locales as $locale){
                                $trans = $category->getTitle($locale['code'], true);

                                if ($trans){
                                    $trans->text = trim($title[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'category';
                                    $trans->model_id    = $category->id;
                                    $trans->field       = 'title';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($title[$locale['code']]);
                                    $trans->save();
                                }
                            }

                            return redirect('dashboard/products/category')->with('sMessage', trans('category.Save changes the category information successfully.'));
                        }
                    }
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getEdit(Request $request, $categoryid)
    {
        $category = Category::where('categoryid', $categoryid)->first();

        if ($category)
        {
            $this->params['request']    = $request;
            $this->params['category']   = $category;
            $this->params['menu']       = 'products';

            return view('dashboard.products.category.edit', $this->params);
        }

        return abort(404);
    }

    public function postCreate(Request $request)
    {
        $title      = $request->input('title');
        $url        = $request->input('url');
        $eMessage   = trans('error.procedure');

        if ($title && $url && preg_match("/^[a-zA-Z0-9-]+$/", $url))
        {
            $exists = Category::where('url', $url)->first();

            if ($exists){
                $eMessage = trans('category.This url is already exists, please choose another one.');
            }
            else
            {
                $valid = true;
                foreach ($this->locales as $locale){
                    if (!isset($title[$locale['code']])){
                        $valid = false;
                    }
                }

                if ($valid)
                {
                    $eMessage = trans('error.general');
                    $category = new Category;
                    $category->url = $url;

                    if ($category->save())
                    {
                        foreach ($this->locales as $locale){
                            $trans = new Translate;
                            $trans->model       = 'category';
                            $trans->model_id    = $category->id;
                            $trans->field       = 'title';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($title[$locale['code']]);
                            $trans->save();
                        }

                        return redirect('dashboard/products/category/' . $category->categoryid . '/image')->with('sMessage', trans('category.Create a new category successfully.'));
                    }
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getCreate(Request $request)
    {
        $this->params['request']    = $request;
        $this->params['menu']       = 'products';

        return view('dashboard.products.category.create', $this->params);
    }

    public function getIndex()
    {
        $items = Category::all();

        $this->params['items']  = $items;
        $this->params['menu']   = 'products';

        return view('dashboard.products.category.index', $this->params);
    }
}
