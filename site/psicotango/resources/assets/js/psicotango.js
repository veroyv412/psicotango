var $ = jQuery.noConflict();

Psicotango = {
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