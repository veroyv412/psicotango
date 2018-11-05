<template>
    <form method="POST" id="paymentForm" action="/checkout/plan" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" class="nobottommargin dark-box">
        <input type="hidden" name="plan_id" v-model="form.plan_id">
        <input type="hidden" name="payment_method" v-model="form.payment_method">
        <input type="hidden" name="card_token" v-model="form.card_token">

        <div class="col_full">
            <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                <label v-html="$t('messages.email')"></label>
                <input type="text" name="email" class="form-control sm-form-control" v-model="form.email">
                <span class="help-block" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
            </div>
        </div>

        <div class="col_half">
            <div class="form-group" :class="{ 'has-error': form.errors.has('card_number') }">
                <label v-html="$t('messages.card_number')"></label>
                <input type="tel" name="card_number" class="form-control sm-form-control" @change="guessPaymentType" @keyup="guessPaymentType" v-model="form.card_number" data-checkout="cardNumber" placeholder="4509 9535 6623 3704" >
                <span class="help-block" v-if="form.errors.has('card_number')" v-text="form.errors.get('card_number')"></span>
            </div>
        </div>

        <div class="col_half col_last">
            <div class="form-group" :class="{ 'has-error': form.errors.has('cvv') }">
                <label v-html="$t('messages.cvv')"></label>
                <vue-mask
                        class="form-control sm-form-control"
                        name="cvv"
                        v-model="form.cvv"
                        data-checkout="securityCode"
                        mask="0009">
                </vue-mask>
                <span class="help-block" v-if="form.errors.has('cvv')" v-text="form.errors.get('cvv')"></span>
            </div>
        </div>

        <div class="col_half">
            <div class="form-group" :class="{ 'has-error': form.errors.has('expiration_month') }">
                <label v-html="$t('messages.expiration_month')"></label>
                <vue-mask
                        class="form-control sm-form-control"
                        name="expiration_month"
                        v-model="form.expiration_month"
                        data-checkout="cardExpirationMonth"
                        mask="00">
                </vue-mask>
                <span class="help-block" v-if="form.errors.has('expiration_month')" v-text="form.errors.get('expiration_month')"></span>
            </div>
        </div>

        <div class="col_half col_last">
            <div class="form-group" :class="{ 'has-error': form.errors.has('expiration_year') }">
                <label v-html="$t('messages.expiration_year')"></label>
                <vue-mask
                        class="form-control sm-form-control"
                        name="expiration_year"
                        v-model="form.expiration_year"
                        data-checkout="cardExpirationYear"
                        mask="00">
                </vue-mask>
                <span class="help-block" v-if="form.errors.has('expiration_year')" v-text="form.errors.get('expiration_year')"></span>
            </div>
        </div>

        <div class="col_full">
            <div class="form-group" :class="{ 'has-error': form.errors.has('cardholder_name') }">
                <label v-html="$t('messages.cardholder_name')"></label>
                <input type="text" name="cardholder_name" class="form-control sm-form-control" v-model="form.cardholder_name" data-checkout="cardholderName">
                <span class="help-block" v-if="form.errors.has('cardholder_name')" v-text="form.errors.get('cardholder_name')"></span>
            </div>
        </div>

        <div class="col_half">
            <div class="form-group" :class="{ 'has-error': form.errors.has('doc_type') }">
                <label v-html="$t('messages.doc_type')"></label>
                <select name="doc_type" class="form-control" v-model="form.doc_type" data-checkout="docType"></select>
                <span class="help-block" v-if="form.errors.has('doc_type')" v-text="form.errors.get('doc_type')"></span>
            </div>
        </div>

        <div class="col_half col_last">
            <div class="form-group" :class="{ 'has-error': form.errors.has('doc_number') }">
                <label v-html="$t('messages.doc_number')"></label>
                <input type="text" name="doc_number" class="form-control sm-form-control" v-model="form.doc_number" data-checkout="docNumber">
                <span class="help-block" v-if="form.errors.has('doc_number')" v-text="form.errors.get('doc_number')"></span>
            </div>
        </div>

        <div class="col_full">
            <div class="style-msg2 errormsg" v-if="form.errors.errors.length">
                <div class="msgtitle" v-html="$t('messages.fix_errors')"></div>
                <div class="sb-msg">
                    <ul>
                        <li v-for="error in form.errors.errors" v-html="$t('messages.'+error.code)"></li>
                    </ul>
                </div>
            </div>
        </div>

        <button type="submit" class="button button-rounded button-green btn-block">
            {{ save }}
        </button>
    </form>

</template>

<script>
    import vueMask from 'vue-jquery-mask';

    export default {
        props: ['plan_id', 'email'],
        data(){
            return {
                form: new Form({
                    plan_id: this.plan_id,
                    email: this.email,
                    card_number: '',
                    cvv: '',
                    expiration_month: '',
                    expiration_year: '',
                    cardholder_name: '',
                    doc_type: '',
                    doc_number: '',
                    payment_method: '',
                    card_token: ''
                }),
                save: this.$t('messages.pay'),
            }
        },
        components: {
            vueMask,
        },
        mounted() {
            Mercadopago.getIdentificationTypes();
        },
        methods: {
            guessPaymentType(ev){
                let bin = ev.target.value.replace(/[ .-]/g, '').slice(0, 6);
                let _this = this;
                Mercadopago.getPaymentMethod({
                    "bin": bin
                }, function(status, response){
                    if (status == 200) {
                        _this.form.payment_method = response[0].id;
                    }
                });
            },
            onSubmit(){
                this.form.setFormElement(document.getElementById('paymentForm'));
                let _this = this;
                Mercadopago.createToken(document.getElementById('paymentForm'), function(status, response){
                    if (status == 400) {
                        _this.form.onFail(response.cause);
                    } else {
                        _this.save = _this.$t('messages.sending_information');
                        _this.form.card_token = response.id;
                        _this.form.post('/checkout/plan')
                                .then( response => { console.log(response); /*window.location.href = "/"*/ })
                                .catch( error => { _this.save = _this.$t('messages.pay'); } );
                    }
                });
            }
        },
    }
</script>
