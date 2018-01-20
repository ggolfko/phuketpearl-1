var SK_LUNAR = {};
SK_LUNAR.isMobile = false;
SK_LUNAR.openAlbumLabel = "FULL VIEW";
MAIN_PATH = "lunar_assets";


jQuery(document).ready(function(){
    SK_LUNAR.isMobile = SakuraPlugins.Lunar.isMobile();
    SakuraPlugins.Lunar.getInstance().proxyWrapper();
});
var SakuraPlugins = {};
SakuraPlugins.Lunar = (function(){

    var _instance;
    var LunarApp = function(){
        this._lunarGalleries = [];
        return this;
    }
    LunarApp.prototype = {
        start: function(){
            var _self = this;
            jQuery('.lunar_galleri_ui').each(function(indx){
                var ta = jQuery(this).find('textarea');
                var data = JSON.parse(ta.html());
                ta.remove();
                var LunarGallery = SakuraPlugins.LunarGallery.createInstance(data, jQuery(this));
                _self._lunarGalleries.push(LunarGallery);
            });
        },
        startInstance: function(data, ui){
            var _self = this;
            var LunarGallery = SakuraPlugins.LunarGallery.createInstance(data, ui);
            _self._lunarGalleries.push(LunarGallery);
        },
        proxyWrapper: function(){
            var _self = this;
            jQuery('.lunar-gallery-ui').each(function(indx){
                jQuery(this).addClass('lunar_galleri_ui');
                jQuery(this).addClass(jQuery(this).attr('data-class'));
                var galleryUI = jQuery(this);
                var galleryAC = [];

                jQuery(this).children().each(function(index){
                    var lunarAlbumDta = {};
                    lunarAlbumDta.imageid = jQuery(this).attr('data-imageid');
                    lunarAlbumDta.app = jQuery(this).attr('data-app');
                    lunarAlbumDta.title = (jQuery(this).find('.lunar-album-title').length!=0)?jQuery(this).find('.lunar-album-title').html():"";
                    lunarAlbumDta.excerpt = (jQuery(this).find('.lunar-album-about').length!=0)?jQuery(this).find('.lunar-album-about').html():"";
                    lunarAlbumDta.id = SakuraUtilsLunar.generateUID();
                    lunarAlbumDta.coverSize = parseInt(jQuery(this).attr('data-width'));
                    var coverImg = (jQuery(this).attr('data-thumbimage')!=undefined)?jQuery(this).attr('data-thumbimage'):"http://placehold.it/640x400";
                    lunarAlbumDta.coverImages = {albumCoverLarge: coverImg, albumCoverMedium: coverImg, albumCoverSmall: coverImg};
                    lunarAlbumDta.customURL = (jQuery(this).attr('data-customurl')!=undefined)?jQuery(this).attr('data-customurl'):false;
                    lunarAlbumDta.customURLTarget = "_self";
                    if(lunarAlbumDta.customURL!=false){
                        lunarAlbumDta.customURLTarget = jQuery(this).attr('data-target');
                    }
                    lunarAlbumDta.previewVideoURL = false;
                    if(jQuery(this).find('.video-cover').length!=0){
                        lunarAlbumDta.previewVideoURL = (jQuery(this).find('.video-mp4').length!=0)?jQuery(this).find('.video-mp4').attr('href'):"";
                        lunarAlbumDta.previewVideoWebmURL = (jQuery(this).find('.video-webm').length!=0)?jQuery(this).find('.video-webm').attr('href'):"";
                        lunarAlbumDta.previewVideoAllTime = (jQuery(this).find('.video-cover').attr('data-preview-video-all-time')=="true")?true:false;
                    }
                    lunarAlbumDta.isSpecial = false;
                    if(jQuery(this).attr('data-is-special')!=undefined){
                        lunarAlbumDta.isSpecial = true;
                        lunarAlbumDta.specialSide = (jQuery(this).attr('data-special-side')!=undefined)?jQuery(this).attr('data-special-side'):"left";
                    }
                    //gallery
                    lunarAlbumDta.gallery = [];
                    jQuery(this).find('.lunar-gallery').children().each(function(){

                        var thumb = jQuery(this).attr('href');
                        var large = jQuery(this).attr('data-imagelarge');
                        var imageSizes = {large: thumb, medium: thumb, small: thumb, fullMobile: large, largeMobile: large, mediumMobile: large};
                        var tempObj = {isVideo: "false", videoCodeAC:"", imageSizes:imageSizes};
                        lunarAlbumDta.gallery.push(tempObj);

                    });
                    galleryAC.push(lunarAlbumDta);
                });

                jQuery(this).empty();
                jQuery('<div class="lnPreloader"></div>').appendTo(jQuery(this));
                jQuery(this).css('display', 'block');
                _self.startInstance(galleryAC, jQuery(this));

            });
        }
    }
    return {
        getInstance: function(){
            if(!_instance){
                _instance = new LunarApp();
            }
            return _instance;
        },
        isMobile: function(){
             if( navigator.userAgent.match(/Android/i)
             || navigator.userAgent.match(/webOS/i)
             || navigator.userAgent.match(/iPhone/i)
             || navigator.userAgent.match(/iPad/i)
             || navigator.userAgent.match(/iPod/i)
             || navigator.userAgent.match(/BlackBerry/i)
             || navigator.userAgent.match(/Windows Phone/i)
             ){
                return true;
              }
             else {
                return false;
              }
        }
    }

})();



//lunar gallery wrapper
SakuraPlugins.LunarGallery = (function(){
    var LunarGallery = function(data, jUi){
        this._galleryData = data;
        this._jUi = jUi;
        this._albumsViews = [];

        this.initialize();

        return this;
    }
    LunarGallery.prototype = {
        initialize: function(){
            this._jUi.packery({
              itemSelector: '.lunarAlbumView',
              gutter: 0
            });
            for (var i = 0; i < this._galleryData.length; i++) {
                var albumModel = new SakuraPlugins.LunarGallery.AlbumModel(this._galleryData[i]);
                var albumView = new SakuraPlugins.LunarGallery.AlbumView(albumModel);
                this._albumsViews.push(albumView);
                if(this._albumsViews[i-1]!=undefined)
                    this._albumsViews[i-1].next(albumView);
                //albumModel.onChange();
            };
            if(this._albumsViews[0] != undefined)
                this._albumsViews[0].render(this._jUi, true);
        }
    }

    return {
        createInstance: function(data, jUi){
            return new LunarGallery(data, jUi);
        }
    }
})();




////////////GENERICS//////////////
//////////////////////////////////
SakuraPlugins.LunarGallery.Model = function(data){
    this._data = data;
    this.onChange = function(){};
}
SakuraPlugins.LunarGallery.View = function(model, jUi){
    this._model = model;
    this.el = jUi;

    this.dataChanged = function(){
        return this;
    }

    if(this._model)
        this.initialize();
}
SakuraPlugins.LunarGallery.View.prototype = {
    initialize: function(){
        var _self = this;
        this._model.onChange = function(){
            _self.dataChanged();
        }
    },
    setModel: function(m){
        this._model = m;
        this.initialize();
    },
    getModel: function(){
        return this._model;
    }
}



////////////VIEWS//////////////
//album view
SakuraPlugins.LunarGallery.AlbumView = function(model){
    SakuraPlugins.LunarGallery.View.call(this, model);
    this._nextView;
    this._player;
    this._playerUI;
    var _self = this;
    var coverSize = (this._model._data.coverSize=="33")?"33.3333":this._model._data.coverSize;
    this._buildHtml = function(){
        return [
            '<div class="lunarAlbumView ln_cursor" style="width: '+coverSize+'%;">',
                '<div class="albumContentUI">',
                    '<div class="albumImgUI"></div>',
                    this._getVideo(),
                    '<div class="albumTransparentHover"></div>',
                    '<div class="borderUI"><div class="lunarBorder"></div></div>',
                    '<div class="movingBorderUI">',
                        '<div class="movingBorder movingBorderLeftTop"></div>',
                        '<div class="movingBorder movingBorderRightTop"></div>',
                        '<div class="movingBorder movingBorderRightBottom"></div>',
                        '<div class="movingBorder movingBorderLeftBottom"></div>',
                    '</div>',
                    '<div class="lnInfoUI">',
                        '<div class="lnInfoContainer">',
                            '<p class="lnTitle ln_font2">'+this._model._data.title+'</p>',
                            '<div class="lnInfo">',
                                '<p class="lnAlbumInfo ln_font2">'+this._model._data.excerpt+'</p>',
                                '<a class="lnOpenAlbum lnOpenAlbumBTN ln_font3" data-id="'+this._model._data.id+'" href="#">'+SK_LUNAR.openAlbumLabel+'</a>',
                            '</div>',
                        '</div>',
                    '</div>',
                '</div>',
            '</div>'
        ].join('');
    }
    this._getVideo = function(){
        if(!this._model._data.previewVideoURL){
            return '';
        }
        function getWEBM(src){
            if(src=="")
                return '';
            return '<source src="'+src+'" type="video/webm;codecs=&quot;vp8, vorbis&quot;" />';
        }
        var autoplay  = (this._model._data.previewVideoAllTime)?' autoplay':'';
        var displayVideo = (this._model._data.previewVideoAllTime)?' displayVideo':'';
        //previewVideoWebmURL
        return [
            '<div class="ln_video'+displayVideo+'">',
                '<video class="ln_video_tag" muted loop'+autoplay+'>',
                    '<source src="'+this._model._data.previewVideoURL+'" type="video/mp4;codecs=&quot;avc1.42E01E, mp4a.40.2&quot;" />',
                    getWEBM(this._model._data.previewVideoWebmURL),
                '</video>',
            '</div>'
        ].join('');
    }
    this._buildImage = function(){
        return jQuery('<img src="'+this._getFeaturedImage()+'" alt="" />');
    }

    this._getFeaturedImage = function(){
        var imgUrl = '';
        if(!SK_LUNAR.isMobile){
            imgUrl = this._model._data.coverImages.albumCoverLarge;
        }else{
            //get appropriete image link
            imgUrl = this._model._data.coverImages.albumCoverSmall;
            var maxSize = (jQuery(window).width()>jQuery(window).height())?jQuery(window).width():jQuery(window).height();
            if(maxSize>720)
                imgUrl = this._model._data.coverImages.albumCoverMedium;
            if(maxSize>1000)
                imgUrl = this._model._data.coverImages.albumCoverLarge;

        }
        return imgUrl;
    }

    //special album html
    this.buildSpecialHTML = function(){
        var leftHTMLContentw = '';
        var rightHTMLContent = '';
        if(this._model._data.specialSide=="left"){
            leftHTMLContent = this.getSpecialContentImage();
            rightHTMLContent = this.getSpecialContentHTML();
        }else{
            leftHTMLContent = this.getSpecialContentHTML();
            rightHTMLContent = this.getSpecialContentImage();
        }
        return [
            '<div class="lunarAlbumView" style="width: 100%;">',
                '<div class="albumContentUI">',
                    '<div class="specialAlbumSection">'+leftHTMLContent+'</div>',
                    '<div class="specialAlbumSection">'+rightHTMLContent+'</div>',
                    '<div class="ln-clear"></div>',
                '</div>',
            '</div>'
        ].join('');
    }
    this.getSpecialContentImage = function(){
        return [
                '<div class="albumImgUI"></div>',
                this._getVideo(),
                '<div class="albumTransparentHover"></div>',
                '<div class="borderUI speicalAlbumImageUI ln_cursor"><div class="lunarBorder"></div></div>',
                '<div class="movingBorderUI">',
                    '<div class="movingBorder movingBorderLeftTop"></div>',
                    '<div class="movingBorder movingBorderRightTop"></div>',
                    '<div class="movingBorder movingBorderRightBottom"></div>',
                    '<div class="movingBorder movingBorderLeftBottom"></div>',
                '</div>',
                '<a class="lnOpenAlbum lnOpenAlbumBTN lnOpenAlbumSpecial ln_font3" data-id="'+this._model._data.id+'" href="#">'+SK_LUNAR.openAlbumLabel+'</a>'
        ].join('');
    }
    this.getSpecialContentHTML = function(){
        return [
            '<div class="specialAlbumUI">',
                '<div class="specialAlbumInfoUI">',
                    '<p class="lnSpecialAlbumTitle ln_font2">'+this._model._data.title+'</p>',
                    '<div class="lnInfoSpecialUI">',
                        '<p class="lnAlbumInfoSpecial ln_font2">'+this._model._data.excerpt+'</p>',
                        '<a class="lnOpenSpecialAlbum lnOpenAlbumBTN ln_font3" data-id="'+this._model._data.id+'" href="#">'+SK_LUNAR.openAlbumLabel+'</a>',
                    '</div>',
                '</div>',
            '</div>'
        ].join('');
    }

    this.buildHTMLProxy = function(){
        if(!this._model._data.isSpecial){
            return this._buildHtml();
        }else{
            //special here
            return this.buildSpecialHTML();
        }
    }

    this.render = function(parrent, isFirst){
        if(isFirst==true)
            parrent.find('.lnPreloader').remove();
        var _self = this;
        var _parent = parrent;
        this.el = jQuery(this.buildHTMLProxy());
        this.el.css('opacity', 0);
        parrent.append(this.el);

        var imgUI = this._buildImage();
        imgUI.bind('load', function(){
            _parent.packery( 'appended', _self.el );
            _self.onResizeEvnt();
            if(_self._nextView)
                _self._nextView.render(_parent, false);
        });
        imgUI.appendTo(this.el.find('.albumImgUI'));

        //is video
        if(this._model._data.previewVideoURL){
            this._player = this.el.find('.ln_video_tag')[0];
            this._playerUI = this.el.find('.ln_video');
        }
        this.eventsProxy();

        if(this.el.width()<100){
            this.el.find('.lnTitle').css('display', 'none');
        }

        return this;
    }

    jQuery(window).bind('resize', function(){
        _self.onResizeEvnt();
    });

    this.onResizeEvnt = function(){
        if(this.el==undefined)
            return;
        var lnOpenAlbumSpecial = this.el.find('.lnOpenAlbumSpecial');
        var speicalAlbumImageUI = this.el.find('.speicalAlbumImageUI');
        lnOpenAlbumSpecial.css('left', speicalAlbumImageUI.width()/2-lnOpenAlbumSpecial.width()/2);
        lnOpenAlbumSpecial.css('top', speicalAlbumImageUI.height()/2-lnOpenAlbumSpecial.height()/2);
    }

    this.eventsProxy = function(){
        if(!this._model._data.isSpecial){
            this.addEvents();
        }else{
            //special here
            this.addSpecialEvents();
        }
    }

    this.addEvents = function(){
        var Efx = Quad.easeInOut;
        var inTime = .5;
        var outTime = .5;
        var infoTime = .3;
        // /var EfxInfo = Power4.easeIn;
        var EfxInfo = Efx;
        var _self = this;
        var maxWidthHoverEfx = 280;
        this.el.hover(function(e){
            if(_self.el.width()>maxWidthHoverEfx){
                TweenMax.to(jQuery(this).find('.movingBorderLeftTop'), inTime, {css:{width:'100%'}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderRightTop'), inTime, {css:{height:'100%'}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderRightBottom'), inTime, {css:{width:'100%'}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderLeftBottom'), inTime, {css:{height:'100%'}, ease:Efx});
                //TweenMax.to(jQuery(this).find('.albumTransparentHover'), inTime, {css:{opacity: 1}, ease:Efx});

                //title
                //jQuery(this).find('.lnInfo').css('opacity', 0);
                //jQuery(this).find('.lnInfo').css('display', 'block');
                //jQuery(this).find('.lnInfo').css('bottom', -(jQuery(this).find('.lnInfo').height()+30));
                TweenMax.to(jQuery(this).find('.lnTitle'), infoTime, {css:{bottom: jQuery(this).find('.lnInfo').height()+30}, ease:EfxInfo});
                TweenMax.to(jQuery(this).find('.lnInfo'), infoTime, {css:{bottom: 20}, delay: .1, ease:EfxInfo});
                TweenMax.to(jQuery(this).find('.lnInfo'), infoTime, {css:{opacity: 1}, delay: .1, ease:EfxInfo});
            }
            if(_self._model._data.previewVideoURL){
                if(!_self._model._data.previewVideoAllTime){
                    _self._playerUI.css('opacity', 0);
                    _self._playerUI.css('display', 'block');
                    TweenMax.to(_self._playerUI, .2, {css:{opacity: 1}, ease:Power4.easeIn});
                    _self._player.play();
                }
            }


        }, function(e){
            if(_self.el.width()>maxWidthHoverEfx){
                TweenMax.to(jQuery(this).find('.movingBorderLeftTop'), outTime, {css:{width: 0}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderRightTop'), outTime, {css:{height: 0}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderRightBottom'), inTime, {css:{width: 0}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderLeftBottom'), inTime, {css:{height:0}, ease:Efx});
                TweenMax.to(jQuery(this).find('.albumTransparentHover'), inTime, {css:{opacity: 0}, ease:Efx});

                //title
                TweenMax.to(jQuery(this).find('.lnTitle'), infoTime, {css:{bottom: '10px'}, delay: .1, ease:EfxInfo});
                TweenMax.to(jQuery(this).find('.lnInfo'), infoTime, {css:{bottom: -(jQuery(this).find('.lnInfo').height()+30)}, ease:EfxInfo});
                TweenMax.to(jQuery(this).find('.lnInfo'), infoTime, {css:{opacity: 0}, delay: .1, ease:EfxInfo});
            }
            if(_self._model._data.previewVideoURL){
                if(!_self._model._data.previewVideoAllTime){
                    _self._playerUI.css('display', 'block');
                    TweenMax.to(_self._playerUI, .2, {css:{opacity: 0}, ease:Power4.easeIn, onComplete: function(){
                         _self._playerUI.css('display', 'none');
                         //_self._player.currentTime = 0;
                    }});
                    _self._player.pause();
                }
            }
        });

        this.el.click(function(e){
            _self.clickProxy(e);
        });
    }
    this.addSpecialEvents = function(){
        var _self = this;
        var Efx = Quad.easeInOut;
        var inTime = .5;
        var outTime = .5;
        this.el.find('.albumImgUI').parent().hover(function(e){
            if(_self._model._data.previewVideoURL){
                if(!_self._model._data.previewVideoAllTime){
                    _self._playerUI.css('opacity', 0);
                    _self._playerUI.css('display', 'block');
                    TweenMax.to(_self._playerUI, .2, {css:{opacity: 1}, ease:Power4.easeIn});
                    _self._player.play();
                }
            }
                TweenMax.to(jQuery(this).find('.movingBorderLeftTop'), inTime, {css:{width:'100%'}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderRightTop'), inTime, {css:{height:'100%'}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderRightBottom'), inTime, {css:{width:'100%'}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderLeftBottom'), inTime, {css:{height:'100%'}, ease:Efx});
                TweenMax.to(jQuery(this).find('.albumTransparentHover'), inTime, {css:{opacity: 1}, ease:Efx});
                TweenMax.to(jQuery(this).find('.lnOpenAlbumSpecial'), inTime, {css:{opacity: 1}, ease:Efx});

        }, function(e){

            if(_self._model._data.previewVideoURL){
                if(!_self._model._data.previewVideoAllTime){
                    _self._playerUI.css('display', 'block');
                    TweenMax.to(_self._playerUI, .2, {css:{opacity: 0}, ease:Power4.easeIn, onComplete: function(){
                         _self._playerUI.css('display', 'none');
                         //_self._player.currentTime = 0;
                    }});
                    _self._player.pause();
                }
            }

                TweenMax.to(jQuery(this).find('.movingBorderLeftTop'), outTime, {css:{width: 0}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderRightTop'), outTime, {css:{height: 0}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderRightBottom'), inTime, {css:{width: 0}, ease:Efx});
                TweenMax.to(jQuery(this).find('.movingBorderLeftBottom'), inTime, {css:{height:0}, ease:Efx});
                TweenMax.to(jQuery(this).find('.albumTransparentHover'), inTime, {css:{opacity: 0}, ease:Efx});
                TweenMax.to(jQuery(this).find('.lnOpenAlbumSpecial'), inTime, {css:{opacity: 0}, ease:Efx});
        });
        this.el.find('.speicalAlbumImageUI').click(function(e){
            _self.clickProxy(e);
        });
        this.el.find('.lnOpenSpecialAlbum').click(function(e){
            _self.clickProxy(e);
        });

        this.el.find('.lnOpenAlbumSpecial').click(function(e){
            _self.clickProxy(e);
        });
        this.el.find('.movingBorderUI').click(function(e){
            _self.clickProxy(e);
        });
    }

    this.clickProxy = function(e){
        e.preventDefault();

        return;
        if(this._model._data.customURL){
            window.open(this._model._data.customURL, this._model._data.customURLTarget);
        }else{
            //open gallery
            if(!SakuraPlugins.Gallery.isOpen)
                SakuraPlugins.Gallery.show(this._model, this.el);
        }
    }
}
SakuraPlugins.LunarGallery.AlbumView.prototype = new SakuraPlugins.LunarGallery.View();
SakuraPlugins.LunarGallery.AlbumView.prototype.constructor = SakuraPlugins.LunarGallery.GalleryView;
SakuraPlugins.LunarGallery.AlbumView.prototype.next = function(nextView){
    this._nextView = nextView;
}


////////START GALLERY MODULE
SakuraPlugins.Gallery = (function(){
    this._galleryModel;
    this._galleryView;
    this.isOpen = false;
    this.oldScrollTop;

    function init(albumModel, el){
        this.isOpen = true;
        this.oldScrollTop = jQuery(window).scrollTop();
        this._galleryModel = new SakuraPlugins.LunarGallery.GalleryModel(albumModel);
        this._galleryView = new SakuraPlugins.LunarGallery.GalleryView(this._galleryModel, el);
        this._galleryView.render().el.appendTo('body');
        var _self = this;
        this._galleryView.setCloseCallback(function(){
            _self._galleryView.destroy();
             _self.isOpen = false;
        });
        this._galleryView.setOnDestroy(function(){
            //tbd
        });
    }

    this.close = function(){
        this.isOpen = false;
        this._galleryView.destroy();
    }

    return {
        show: function(albumModel, el){
            init(albumModel, el);
        },
        hide: function(){
            this.close();
        }
    }
})();
////////END GALLERY MODULE



//gallery view
SakuraPlugins.LunarGallery.GalleryView = function(model, elView){
    SakuraPlugins.LunarGallery.View.call(this, model);
    this.elView = elView;

    this._buildHtml = function(){
        return [
            '<div id="lunarGalleryUI">',
                '<div class="lunarGalleryUIViewport">',
                    '<div id="lunarGalleryContent">',
                    '</div>',
                '</div>',
                '<div class="lunarGalleryClose"><div class="lunarGalleryCloseIco"></div></div>',
                '<div class="galleryScrollNavUI">',
                    '<div class="galleryScrollNav galleryScrollNavUp"></div>',
                    '<div class="galleryScrollNav galleryScrollNavDown"></div>',
                '</div>',
            '</div>'
        ].join('');
    }

    this.closeBTN;
    this.galleryScrollNavUI;
    this._galleryItems;
    this.galleryScrollNavUp;
    this.galleryScrollNavDown;
    this.lunarGalleryUIViewport;
    this.lunarGalleryContent;

    this.init = function(){
        this._galleryContainer =this.el.find('#lunarGalleryContent');
        this._galleryContainer.packery({
          itemSelector: '.lunarGalleryItem',
          gutter: 0
        });
        this.galleryScrollNavUp = this.el.find('.galleryScrollNavUp');
        this.galleryScrollNavDown = this.el.find('.galleryScrollNavDown');
        this.lunarGalleryUIViewport = this.el.find('.lunarGalleryUIViewport');
        this.lunarGalleryContent = this.el.find('#lunarGalleryContent');

        this.closeBTN = this.el.find('.lunarGalleryClose');
        this.galleryScrollNavUI = this.el.find('.galleryScrollNavUI');

        TweenMax.to(this.closeBTN, .3, {css:{opacity: 1}, delay: .5, ease:Quad.easeInOut});
        if(SK_LUNAR.isMobile){
            this.galleryScrollNavUI.css('opacity', 0);
            this.galleryScrollNavUI.css('display', 'block');
            TweenMax.to(this.galleryScrollNavUI, .3, {css:{opacity: 1}, delay: .5, ease:Quad.easeInOut});
        }

        this._galleryItems = [];
        this._galleriesDataAC = [];

        for (var i = 0; i < this._model._gallery.length; i++) {
            var galleryItemModel = new SakuraPlugins.LunarGallery.GalleryItemModel(this._model._gallery[i]);
            var galleryItemView = new SakuraPlugins.LunarGallery.GalleryItemView(galleryItemModel);
            galleryItemView.setIndex(i);
            this._galleriesDataAC.push(this._model._gallery[i]);
            this._galleryItems.push(galleryItemView);
            if(this._galleryItems[i-1]!=undefined){
                this._galleryItems[i-1].next(galleryItemView);
            }
        };
        if(this._galleryItems[0] != undefined){
            this._galleryItems[0].setGalleryData(this._galleriesDataAC);
            this._galleryItems[0].render(this._galleryContainer);
        }
        //this.el.find('.lunarGalleryContent').append(galleryItemView.render().el);
        this.events();
        this.addEscapeKeyEvent();
        var _self = this;

        if(SK_LUNAR.isMobile){
            jQuery(window).bind('resize', function(){
                _self.onResize();
            });
            this.handleScrollButtons();
        }
    }

    this.handleScrollButtons = function(){
        var _self = this;
        this.galleryScrollNavUp.click(function(e){
            e.preventDefault();
            _self.moveContentDOWN();
        });
        this.galleryScrollNavDown.click(function(e){
            e.preventDefault();
            _self.moveContentUP();
        });
    }
    this.moveContentUP = function(){
        var _self = this;
        var currentTop = (isNaN(this.extractNumber(this.lunarGalleryContent.css('top')))) ? 0 : this.extractNumber(this.lunarGalleryContent.css('top'));
        TweenMax.to(this.lunarGalleryContent, .8, {css:{top: currentTop-(jQuery(window).height()/1.5)}, ease: Power1.easeIn, onComplete: function(){
            _self.checkMobileScroll();
        }});
    }
    this.moveContentDOWN = function(){
        var _self = this;
        var currentTop = (isNaN(this.extractNumber(this.lunarGalleryContent.css('top')))) ? 0 : this.extractNumber(this.lunarGalleryContent.css('top'));
        TweenMax.to(this.lunarGalleryContent, .8, {css:{top: currentTop+(jQuery(window).height()/1.5)}, ease: Power1.easeIn, onComplete: function(){
            _self.checkMobileScroll();
        }});
    }
    this.checkMobileScroll = function(){
        var currentTop = (isNaN(this.extractNumber(this.lunarGalleryContent.css('top')))) ? 0 : this.extractNumber(this.lunarGalleryContent.css('top'));
        var hgt = this.lunarGalleryContent.height();
        if(currentTop>0){
            TweenMax.to(this.lunarGalleryContent, .2, {css:{top: 0}, ease: Power1.easeIn});
        }
        if((currentTop+hgt)<jQuery(window).height()){
            if(jQuery(window).height()>this.lunarGalleryContent.height()){
                TweenMax.to(this.lunarGalleryContent, .2, {css:{top: 0}, ease: Power1.easeIn});
            }else{
                TweenMax.to(this.lunarGalleryContent, .2, {css:{top: -(this.lunarGalleryContent.height()-jQuery(window).height())}, ease: Power1.easeIn});
            }
        }
    }

  //extract number
  this.extractNumber = function(pxValue){
      var striped = pxValue.substring(0, pxValue.length-2);
      var val = parseFloat(striped);
      return val;
  }

    this.onResize = function(){

    }

    this.events = function(){
        this.closeBTN.hover(function(){
            TweenMax.to(jQuery(this).find('.lunarGalleryCloseIco'), .2, {css:{scale: .8}, ease:Power4.EaseIn});
        }, function(){
            TweenMax.to(jQuery(this).find('.lunarGalleryCloseIco'), .2, {css:{scale: 1}, ease:Power4.EaseIn});
        });
        var _self = this;
        this.closeBTN.bind('click', function(e){
            e.preventDefault();
            //close
            if(_self._closeCallBack){
                _self._closeCallBack();
            }
        });
    }


    //lightbox proxy
    this.addEscapeKeyEvent = function(){
      var _self = this;
      jQuery(document).bind("keydown", function(e){
            switch(e.keyCode)
            {
            case 27:
            if(_self._closeCallBack)
                _self._closeCallBack();
              break;
            }
      });
    }
    this.removeEscapeEvent = function(){
        jQuery(document).unbind("keydown");
    }
    var _self = this;
    LightBoxLunar.setCloseListener(function(){
        _self.addEscapeKeyEvent();
    });
    LightBoxLunar.setOpenListener(function(){
       _self.removeEscapeEvent();
    });
    //lightbox proxy

    this._closeCallBack;
    this.setCloseCallback = function(callBack){
        this._closeCallBack = callBack;
    }
    this._onDestroy;
    this.setOnDestroy = function(callBack){
        this._onDestroy = callBack;
    }



    this.render = function(){
        this.el = jQuery(this._buildHtml());
        this.el.css('height', '3px');
        this.el.css('top', jQuery(window).height()/2);
        var _self = this;
        TweenMax.to(this.el, .5, {css:{height:'100%', top: '0px'}, delay: .3, ease:Quad.easeInOut, onComplete: function(){
            jQuery('html, body').css({
                'overflow': 'hidden',
                'height': '100%'
            });
            _self.init();
        }});
        return this;
    }

    this.destroy = function(){
        jQuery(window).unbind('resize');
        this.removeEscapeEvent();
        this.closeBTN.unbind();
        TweenMax.to(this.closeBTN, .3, {css:{opacity: 0}, ease:Quad.easeInOut});
        if(SK_LUNAR.isMobile){
            TweenMax.to(this.galleryScrollNavUI, .3, {css:{opacity: 0}, ease:Quad.easeInOut});
        }

        var _self = this;
        if(this._galleryItems[this._galleryItems.length-1]!=undefined){
            this._galleryItems[this._galleryItems.length-1].set_lastDestroyedCallback(function(){
                TweenMax.to(_self.el, .3, {css:{opacity: 0}, ease:Power4.easeIn, onComplete: function(){
                    _self.el.remove();
                    jQuery('html, body').css({
                        'overflow': 'auto',
                        'height': 'auto'
                    });
                    //jQuery(window).scrollTop(SakuraPlugins.Gallery.oldScrollTop);
                    jQuery('html, body').animate({
                        scrollTop: _self.elView.offset().top-100
                    }, 800);
                }});
            });
        }
        for (var i = 0; i < this._galleryItems.length; i++) {
            this._galleryItems[i].destroy();
        };
    }
}
SakuraPlugins.LunarGallery.GalleryView.prototype = new SakuraPlugins.LunarGallery.View();
SakuraPlugins.LunarGallery.GalleryView.prototype.constructor = SakuraPlugins.LunarGallery.GalleryView;


//gallery item view
SakuraPlugins.LunarGallery.GalleryItemView = function(model){
    SakuraPlugins.LunarGallery.View.call(this, model);

    this._buildHtml = function(){
        return [
            '<div class="lunarGalleryItem">',
                '<div class="lunarGalleryItemPerspectiveUI">',
                    '<div class="lunarGalleryItemImage"></div>',
                    '<div class="lunarGalleryItemHover"></div>',
                '</div>',
            '</div>'
        ].join('');
    }
    this._buildImageElement = function(){
        return '<img src="'+this._getOptimiziedImage()+'" alt="" />';
    }

    this._parrent;
    this.render = function(parrent){
        this._parrent = parrent;
        this.el = jQuery(this._buildHtml());
        var img = jQuery(this._buildImageElement());
        var _self = this;
        this.el.css('opacity', 0);
        img.bind('load', function(){
            _self._parrent.packery( 'appended', _self.el );
            //img.css('opacity', 0);
            _self.el.css('opacity', 1);
            //TweenMax.to(jQuery(this), .3, {css:{opacity: 1}, delay: .5, ease:Power4.easeIn});
            //jQuery(this).css('opacity', 1);
            if(_self._next){
                _self._next.setGalleryData(_self._galleryData);
                _self._next.render(_self._parrent);
            }
            if(!SK_LUNAR.isMobile){
                _self._parrent.parent().niceScroll({cursorcolor:"#00F", horizrailenabled: false, cursorborder:"1px solid #323231", cursorcolor: "#212121"});
            }else{
                _self.el.find('.lunarGalleryItemHover').addClass('lunarGalleryItemHoverMobile');
            }
        });
        parrent.append(this.el);
        img.appendTo(this.el.find('.lunarGalleryItemImage'));
        this.addEvents();
        return this;
    }

    this.destroy = function(){
        var _self = this;
        try{
            this.el.unbind();
            TweenMax.set(this.el, {perspective:500});
            TweenMax.to(this.el.find('.lunarGalleryItemPerspectiveUI'), .5, {css:{scale: .7, opacity: 0, rotationY: this.perspectiveUngleAC[randomIntFromInterval(0, 9)], rotationX: this.perspectiveUngleAC[randomIntFromInterval(0, 9)]}, ease:Quad.easeInOut, onComplete: function(){
                _self.el.remove();
                if(_self._lastDestroyedCallback)
                    _self._lastDestroyedCallback();
            }});
        }catch(e){
                try{
                    _self.el.remove();
                }catch(e){}
                if(_self._lastDestroyedCallback)
                    _self._lastDestroyedCallback();
        }
    }

    this._lastDestroyedCallback;
    this.set_lastDestroyedCallback = function(callBack){
        this._lastDestroyedCallback = callBack;
    }

    this.perspectiveUngleAC = [-60, -45, -35, -25, -15, 15, 25, 35, 45, 60];
    function randomIntFromInterval(min,max){
        return Math.floor(Math.random()*(max-min+1)+min);
    }

    this._index;
    this.setIndex = function(indx){
        this._index = indx;
    }

    this._galleryData;
    this.setGalleryData = function(galleryData){
        this._galleryData = galleryData;
    }

    this.addEvents = function(){
        var _self = this;
        var Efx = Quad.easeInOut;
        var inTime = .3;
        this.el.hover(function(){
            TweenMax.to(jQuery(this).find('.lunarGalleryItemHover'), inTime, {css:{opacity:'0'}, ease:Efx});
        }, function(){
            TweenMax.to(jQuery(this).find('.lunarGalleryItemHover'), inTime, {css:{opacity:'1'}, ease:Efx});
        });
        this.el.bind('click', function(e){
            //_self.removeEscapeEvent();
            var wrappedDta = _self.decorate(_self._galleryData);
            var lunarLghtb = LightBoxLunar.createInstance();
            lunarLghtb.init(wrappedDta, false, null, _self._index);
        });
    }

    this.decorate = function(dataObj){
        var data = [];
        var msg = "";
        for (var i = 0; i < dataObj.length; i++) {
            data.push({imageLargeURL: this._getOptimiziedImageLightbox(dataObj[i].imageSizes), type: (dataObj[i].isVideo=="false")?"image":"video", extraData: ""})
        };
        return data;
    }

    this._getOptimiziedImageLightbox = function(imageSizes){
        var imgUrl = '';
        if(!SK_LUNAR.isMobile){
            imgUrl = imageSizes.fullMobile;
        }else{
            //get appropriete image link
            imgUrl = this._model._data.imageSizes.mediumMobile;
            var maxSize = (jQuery(window).width()>jQuery(window).height())?jQuery(window).width():jQuery(window).height();
            if(maxSize>500)
                imgUrl = imageSizes.largeMobile;
            if(maxSize>1000)
                imgUrl = imageSizes.fullMobile;
        }
        return imgUrl;
    }

    this._getOptimiziedImage = function(){
        var imgUrl = '';
        if(!SK_LUNAR.isMobile){
            imgUrl = this._model._data.imageSizes.large;
        }else{
            //get appropriete image link
            imgUrl = this._model._data.imageSizes.small;
            var maxSize = (jQuery(window).width()>jQuery(window).height())?jQuery(window).width():jQuery(window).height();
            if(maxSize>720)
                imgUrl = this._model._data.imageSizes.medium;
            if(maxSize>1000)
                imgUrl = this._model._data.imageSizes.large;
        }
        return imgUrl;
    }
}
SakuraPlugins.LunarGallery.GalleryItemView.prototype = new SakuraPlugins.LunarGallery.View();
SakuraPlugins.LunarGallery.GalleryItemView.prototype.constructor = SakuraPlugins.LunarGallery.GalleryItemView;
SakuraPlugins.LunarGallery.GalleryItemView.prototype.next = function(next){
    this._next = next;
}






////////////MODELS//////////////
//album model
SakuraPlugins.LunarGallery.AlbumModel = function(data){
    if(SK_LUNAR.isMobile)
        data.previewVideoURL = false;
    SakuraPlugins.LunarGallery.Model.call(this, data);
}
SakuraPlugins.LunarGallery.AlbumModel.prototype = new SakuraPlugins.LunarGallery.Model();
SakuraPlugins.LunarGallery.AlbumModel.prototype.constructor = SakuraPlugins.LunarGallery.AlbumModel;

//gallery model
SakuraPlugins.LunarGallery.GalleryModel = function(albumModel){
    if(albumModel){
        if(albumModel.constructor!=SakuraPlugins.LunarGallery.AlbumModel)
            throw new Error("Invalida data model! at "+this.data.constructor.name);
    }
    SakuraPlugins.LunarGallery.Model.call(this, albumModel);
    this._gallery = this._data._data.gallery;
}
SakuraPlugins.LunarGallery.GalleryModel.prototype = new SakuraPlugins.LunarGallery.Model();
SakuraPlugins.LunarGallery.GalleryModel.prototype.constructor = SakuraPlugins.LunarGallery.GalleryModel;



//gallery item model
SakuraPlugins.LunarGallery.GalleryItemModel = function(data){
    SakuraPlugins.LunarGallery.Model.call(this, data);
}
SakuraPlugins.LunarGallery.GalleryItemModel.prototype = new SakuraPlugins.LunarGallery.Model();
SakuraPlugins.LunarGallery.GalleryItemModel.prototype.constructor = SakuraPlugins.LunarGallery.GalleryItemModel;





//lightbox
/*
* @data - array with images URL's
* @advanced - show 3D effect
* @websiteWrapper - main website container
* @startIndx - start index
* dataObj.type (image/video/sound)
* dataObj.imageLargeURL
*/
var LightBoxLunar = (function(){
    var closeListener;
    var openListener;
    return {
        createInstance: function(){
            return new LightBoxLunarClass();
        },
        setCloseListener: function(cl){
            closeListener = cl;
        },
        setOpenListener: function(ol){
            openListener = ol;
        },
        onClose: function(){
            if(closeListener)
                closeListener();
        },
        onOpen: function(){
            if(openListener)
                openListener();
        }
    }
})();

function LightBoxLunarClass(){
  var active = true;


  this.init=function(data, advanced, websiteWrapper, startIndx){
      LightBoxLunar.onOpen();

      if(startIndx==undefined||startIndx==null){
        startIndx = 0;
      }
      if(advanced){
          TweenMax.to(websiteWrapper, .2, {css:{opacity:.9, scale: .9}, ease:Power4.EaseIn});
      }
      var isRestrict = false;
      var lightboxUI = jQuery('<div class="gravityLightboxUI gravityLightboxSettings"></div>');
      lightboxUI.css('opacity', 0);
      lightboxUI.appendTo('body');
      lightboxUI.css('width', '80%');
      lightboxUI.css('height', '80%');
      lightboxUI.css('left', jQuery(window).width()/2-lightboxUI.width()/2);
      lightboxUI.css('top', 130);
      TweenMax.to(lightboxUI, .1, {css:{opacity:1, width: '100%', left: 0, height: '100%', top: 0}, ease:Power4.EaseIn, onComplete:function(){
          routeData(data[startIndx]);
          lightboxResize();
      }});


      jQuery(window).resize(function(){
         lightboxResize();
      });

      var leftControlUI = jQuery('<div class="gravityArrow gravityArrowLeft"></div>');
      leftControlUI.css('display', 'none');
      leftControlUI.appendTo(lightboxUI);
      var rightControlUI = jQuery('<div class="gravityArrow gravityArrowRight"></div>');
      rightControlUI.css('display', 'none');
      rightControlUI.appendTo(lightboxUI);
      var gravityLightCloseUI = jQuery('<div class="gravityLightCloseUI"><div class="gravityLightClose"></div></div>');
      gravityLightCloseUI.appendTo(lightboxUI);
      var gravityLightClose = gravityLightCloseUI.find('.gravityLightClose');

      var loaderUI = jQuery('<div class="lbgLoader"><img src="'+MAIN_PATH+'/img/lightbox/preloader.gif" alt="" /></div>');
      loaderUI.css('opacity', 0);
      loaderUI.appendTo(lightboxUI);

      var controlls = new Array(leftControlUI, rightControlUI, gravityLightClose);
      for (var i = 0; i < controlls.length; i++) {
        controlls[i].css('opacity', .7);
        controlls[i].hover(function(){
            TweenMax.to(jQuery(this), .2, {css:{opacity:1}, ease:Power4.EaseIn});
        },function(){
            TweenMax.to(jQuery(this), .2, {css:{opacity:.7}, ease:Power4.EaseIn});
        });
      };

      lightboxResize();


      function displayPreloader(val){
          if(val){
              TweenMax.to(loaderUI, .19, {css:{opacity:1, scale: 1}, ease:Power4.EaseIn});
          }else{
            TweenMax.to(loaderUI, .19, {css:{opacity:0, scale: .5}, ease:Power4.EaseIn});
          }
      }

      keyEvents();
      function keyEvents(){
          jQuery(document).bind("keydown", function(e){
              if(isRestrict)
                return;
                switch(e.keyCode)
                {
                case 37:
                  if(startIndx>0){
                    startIndx--;
                    routeData(data[startIndx]);
                  }
                  break;
                case 39:
                  if(startIndx<data.length-1){
                    startIndx++;
                    routeData(data[startIndx]);
                  }
                  break;
                case 27:
                  lightboxClose();
                  break;
                }
          });
      }

      leftControlUI.click(function(e){
        e.preventDefault();
        if(isRestrict){
          return;
        }
        if(startIndx>0){
          startIndx--;
          routeData(data[startIndx]);
        }
      });

      rightControlUI.click(function(e){
        e.preventDefault();
        if(isRestrict){
          return;
        }
        if(startIndx<data.length-1){
          startIndx++;
          routeData(data[startIndx]);
        }
      });

      function validateButtons(){
        if(currentImageUI==null){
          leftControlUI.css('display', 'none');
          rightControlUI.css('display', 'none');
          return;
        }
        leftControlUI.css('display', 'block');
        rightControlUI.css('display', 'block');
          if(startIndx==0){
            //disable left
            leftControlUI.css('display', 'none');
          }

          if(startIndx>=data.length-1){
            //disable right
            rightControlUI.css('display', 'none');
          }
      }

      function routeData(dataObj){
          switch(dataObj.type)
          {
          case "image":
            loadImage(dataObj.imageLargeURL);
            break;
          case "video":
            loadVideo(dataObj.extraData);
            break;
          case "sound":
            loadSound(dataObj.extraData);
            break;
          }
      }

      function loadSound(videoSrc){
          validateButtons();
          isRestrict = true;
          if(currentImageUI!=null){
              displayPreloader(true);
              TweenMax.to(currentImageUI, .2, {css:{opacity:0}, ease:Power4.EaseIn, onComplete: function(){
                  currentImageUI.remove();
                  loadNewSound(videoSrc);
              }});
          }else{
            displayPreloader(true);
            loadNewSound(videoSrc);
          }
      }
      //load sound
      function loadNewSound(videoSrc){
        try{
          currentImageUI = jQuery('<div class="gridSound">'+videoSrc+'</div>');
          currentImageUI.css('opacity', 0);
          currentImageUI.appendTo(lightboxUI);
          TweenMax.to(currentImageUI, .2, {css:{opacity:1}, ease:Power4.EaseIn});
          displayPreloader(false);
          lightboxResize();
          isRestrict = false;
        }catch(e){}
        validateButtons();
      }

      function loadVideo(videoSrc){
          validateButtons();
          isRestrict = true;
          if(currentImageUI!=null){
              displayPreloader(true);
              TweenMax.to(currentImageUI, .2, {css:{opacity:0}, ease:Power4.EaseIn, onComplete: function(){
                  currentImageUI.remove();
                  loadNewVideo(videoSrc);
              }});
          }else{
            displayPreloader(true);
            loadNewVideo(videoSrc);
          }
      }
      //load video
      function loadNewVideo(videoSrc){
        try{
          currentImageUI = jQuery('<div class="gridVideo">'+videoSrc+'</div>');
          currentImageUI.css('opacity', 0);
          currentImageUI.appendTo(lightboxUI);
          TweenMax.to(currentImageUI, .2, {css:{opacity:1}, ease:Power4.EaseIn});
          displayPreloader(false);
          lightboxResize();
          isRestrict = false;
        }catch(e){}
        validateButtons();
      }


      var currentImageUI=null;
      function loadImage(imgSrc){
        validateButtons();
        isRestrict = true;
          if(currentImageUI!=null){
              displayPreloader(true);
              TweenMax.to(currentImageUI, .2, {css:{opacity:0}, ease:Power4.EaseIn, onComplete: function(){
                  currentImageUI.remove();
                  loadNewImage(imgSrc);
              }});
          }else{
            displayPreloader(true);
            loadNewImage(imgSrc);
          }
      }

      function loadNewImage(imgSrc){
        try{
          currentImageUI = jQuery('<img class="gravityLightboxImage" src="'+imgSrc+'" alt="" />');
          currentImageUI.css('opacity', 0);
          currentImageUI.bind('load', function(){
              lightboxResize();
              currentImageUI.unbind('load');
              displayPreloader(false);
              TweenMax.to(currentImageUI, .2, {css:{opacity:1}, ease:Power4.EaseIn});
          })
          currentImageUI.appendTo(lightboxUI);
          try{
                currentImageUI.unbind('contextmenu');
                currentImageUI.bind('contextmenu', function(e) {
                    return false;
                });
          }catch(e){}
          isRestrict = false;
        }catch(e){}
        validateButtons();
      }

      gravityLightClose.hover(function(e){
          TweenMax.to(jQuery(this), .2, {css:{scale: .9}, ease:Power4.EaseIn});
      }, function(e){
          TweenMax.to(jQuery(this), .2, {css:{scale: 1}, ease:Power4.EaseIn});
      });
      gravityLightCloseUI.click(function(e){
          e.preventDefault();
          lightboxClose();
      });

      function lightboxClose(){
          active = false;
          if(advanced){
            TweenMax.to(lightboxUI, .2, {css:{opacity:.2, scale: 1.3}, ease:Power4.EaseIn});
            TweenMax.to(websiteWrapper, .2, {css:{opacity:1, scale: 1}, delay:.1, ease:Power4.EaseIn, onComplete: function(){
              lightboxUI.remove();
            }});
         }else{
            if(currentImageUI!=null){
                TweenMax.to(currentImageUI, .1, {css:{opacity:0, scale: .8}, ease:Power4.EaseIn, onComplete:function(){
                    TweenMax.to(lightboxUI, .2, {css:{opacity:0}, delay: .2, ease:Power4.EaseIn, onComplete: function(){
                      lightboxUI.remove();
                    }});
                }});
                TweenMax.to(rightControlUI, .1, {css:{opacity:0}, ease:Power4.EaseIn});
                TweenMax.to(leftControlUI, .1, {css:{opacity:0}, ease:Power4.EaseIn});
                jQuery(this).css('display', 'none');
            }else{
                lightboxUI.remove();
            }
         }
         jQuery(document).unbind('keydown');
         LightBoxLunar.onClose();
      }

      function lightboxResize(){
          if(!active){
              return;
          }
          try{
          currentImageUI.css('left', lightboxUI.width()/2-currentImageUI.width()/2+'px');
          currentImageUI.css('top', lightboxUI.height()/2-currentImageUI.height()/2+'px');
        }catch(e){}
          try{
              leftControlUI.css('left', 20+'px');
              leftControlUI.css('top', lightboxUI.height()/2-leftControlUI.height()/2+'px');
              rightControlUI.css('right', 20+'px');
              rightControlUI.css('top', lightboxUI.height()/2-rightControlUI.height()/2+'px');
              gravityLightCloseUI.css('bottom', 20+'px');
              gravityLightCloseUI.css('left', lightboxUI.width()/2-42/2+'px');

              loaderUI.css('left', lightboxUI.width()/2-30/2+'px');
              loaderUI.css('top', lightboxUI.height()/2-30/2+'px');

          }catch(e){}
      }

      /**
       * Utils
       */
      //extract number
      function extractNumber(pxValue){
          var striped = pxValue.substring(0, pxValue.length-2);
          var val = parseFloat(striped);
          return val;
      }

  }
}



function base64_decode(data) {
// discuss at: http://phpjs.org/functions/base64_decode/
// original by: Tyler Akins (http://rumkin.com)
// improved by: Thunder.m
// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
// improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
// input by: Aman Gupta
// input by: Brett Zamir (http://brett-zamir.me)
// bugfixed by: Onno Marsman
// bugfixed by: Pellentesque Malesuada
// bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
// example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==');
// returns 1: 'Kevin van Zonneveld'
// example 2: base64_decode('YQ===');
// returns 2: 'a'
// example 3: base64_decode('4pyTIMOgIGxhIG1vZGU=');
// returns 3: '✓ à la mode'
var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
ac = 0,
dec = '',
tmp_arr = [];
if (!data) {
return data;
}
data += '';
do {
// unpack four hexets into three octets using index points in b64
h1 = b64.indexOf(data.charAt(i++));
h2 = b64.indexOf(data.charAt(i++));
h3 = b64.indexOf(data.charAt(i++));
h4 = b64.indexOf(data.charAt(i++));
bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;
o1 = bits >> 16 & 0xff;
o2 = bits >> 8 & 0xff;
o3 = bits & 0xff;
if (h3 == 64) {
tmp_arr[ac++] = String.fromCharCode(o1);
} else if (h4 == 64) {
tmp_arr[ac++] = String.fromCharCode(o1, o2);
} else {
tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
}
} while (i < data.length);
dec = tmp_arr.join('');
return decodeURIComponent(escape(dec.replace(/\0+$/, '')));
}


var SakuraUtilsLunar = (function(){
    return {
        hexToRgb: function(hex){
            var bigint = parseInt(hex, 16);
            var r = (bigint >> 16) & 255;
            var g = (bigint >> 8) & 255;
            var b = bigint & 255;
            return [r, g, b];
        },
        generateUID: function(){
            return Math.random().toString(36).substring(2, 15) +
                Math.random().toString(36).substring(2, 15);
        }
    }
})();
