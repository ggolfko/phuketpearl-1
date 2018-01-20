<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sitemap;
use App\News;
use App\Category;
use App\Product;
use App\Gallery;
use App\GalleryVideo;
use App\Tour;
use App\Award;
use App\Certificate;
use App\Story;
use App\StoryImage;
use App\MediaSpecialGuest;
use App\Crown;
use App\PearlFarm;
use App\PearlFarmVideo;

class SitemapController extends Controller {

	public function index()
	{
		$url = config('app.url') . '/sitemap';

		Sitemap::addSitemap( "{$url}/static.xml" );
		Sitemap::addSitemap( "{$url}/news.xml" );
		Sitemap::addSitemap( "{$url}/jewels.xml" );
		Sitemap::addSitemap( "{$url}/jewels/category.xml" );
		Sitemap::addSitemap( "{$url}/gallery.xml" );
		Sitemap::addSitemap( "{$url}/videos.xml" );
		Sitemap::addSitemap( "{$url}/tours.xml" );
		Sitemap::addSitemap( "{$url}/awards.xml" );
		Sitemap::addSitemap( "{$url}/certificates.xml" );
		Sitemap::addSitemap( "{$url}/ourstory.xml" );
		Sitemap::addSitemap( "{$url}/contactus.xml" );
		Sitemap::addSitemap( "{$url}/home.xml" );
		Sitemap::addSitemap( "{$url}/media-special-guests.xml" );
		Sitemap::addSitemap( "{$url}/location-opening-hours.xml" );
		Sitemap::addSitemap( "{$url}/pearl-care.xml" );
		Sitemap::addSitemap( "{$url}/pearl-crowns.xml" );
		Sitemap::addSitemap( "{$url}/pearl-farm.xml" );
		Sitemap::addSitemap( "{$url}/pearl-farming.xml" );
		Sitemap::addSitemap( "{$url}/pearl-quality.xml" );
		Sitemap::addSitemap( "{$url}/pearl-type.xml" );

		return Sitemap::index();
	}

	public function pearltype()
	{
		$url		= config('app.url');
		$location	= "{$url}/pearl-type.html";

		$tag = Sitemap::addTag(
			new \Watson\Sitemap\Tags\MultilingualTag(
				$location, '', 'daily', '0.8', $this->langs($location)
			)
		);

        return Sitemap::render();
	}

	public function pearlquality()
	{
		$url		= config('app.url');
		$location	= "{$url}/pearl-quality.html";

		$tag = Sitemap::addTag(
			new \Watson\Sitemap\Tags\MultilingualTag(
				$location, '', 'daily', '0.8', $this->langs($location)
			)
		);

        return Sitemap::render();
	}

	public function pearlfarming()
	{
		$url		= config('app.url');
		$location	= "{$url}/pearl-farming.html";

		$tag = Sitemap::addTag(
			new \Watson\Sitemap\Tags\MultilingualTag(
				$location, '', 'daily', '0.8', $this->langs($location)
			)
		);

        return Sitemap::render();
	}

	public function pearlfarm()
	{
		$url	= config('app.url');
		$items	= PearlFarm::orderBy('created_at', 'desc')->get();

        foreach ($items as $item)
		{
			$location = "{$url}/pearl-farm/{$item->imageid}.html";
            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.9', $this->langs($location)
				)
			);

			$tag->addImage("{$url}/app/pearlfarm/{$item->imageid}.png");
        }

		$items	= PearlFarmVideo::where('publish', '1')->orderBy('created_at', 'desc')->get();

		foreach ($items as $item)
		{
			$location = "{$url}/pearl-farm/{$item->videoid}.html";
            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.9', $this->langs($location)
				)
			);

			$tag->addImage("{$url}/app/pearlfarm_videos/{$item->videoid}/preview.png");
        }

        return Sitemap::render();
	}

	public function pearlcrowns()
	{
		$url	= config('app.url');
		$items	= Crown::all();

        foreach ($items as $item) {
			$title		= $item->getTitle($this->config['lang']['code']);
			$title		= trimUrl($title);
			$location	= "{$url}/pearl-crowns/{$title}.html";

            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.8', $this->langs($location)
				)
			);

			$tag->addImage("{$url}/app/crown/{$item->crownid}/{$item->imageid}.png");
        }

        return Sitemap::render();
	}

	public function pearlcare()
	{
		$url		= config('app.url');
		$location	= "{$url}/pearl-care.html";

		$tag = Sitemap::addTag(
			new \Watson\Sitemap\Tags\MultilingualTag(
				$location, '', 'daily', '0.8', $this->langs($location)
			)
		);

        return Sitemap::render();
	}

	public function locationopeninghours()
	{
		$url		= config('app.url');
		$location	= "{$url}/location-opening-hours.html";

		$tag = Sitemap::addTag(
			new \Watson\Sitemap\Tags\MultilingualTag(
				$location, '', 'daily', '0.8', $this->langs($location)
			)
		);

        return Sitemap::render();
	}

	public function mediaspecialguests()
	{
		$url	= config('app.url');
		$items	= MediaSpecialGuest::orderBy('created_at', 'desc')->get();

        foreach ($items as $item) {
			$title		= $item->getTopic($this->config['lang']['code']);
			$title		= trimUrl($title);
			$location	= "{$url}/media-special-guests/{$title}.html";

            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.8', $this->langs($location)
				)
			);

			foreach($item->images as $image) {
				$tag->addImage("{$url}/app/media_special_guests/{$item->itemid}/{$image->imageid}.png");
			}
        }

        return Sitemap::render();
	}

	public function home()
	{
		$url		= config('app.url');
		$location	= $url;

		$tag = Sitemap::addTag(
			new \Watson\Sitemap\Tags\MultilingualTag(
				$location, '', 'daily', '0.8'
			)
		);

		$tag->addImage("{$url}/static/frontend/images/home/banner_image_1705092115.jpg");

        return Sitemap::render();
	}

	public function contactus()
	{
		$url		= config('app.url');
		$location	= "{$url}/contactus.html";

		Sitemap::addTag(
			new \Watson\Sitemap\Tags\MultilingualTag(
				$location, '', 'daily', '0.8', $this->langs($location)
			)
		);

        return Sitemap::render();
	}

	public function ourstory()
	{
		$url		= config('app.url');
		$location	= "{$url}/our-story.html";
		$story      = Story::first();
		$images     = StoryImage::orderBy('created_at', 'desc')->get();

		$tag = Sitemap::addTag(
			new \Watson\Sitemap\Tags\MultilingualTag(
				$location, $story->updated_at, 'daily', '0.8', $this->langs($location)
			)
		);

		foreach ($images as $image) {
			$tag->addImage("{$url}/app/ourstory/{$image->imageid}.png");
		}

        return Sitemap::render();
	}

	public function certificates()
	{
		$url	= config('app.url');
		$items	= Certificate::all();

        foreach ($items as $item) {
			$title		= $item->getTitle($this->config['lang']['code']);
			$title		= trimUrl($title);
			$location	= "{$url}/certificates/{$title}.html";

            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.8', $this->langs($location)
				)
			);

			$tag->addImage("{$url}/app/certificate/{$item->certificateid}/{$item->imageid}.png");
        }

        return Sitemap::render();
	}

	public function awards()
	{
		$url	= config('app.url');
		$items	= Award::all();

        foreach ($items as $item) {
			$title		= $item->getTitle($this->config['lang']['code']);
			$title		= trimUrl($title);
			$location	= "{$url}/awards/{$title}.html";

            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.8', $this->langs($location)
				)
			);

			$tag->addImage("{$url}/app/award/{$item->awardid}/{$item->imageid}.png");
        }

        return Sitemap::render();
	}

	public function tours()
	{
		$url	= config('app.url');
		$items	= Tour::where('publish', '1')->orderBy('created_at', 'desc')->get();

        foreach ($items as $item) {
			$location = "{$url}/tours/{$item->url}.html";
            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.8', $this->langs($location)
				)
			);

			foreach ($item->images as $image) {
                $tag->addImage("{$url}/app/tour/{$item->tourid}/{$image->imageid}.png");
            }
        }

        return Sitemap::render();
	}

	public function gallery()
	{
		$url	= config('app.url');
		$items	= Gallery::orderBy('created_at', 'desc')->get();

        foreach ($items as $item)
		{
			$location = "{$url}/gallery/{$item->imageid}.html";
            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.9', $this->langs($location)
				)
			);

			$tag->addImage("{$url}/app/gallery/{$item->imageid}.png");
        }

        return Sitemap::render();
	}

	public function videos()
	{
		$url	= config('app.url');
		$items	= GalleryVideo::where('publish', '1')->orderBy('created_at', 'desc')->get();

        foreach ($items as $item)
		{
			$location = "{$url}/gallery/{$item->videoid}.html";
            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.9', $this->langs($location)
				)
			);

			if (
				$item->thumb_default == '1' ||
				$item->thumb_medium == '1' ||
				$item->thumb_high == '1' ||
				$item->thumb_standard == '1' ||
				$item->thumb_maxres == '1'
			)
			{
				$tag->addImage("{$url}/app/gallery_videos/{$item->videoid}/preview.png");
			}
        }

        return Sitemap::render();
	}

	public function jewelsCategory()
	{
		$url	= config('app.url');
		$items	= Category::all();

        foreach ($items as $item)
		{
			$location = "{$url}/jewels/{$item->url}";
            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.9', $this->langs($location)
				)
			);

			if ($item->imageid != ''){
				$tag->addImage("{$url}/app/category/{$item->categoryid}/{$item->imageid}.png");
			}
        }

        return Sitemap::render();
	}

	public function jewels()
	{
		$url	= config('app.url');
		$items	= Product::where('publish', '1')->orderBy('created_at', 'desc')->get();

        foreach ($items as $item) {
			$location = "{$url}/jewels/{$item->url}.html";
            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '1.0', $this->langs($location)
				)
			);

			foreach ($item->images as $image) {
                $tag->addImage("{$url}/app/product/{$item->productid}/{$image->imageid}.png");
            }
        }

        return Sitemap::render();
	}

	public function news()
	{
		$url	= config('app.url');
		$items	= News::where('publish', '1')->orderBy('created_at', 'desc')->get();

        foreach ($items as $item) {
			$location = "{$url}/news/{$item->newsid}.html";
            $tag = Sitemap::addTag(
				new \Watson\Sitemap\Tags\MultilingualTag(
					$location, $item->updated_at, 'daily', '0.8', $this->langs($location)
				)
			);

			foreach ($item->images as $image) {
                $tag->addImage("{$url}/app/news/{$item->newsid}/{$image->imageid}.png");
            }
        }

        return Sitemap::render();
	}

	public function statics()
	{
		$url = config('app.url');

		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			$url, null, 'daily', '0.8'
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/news.html", null, 'daily', '0.8', $this->langs("{$url}/news.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/jewels.html", null, 'daily', '0.8', $this->langs("{$url}/jewels.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/gallery.html", null, 'daily', '0.8', $this->langs("{$url}/gallery.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/tours", null, 'daily', '0.8', $this->langs("{$url}/tours")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/contactus.html", null, 'daily', '0.8', $this->langs("{$url}/contactus.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/location-opening-hours.html", null, 'daily', '0.8', $this->langs("{$url}/location-opening-hours.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/pearl-care.html", null, 'daily', '0.8', $this->langs("{$url}/pearl-care.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/pearl-quality.html", null, 'daily', '0.8', $this->langs("{$url}/pearl-quality.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/pearl-farm.html", null, 'daily', '0.8', $this->langs("{$url}/pearl-farm.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/pearl-farming.html", null, 'daily', '0.8', $this->langs("{$url}/pearl-farming.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/pearl-type.html", null, 'daily', '0.8', $this->langs("{$url}/pearl-type.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/pearl-crowns.html", null, 'daily', '0.8', $this->langs("{$url}/pearl-crowns.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/our-story.html", null, 'daily', '0.8', $this->langs("{$url}/our-story.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/awards-certificates.html", null, 'daily', '0.8', $this->langs("{$url}/awards-certificates.html")
		));
		Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
			"{$url}/media-special-guests.html", null, 'daily', '0.8', $this->langs("{$url}/media-special-guests.html")
		));

        return Sitemap::render();
	}

	public function langs($location, $amp = false)
	{
		$langs		= [];
		$locales	= config('app.locales');
		$connect	= $amp? '&': '?';

		foreach ($locales as $locale){
			$langs[$locale['code']] = "{$location}{$connect}lang={$locale['code']}";
		}

		return $langs;
	}
}
