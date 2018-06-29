<template>
    <div class="courses-list">
        <!--Portfolio Filter ============================================= -->
        <ul class="portfolio-filter isotope clearfix" id="portfolio-filter" data-filter=".3" data-container="#portfolio">
            <li v-for="(course, key) in courses" :class="{ activeFilter: key == 0 }">
                <a href="#" :data-filter="'.'+course.id">sss</a>
            </li>
        </ul>

        <div class="clear"></div>

        <div id="portfolio" class="portfolio grid-container portfolio-2 clearfix">
            <lesson-box v-for="lesson in lessons" :lesson="lesson" :key="lesson.id"></lesson-box>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['identifier'],

        data(){
            return { courses: [], lessons: [] }
        },

        mounted() {
            var _lessons = [];
            axios.get('/api/my-courses').then(response => {
                //this is data.
                this.courses = response.data.data;
                this.courses.map(function(course){
                    course.lessons.map(function(lesson){
                        _lessons.push(lesson);
                    });
                });
                this.lessons = _lessons;
                setTimeout(() => {
                    $(function() {
                        jQuery('.grid-container').isotope('destroy').isotope({itemSelector: '.portfolio-item', filter: '.3'}).isotope( 'layout' );
                        SEMICOLON.portfolio.gridInit(jQuery('.grid-container'));
                        SEMICOLON.portfolio.filterInit();
                    });
                }, 0);


            }, response => {});
        }
    }
</script>
