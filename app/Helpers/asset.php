<?php

function asset_cache_path($type, $file, $minify = true)
{
	if ($type == 'js')
	{
		$lastModified	= filemtime(base_path("resources/assets/js/{$file}.blade.php"));
		$tagDir			= substr(preg_replace("/[^a-zA-Z0-9_-]/", '', base64_encode(date('Ymd'))), -4);
		$tagFile		= substr(preg_replace("/[^a-zA-Z0-9_-]/", '', base64_encode($file.$lastModified)), -8);
		if (!file_exists(storage_path("app/cache/assets/js/{$tagDir}/{$tagFile}.blade.php")))
		{
		    if (!file_exists(storage_path("app/cache/assets/js/{$tagDir}")) || !is_dir(storage_path("app/cache/assets/js/{$tagDir}"))){
		        mkdir(storage_path("app/cache/assets/js/{$tagDir}"), 0755);
		    }
			$content = file_get_contents(base_path("resources/assets/js/{$file}.blade.php"));
		    if ($minify == true){
		        $content = minify_js($content);
		    }
		    file_put_contents(storage_path("app/cache/assets/js/{$tagDir}/{$tagFile}.blade.php"), $content);
		}
		return "/resc.php/c/{$tagDir}/{$tagFile}.js";
	}
	else if ($type == 'css')
	{
		$lastModified	= filemtime(base_path("resources/assets/css/{$file}.blade.php"));
		$tagDir			= substr(preg_replace("/[^a-zA-Z0-9_-]/", '', base64_encode(date('Ymd'))), -4);
		$tagFile		= substr(preg_replace("/[^a-zA-Z0-9_-]/", '', base64_encode($file.$lastModified)), -8);
		if (!file_exists(storage_path("app/cache/assets/css/{$tagDir}/{$tagFile}.blade.php")))
		{
			if (!file_exists(storage_path("app/cache/assets/css/{$tagDir}")) || !is_dir(storage_path("app/cache/assets/css/{$tagDir}"))){
				mkdir(storage_path("app/cache/assets/css/{$tagDir}"), 0755);
			}
			$content = file_get_contents(base_path("resources/assets/css/{$file}.blade.php"));
			if ($minify == true){
				$content = minify_css($content);
			}
			file_put_contents(storage_path("app/cache/assets/css/{$tagDir}/{$tagFile}.blade.php"), $content);
		}
		return "/resc.php/c/{$tagDir}/{$tagFile}.css";
	}

	return '';
}

function asset_cache_content($type, $file, $params = [])
{
	if ($type == 'js')
	{
		$lastModified	= filemtime(base_path("resources/assets/js/{$file}.blade.php"));
		$tagDir			= substr(preg_replace("/[^a-zA-Z0-9_-]/", '', base64_encode(date('Ymd'))), -4);
		$tagFile		= substr(preg_replace("/[^a-zA-Z0-9_-]/", '', base64_encode($file.$lastModified)), -8);


		if (!file_exists(storage_path("cache/assets/js/{$tagDir}/{$tagFile}.blade.php")))
		{
			if (!file_exists(storage_path("cache/assets/js/{$tagDir}")) || !is_dir(storage_path("cache/assets/js/{$tagDir}"))){
				mkdir(base_path("resources/cache/assets/js/{$tagDir}"), 0755);
			}
			$content = minify_js(file_get_contents(base_path("resources/assets/js/{$file}.blade.php")));
			file_put_contents(storage_path("cache/assets/js/{$tagDir}/{$tagFile}.blade.php"), $content);
		}
		return view("assets.js.{$tagDir}.{$tagFile}", $params)->render();
	}
	else if ($type == 'css')
	{
		$lastModified	= filemtime(base_path("resources/assets/css/{$file}.blade.php"));
		$tagDir			= substr(preg_replace("/[^a-zA-Z0-9_-]/", '', base64_encode(date('Ymd'))), -4);
		$tagFile		= substr(preg_replace("/[^a-zA-Z0-9_-]/", '', base64_encode($file.$lastModified)), -8);


		if (!file_exists(storage_path("cache/assets/css/{$tagDir}/{$tagFile}.blade.php")))
		{
			if (!file_exists(storage_path("cache/assets/css/{$tagDir}")) || !is_dir(storage_path("cache/assets/css/{$tagDir}"))){
				mkdir(storage_path("cache/assets/css/{$tagDir}"), 0755);
			}
			$content = minify_css(file_get_contents(base_path("resources/assets/css/{$file}.blade.php")));
			file_put_contents(storage_path("cache/assets/css/{$tagDir}/{$tagFile}.blade.php"), $content);
		}
		return view("assets.css.{$tagDir}.{$tagFile}", $params)->render();
	}

	return '';
}
