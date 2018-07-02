<template>
    <form method="POST" action="/login" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)" class="nobottommargin">
        <div class="line line-sm"></div>

        <div class="form-group" :class="{ 'has-error': errors.has('name') }">
            <label v-html="$t('messages.name')"></label>
            <input type="text" name="name" class="form-control sm-form-control" v-model="name">
            <span class="help-block" v-if="errors.has('name')" v-text="errors.get('name')"></span>
        </div>

        <div class="form-group" :class="{ 'has-error': errors.has('last_name') }">
            <label v-html="$t('messages.lastname')"></label>
            <input type="text" name="last_name" class="form-control sm-form-control" v-model="last_name">
            <span class="help-block" v-if="errors.has('last_name')" v-text="errors.get('last_name')"></span>
        </div>

        <div class="form-group" :class="{ 'has-error': errors.has('email') }">
            <label v-html="$t('messages.email')"></label>
            <input type="email" name="email" class="form-control sm-form-control" v-model="email">
            <span class="help-block" v-if="errors.has('email')" v-text="errors.get('email')"></span>
        </div>

        <button type="submit" class="button button-rounded button-blue btn-block" :disabled="errors.any()">
            {{ save }}
        </button>

    </form>
</template>

<script>
    class Errors {
        constructor(){
            this.errors = {};
        }

        get(field){
            if ( this.errors[field] ){
                return this.errors[field][0];
            }
        }

        store(errors){
            this.errors = errors;
        }

        clear(field){
            delete this.errors[field];
        }

        has(field){
            return this.errors.hasOwnProperty(field);
        }

        any(){
            return Object.keys(this.errors).length > 0;
        }
    }

    export default {
        data(){
            return { email: '', name: '', last_name: '', errors: new Errors(), save: this.$t('messages.save')}
        },
        mounted() {
            axios.get('/api/user').then(response => {
                this.name = response.data.data.name;
                this.last_name = response.data.data.last_name;
                this.email = response.data.data.email;
            });
        },
        methods: {
            onSubmit(){
                this.save = this.$t('messages.saving');
                axios.post('/profile', this.$data)
                    .then(response => {
                        this.save = this.$t('messages.save');
                        window.location.href = "/profile";

                    })
                    .catch(error => {
                        this.save = this.$t('messages.save');
                        this.errors.store(error.response.data.errors);
                    })
            }
        },
    }
</script>
