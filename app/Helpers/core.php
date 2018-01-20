<?php

function trimUrl($input = '')
{
	$output	= preg_replace('!\s+!', ' ', $input);
	$string	= str_replace(' ', '-', $output);
	$alias	= preg_replace('/[^A-Za-z0-9\-]/', '', $string);

	return $alias;
}

function getYoutubeId($url)
{
    $parts = parse_url($url);
    if(isset($parts['query'])){
        parse_str($parts['query'], $qs);
        if(isset($qs['v'])){
            return $qs['v'];
        }else if(isset($qs['vi'])){
            return $qs['vi'];
        }
    }
    if(isset($parts['path'])){
        $path = explode('/', trim($parts['path'], '/'));
        return $path[count($path)-1];
    }
    return false;
}

function dateTime($time, $format = 'Y-m-d H:i:s')
{
    $dateTime = new \DateTime($time);
    return $dateTime->format($format);
}

function getMapSrc($data)
{
	$src = '';
	preg_match('#<iframe(.*?)></iframe>#is', $data, $matches);

	if (isset($matches[0]))
	{
		preg_match('/src="([^"]+)"/', $data, $match);

		if (isset($match[1])){
			$src = $match[1];
		}
	}

	return $src;
}

function tempFile($file)
{
	$data	= null;
	$dir	= true;

	if ( !File::isDirectory(public_path('__temp')) ){
		$dir = File::makeDirectory('__temp')? true: false;
	}

	if ($dir && $file->isValid())
	{
		$uuid	= uniqid();
		$ext	= strtolower( $file->getClientOriginalExtension() );

		if ( $file->move(public_path('__temp'), "{$uuid}.$ext") )
		{
			$data = [
				'name'	=> $uuid,
				'ext'	=> $ext,
				'file'	=> "__temp/{$uuid}.{$ext}"
			];
		}
	}

	return $data;
}

function clearTempFiles()
{
	if ( File::isDirectory(public_path('__temp')) ){
		File::cleanDirectory('__temp');
	}
}
