<template>
    <form method="POST" id="signupForm" action="/signup" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" class="nobottommargin dark-box">

        <div class="form-group" :class="{ 'has-error': form.errors.has('name') }">
            <label v-html="$t('messages.name')"></label>
            <input type="text" name="name" class="form-control sm-form-control" v-model="form.name">
            <span class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
        </div>

        <div class="form-group" :class="{ 'has-error': form.errors.has('last_name') }">
            <label v-html="$t('messages.lastname')"></label>
            <input type="text" name="last_name" class="form-control sm-form-control" v-model="form.last_name">
            <span class="help-block" v-if="form.errors.has('last_name')" v-text="form.errors.get('last_name')"></span>
        </div>

        <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
            <label v-html="$t('messages.email')"></label>
            <input type="text" name="email" class="form-control sm-form-control" v-model="form.email">
            <span class="help-block" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
        </div>

        <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
            <label v-html="$t('messages.password')"></label>
            <input type="password" name="password" class="form-control sm-form-control" v-model="form.password">
            <span class="help-block" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
        </div>

        <div class="form-group" :class="{ 'has-error': form.errors.has('password_confirmation') }">
            <label v-html="$t('messages.repeat_password')"></label>
            <input type="password" name="password_confirmation" class="form-control sm-form-control" v-model="form.password_confirmation">
            <span class="help-block" v-if="form.errors.has('password_confirmation')" v-text="form.errors.get('password_confirmation')"></span>
        </div>

        <div class="form-group">
            <label v-html="$t('messages.signup_terms')"></label>
        </div>

        <button type="submit" class="button button-rounded button-green btn-block" :disabled="form.errors.any()">
            {{ save }}
        </button>
    </form>
</template>

<script>
    export default {
        data(){
            return {
                form: new Form({
                    name: '',
                    last_name: '',
                    password: '',
                    password_confirmation: '',
                    email: '',
                }),
                save: this.$t('messages.save')}
        },
        mounted() {},
        methods: {
            onSubmit(){
                this.save = this.$t('messages.saving');
                this.form.setFormElement(document.getElementById('signupForm'));
                this.form.post('/signup')
                        .then( response => { window.location.href = "/" })
                        .catch( error => { this.save = this.$t('messages.save'); } );
            }
        },
    }
</script>
