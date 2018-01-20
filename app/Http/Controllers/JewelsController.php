<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Country;
use App\Enquiry;
use App\User;
use Mail;

class JewelsController extends Controller {

    public function ajaxPostEnquiry(Request $request, $productid)
    {
        $response   = ['status' => 'error', 'message' => trans('error.procedure'), 'payload' => []];
        $product_id = $request->input('product_id');
        $country_id = $request->input('country_id');
        $fullname   = $request->input('fullname');
        $phone      = $request->input('phone');
        $email      = $request->input('email');
        $detail     = $request->input('detail');
        $hookid     = $request->input('hookid');

        if ($product_id && $fullname && $email && filter_var($email, FILTER_VALIDATE_EMAIL) && $detail)
        {
            $product = Product::find($product_id);

            if ($product && $product->productid == $productid && $product->publish == '1')
            {
                $response['message'] = trans('error.general');

                $country = Country::find($country_id);

                $enquiry = new Enquiry;
                $enquiry->product_id    = $product->id;
                $enquiry->country_id    = $country? $country->id: 0;
                $enquiry->fullname      = trim($fullname);
                $enquiry->phone         = trim($phone);
                $enquiry->email         = trim($email);
                $enquiry->detail        = trim($detail);
                $enquiry->hookid        = ($hookid && strlen($hookid) == 16)? $hookid: '';
                $enquiry->open          = '0000-00-00 00:00:00';

                if ($enquiry->save())
                {
                    $subject = $this->config['name'] . ' - Jewel enquiry';

					Mail::queue('emails.enquiry', ['product' => $product, 'enquiry' => $enquiry, 'config' => $this->config], function($mail) use ($enquiry, $subject){
						$mail->from($enquiry->email, $enquiry->fullname);
						$mail->to(config('app.email'));
						$mail->subject($subject);
					});

					session()->flash('enquiryCompleted', true);

                    $response['status']     = 'ok';
                    $response['message']    = 'success';
                }
            }
        }

        return response()->json($response);
    }

    public function getProduct(Request $request, $url)
    {
        $product = Product::where('url', $url)->first();

        if ($product && $product->publish == '1')
        {
            $images = [];

            foreach($product->images as $image){
                $images[] = [
                    'imageid'   => $image->imageid
                ];
            }

            $name = $product->getTitle($this->config['lang']['code']);
            $countries = Country::all();

			$title = $product->getTitle($this->config['lang']['code']);

            $this->params['countries']  = $countries;
            $this->params['images']     = $images;
            $this->params['name']       = $name;
            $this->params['product']    = $product;
            $this->params['title']      = $title.' - '.$this->config['name'];
            $this->params['menu']       = 'jewels';

            $tags = [];
            foreach($product->getTags() as $map){
                if($map->tag){
                    $tags[] = $map->tag->text;
                }
            }
            $keywords = array_merge($tags, $this->config['keywords']);
            $this->params['meta_keywords']      = implode(',', $keywords);
            $this->params['meta_description']   = $this->params['title'];

            $views = $request->cookie('VIEWED')? unserialize($request->cookie('VIEWED')): [];
            if (isset($views['jewels'])){
                if (!in_array($product->productid, $views['jewels'])){
                    $views['jewels'][] = $product->productid;

                    $product->views = $product->views+1;
                    $product->save();
                }
            }
            else {
                $views['jewels'] = [];
                $views['jewels'][] = $product->productid;

                $product->views = $product->views+1;
                $product->save();
            }
            \Cookie::queue('VIEWED', serialize($views), 60*24*3);

			$og_tags = ['title' => $title];

			if (count($images) > 0){
				if (count($images) == 1){
					$image = $images[0];
					$og_tags['image'] = config('app.url') . "/app/product/{$product->productid}/{$image['imageid']}.png";
				}
				else {
					$og_tags['images'] = [];

					foreach ($images as $image){
						$og_tags['images'][] = config('app.url') . "/app/product/{$product->productid}/{$image['imageid']}.png";
					}
				}
			}

			$this->params['og_tags'] = $og_tags;

			$this->params['qualities'] = $product->qualities()->where('display', '1')->orderBy('block', 'asc')->get();

			$this->params['quality_levels'] = [null, 'Excellent', 'Very Good', 'Good', 'Fair'];
			$this->params['quality_shapes'] = [null, 'Round', 'Almost Round', 'Drop', 'Baroque'];

            return view('frontend.jewels.product', $this->params);
        }

        return abort(404);
    }

    public function getCategory(Request $request, $url)
    {
        $category = Category::where('url', $url)->first();

        if ($category)
        {
            $items = $category->products()->leftJoin('products', 'product_maps.product_id', '=', 'products.id')->where('publish', '1')->orderBy('products.created_at', 'desc')->paginate(12);

            $this->params['category']   = $category;
            $this->params['items']      = $items;
            $this->params['title']      = $category->getTitle($this->config['lang']['code']).' - '.$this->config['name'];
            $this->params['menu']       = 'jewels';
            $this->params['submenu']    = $category->url;

            return view('frontend.jewels.list', $this->params);
        }

        return abort(404);
    }

    public function getIndex()
    {
        $categories = Category::all();

        if ($categories->count() > 0){
            $category = $categories->get(0);

            return redirect('jewels/'.$category->url);
        }

        return redirect('/?home');
    }
}
