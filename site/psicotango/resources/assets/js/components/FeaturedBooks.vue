<template>
    <!--Needs to be taken from database or JSON file-->
    <div id="p-carousel" class="widget clearfix">

        <h4 class="highlight-me" v-html="$t('messages.published_books')"></h4>
        <div id="oc-portfolio-sidebar" class="owl-carousel carousel-widget" data-items="1" data-margin="10" data-loop="true" data-nav="false" data-autoplay="5000">

            <div class="oc-item">
                <div class="iportfolio">
                    <div class="portfolio-image">
                        <a href="#">
                            <img src="/images/libroTangoDanzaTerapia.png" alt="Tango Terapia">
                        </a>
                        <div class="portfolio-overlay">
                            <a href="/images/libroTangoDanzaTerapia.png" class="center-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="oc-item">
                <div class="iportfolio">
                    <div class="portfolio-image">
                        <a href="#">
                            <img src="/images/libroTangoDanzaInterior.png" alt="Tango Terapia">
                        </a>
                        <div class="portfolio-overlay">
                            <a href="/images/libroTangoDanzaInterior.png" class="center-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="oc-item">
                <div class="iportfolio">
                    <div class="portfolio-image">
                        <a href="#">
                            <img src="/images/libroTangoUnAbrazoSanador1.png" alt="Tango Terapia">
                        </a>
                        <div class="portfolio-overlay">
                            <a href="/images/libroTangoUnAbrazoSanador1.png" class="center-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
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
