(function() {

    'use strict';

    var defaults = {
        videoMaxWidth: '855px',

        autoplayFirstVideo: true,

        youtubePlayerParams: false,
        vimeoPlayerParams: false,
        dailymotionPlayerParams: false,
        vkPlayerParams: false,

        videojs: false,
        videojsOptions: {}
    };

    var Video = function(element) {

        this.core = jQuery(element).data('lightGallery');

        this.jQueryel = jQuery(element);
        this.core.s = jQuery.extend({}, defaults, this.core.s);
        this.videoLoaded = false;

        this.init();

        return this;
    };

    Video.prototype.init = function() {
        var _this = this;

        // Event triggered when video url found without poster
        _this.core.jQueryel.on('hasVideo.lg.tm', onHasVideo.bind(this));

        // Set max width for video
        _this.core.jQueryel.on('onAferAppendSlide.lg.tm', onAferAppendSlide.bind(this));

        if (_this.core.doCss() && (_this.core.jQueryitems.length > 1) && (_this.core.s.enableSwipe || _this.core.s.enableDrag)) {
            _this.core.jQueryel.on('onSlideClick.lg.tm', function() {
                var jQueryel = _this.core.jQueryslide.eq(_this.core.index);
                _this.loadVideoOnclick(jQueryel);
            });
        } else {

            // For IE 9 and bellow
            _this.core.jQueryslide.on('click.lg', function() {
                _this.loadVideoOnclick(jQuery(this));
            });
        }

        _this.core.jQueryel.on('onBeforeSlide.lg.tm', onBeforeSlide.bind(this));

        _this.core.jQueryel.on('onAfterSlide.lg.tm', function(event, prevIndex) {
            _this.core.jQueryslide.eq(prevIndex).removeClass('lg-video-playing');
        });

        if (_this.core.s.autoplayFirstVideo) {
            _this.core.jQueryel.on('onAferAppendSlide.lg.tm', function (e, index) {
                if (!_this.core.lGalleryOn) {
                    var jQueryel = _this.core.jQueryslide.eq(index);
                    setTimeout(function () {
                        _this.loadVideoOnclick(jQueryel);
                    }, 100);
                }
            });
        }
    };

    Video.prototype.loadVideo = function(src, addClass, noPoster, index, html) {
        var video = '';
        var autoplay = 1;
        var a = '';
        var isVideo = this.core.isVideo(src, index) || {};

        // Enable autoplay based on setting for first video if poster doesn't exist
        if (noPoster) {
            if (this.videoLoaded) {
                autoplay = 0;
            } else {
                autoplay = this.core.s.autoplayFirstVideo ? 1 : 0;
            }
        }

        if (isVideo.youtube) {

            a = '?wmode=opaque&autoplay=' + autoplay + '&enablejsapi=1';
            if (this.core.s.youtubePlayerParams) {
                a = a + '&' + jQuery.param(this.core.s.youtubePlayerParams);
            }

            video = '<iframe class="lg-video-object lg-youtube ' + addClass + '" width="560" height="315" src="//www.youtube.com/embed/' + isVideo.youtube[1] + a + '" frameborder="0" allowfullscreen></iframe>';

        } else if (isVideo.vimeo) {

            a = '?autoplay=' + autoplay + '&api=1';
            if (this.core.s.vimeoPlayerParams) {
                a = a + '&' + jQuery.param(this.core.s.vimeoPlayerParams);
            }

            video = '<iframe class="lg-video-object lg-vimeo ' + addClass + '" width="560" height="315"  src="//player.vimeo.com/video/' + isVideo.vimeo[1] + a + '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

        } else if (isVideo.dailymotion) {

            a = '?wmode=opaque&autoplay=' + autoplay + '&api=postMessage';
            if (this.core.s.dailymotionPlayerParams) {
                a = a + '&' + jQuery.param(this.core.s.dailymotionPlayerParams);
            }

            video = '<iframe class="lg-video-object lg-dailymotion ' + addClass + '" width="560" height="315" src="//www.dailymotion.com/embed/video/' + isVideo.dailymotion[1] + a + '" frameborder="0" allowfullscreen></iframe>';

        } else if (isVideo.html5) {
            var fL = html.substring(0, 1);
            if (fL === '.' || fL === '#') {
                html = jQuery(html).html();
            }

            video = html;

        } else if (isVideo.vk) {

            a = '&autoplay=' + autoplay;
            if (this.core.s.vkPlayerParams) {
                a = a + '&' + jQuery.param(this.core.s.vkPlayerParams);
            }

            video = '<iframe class="lg-video-object lg-vk ' + addClass + '" width="560" height="315" src="//vk.com/video_ext.php?' + isVideo.vk[1] + a + '" frameborder="0" allowfullscreen></iframe>';

        }

        return video;
    };

    Video.prototype.loadVideoOnclick = function(jQueryel){

        var _this = this;
        // check slide has poster
        if (jQueryel.find('.lg-object').hasClass('lg-has-poster') && jQueryel.find('.lg-object').is(':visible')) {

            // check already video element present
            if (!jQueryel.hasClass('lg-has-video')) {

                jQueryel.addClass('lg-video-playing lg-has-video');

                var _src;
                var _html;
                var _loadVideo = function(_src, _html) {

                    jQueryel.find('.lg-video').append(_this.loadVideo(_src, '', false, _this.core.index, _html));

                    if (_html) {
                        if (_this.core.s.videojs) {
                            try {
                                videojs(_this.core.jQueryslide.eq(_this.core.index).find('.lg-html5').get(0), _this.core.s.videojsOptions, function() {
                                    this.play();
                                });
                            } catch (e) {
                                console.error('Make sure you have included videojs');
                            }
                        } else {
                            _this.core.jQueryslide.eq(_this.core.index).find('.lg-html5').get(0).play();
                        }
                    }

                };

                if (_this.core.s.dynamic) {

                    _src = _this.core.s.dynamicEl[_this.core.index].src;
                    _html = _this.core.s.dynamicEl[_this.core.index].html;

                    _loadVideo(_src, _html);

                } else {

                    _src = _this.core.jQueryitems.eq(_this.core.index).attr('href') || _this.core.jQueryitems.eq(_this.core.index).attr('data-src');
                    _html = _this.core.jQueryitems.eq(_this.core.index).attr('data-html');

                    _loadVideo(_src, _html);

                }

                var jQuerytempImg = jQueryel.find('.lg-object');
                jQueryel.find('.lg-video').append(jQuerytempImg);

                // @todo loading icon for html5 videos also
                // for showing the loading indicator while loading video
                if (!jQueryel.find('.lg-video-object').hasClass('lg-html5')) {
                    jQueryel.removeClass('lg-complete');
                    jQueryel.find('.lg-video-object').on('load.lg error.lg', function() {
                        jQueryel.addClass('lg-complete');
                    });
                }

            } else {

                var youtubePlayer = jQueryel.find('.lg-youtube').get(0);
                var vimeoPlayer = jQueryel.find('.lg-vimeo').get(0);
                var dailymotionPlayer = jQueryel.find('.lg-dailymotion').get(0);
                var html5Player = jQueryel.find('.lg-html5').get(0);
                if (youtubePlayer) {
                    youtubePlayer.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
                } else if (vimeoPlayer) {
                    try {
                        jQueryf(vimeoPlayer).api('play');
                    } catch (e) {
                        console.error('Make sure you have included froogaloop2 js');
                    }
                } else if (dailymotionPlayer) {
                    dailymotionPlayer.contentWindow.postMessage('play', '*');

                } else if (html5Player) {
                    if (_this.core.s.videojs) {
                        try {
                            videojs(html5Player).play();
                        } catch (e) {
                            console.error('Make sure you have included videojs');
                        }
                    } else {
                        html5Player.play();
                    }
                }

                jQueryel.addClass('lg-video-playing');

            }
        }
    };

    Video.prototype.destroy = function() {
        this.videoLoaded = false;
    };

    function onHasVideo(event, index, src, html) {
        /*jshint validthis:true */
        var _this = this;
        _this.core.jQueryslide.eq(index).find('.lg-video').append(_this.loadVideo(src, 'lg-object', true, index, html));
        if (html) {
            if (_this.core.s.videojs) {
                try {
                    videojs(_this.core.jQueryslide.eq(index).find('.lg-html5').get(0), _this.core.s.videojsOptions, function() {
                        if (!_this.videoLoaded && _this.core.s.autoplayFirstVideo) {
                            this.play();
                        }
                    });
                } catch (e) {
                    console.error('Make sure you have included videojs');
                }
            } else {
                if(!_this.videoLoaded && _this.core.s.autoplayFirstVideo) {
                    _this.core.jQueryslide.eq(index).find('.lg-html5').get(0).play();
                }
            }
        }
    }

    function onAferAppendSlide(event, index) {
        /*jshint validthis:true */
        var jQueryvideoCont = this.core.jQueryslide.eq(index).find('.lg-video-cont');
        if (!jQueryvideoCont.hasClass('lg-has-iframe')) {
            jQueryvideoCont.css('max-width', this.core.s.videoMaxWidth);
            this.videoLoaded = true;
        }
    }

    function onBeforeSlide(event, prevIndex, index) {
        /*jshint validthis:true */
        var _this = this;

        var jQueryvideoSlide = _this.core.jQueryslide.eq(prevIndex);
        var youtubePlayer = jQueryvideoSlide.find('.lg-youtube').get(0);
        var vimeoPlayer = jQueryvideoSlide.find('.lg-vimeo').get(0);
        var dailymotionPlayer = jQueryvideoSlide.find('.lg-dailymotion').get(0);
        var vkPlayer = jQueryvideoSlide.find('.lg-vk').get(0);
        var html5Player = jQueryvideoSlide.find('.lg-html5').get(0);
        if (youtubePlayer) {
            youtubePlayer.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
        } else if (vimeoPlayer) {
            try {
                jQueryf(vimeoPlayer).api('pause');
            } catch (e) {
                console.error('Make sure you have included froogaloop2 js');
            }
        } else if (dailymotionPlayer) {
            dailymotionPlayer.contentWindow.postMessage('pause', '*');

        } else if (html5Player) {
            if (_this.core.s.videojs) {
                try {
                    videojs(html5Player).pause();
                } catch (e) {
                    console.error('Make sure you have included videojs');
                }
            } else {
                html5Player.pause();
            }
        } if (vkPlayer) {
            jQuery(vkPlayer).attr('src', jQuery(vkPlayer).attr('src').replace('&autoplay', '&noplay'));
        }

        var _src;
        if (_this.core.s.dynamic) {
            _src = _this.core.s.dynamicEl[index].src;
        } else {
            _src = _this.core.jQueryitems.eq(index).attr('href') || _this.core.jQueryitems.eq(index).attr('data-src');

        }

        var _isVideo = _this.core.isVideo(_src, index) || {};
        if (_isVideo.youtube || _isVideo.vimeo || _isVideo.dailymotion || _isVideo.vk) {
            _this.core.jQueryouter.addClass('lg-hide-download');
        }

    }

    jQuery.fn.lightGallery.modules.video = Video;

})();