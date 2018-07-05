<template>
    <form method="POST" id="loginForm" action="/login" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" class="nobottommargin dark-box">
        <div class="line line-sm"></div>

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

        <div class="form-group">
            <label>
                <a href="/password/reset" v-html="$t('messages.forgot_password_text')"></a>
            </label>
        </div>

        <div class="form-group">
            <label>
                {{ $t('messages.need_account') }} <small><a href="/signup">{{ $t('messages.signup') }}</a></small>
            </label>
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
                    password: '',
                    email: '',
                }),
                save: this.$t('messages.save')}
        },
        mounted() {},
        methods: {
            onSubmit(){
                this.save = this.$t('messages.saving');
                this.form.setFormElement(document.getElementById('loginForm'));
                this.form.post('/login')
                        .then( response => { window.location.href = "/" })
                        .catch( error => { this.save = this.$t('messages.save'); } );
            }
        },
    }
</script>
