var $ = jQuery.noConflict();

Psicotango = {
    indexMapInit: function(){
        jQuery(window).load(function(){

            // Google Map
            jQuery('#headquarters-map').gMap({
                address: 'Balvanera, Buenos Aires',
                maptype: 'ROADMAP',
                zoom: 13,
                markers: [
                    {
                        address: "Balvanera, Buenos Aires",
                        html: "Balvanera, Buenos Aires",
                        icon: {
                            image: "images/map-icon-red.png",
                            iconsize: [32, 36],
                            iconanchor: [14,44]
                        }
                    }
                ],
                doubleclickzoom: false,
                controls: {
                    panControl: false,
                    zoomControl: false,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: false,
                    overviewMapControl: false
                },
                styles: [
                    {"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#ff0000"}]},
                    {"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},
                    {"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},
                    {"featureType":"road","elementType":"all","stylers":[{"color":"#F0AD4E"},{"lightness":60}]},
                    {"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},
                    {"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
                    {"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},
                    {"featureType":"water","elementType":"all","stylers":[{"color":"#2C3E50"},{"visibility":"on"}]}]
            });

        });
    },
    indexBooksInit: function(){
        jQuery(document).ready( function(){

            if( !jQuery('body').hasClass('device-touch') ) {

                var lFollowX = 0,
                    lFollowY = 0,
                    x = 0,
                    y = 0,
                    friction = 1 / 30;

                function moveBackground() {
                    x += (lFollowX - x) * friction;
                    y += (lFollowY - y) * friction;

                    translate = 'translate(' + x + 'px, ' + y + 'px) scale(1.1)';

                    jQuery('.move-bg').css({
                        '-webit-transform': translate,
                        '-moz-transform': translate,
                        'transform': translate
                    });

                    window.requestAnimationFrame(moveBackground);
                }

                jQuery(window).on('mousemove click', function(e) {

                    var lMouseX = Math.max(-100, Math.min(100, jQuery(window).width() / 2 - e.clientX));
                    var lMouseY = Math.max(-100, Math.min(100, jQuery(window).height() / 2 - e.clientY));
                    lFollowX = (10 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
                    lFollowY = (10 * lMouseY) / 100;

                });

                moveBackground();

                jQuery(".book-wrap").hover3d({
                    selector: ".book-card",
                    shine: false,
                });
            }

        });
    },
    viewLessonInit: function(){
        var lessonId = $("#player").data('lesson_id');
        $.ajax
        ({
            type: "GET",
            url: "/api/lesson/view/"+ lessonId,
            dataType: 'json',
            headers: {
                "Authorization": "Bearer " + this.api_token
            },
            success: function (data){
                $("#lesson-title").html(data.name);

                if ( data.privious_lesson != 0 ){
                    $("#previous").attr("href", $("#previous").attr("href") + data.privious_lesson);
                } else {
                    $("#previous").remove();
                }

                if ( data.next_lesson != 0 ){
                    $("#next").attr("href", $("#next").attr("href") + data.next_lesson);
                } else {
                    $("#next").remove();
                }

                
                jQuery(function(){
                    var options = {
                        videoURL: data.youtube_id,
                        containment:'#player',
                        mobileFallbackImage: data.youtube_image,
                        playOnlyIfVisible  : false,
                        ratio:'16/9',
                        autoPlay:true,
                        optimizeDisplay: true,
                        remember_last_time: true,
                        showYTLogo: false,
                        stopMovieOnBlur: true,
                        anchor: 'center, center'
                    };
                    jQuery("#player").YTPlayer(options);
                });
            }
        });

    },

    indexInit: function(){
        $('.grid-container').isotope({filter: '.3'});
    }
};

window.psicotango = Psicotango;