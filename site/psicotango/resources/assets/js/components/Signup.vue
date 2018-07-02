<template>
    <form method="POST" action="/signup" @submit.prevent="onSubmit" class="nobottommargin dark-box">
        <div class="line line-sm"></div>

        <div class="form-group">
            <label v-html="$t('messages.email')"></label>
            <input type="text" name="email" class="form-control sm-form-control" v-model="email">
            <span class="help-block"></span>
        </div>

        <div class="form-group">
            <label v-html="$t('messages.password')"></label>
            <input type="password" name="password" class="form-control sm-form-control" v-model="password">
            <span class="help-block"></span>
        </div>

        <div class="form-group">
            <label>
                <a href="/password/reset" v-html="$t('forgot_password_text.password')"></a>
            </label>
        </div>

        <div class="form-group">
            <label>
                {{ $t('messages.need_account') }} <small><a href="/signup">{{ $t('messages.signup') }}</a></small>
            </label>
        </div>

        <button type="submit" class="button button-rounded button-green btn-block">
            {{ $t('messages.login') }}
        </button>

    </form>
</template>

<script>
    export default {
        data(){
            return { email: '', password: '', errors: {} }
        },
        mounted() {

        },
        methods: {
            onSubmit(){
                axios.post('/signup', this.$data).then(response => { console.log(response) });
            }
        },
    }
</script>
