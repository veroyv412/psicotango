<template>
    <!--Needs to be taken from database or JSON file-->
    <div id="tesimonials" class="widget clearfix bottommargin">

        <h4 class="highlight-me"><span v-html="$t('messages.testimonials_title')"></span></h4>
        <div class="fslider testimonial noborder nopadding noshadow" data-animation="slide" data-arrows="false">
            <div class="flexslider">
                <div class="slider-wrap">
                    <div class="slide">
                        <div class="testi-content">
                            <p v-html="$t('messages.testimonial_1')"></p>
                            <div class="testi-meta">
                                Laura
                            </div>
                        </div>
                    </div>
                    <div class="slide">
                        <div class="testi-content">
                            <p v-html="$t('messages.testimonial_2')"></p>
                            <div class="testi-meta">
                                Paola Marabini
                            </div>
                        </div>
                    </div>
                    <div class="slide">
                        <div class="testi-content">
                            <p v-html="$t('messages.testimonial_3')"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['identifier'],

        data(){
            return { items: [] }
        },

        mounted() {

        }
    }
</script>
