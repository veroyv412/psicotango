<template>
    <section id="section-prices" class="page-section topmargin-lg">
        <div class="pricing bottommargin clearfix">
            <div class="col-sm-4">

                <div class="pricing-box">
                    <div class="pricing-title">
                        <h3 v-html="$t('messages.module_one')"></h3>
                    </div>
                    <div class="pricing-price">
                        <span class="price-unit">u$d</span>50
                    </div>
                    <div class="pricing-features">
                        <ul>
                            <li>4 Videos de 4 Cursos Introductorios</li>
                        </ul>
                    </div>
                    <div class="pricing-action">
                        <a href="/checkout/plan/1" class="btn btn-danger btn-block btn-sm" v-html="$t('messages.get_course')"></a>
                    </div>
                </div>

            </div>

            <div class="col-sm-4">

                <div class="pricing-box best-price">
                    <div class="pricing-title">
                        <h3 v-html="$t('messages.module_two')"></h3>
                        <span>Mas popular</span>
                    </div>
                    <div class="pricing-price">
                        <span class="price-unit">u$d</span>80
                    </div>
                    <div class="pricing-features">
                        <ul>
                            <li>4 Videos de 4 Cursos Introductorios</li>
                            <li>+ 4 Videos de 4 Cursos Nivel Avanzado</li>
                            <li><i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i>
                                <i class="icon-star3"></i></li>
                        </ul>
                    </div>
                    <div class="pricing-action">
                        <a href="/checkout/plan/2" class="btn btn-danger btn-block btn-sm bgcolor border-color" v-html="$t('messages.get_course')"></a>
                    </div>
                </div>

            </div>

            <div class="col-sm-4">

                <div class="pricing-box">
                    <div class="pricing-title">
                        <h3 v-html="$t('messages.seminary')"></h3>
                    </div>
                    <div class="pricing-price">
                        <span class="price-unit">u$d</span>100
                    </div>
                    <div class="pricing-features">
                        <ul>
                            <li>4 Videos de 4 Cursos Introductorios</li>
                            <li>+ 4 Videos de 4 Cursos Nivel Avanzado</li>
                            <li>+ 2 videos de un Seminario de Psicotango</li>
                        </ul>
                    </div>
                    <div class="pricing-action">
                        <a href="/checkout/plan/3" class="btn btn-danger btn-block btn-sm" v-html="$t('messages.get_course')"></a>
                    </div>
                </div>

            </div>
        </div>

    </section>
</template>

<script>


</script>