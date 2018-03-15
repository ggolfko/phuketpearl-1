<?php

Route::group(['middleware' => 'web'], function($route){
    //frontend
	$route->any('', 'HomeController@getIndex');
	$route->any('/home', 'HomeController@getIndex');
	$route->get('news', 'NewsController@getIndex');
	$route->get('news.html', 'NewsController@getIndex');
	$route->get('news/{newsid}', 'NewsController@getRead')->where('newsid', '[0-9]{16}');
	$route->get('news/{newsid}.html', 'NewsController@getRead')->where('newsid', '[0-9]{16}');
	$route->get('jewels.html', 'JewelsController@getIndex');
    $route->group(['prefix' => 'jewels'], function($route){
        $route->get('', 'JewelsController@getIndex');
        $route->get('{url}.html', 'JewelsController@getProduct');
        $route->get('{url}', 'JewelsController@getCategory');
    });
    $route->group(['prefix' => 'tours'], function($route){
        $route->get('', 'TourController@getIndex');
        $route->get('{url}.html', 'TourController@getDetail');
        $route->post('{url}.html', 'TourController@postDetail');
    });
    $route->get('contactus.html', 'ContactController@getIndex');
    $route->group(['prefix' => 'books'], function($route){
        $route->group(['prefix' => '{bookid}'], function($route){
            $route->get('payment', 'BookingController@getPayment')->where('bookid', '[0-9]{16}');
            $route->any('success', 'BookingController@anySuccess')->where('bookid', '[0-9]{16}');
        });
    });
	$route->get('gallery.html', 'GalleryController@getIndex');
	$route->get('gallery', 'GalleryController@getIndex');
	$route->get('gallery/{id}.html', 'GalleryController@getIndex');
    $route->get('location-opening-hours.html', 'WorkingController@getIndex');
    $route->get('pearl-care.html', 'PearlController@getCare');
    $route->get('pearl-quality.html', 'PearlController@getQuality');
    $route->get('pearl-farm.html', 'PearlController@getFarm');
	$route->get('pearl-farm', 'PearlController@getFarm');
	$route->get('pearl-farm/{id}.html', 'PearlController@getFarm');
    $route->get('pearl-farming.html', 'PearlController@getFarming');
    $route->get('pearl-type.html', 'PearlController@getType');
    $route->get('pearl-crowns.html', 'PearlController@getCrown');
    $route->get('our-story.html', 'CompanyController@getStory');
    $route->get('awards-certificates.html', 'CompanyController@getAwardCertificate');
	$route->get('media-special-guests.html', 'NewsController@getMediaSpecialGuests');
	$route->any('sitemap.xml', 'SitemapController@index');
	$route->any('robots.txt', 'CoreController@robots');

	$route->group(['prefix' => 'sitemap'], function($route){
		$route->any('static.xml', 'SitemapController@statics');
		$route->any('news.xml', 'SitemapController@news');
		$route->any('jewels.xml', 'SitemapController@jewels');
		$route->any('jewels/category.xml', 'SitemapController@jewelsCategory');
		$route->any('gallery.xml', 'SitemapController@gallery');
		$route->any('videos.xml', 'SitemapController@videos');
		$route->any('tours.xml', 'SitemapController@tours');
		$route->any('awards.xml', 'SitemapController@awards');
		$route->any('certificates.xml', 'SitemapController@certificates');
		$route->any('ourstory.xml', 'SitemapController@ourstory');
		$route->any('contactus.xml', 'SitemapController@contactus');
		$route->any('home.xml', 'SitemapController@home');
		$route->any('media-special-guests.xml', 'SitemapController@mediaspecialguests');
		$route->any('location-opening-hours.xml', 'SitemapController@locationopeninghours');
		$route->any('pearl-care.xml', 'SitemapController@pearlcare');
		$route->any('pearl-crowns.xml', 'SitemapController@pearlcrowns');
		$route->any('pearl-farm.xml', 'SitemapController@pearlfarm');
		$route->any('pearl-farming.xml', 'SitemapController@pearlfarming');
		$route->any('pearl-quality.xml', 'SitemapController@pearlquality');
		$route->any('pearl-type.xml', 'SitemapController@pearltype');
	});

	$route->group(['prefix' => 'pearl-crowns'], function($route){
		$route->get('', 'PearlController@getCrown');
		$route->get('{alias}.html', 'PearlController@getCrown');
	});

	$route->group(['prefix' => 'media-special-guests'], function($route){
		$route->get('', 'NewsController@getMediaSpecialGuests');
		$route->get('{alias}.html', 'NewsController@getMediaSpecialGuests');
	});

	$route->group(['prefix' => 'awards'], function($route){
		$route->get('', 'CompanyController@getAwardCertificate');
		$route->get('{alias}.html', 'CompanyController@getAwardCertificate');
	});

	$route->group(['prefix' => 'certificates'], function($route){
		$route->get('', 'CompanyController@getAwardCertificate');
		$route->get('{alias}.html', 'CompanyController@getAwardCertificate');
	});

	//dashboard
	$route->group(['prefix' => 'dashboard', 'namespace' => 'Dashboard'], function($route){
		$route->get('', ['middleware' => 'dashboard.auth', 'uses' => 'HomeController@getIndex']);
		$route->group(['prefix' => 'auth'], function($route){
			$route->get('login', ['middleware' => 'dashboard.guest', 'uses' => 'AuthController@getLogin']);
			$route->post('login', ['middleware' => 'dashboard.guest', 'uses' => 'AuthController@postLogin']);
			$route->get('logout', 'AuthController@getLogout');
			$route->get('account', 'AuthController@getAccount');
			$route->post('account', 'AuthController@postAccount');
			$route->group(['prefix' => 'reset'], function($route){
				$route->get('{token}', 'AuthController@getReset');
				$route->post('{token}', 'AuthController@postReset');
			});
		});
		$route->group(['prefix' => 'settings', 'middleware' => ['dashboard.auth', 'permission.setting']], function($route){
			$route->get('', 'SettingsController@getIndex');
		});
		$route->group(['prefix' => 'employees', 'middleware' => ['dashboard.auth', 'permission.employee']], function($route){
			$route->get('', 'EmployeesController@getIndex');
			$route->get('create', 'EmployeesController@getCreate');
			$route->post('create', 'EmployeesController@postCreate');
			$route->group(['prefix' => '{userid}'], function($route){
				$route->get('', 'EmployeesController@getPerson')->where('userid', '[0-9]{16}');
				$route->get('edit', 'EmployeesController@getPersonEdit')->where('userid', '[0-9]{16}');
				$route->post('edit', 'EmployeesController@postPersonEdit')->where('userid', '[0-9]{16}');
			});
		});
        $route->group(['prefix' => 'products', 'middleware' => ['dashboard.auth', 'permission.product']], function($route){
            $route->get('', 'ProductsController@getIndex');
            $route->get('add', 'ProductsController@getAdd');
            $route->post('add', 'ProductsController@postAdd');
            $route->group(['prefix' => 'category'], function($route){
                $route->get('', 'CategoryController@getIndex');
                $route->get('create', 'CategoryController@getCreate');
                $route->post('create', 'CategoryController@postCreate');
				$route->group(['prefix' => '{categoryid}'], function($route){
					$route->get('', 'CategoryController@getEdit')->where('categoryid', '[0-9]{16}');
	                $route->post('', 'CategoryController@postEdit')->where('categoryid', '[0-9]{16}');
					$route->get('image', 'CategoryController@getImage')->where('categoryid', '[0-9]{16}');
				});
            });
            $route->group(['prefix' => '{productid}'], function($route){
                $route->get('', 'ProductsController@getItem')->where('productid', '[0-9]{16}');
                $route->get('images', 'ProductsController@getImage')->where('productid', '[0-9]{16}');
                $route->get('edit', 'ProductsController@getEdit')->where('productid', '[0-9]{16}');
                $route->post('edit', 'ProductsController@postEdit')->where('productid', '[0-9]{16}');
                $route->get('hooks', 'ProductsController@getHooks')->where('productid', '[0-9]{16}');
				$route->get('quality', 'ProductsController@getQuality')->where('productid', '[0-9]{16}');
            });
        });
        $route->group(['prefix' => 'newsletter', 'middleware' => ['dashboard.auth', 'permission.newsletter']], function($route){
            $route->get('', 'NewsletterController@getIndex');
            $route->get('compose', 'NewsletterController@getCompose');
            $route->get('subscribers', 'NewsletterController@getSubscriber');
            $route->group(['prefix' => '{letterid}'], function($route){
                $route->get('', 'NewsletterController@getItem')->where('letterid', '[0-9]{16}');
            });
        });
        $route->group(['prefix' => 'news', 'middleware' => ['dashboard.auth', 'permission.news']], function($route){
            $route->get('', 'NewsController@getIndex');
            $route->get('write', 'NewsController@getWrite');
            $route->post('write', 'NewsController@postWrite');
            $route->group(['prefix' => '{newsid}'], function($route){
                $route->get('', 'NewsController@getItem')->where('newsid', '[0-9]{16}');
                $route->get('images', 'NewsController@getImages')->where('newsid', '[0-9]{16}');
                $route->get('edit', 'NewsController@getEdit')->where('newsid', '[0-9]{16}');
                $route->post('edit', 'NewsController@postEdit')->where('newsid', '[0-9]{16}');
            });
        });
        $route->group(['prefix' => 'contacts', 'middleware' => ['dashboard.auth', 'permission.contact']], function($route){
            $route->get('', 'ContactsController@getIndex');
            $route->get('{contactid}', 'ContactsController@getRead')->where('contactid', '[0-9]{16}');
        });
        $route->group(['prefix' => 'gallery', 'middleware' => ['dashboard.auth', 'permission.gallery']], function($route){
            $route->get('', 'PictureController@getIndex');
            $route->group(['prefix' => 'videos'], function($route){
                $route->get('', 'PictureController@getVideo');
                $route->get('add', 'PictureController@getVideoAdd');
                $route->post('add', 'PictureController@postVideoAdd');
                $route->group(['prefix' => '{videoid}'], function($route){
                    $route->get('', 'PictureController@getVideoEdit')->where('videoid', '[0-9]{16}');
                    $route->post('', 'PictureController@postVideoEdit')->where('videoid', '[0-9]{16}');
                });
            });
        });
        $route->group(['prefix' => 'videos', 'middleware' => ['dashboard.auth', 'permission.video']], function($route){
            $route->get('', 'VideoController@getIndex');
            $route->get('add', 'VideoController@getAdd');
            $route->post('add', 'VideoController@postAdd');
            $route->group(['prefix' => '{videoid}'], function($route){
                $route->get('', 'VideoController@getEdit')->where('videoid', '[0-9]{16}');
                $route->post('', 'VideoController@postEdit')->where('videoid', '[0-9]{16}');
            });
        });
        $route->group(['prefix' => 'docs', 'middleware' => ['dashboard.auth', 'permission.document']], function($route){
            $route->get('', 'DocController@getIndex');
            $route->group(['prefix' => 'timeline'], function($route){
                $route->get('', 'TimelineController@getIndex');
                $route->get('add', 'TimelineController@getAdd');
                $route->post('add', 'TimelineController@postAdd');
                $route->group(['prefix' => '{timelineid}'], function($route){
                    $route->get('', 'TimelineController@getItem')->where('timelineid', '[0-9]{16}');
                    $route->get('images', 'TimelineController@getImage')->where('timelineid', '[0-9]{16}');
                    $route->get('edit', 'TimelineController@getEdit')->where('timelineid', '[0-9]{16}');
                    $route->post('edit', 'TimelineController@postEdit')->where('timelineid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'crown'], function($route){
                $route->get('', 'CrownController@getIndex');
                $route->get('add', 'CrownController@getAdd');
                $route->post('add', 'CrownController@postAdd');
                $route->group(['prefix' => '{crownid}'], function($route){
                    $route->get('', 'CrownController@getEdit')->where('crownid', '[0-9]{16}');
                    $route->post('', 'CrownController@postEdit')->where('crownid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'award'], function($route){
                $route->get('', 'AwardController@getIndex');
                $route->get('add', 'AwardController@getAdd');
                $route->post('add', 'AwardController@postAdd');
                $route->group(['prefix' => '{awardid}'], function($route){
                    $route->get('', 'AwardController@getEdit')->where('awardid', '[0-9]{16}');
                    $route->post('', 'AwardController@postEdit')->where('awardid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'certificate'], function($route){
                $route->get('', 'CertificateController@getIndex');
                $route->get('add', 'CertificateController@getAdd');
                $route->post('add', 'CertificateController@postAdd');
                $route->group(['prefix' => '{certificateid}'], function($route){
                    $route->get('', 'CertificateController@getEdit')->where('certificateid', '[0-9]{16}');
                    $route->post('', 'CertificateController@postEdit')->where('certificateid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'pearlcare'], function($route){
                $route->get('', 'PearlController@getCare');
                $route->post('', 'PearlController@postCare');
            });
            $route->group(['prefix' => 'pearlquality'], function($route){
                $route->get('', 'PearlController@getQuality');
				$route->get('add', 'PearlController@getQualityAdd');
				$route->post('add', 'PearlController@postQualityAdd');
				$route->group(['prefix' => '{itemid}'], function($route){
					$route->get('', 'PearlController@getQualityItem')->where('itemid', '[0-9]{16}');
                    $route->get('edit', 'PearlController@getQualityEdit')->where('itemid', '[0-9]{16}');
					$route->post('edit', 'PearlController@postQualityEdit')->where('itemid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'pearltype'], function($route){
                $route->get('', 'PearlController@getType');
                $route->get('add', 'PearlController@getTypeAdd');
                $route->post('add', 'PearlController@postTypeAdd');
                $route->group(['prefix' => '{typeid}'], function($route){
                    $route->get('', 'PearlController@getTypeItem')->where('typeid', '[0-9]{16}');
                    $route->get('edit', 'PearlController@getTypeEdit')->where('typeid', '[0-9]{16}');
                    $route->post('edit', 'PearlController@postTypeEdit')->where('typeid', '[0-9]{16}');
                    $route->get('images', 'PearlController@getTypeImage')->where('typeid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'pearlfarm'], function($route){
                $route->get('', 'PearlController@getFarm');
                $route->group(['prefix' => 'videos'], function($route){
                    $route->get('', 'PearlController@getFarmVideo');
                    $route->get('add', 'PearlController@getFarmVideoAdd');
                    $route->post('add', 'PearlController@postFarmVideoAdd');
                    $route->group(['prefix' => '{videoid}'], function($route){
                        $route->get('', 'PearlController@getFarmVideoEdit')->where('videoid', '[0-9]{16}');
                        $route->post('', 'PearlController@postFarmVideoEdit')->where('videoid', '[0-9]{16}');
                    });
                });
            });
            $route->group(['prefix' => 'pearlfarming'], function($route){
                $route->get('', 'PearlController@getFarming');
                $route->get('add', 'PearlController@getFarmingAdd');
                $route->post('add', 'PearlController@postFarmingAdd');
                $route->group(['prefix' => '{farmingid}'], function($route){
                    $route->get('', 'PearlController@getFarmingItem')->where('farmingid', '[0-9]{16}');
                    $route->get('edit', 'PearlController@getFarmingEdit')->where('farmingid', '[0-9]{16}');
                    $route->post('edit', 'PearlController@postFarmingEdit')->where('farmingid', '[0-9]{16}');
					$route->group(['prefix' => 'slides'], function($route){
	                    $route->get('', 'PearlController@getFarmingSlides')->where('farmingid', '[0-9]{16}');
						$route->get('add', 'PearlController@getFarmingSlideAdd')->where('farmingid', '[0-9]{16}');
						$route->post('add', 'PearlController@postFarmingSlideAdd')->where('farmingid', '[0-9]{16}');
						$route->group(['prefix' => '{slideid}'], function($route){
							$route->get('', 'PearlController@getFarmingSlideEdit')->where(['farmingid' => '[0-9]{16}', 'slideid' => '[0-9]{16}']);
							$route->post('', 'PearlController@postFarmingSlideEdit')->where(['farmingid' => '[0-9]{16}', 'slideid' => '[0-9]{16}']);
						});
	                });
                });
            });
            $route->group(['prefix' => 'ourstory'], function($route){
                $route->get('article', 'StoryController@getArticle');
                $route->post('article', 'StoryController@postArticle');
                $route->get('images', 'StoryController@getImages');
            });
			$route->group(['prefix' => 'media-special-guests'], function($route){
                $route->get('', 'NewsController@getMediaSpecialGuests');
				$route->get('add', 'NewsController@getMediaSpecialGuestsAdd');
				$route->post('add', 'NewsController@postMediaSpecialGuestsAdd');
				$route->group(['prefix' => '{itemid}'], function($route){
					$route->get('', 'NewsController@getMediaSpecialGuestsItem')->where(['itemid' => '[0-9]{16}']);
					$route->post('', 'NewsController@postMediaSpecialGuestsItem')->where(['itemid' => '[0-9]{16}']);
					$route->get('images', 'NewsController@getMediaSpecialGuestsImages')->where(['itemid' => '[0-9]{16}']);
				});
            });
        });
        $route->group(['prefix' => 'tours', 'middleware' => ['dashboard.auth', 'permission.tour']], function($route){
            $route->get('', 'TourController@getIndex');
            $route->get('create', 'TourController@getCreate');
            $route->post('create', 'TourController@postCreate');
            $route->get('terms', 'TourController@getTerms');
            $route->post('terms', 'TourController@postTerms');
            $route->group(['prefix' => '{tourid}'], function($route){
                $route->get('', 'TourController@getItem')->where('tourid', '[0-9]{16}');
                $route->get('images', 'TourController@getImage')->where('tourid', '[0-9]{16}');
                $route->get('edit', 'TourController@getEdit')->where('tourid', '[0-9]{16}');
                $route->post('edit', 'TourController@postEdit')->where('tourid', '[0-9]{16}');
                $route->get('disabled', 'TourController@getDisabled')->where('tourid', '[0-9]{16}');
                $route->post('disabled', 'TourController@postDisabled')->where('tourid', '[0-9]{16}');
            });
        });
        $route->group(['prefix' => 'booking', 'middleware' => ['dashboard.auth', 'permission.book']], function($route){
            $route->get('', 'BookingController@getIndex');
            $route->group(['prefix' => '{bookid}'], function($route){
                $route->get('', 'BookingController@getDetail')->where('bookid', '[0-9]{16}');
                $route->get('proof', 'BookingController@getProof')->where('bookid', '[0-9]{16}');
            });
        });
        $route->group(['prefix' => 'payments', 'middleware' => ['dashboard.auth', 'permission.payment']], function($route){
            $route->get('', 'PaymentController@getIndex');
            $route->post('', 'PaymentController@postUpdate');
        });
        $route->group(['prefix' => 'enquiry', 'middleware' => ['dashboard.auth', 'permission.enquiry']], function($route){
            $route->get('', 'EnquiryController@getIndex');
            $route->group(['prefix' => '{enquiryid}'], function($route){
                $route->get('', 'EnquiryController@getItem')->where('enquiryid', '[0-9]{16}');
            });
        });
		$route->group(['prefix' => 'howto', 'middleware' => ['dashboard.auth']], function($route){
            $route->get('map', 'HowtoController@getMap');
        });
		$route->group(['prefix' => 'slides', 'middleware' => ['dashboard.auth']], function($route){
            $route->get('', 'SlideController@getIndex');
			$route->get('add', 'SlideController@getAdd');
			$route->post('add', 'SlideController@postAdd');
			$route->group(['prefix' => '{slideid}'], function($route){
				$route->get('', 'SlideController@getItem')->where('slideid', '[0-9]{16}');
				$route->post('', 'SlideController@postItem')->where('slideid', '[0-9]{16}');
			});
        });
	});

	//ajax
	$route->group(['prefix' => 'ajax'], function($route){
        $route->post('lang', 'AjaxController@postLang');

        $route->group(['prefix' => 'docs'], function($route){
            $route->get('tour-terms.html', 'DocController@getTourTerms');
        });

        $route->group(['prefix' => 'tours'], function($route){
            $route->post('booking', 'TourController@ajaxPostBooking');
        });
        $route->group(['prefix' => 'contactus'], function($route){
            $route->post('', 'ContactController@ajaxPostCreate');
            $route->post('reply', 'ContactController@ajaxPostReply');
        });
        $route->group(['prefix' => 'subscribe'], function($route){
            $route->post('add', 'SubscribeController@ajaxPostAdd');
        });
        $route->group(['prefix' => 'books'], function($route){
            $route->post('inform', 'BookingController@ajaxPostInform');
            $route->post('success', 'BookingController@ajaxPostSuccess');
        });
        $route->group(['prefix' => 'jewels'], function($route){
            $route->group(['prefix' => '{productid}'], function($route){
                $route->post('enquiry', 'JewelsController@ajaxPostEnquiry');
            });
        });

		//dashboard
		$route->group(['prefix' => 'dashboard', 'namespace' => 'Dashboard'], function($route){
			$route->post('auth/reminder', 'AuthController@ajaxPostReminder');
			$route->post('settings/update', ['middleware' => ['dashboard.auth', 'permission.setting'], 'uses' => 'SettingsController@ajaxPostUpdate']);
			$route->post('settings/fbimage', ['middleware' => ['dashboard.auth', 'permission.setting'], 'uses' => 'SettingsController@ajaxPostFbImage']);
			$route->group(['prefix' => 'employees', 'middleware' => ['dashboard.auth', 'permission.employee']], function($route){
				$route->group(['prefix' => 'exists'], function($route){
					$route->post('username', 'EmployeesController@ajaxPostExistsUsername');
					$route->post('email', 'EmployeesController@ajaxPostExistsEmail');
				});
				$route->group(['prefix' => '{userid}'], function($route){
					$route->post('', 'EmployeesController@ajaxPostDeletePerson')->where('userid', '[0-9]{16}');
					$route->group(['prefix' => 'exists'], function($route){
						$route->post('username', 'EmployeesController@ajaxPostPersonExistsUsername')->where('userid', '[0-9]{16}');
						$route->post('email', 'EmployeesController@ajaxPostPersonExistsEmail')->where('userid', '[0-9]{16}');
					});
				});
			});
            $route->group(['prefix' => 'products', 'middleware' => ['dashboard.auth', 'permission.product']], function($route){
                $route->group(['prefix' => 'category'], function($route){
                    $route->group(['prefix' => '{categoryid}'], function($route){
                        $route->post('delete', 'CategoryController@ajaxPostDelete')->where('categoryid', '[0-9]{16}');
						$route->post('image', 'CategoryController@ajaxPostImage')->where('categoryid', '[0-9]{16}');
						$route->post('removeimage', 'CategoryController@ajaxPostRemoveImage')->where('categoryid', '[0-9]{16}');
                    });
                });
                $route->group(['prefix' => '{productid}'], function($route){
                    $route->post('images', 'ProductsController@ajaxPostImage')->where('productid', '[0-9]{16}');
                    $route->post('publish', 'ProductsController@ajaxPostPublish')->where('productid', '[0-9]{16}');
                    $route->post('recommend', 'ProductsController@ajaxPostRecommend')->where('productid', '[0-9]{16}');
                    $route->post('popular', 'ProductsController@ajaxPostPopular')->where('productid', '[0-9]{16}');
                    $route->post('new', 'ProductsController@ajaxPostNew')->where('productid', '[0-9]{16}');
                    $route->post('delete', 'ProductsController@ajaxPostDelete')->where('productid', '[0-9]{16}');
					$route->post('quality', 'ProductsController@ajaxPostQuality')->where('productid', '[0-9]{16}');
                    $route->group(['prefix' => '{imageid}'], function($route){
                        $route->post('delete', 'ProductsController@ajaxPostImageDelete')->where(['productid' => '[0-9]{16}', 'imageid' => '[0-9]{16}']);
                        $route->post('cover', 'ProductsController@ajaxPostImageCover')->where(['productid' => '[0-9]{16}', 'imageid' => '[0-9]{16}']);
                    });
                    $route->group(['prefix' => 'hooks'], function($route){
                        $route->post('status', 'ProductsController@ajaxPostHooksStatus')->where('productid', '[0-9]{16}');
                        $route->post('image', 'ProductsController@ajaxPostHooksImage')->where('productid', '[0-9]{16}');
                        $route->post('save', 'ProductsController@ajaxPostHooksSave')->where('productid', '[0-9]{16}');
                    });
                });
            });
            $route->group(['prefix' => 'gallery', 'middleware' => ['dashboard.auth', 'permission.gallery']], function($route){
                $route->group(['prefix' => 'videos'], function($route){
                    $route->group(['prefix' => '{videoid}'], function($route){
                        $route->post('delete', 'PictureController@ajaxPostVideoDelete')->where('videoid', '[0-9]{16}');
                    });
                });
				$route->post('upload', 'PictureController@ajaxPostUpload');
				$route->post('images', 'PictureController@ajaxPostImages');

                $route->group(['prefix' => '{imageid}'], function($route){
                    $route->post('delete', 'PictureController@ajaxPostImageDelete')->where('imageid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'news', 'middleware' => ['dashboard.auth', 'permission.news']], function($route){
                $route->post('image', 'NewsController@ajaxPostImageUpload');
                $route->post('publish', 'NewsController@ajaxPostPublish');
                $route->group(['prefix' => '{newsid}'], function($route){
                    $route->post('upload', 'NewsController@ajaxPostItemImagesUpload')->where('newsid', '[0-9]{16}');
					$route->post('images', 'NewsController@ajaxPostItemImages')->where('newsid', '[0-9]{16}');
                    $route->post('{imageid}', 'NewsController@ajaxPostItemImageDelete')->where(['newsid' => '[0-9]{16}', 'imageid' => '[0-9]{16}']);
                    $route->post('', 'NewsController@ajaxPostItemDelete')->where('newsid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'videos', 'middleware' => ['dashboard.auth', 'permission.video']], function($route){
                $route->group(['prefix' => '{videoid}'], function($route){
                    $route->post('delete', 'VideoController@ajaxPostDelete')->where('videoid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'docs', 'middleware' => ['dashboard.auth', 'permission.document']], function($route){
                $route->group(['prefix' => 'timeline'], function($route){
                    $route->group(['prefix' => '{timelineid}'], function($route){
                        $route->post('delete', 'TimelineController@ajaxPostDelete')->where('timelineid', '[0-9]{16}');
                        $route->post('images', 'TimelineController@ajaxPostImageUpload')->where('timelineid', '[0-9]{16}');
                        $route->group(['prefix' => '{imageid}'], function($route){
                            $route->post('', 'TimelineController@ajaxPostImageDelete')->where(['timelineid' => '[0-9]{16}', 'imageid' => '[0-9]{16}']);
                        });
                    });
                });
                $route->group(['prefix' => 'crown'], function($route){
                    $route->post('image', 'CrownController@ajaxPostImageUpload');
                    $route->group(['prefix' => '{crownid}'], function($route){
                        $route->post('delete', 'CrownController@ajaxPostDelete')->where('crownid', '[0-9]{16}');
                    });
                });
                $route->group(['prefix' => 'award'], function($route){
                    $route->post('image', 'AwardController@ajaxPostImage');
                    $route->group(['prefix' => '{awardid}'], function($route){
                        $route->post('delete', 'AwardController@ajaxPostDelete')->where('awardid', '[0-9]{16}');
                    });
                });
                $route->group(['prefix' => 'certificate'], function($route){
                    $route->post('image', 'CertificateController@ajaxPostImage');
                    $route->group(['prefix' => '{certificateid}'], function($route){
                        $route->post('delete', 'CertificateController@ajaxPostDelete')->where('certificateid', '[0-9]{16}');
                    });
                });
                $route->group(['prefix' => 'pearlcare'], function($route){
                    $route->post('image', 'PearlController@ajaxPostCareImage');
                });
                $route->group(['prefix' => 'pearlquality'], function($route){
                    $route->post('image', 'PearlController@ajaxPostQualityImage');
                    $route->group(['prefix' => '{itemid}'], function($route){
                        $route->post('delete', 'PearlController@ajaxPostQualityItemDelete')->where('itemid', '[0-9]{16}');
                    });
                });
                $route->group(['prefix' => 'pearltype'], function($route){
                    $route->group(['prefix' => '{typeid}'], function($route){
                        $route->post('upload', 'PearlController@ajaxPostTypeUpload')->where('typeid', '[0-9]{16}');
                        $route->post('main', 'PearlController@ajaxPostTypeMain')->where('typeid', '[0-9]{16}');
                        $route->post('delete', 'PearlController@ajaxPostTypeDelete')->where('typeid', '[0-9]{16}');
                        $route->post('{imageid}', 'PearlController@ajaxPostTypeImageDelete')->where(['typeid' => '[0-9]{16}', 'imageid' => '[0-9]{16}']);
                    });
                });
                $route->group(['prefix' => 'pearlfarm'], function($route){
                    $route->post('upload', 'PearlController@ajaxPostFarmUpload');
                    $route->post('delete', 'PearlController@ajaxPostFarmDelete');
                    $route->group(['prefix' => 'videos'], function($route){
                        $route->group(['prefix' => '{videoid}'], function($route){
                            $route->post('delete', 'PearlController@ajaxPostFarmVideoDelete')->where('videoid', '[0-9]{16}');
                        });
                    });
                });
                $route->group(['prefix' => 'pearlfarming'], function($route){
                    $route->post('image', 'PearlController@ajaxPostFarmingImage');
                    $route->group(['prefix' => '{farmingid}'], function($route){
                        $route->post('delete', 'PearlController@ajaxPostFarmingDelete')->where('farmingid', '[0-9]{16}');
						$route->post('imagetemp', 'PearlController@ajaxPostFarmingImageTemp')->where('farmingid', '[0-9]{16}');
						$route->group(['prefix' => 'slides'], function($route){
							$route->group(['prefix' => '{slideid}'], function($route){
		                        $route->post('delete', 'PearlController@ajaxPostFarmingSlideDelete')->where(['farmingid' => '[0-9]{16}', 'slideid' => '[0-9]{16}']);
		                    });
	                    });
                    });
                });
                $route->group(['prefix' => 'ourstory'], function($route){
                    $route->group(['prefix' => 'images'], function($route){
                        $route->post('upload', 'StoryController@ajaxPostImagesUpload');
                        $route->post('{imageid}', 'StoryController@ajaxPostImagesDelete');
                    });
                });
				$route->group(['prefix' => 'media-special-guests'], function($route){
					$route->group(['prefix' => '{itemid}'], function($route){
						$route->post('upload', 'NewsController@ajaxPostMediaSpecialGuestsUpload')->where(['itemid' => '[0-9]{16}']);
						$route->post('images', 'NewsController@ajaxPostMediaSpecialGuestsImages')->where(['itemid' => '[0-9]{16}']);
						$route->post('delete', 'NewsController@ajaxPostMediaSpecialGuestsDelete')->where(['itemid' => '[0-9]{16}']);
						$route->group(['prefix' => '{imageid}'], function($route){
							$route->post('', 'NewsController@ajaxPostMediaSpecialGuestsImageDelete')->where(['itemid' => '[0-9]{16}', 'imageid' => '[0-9]{16}']);
						});
					});
	            });
            });
            $route->group(['prefix' => 'tours', 'middleware' => ['dashboard.auth', 'permission.tour']], function($route){
                $route->post('image', 'TourController@ajaxPostImage');
                $route->group(['prefix' => '{tourid}'], function($route){
                    $route->post('images', 'TourController@ajaxPostImageUpload')->where('tourid', '[0-9]{16}');
                    $route->post('publish', 'TourController@ajaxPostPublish')->where('tourid', '[0-9]{16}');
                    $route->post('recommend', 'TourController@ajaxPostRecommend')->where('tourid', '[0-9]{16}');
                    $route->post('popular', 'TourController@ajaxPostPopular')->where('tourid', '[0-9]{16}');
                    $route->post('new', 'TourController@ajaxPostNew')->where('tourid', '[0-9]{16}');
                    $route->post('delete', 'TourController@ajaxPostDelete')->where('tourid', '[0-9]{16}');
                    $route->group(['prefix' => '{imageid}'], function($route){
                        $route->post('delete', 'TourController@ajaxPostImageDelete')->where(['tourid' => '[0-9]{16}', 'imageid' => '[0-9]{16}']);
                    });
                });
            });
            $route->group(['prefix' => 'booking', 'middleware' => ['dashboard.auth', 'permission.book']], function($route){
                $route->post('deletes', 'BookingController@ajaxPostDeletes');
                $route->post('deleteall', 'BookingController@ajaxPostDeleteAll');
                $route->group(['prefix' => '{bookid}'], function($route){
                    $route->post('delete', 'BookingController@ajaxPostDelete')->where('bookid', '[0-9]{16}');
                    $route->post('sendmessage', 'BookingController@ajaxPostSendMessage');
                });
            });
            $route->group(['prefix' => 'contacts', 'middleware' => ['dashboard.auth', 'permission.contact']], function($route){
                $route->post('deletes', 'ContactsController@ajaxPostDeletes');
                $route->post('deleteall', 'ContactsController@ajaxPostDeleteAll');
                $route->group(['prefix' => '{contactid}'], function($route){
                    $route->post('delete', 'ContactsController@ajaxPostDelete')->where('contactid', '[0-9]{16}');
                    $route->post('reply', 'ContactsController@ajaxPostReply')->where('contactid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'newsletter', 'middleware' => ['dashboard.auth', 'permission.newsletter']], function($route){
                $route->post('send', 'NewsletterController@ajaxPostSend');
                $route->get('builder', 'NewsletterController@ajaxGetBuilder');
                $route->get('preview', 'NewsletterController@ajaxGetPreview');
                $route->get('imagesid', 'NewsletterController@ajaxGetImagesId');
                $route->get('images', 'NewsletterController@ajaxGetImages');
                $route->post('images', 'NewsletterController@ajaxPostImages');
				$route->get('subscribers', 'NewsletterController@ajaxGetSubscribers');
                $route->group(['prefix' => 'image'], function($route){
                    $route->group(['prefix' => '{imageid}'], function($route){
                        $route->post('delete', 'NewsletterController@ajaxPostImageDelete')->where('imageid', '[0-9]{16}');
                    });
                });
                $route->group(['prefix' => 'subscriber'], function($route){
                    $route->post('delete', 'NewsletterController@ajaxPostSubscriberDelete');
                });
                $route->group(['prefix' => '{letterid}'], function($route){
					$route->post('campaign', 'NewsletterController@ajaxPostCampaign')->where('letterid', '[0-9]{16}');
					$route->post('deliver', 'NewsletterController@ajaxPostDeliver')->where('letterid', '[0-9]{16}');
                    $route->post('delete', 'NewsletterController@ajaxDelete')->where('letterid', '[0-9]{16}');
                    $route->get('sent', 'NewsletterController@ajaxGetSent')->where('letterid', '[0-9]{16}');
					$route->get('status', 'NewsletterController@ajaxGetStatus')->where('letterid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'payments', 'middleware' => ['dashboard.auth', 'permission.payment']], function($route){
                $route->post('removebankmap', 'PaymentController@ajaxPostRemoveBankMap');
            });
            $route->group(['prefix' => 'enquiry', 'middleware' => ['dashboard.auth', 'permission.enquiry']], function($route){
                $route->post('deletes', 'EnquiryController@ajaxPostDeletes');
                $route->post('deleteall', 'EnquiryController@ajaxPostDeleteAll');
                $route->group(['prefix' => '{enquiryid}'], function($route){
                    $route->post('delete', 'EnquiryController@ajaxPostDelete')->where('enquiryid', '[0-9]{16}');
                    $route->post('sendmessage', 'EnquiryController@ajaxPostSendMessage')->where('enquiryid', '[0-9]{16}');
                });
            });
            $route->group(['prefix' => 'home', 'middleware' => ['dashboard.auth']], function($route){
				$route->get('subscribers', 'HomeController@ajaxGetSubscribers');
                $route->get('stat', 'HomeController@ajaxGetStat');
				$route->post('clear', 'HomeController@ajaxPostClear');
				$route->post('warning', 'HomeController@ajaxPostWarning');
				$route->get('google-analytics', 'HomeController@ajaxGetGoogleAnalytics');
            });
			$route->group(['prefix' => 'slides', 'middleware' => ['dashboard.auth']], function($route){
				$route->post('image', 'SlideController@ajaxPostImage');
				$route->group(['prefix' => '{slideid}'], function($route){
                    $route->post('delete', 'SlideController@ajaxPostDelete')->where('slideid', '[0-9]{16}');
					$route->post('sort', 'SlideController@ajaxPostSort')->where('slideid', '[0-9]{16}');
					$route->post('publish', 'SlideController@ajaxPostPublish')->where('slideid', '[0-9]{16}');
                });
            });
		});
	});
});
