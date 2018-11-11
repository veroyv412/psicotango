<template>
    <div class="view-lesson" v-if="lesson.youtube_id != ''">
        <div class="fancy-title title-bottom-border">
            <h1 id="lesson-title">{{lesson.name}}</h1>
        </div>

        <div class="fluid-width-video-wrapper">
            <div id="player" class="player"  style="height: 450px; width: 100%;">Loading...</div>
        </div>

        <div class="row topmargin">
            <div class="col-xs-6 text-left"><a :href="'/lesson/'+ lesson.privious_lesson" id="previous" v-if="lesson.privious_lesson != 0" class="button button-3d button-rounded button-black"><< Previous</a></div>
            <div class="col-xs-6 text-right"><a :href="'/lesson/'+ lesson.next_lesson" id="next" v-if="lesson.next_lesson != 0" class="button button-3d button-rounded button-black">Next >></a></div>
        </div>
    </div>
    <div class="view-lesson" v-else-if="lesson.youtube_id == ''">
        <div class="fancy-title title-bottom-border">
            <h1 id="lesson-title">{{lesson.name}}</h1>
        </div>

        <img :src="lesson.youtube_image" :alt="lesson.name">

        <div class="row topmargin">
            <div class="col-xs-12 text-right"><a href="javascript:window.print();" class="button button-3d button-rounded button-black"><i class="icon-print"></i>Print</a></div>
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
                                showControls: true,
                                realfullscreen: true,
                                mute:false,
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
                                        jQuery('#player').YTPChangeMovie({videoURL: response.data.data.youtube_id});
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
