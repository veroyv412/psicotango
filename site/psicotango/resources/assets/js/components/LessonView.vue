<template>
    <div class="view-lesson">
        <div class="fancy-title title-bottom-border">
            <h1 id="lesson-title">{{lesson.name}}</h1>
        </div>

        <div id="player" class="player"  style="height: 450px; width: 100%;">Loading...</div>

        <div class="row topmargin">
            <div class="col-xs-6 text-left"><a :href="'lesson/'+ lesson.privious_lesson" id="previous" v-if="lesson.privious_lesson != 0"><< Previous</a></div>
            <div class="col-xs-6 text-right"><a :href="'lesson/'+ lesson.next_lesson" id="next" v-if="lesson.next_lesson != 0">Next >></a></div>
        </div>
    </div>
</template>


<script>
    export default {
        props: ['lesson_id'],

        data(){
            return { lesson: [] }
        },
        mounted() {
            var _lessons = [];
            axios.get('/api/lesson/'+this.lesson_id).then(response => {
                //this is data.
                this.lesson = response.data.data;
                setTimeout(() => {
                    $(function() {
                        jQuery(function(){
                            var first = true;
                            var options = {
                                videoURL: 'pBSV2tOqzZ4',
                                containment:'#player',
                                mobileFallbackImage: response.data.data.youtube_image,
                                playOnlyIfVisible  : false,
                                ratio:'16/9',
                                autoPlay:true,
                                optimizeDisplay: true,
                                remember_last_time: true,
                                showYTLogo: false,
                                stopMovieOnBlur: true,
                                anchor: 'center, center',
                                onReady: function( player ) {
                                    if (first){
                                        jQuery('#player').YTPChangeMovie({videoURL: response.data.data.youtube_id, ratio:'16/9'});
                                        first = false;
                                    }
                                }
                            };
                            jQuery("#player").YTPlayer(options);
                        });
                    });
                }, 0);
            }, response => {});
        }
    }
</script>
