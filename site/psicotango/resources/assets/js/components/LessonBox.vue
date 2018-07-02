<template>
    <article :class="'portfolio-item '+ lesson.course_id">
        <div class="portfolio-image">
            <a href="#">
                <img :src="lesson.youtube_image" :alt="lesson.name">
            </a>
            <div class="portfolio-overlay">
                <a :href="'lesson/' + lesson.id" class="left-icon"><i class="icon-line-play"></i></a>
                <a :href="'lesson/'+ lesson.id" class="right-icon"><i class="icon-line-ellipsis"></i></a>
            </div>
        </div>
        <div class="portfolio-desc">
            <h3><a href="#">{{ lesson.name }}</a></h3>
            <!-- <span><a href="#">Duration:</a>, <a href="#">UI Elements</a></span> -->
        </div>
    </article>
</template>

<script>
    export default {
        props: ['lesson'],

        data(){
            return {  }
        },

        mounted() {

        },
    }
</script>
