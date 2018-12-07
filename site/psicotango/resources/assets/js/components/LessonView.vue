<template>
    <div class="view-lesson" v-if="lesson.youtube_id != ''">
        <div class="fancy-title title-bottom-border">
            <h1 id="lesson-title">{{lesson.name}}</h1>
            <br><span>Duración {{duration}}</span>
        </div>

        <div class="fluid-width-video-wrapper clearfix">
            <div style="height: 450px; width: 100%;" class="player" id="playerContainer">
                <div id="player2">Loading...</div>
            </div>
        </div>

        <br>
        <div class="clearfix topmargin">
            <div class="row">
                <div class="col-xs-4 text-left"><a :href="'/lesson/'+ lesson.privious_lesson" id="previous" v-if="lesson.privious_lesson != 0" class="button button-3d button-rounded button-black"><< Anterior</a></div>
                <div class="col-xs-8 text-right">
                    <a :href="'/lesson/'+ lesson.next_lesson" id="next" v-if="lesson.next_lesson != 0" class="button button-3d button-rounded button-black">Siguiente >></a>
                </div>
            </div>
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
    const YTPlayer = require('yt-player');

    export default {
        props: ['lesson_id'],

        data(){
            return { lesson: [], duration: '00:00' }
        },
        mounted() {
            const player = new YTPlayer('#player2', {
                'autoplay': true,
                'related': false,
                'info': false,
                'controls': true,
                'height': '450px',
                'width': '100%',
                'modestBranding': true
            });

            var _lessons = [];
            var _this = this;
            axios.get('/api/lesson/'+this.lesson_id).then(response => {
                //this is data.
                this.lesson = response.data.data;
                player.load(response.data.data.youtube_id, true);

                player.on('playing', () => {
                    const time = player.getDuration();
                    const minutes = Math.floor(time / 60);
                    const seconds = Math.floor(time - minutes * 60);

                    _this.duration = minutes + ':' + seconds;

                    //console.log($(".ytp-share-button"));
                })

                player.on('error', (err) => {
                    console.log(err);
                });


            }, response => {});
        }
    }
</script>
