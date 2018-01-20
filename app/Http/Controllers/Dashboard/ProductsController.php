<?php namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Product;
use App\ProductMap;
use App\ProductImage;
use App\ProductQuality;
use App\Category;
use App\Translate;
use App\Tag;
use App\TagMap;
use App\Hook;
use App\HookImage;
use Image;

class ProductsController extends Controller {

	public function ajaxPostQuality(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();
		$b1			= $request->input('b1');
		$b2			= $request->input('b2');
		$b3			= $request->input('b3');

        if ($product && $b1 && $b2 && $b3)
        {
			$data = [
				'b1'	=> json_decode($b1),
				'b2'	=> json_decode($b2),
				'b3'	=> json_decode($b3)
			];

			if (
				(
					isset($data['b1']->show) && in_array($data['b1']->show, ['yes', 'no']) &&
					isset($data['b1']->show_matching) && in_array($data['b1']->show_matching, ['yes', 'no']) &&
					isset($data['b1']->title) &&
					isset($data['b1']->luster) && in_array($data['b1']->luster, ['1', '2', '3', '4']) &&
					isset($data['b1']->surface) && in_array($data['b1']->surface, ['1', '2', '3', '4']) &&
					isset($data['b1']->shape) && in_array($data['b1']->shape, ['1', '2', '3', '4']) &&
					isset($data['b1']->colour) && in_array($data['b1']->colour, ['1', '2', '3', '4']) &&
					isset($data['b1']->matching) && in_array($data['b1']->matching, ['1', '2', '3', '4'])
				)
				&&
				(
					isset($data['b2']->show) && in_array($data['b2']->show, ['yes', 'no']) &&
					isset($data['b2']->show_matching) && in_array($data['b2']->show_matching, ['yes', 'no']) &&
					isset($data['b2']->title) &&
					isset($data['b2']->luster) && in_array($data['b2']->luster, ['1', '2', '3', '4']) &&
					isset($data['b2']->surface) && in_array($data['b2']->surface, ['1', '2', '3', '4']) &&
					isset($data['b2']->shape) && in_array($data['b2']->shape, ['1', '2', '3', '4']) &&
					isset($data['b2']->colour) && in_array($data['b2']->colour, ['1', '2', '3', '4']) &&
					isset($data['b2']->matching) && in_array($data['b2']->matching, ['1', '2', '3', '4'])
				)
				&&
				(
					isset($data['b3']->show) && in_array($data['b3']->show, ['yes', 'no']) &&
					isset($data['b3']->show_matching) && in_array($data['b3']->show_matching, ['yes', 'no']) &&
					isset($data['b3']->title) &&
					isset($data['b3']->luster) && in_array($data['b3']->luster, ['1', '2', '3', '4']) &&
					isset($data['b3']->surface) && in_array($data['b3']->surface, ['1', '2', '3', '4']) &&
					isset($data['b3']->shape) && in_array($data['b3']->shape, ['1', '2', '3', '4']) &&
					isset($data['b3']->colour) && in_array($data['b3']->colour, ['1', '2', '3', '4']) &&
					isset($data['b3']->matching) && in_array($data['b3']->matching, ['1', '2', '3', '4'])
				)
			)
			{
				$response['message'] = trans('error.general');

				$b1 = $product->qualities()->where('block', 1)->first();
				$b2 = $product->qualities()->where('block', 2)->first();
				$b3 = $product->qualities()->where('block', 3)->first();

				$ok = ['b1' => false, 'b2' => false, 'b3' => 'false'];

				//block 1
				if ($b1)
				{
					$b1->product_id	= $product->id;
					$b1->block		= 1;
					$b1->display	= ($data['b1']->show == 'yes');
					$b1->display_matching = ($data['b1']->show_matching == 'yes');
					$b1->luster		= $data['b1']->luster;
					$b1->surface	= $data['b1']->surface;
					$b1->shape		= $data['b1']->shape;
					$b1->colour		= $data['b1']->colour;
					$b1->matching	= $data['b1']->matching;

					if ($b1->save())
					{
						$ok['b1'] = true;

						foreach ($this->locales as $locale)
						{
							$trans = $b1->getTitle($locale['code'], true);
							if ($trans){
								$trans->text = isset($data['b1']->title->{$locale['code']})? trim($data['b1']->title->{$locale['code']}): '';
								$trans->save();
							}
							else {
								$trans = new Translate;
								$trans->model       = 'product_quality';
								$trans->model_id    = $b1->id;
								$trans->field       = 'title';
								$trans->locale      = $locale['code'];
								$trans->text        = isset($data['b1']->title->{$locale['code']})? trim($data['b1']->title->{$locale['code']}): '';
								$trans->save();
							}
						}
					}
				}
				else
				{
					$b1 = new ProductQuality;
					$b1->product_id	= $product->id;
					$b1->block		= 1;
					$b1->display	= ($data['b1']->show == 'yes');
					$b1->display_matching = ($data['b1']->show_matching == 'yes');
					$b1->luster		= $data['b1']->luster;
					$b1->surface	= $data['b1']->surface;
					$b1->shape		= $data['b1']->shape;
					$b1->colour		= $data['b1']->colour;
					$b1->matching	= $data['b1']->matching;

					if ($b1->save())
					{
						$ok['b1'] = true;

						foreach ($this->locales as $locale)
						{
							$trans = new Translate;
							$trans->model       = 'product_quality';
							$trans->model_id    = $b1->id;
							$trans->field       = 'title';
							$trans->locale      = $locale['code'];
							$trans->text        = isset($data['b1']->title->{$locale['code']})? trim($data['b1']->title->{$locale['code']}): '';
							$trans->save();
						}
					}
				}

				//block 2
				if ($b2)
				{
					$b2->product_id	= $product->id;
					$b2->block		= 2;
					$b2->display	= ($data['b2']->show == 'yes');
					$b2->display_matching = ($data['b2']->show_matching == 'yes');
					$b2->luster		= $data['b2']->luster;
					$b2->surface	= $data['b2']->surface;
					$b2->shape		= $data['b2']->shape;
					$b2->colour		= $data['b2']->colour;
					$b2->matching	= $data['b2']->matching;

					if ($b2->save())
					{
						$ok['b2'] = true;

						foreach ($this->locales as $locale)
						{
							$trans = $b2->getTitle($locale['code'], true);
							if ($trans){
								$trans->text = isset($data['b2']->title->{$locale['code']})? trim($data['b2']->title->{$locale['code']}): '';
								$trans->save();
							}
							else {
								$trans = new Translate;
								$trans->model       = 'product_quality';
								$trans->model_id    = $b2->id;
								$trans->field       = 'title';
								$trans->locale      = $locale['code'];
								$trans->text        = isset($data['b2']->title->{$locale['code']})? trim($data['b2']->title->{$locale['code']}): '';
								$trans->save();
							}
						}
					}
				}
				else
				{
					$b2 = new ProductQuality;
					$b2->product_id	= $product->id;
					$b2->block		= 2;
					$b2->display	= ($data['b2']->show == 'yes');
					$b2->display_matching = ($data['b2']->show_matching == 'yes');
					$b2->luster		= $data['b2']->luster;
					$b2->surface	= $data['b2']->surface;
					$b2->shape		= $data['b2']->shape;
					$b2->colour		= $data['b2']->colour;
					$b2->matching	= $data['b2']->matching;

					if ($b2->save())
					{
						$ok['b2'] = true;

						foreach ($this->locales as $locale)
						{
							$trans = new Translate;
							$trans->model       = 'product_quality';
							$trans->model_id    = $b2->id;
							$trans->field       = 'title';
							$trans->locale      = $locale['code'];
							$trans->text        = isset($data['b2']->title->{$locale['code']})? trim($data['b2']->title->{$locale['code']}): '';
							$trans->save();
						}
					}
				}

				//block 3
				if ($b3)
				{
					$b3->product_id	= $product->id;
					$b3->block		= 3;
					$b3->display	= ($data['b3']->show == 'yes');
					$b3->display_matching = ($data['b3']->show_matching == 'yes');
					$b3->luster		= $data['b3']->luster;
					$b3->surface	= $data['b3']->surface;
					$b3->shape		= $data['b3']->shape;
					$b3->colour		= $data['b3']->colour;
					$b3->matching	= $data['b3']->matching;

					if ($b3->save())
					{
						$ok['b3'] = true;

						foreach ($this->locales as $locale)
						{
							$trans = $b3->getTitle($locale['code'], true);
							if ($trans){
								$trans->text = isset($data['b3']->title->{$locale['code']})? trim($data['b3']->title->{$locale['code']}): '';
								$trans->save();
							}
							else {
								$trans = new Translate;
								$trans->model       = 'product_quality';
								$trans->model_id    = $b3->id;
								$trans->field       = 'title';
								$trans->locale      = $locale['code'];
								$trans->text        = isset($data['b3']->title->{$locale['code']})? trim($data['b3']->title->{$locale['code']}): '';
								$trans->save();
							}
						}
					}
				}
				else
				{
					$b3 = new ProductQuality;
					$b3->product_id	= $product->id;
					$b3->block		= 3;
					$b3->display	= ($data['b3']->show == 'yes');
					$b3->display_matching = ($data['b3']->show_matching == 'yes');
					$b3->luster		= $data['b3']->luster;
					$b3->surface	= $data['b3']->surface;
					$b3->shape		= $data['b3']->shape;
					$b3->colour		= $data['b3']->colour;
					$b3->matching	= $data['b3']->matching;

					if ($b3->save())
					{
						$ok['b3'] = true;

						foreach ($this->locales as $locale)
						{
							$trans = new Translate;
							$trans->model       = 'product_quality';
							$trans->model_id    = $b3->id;
							$trans->field       = 'title';
							$trans->locale      = $locale['code'];
							$trans->text        = isset($data['b3']->title->{$locale['code']})? trim($data['b3']->title->{$locale['code']}): '';
							$trans->save();
						}
					}
				}

				//response
				if ($ok['b1'] && $ok['b2'] && $ok['b3']){
					$response['status'] = 'ok';
				}
			}
        }

        return response()->json($response);
    }

	public function getQuality(Request $request, $productid)
    {
        $product = Product::where('productid', $productid)->first();

        if ($product)
        {
    		$this->params['product']    = $product;
            $this->params['menu']       = 'products';

            return view('dashboard.products.quality', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostHooksSave(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $columns    = $request->input('columns');
        $items      = $request->input('items');

        if ($columns && $items)
        {
            $product = Product::where('productid', $productid)->first();

            if ($product)
            {
                $response['message'] = trans('error.general');

                $product->hook->columns = trim($columns);
                $product->hook->items   = trim($items);

                if ($product->hook->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostHooksImage(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();

        if ($product && $request->hasFile('image'))
        {
            $file   = $request->file('image');
            $ext    = $file->getClientOriginalExtension();
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'gif', 'png']))
            {
                $response['message'] = trans('error.general');

                if (!\File::isDirectory(public_path("app/product/{$product->productid}/{$product->hook->hookid}"))){
                    \File::makeDirectory(public_path("app/product/{$product->productid}/{$product->hook->hookid}"));
                }

                $id     = HookImage::createId();
                $image  = Image::make($file);

                if ($image->save(public_path("app/product/{$product->productid}/{$product->hook->hookid}/{$id}.png"), 100))
                {
                    $image  = Image::make(public_path("app/product/{$product->productid}/{$product->hook->hookid}/{$id}.png"));
                    $width	= $image->width();
                    $height	= $image->height();

                    if ($width == $height)
                    {
                        $image->resize(100, 100, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    else if ($height > $width)
                    {
                        $image->resize(100, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        if ($image->height() < 100){
                            $image->resize(null, 100, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                    }
                    else if ($width > $height)
                    {
                        $image->resize(null, 100, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        if ($image->width() < 100){
                            $image->resize(100, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                    }

                    $image->crop(100, 100, 0, 0);

                    if ($image->save(public_path("app/product/{$product->productid}/{$product->hook->hookid}/{$id}_t.png"), 100))
                    {
                        $item = new HookImage;
                        $item->imageid  = $id;
                        $item->hook_id  = $product->hook->id;

                        if ($item->save()){
                            $response['status']     = 'ok';
                            $response['message']    = 'success';
                            $response['payload']['image'] = [
                                'id'      => $item->id,
                                'imageid' => $item->imageid
                            ];
                        }
                    }
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostHooksStatus(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $status     = $request->input('status');

        if ($status && in_array($status, ['yes', 'no']))
        {
            $product = Product::where('productid', $productid)->first();

            if ($product)
            {
                $response['message'] = trans('error.general');
                $product->hook_status = $status == 'yes'? true: false;

                if ($product->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function getHooks(Request $request, $productid)
    {
        $product = Product::where('productid', $productid)->first();

        if ($product)
        {
    		$this->params['product']    = $product;
            $this->params['menu']       = 'products';

            return view('dashboard.products.hooks', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostImageCover(Request $request, $productid, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();
        $id         = $request->input('id');

        if ($product && $id)
        {
            $image = ProductImage::find($id);
            if ($image && $image->imageid == $imageid)
            {
                $response['message'] = trans('error.general');

                $product->images->each(function($item) use ($image){
                    if ($item->imageid == $image->imageid){
                        $item->cover = true;
                        $item->save();
                    }
                    else if ($item->cover == '1'){
                        $item->cover = false;
                        $item->save();
                    }
                });

                $response['status']     = 'ok';
                $response['message']    = 'success';
            }
        }

        return response()->json($response);
    }

    public function ajaxPostDelete(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();

        if ($product)
        {
            $response['message'] = trans('error.general');

            $product->categories->each(function($map){
                $map->delete();
            });

            $product->getTags()->each(function($map){
                $map->delete();
            });

            $product->images()->each(function($item){
                $item->delete();
            });

            $product->hook->images->each(function($item){
                $item->delete();
            });

            $product->hook->delete();

            $translates = Translate::where('model', 'product')
                ->where('model_id', $product->id)
                ->get()
                ->each(function($item){
                    $item->delete();
                });

			$product->qualities()->each(function($item){
				Translate::where('model', 'product_quality')
	                ->where('model_id', $item->id)
	                ->get()
	                ->each(function($itemTrans){
	                    $itemTrans->delete();
	                });
                $item->delete();
            });

            if ($product->delete())
            {
                if (\File::isDirectory(public_path("app/product/{$productid}"))){
                    \File::deleteDirectory(public_path("app/product/{$productid}"));
                }

                $response['status']     = 'ok';
                $response['message']    = 'success';
            }
        }

        return response()->json($response);
    }

    public function ajaxPostNew(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();

        if ($product)
        {
            $response['message'] = trans('error.general');

            $set = $request->input('set');
            if ($set)
            {
                $product->new = $set == 'yes'? true: false;
                if ($product->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostPopular(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();

        if ($product)
        {
            $response['message'] = trans('error.general');

            $set = $request->input('set');
            if ($set)
            {
                $product->popular = $set == 'yes'? true: false;
                if ($product->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostRecommend(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();

        if ($product)
        {
            $response['message'] = trans('error.general');

            $set = $request->input('set');
            if ($set)
            {
                $product->recommend = $set == 'yes'? true: false;
                if ($product->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostPublish(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();

        if ($product)
        {
            $response['message'] = trans('error.general');

            $set = $request->input('set');
            if ($set)
            {
                $product->publish = $set == 'yes'? true: false;
                if ($product->save()){
                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function postEdit(Request $request, $productid)
    {
        $product = Product::where('productid', $productid)->first();

        if ($product)
        {
            $eMessage   = trans('error.procedure');
            $title      = $request->input('title');
            $url        = $request->input('url');
            $bodytype   = $request->input('bodytype');
            $materials  = $request->input('materials');
            $pearltype  = $request->input('pearltype');
            $pearlsize  = $request->input('pearlsize');
            $moredetails= $request->input('moredetails');
            $code       = $request->input('code');
            $category   = $request->input('category');
            $publish    = $request->input('publish');
            $about_new  = $request->input('about_new');
            $keywords   = $request->input('keywords');
            $about_popular      = $request->input('about_popular');
            $about_recommend    = $request->input('about_recommend');

            if ($title && $url && preg_match("/^[a-zA-Z0-9-]+$/", $url) && $publish && in_array($publish, ['yes', 'no']) && $code)
            {
                $exists = Product::where('url', $url)->first();

                if ($exists && $exists->productid != $product->productid){
                    $eMessage = trans('product.This url is already exists, please choose another one.');
                }
                else
                {
                    $valid = true;
                    foreach ($this->locales as $locale){
                        if ($valid)
                        {
                            if (!isset($title[$locale['code']])){
                                $valid = false;
                            }
                        }
                        else {
                            break;
                        }
                    }

                    if ($valid)
                    {
                        $product->code      = trim($code);
                        $product->url       = trim($url);
                        $product->publish   = $publish == 'yes'? true: false;
                        $product->new       = $about_new == 'true'? true: false;
                        $product->popular   = $about_popular == 'true'? true: false;
                        $product->recommend = $about_recommend == 'true'? true: false;

                        if ($product->save())
                        {
                            if (!\File::isDirectory(public_path("app/product/{$product->productid}"))){
    							\File::makeDirectory(public_path("app/product/{$product->productid}"));
    						}

                            //category
                            $product->categories->each(function($map){
                                $map->delete();
                            });

                            if ($category)
                            {
                                foreach ($category as $cid)
                                {
                                    $item = Category::where('categoryid', $cid)->first();
                                    if ($item){
                                        $map = new ProductMap;
                                        $map->product_id    = $product->id;
                                        $map->category_id   = $item->id;
                                        $map->save();
                                    }
                                }
                            }

                            //keywords
                            $product->getTags()->each(function($map){
                                $map->delete();
                            });

                            if ($keywords)
                            {
                                $keyword = explode(',', $keywords);
                                foreach ($keyword as $text)
                                {
                                    $tag = Tag::where('text', trim($text))->first();
                                    if (!$tag){
                                        $tag = new Tag;
                                        $tag->text = trim($text);
                                        $tag->save();
                                    }

                                    if ($tag){
                                        $map = new TagMap;
                                        $map->model     = 'product';
                                        $map->tag_id    = $tag->id;
                                        $map->model_id  = $product->id;
                                        $map->save();
                                    }
                                }
                            }

                            //translate
                            foreach ($this->locales as $locale)
                            {
                                $trans = $product->getTitle($locale['code'], true);
                                if ($trans){
                                    $trans->text = trim($title[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'product';
                                    $trans->model_id    = $product->id;
                                    $trans->field       = 'title';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($title[$locale['code']]);
                                    $trans->save();
                                }

                                $trans = $product->getPearltype($locale['code'], true);
                                if ($trans){
                                    $trans->text = trim($pearltype[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'product';
                                    $trans->model_id    = $product->id;
                                    $trans->field       = 'pearltype';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($pearltype[$locale['code']]);
                                    $trans->save();
                                }

                                $trans = $product->getPearlsize($locale['code'], true);
                                if ($trans){
                                    $trans->text = trim($pearlsize[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'product';
                                    $trans->model_id    = $product->id;
                                    $trans->field       = 'pearlsize';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($pearlsize[$locale['code']]);
                                    $trans->save();
                                }

                                $trans = $product->getMoredetails($locale['code'], true);
                                if ($trans){
                                    $trans->text = trim($moredetails[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'product';
                                    $trans->model_id    = $product->id;
                                    $trans->field       = 'moredetails';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($moredetails[$locale['code']]);
                                    $trans->save();
                                }

                                $trans = $product->getBodytype($locale['code'], true);
                                if ($trans){
                                    $trans->text = trim($bodytype[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'product';
                                    $trans->model_id    = $product->id;
                                    $trans->field       = 'bodytype';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($bodytype[$locale['code']]);
                                    $trans->save();
                                }

                                $trans = $product->getMaterials($locale['code'], true);
                                if ($trans){
                                    $trans->text = trim($materials[$locale['code']]);
                                    $trans->save();
                                }
                                else {
                                    $trans = new Translate;
                                    $trans->model       = 'product';
                                    $trans->model_id    = $product->id;
                                    $trans->field       = 'materials';
                                    $trans->locale      = $locale['code'];
                                    $trans->text        = trim($materials[$locale['code']]);
                                    $trans->save();
                                }
                            }

                            return redirect("dashboard/products/{$product->productid}")->with('sMessage', trans('_.Save changes successfully.'));
                        }
                    }
                }
            }

            return redirect()->back()->with('eMessage', $eMessage);
        }

        return abort(404);
    }

    public function getEdit(Request $request, $productid)
    {
        $product = Product::where('productid', $productid)->first();

        if ($product)
        {
            $categories = Category::all();
            $keywords   = '';
            $tags       = [];
            foreach ($product->getTags() as $map)
            {
                if ($map->tag){
                    $tags[] = $map->tag->text;
                }
            }
            if (count($tags) > 0){
                $keywords = implode(',', $tags);
            }

            $this->params['request']    = $request;
            $this->params['keywords']   = $keywords;
            $this->params['categories'] = $categories;
            $this->params['product']    = $product;
            $this->params['menu']       = 'products';

            return view('dashboard.products.edit', $this->params);
        }

        return abort(404);
    }

    public function getItem(Request $request, $productid)
    {
        $product = Product::where('productid', $productid)->first();

        if ($product)
        {
            $keywords   = '-';
            $tags       = [];
            foreach ($product->getTags() as $map)
            {
                if ($map->tag){
                    $tags[] = $map->tag->text;
                }
            }
            if (count($tags) > 0){
                $keywords = implode(',', $tags);
            }

            $this->params['keywords']   = $keywords;
            $this->params['product']    = $product;
            $this->params['menu']       = 'products';

            return view('dashboard.products.item', $this->params);
        }

        return abort(404);
    }

    public function ajaxPostImageDelete(Request $request, $productid, $imageid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();
        $id         = $request->input('id');

        if ($product && $id)
        {
            $image = ProductImage::find($id);
            if ($image && $image->imageid == $imageid)
            {
                $response['message'] = trans('error.general');

                $cover      = $image->cover;
                $refresh    = false;

                if ($image->delete())
                {
                    \File::delete([
                        public_path("app/product/{$product->productid}/{$imageid}.png"),
                        public_path("app/product/{$product->productid}/{$imageid}_t.png")
                    ]);

                    if ($product->images->count() < 1){
                        $refresh = true;
                    }
                    else if ($cover == 1){
                        $item = $product->images->get(0);
                        $item->cover = true;
                        if ($item->save()){
                            $refresh = true;
                        }
                    }

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                    $response['payload']['refresh'] = $refresh;
                }
            }
        }

        return response()->json($response);
    }

    public function ajaxPostImage(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product    = Product::where('productid', $productid)->first();

        if ($product)
        {
            if ($request->hasFile('image'))
            {
                $response['message'] = trans('error.image');

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
                        $interrupt  = false;
                        $count      = $product->images->count();

                        foreach ($files as $file)
                        {
                            $id     = ProductImage::createId();
                            $image  = \Image::make($file);
                            if ($image->save(public_path("app/product/{$product->productid}/{$id}.png"), 100))
                            {
                                $image  = \Image::make(public_path("app/product/{$product->productid}/{$id}.png"));

								/*
								$width	= $image->width();
    							$height	= $image->height();

                                if ($width == $height){
                                    $image->resize(600, 600);
                                }
                                else if ($height > $width){
    								$image->resize(600, null, function ($constraint) {
    									$constraint->aspectRatio();
    								});
                                    if ($image->height() < 600){
                                        $image->resize(null, 600, function ($constraint) {
        									$constraint->aspectRatio();
        								});
                                    }
    							}
                                else if ($width > $height)
                                {
                                    $image->resize(null, 600, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                                    if ($image->width() < 600){
                                        $image->resize(600, null, function ($constraint) {
        									$constraint->aspectRatio();
        								});
                                    }
                                }

                                $image->crop(600, 600, 0, 0); */

								$image->fit(600, 600);

                                if ($image->save(public_path("app/product/{$product->productid}/{$id}_t.png"), 100))
                                {
                                    $img = new ProductImage;
                                    $img->imageid     = $id;
                                    $img->product_id  = $product->id;
                                    $img->cover       = $count < 1? true: false;

                                    if (!$img->save()){
                                        $interrupt = true;
                                    }
                                    else {
                                        $count++;
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
                    $response['message'] = trans('_.Allowed only "jpeg, jpg, gif, png" file extension only.');
                }
            }
        }

        return response()->json($response);
    }

    public function getImage(Request $request, $productid)
    {
        $product = Product::where('productid', $productid)->first();

        if ($product)
        {
    		$this->params['product']    = $product;
            $this->params['menu']       = 'products';

            return view('dashboard.products.image', $this->params);
        }

        return abort(404);
    }

    public function postAdd(Request $request)
    {
        $eMessage   = trans('error.procedure');
        $title      = $request->input('title');
        $url        = $request->input('url');
        $bodytype   = $request->input('bodytype');
        $materials  = $request->input('materials');
        $pearltype  = $request->input('pearltype');
        $pearlsize  = $request->input('pearlsize');
        $moredetails= $request->input('moredetails');
        $code       = $request->input('code');
        $category   = $request->input('category');
        $publish    = $request->input('publish');
        $about_new  = $request->input('about_new');
        $keywords   = $request->input('keywords');
        $about_popular      = $request->input('about_popular');
        $about_recommend    = $request->input('about_recommend');

        if ($title && $url && preg_match("/^[a-zA-Z0-9-]+$/", $url) && $publish && in_array($publish, ['yes', 'no']) && $code)
        {
            $exists = Product::where('url', $url)->first();

            if ($exists){
                $eMessage = trans('product.This url is already exists, please choose another one.');
            }
            else
            {
                $valid = true;
                foreach ($this->locales as $locale){
                    if ($valid)
                    {
                        if (!isset($title[$locale['code']])){
                            $valid = false;
                        }
                    }
                    else {
                        break;
                    }
                }

                if ($valid)
                {
                    $product = new Product;
                    $product->code      = trim($code);
                    $product->url       = trim($url);
                    $product->publish   = $publish == 'yes'? true: false;
                    $product->new       = $about_new == 'true'? true: false;
                    $product->popular   = $about_popular == 'true'? true: false;
                    $product->recommend = $about_recommend == 'true'? true: false;
                    $product->views     = 0;
                    $product->hook_status = false;

                    if ($product->save())
                    {
                        if (!\File::isDirectory(public_path("app/product/{$product->productid}"))){
							\File::makeDirectory(public_path("app/product/{$product->productid}"));
						}

                        //category
                        if ($category)
                        {
                            foreach ($category as $cid)
                            {
                                $item = Category::where('categoryid', $cid)->first();
                                if ($item){
                                    $map = new ProductMap;
                                    $map->product_id    = $product->id;
                                    $map->category_id   = $item->id;
                                    $map->save();
                                }
                            }
                        }

                        //keywords
                        if ($keywords)
                        {
                            $keyword = explode(',', $keywords);
                            foreach ($keyword as $text)
                            {
                                $tag = Tag::where('text', trim($text))->first();
                                if (!$tag){
                                    $tag = new Tag;
                                    $tag->text = trim($text);
                                    $tag->save();
                                }

                                if ($tag){
                                    $map = new TagMap;
                                    $map->model     = 'product';
                                    $map->tag_id    = $tag->id;
                                    $map->model_id  = $product->id;
                                    $map->save();
                                }
                            }
                        }

                        //translate
                        foreach ($this->locales as $locale)
                        {
                            $trans = new Translate;
                            $trans->model       = 'product';
                            $trans->model_id    = $product->id;
                            $trans->field       = 'title';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($title[$locale['code']]);
                            $trans->save();

                            $trans = new Translate;
                            $trans->model       = 'product';
                            $trans->model_id    = $product->id;
                            $trans->field       = 'pearltype';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($pearltype[$locale['code']]);
                            $trans->save();

                            $trans = new Translate;
                            $trans->model       = 'product';
                            $trans->model_id    = $product->id;
                            $trans->field       = 'pearlsize';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($pearlsize[$locale['code']]);
                            $trans->save();

                            $trans = new Translate;
                            $trans->model       = 'product';
                            $trans->model_id    = $product->id;
                            $trans->field       = 'moredetails';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($moredetails[$locale['code']]);
                            $trans->save();

                            $trans = new Translate;
                            $trans->model       = 'product';
                            $trans->model_id    = $product->id;
                            $trans->field       = 'bodytype';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($bodytype[$locale['code']]);
                            $trans->save();

                            $trans = new Translate;
                            $trans->model       = 'product';
                            $trans->model_id    = $product->id;
                            $trans->field       = 'materials';
                            $trans->locale      = $locale['code'];
                            $trans->text        = trim($materials[$locale['code']]);
                            $trans->save();
                        }

                        $columns = json_encode([
                            [
                                'text' => 'Click edit text',
                                'id'    => Hook::createId(),
                            ],
                            [
                                'text' => 'Click edit text',
                                'id'    => Hook::createId(),
                            ],
                            [
                                'text' => 'Click edit text',
                                'id'    => Hook::createId(),
                            ],
                            [
                                'text' => 'Click edit text',
                                'id'    => Hook::createId(),
                            ]
                        ]);

                        $items = json_encode([
                            [
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ]
                            ],
                            [
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ]
                            ],
                            [
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ],
                                [
                                    'id'    => Hook::createId(),
                                    'text'  => 'Click edit text',
                                    'image' => ''
                                ]
                            ]
                        ]);

                        $hook = new Hook;
                        $hook->product_id   = $product->id;
                        $hook->columns      = $columns;
                        $hook->items        = $items;

                        if ($hook->save()){
                            if (!\File::isDirectory(public_path("app/product/{$product->productid}/{$hook->hookid}"))){
    							\File::makeDirectory(public_path("app/product/{$product->productid}/{$hook->hookid}"));
    						}

                            return redirect("dashboard/products/{$product->productid}/images")->with('sMessage', trans('product.Added a new product successfully.'));
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('eMessage', $eMessage);
    }

    public function getAdd(Request $request)
    {
        $categories = Category::all();

        $this->params['request']    = $request;
        $this->params['categories'] = $categories;
        $this->params['menu']       = 'products';

        return view('dashboard.products.add', $this->params);
    }

    public function getIndex(Request $request)
    {
        $items = Product::orderBy('created_at', 'desc')->paginate(25);

		$this->params['items']      = $items;
        $this->params['request']    = $request;
        $this->params['menu']       = 'products';

        return view('dashboard.products.index', $this->params);
    }
}
