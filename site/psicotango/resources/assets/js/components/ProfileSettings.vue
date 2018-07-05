<template>
    <form method="POST" id="profileSettingsForm" action="/profile" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" class="nobottommargin">
        <div class="line line-sm"></div>

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
            <input type="email" name="email" class="form-control sm-form-control" v-model="form.email">
            <span class="help-block" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
        </div>

        <button type="submit" class="button button-rounded button-blue btn-block" :disabled="form.errors.any()">
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
                    email: '',
                }),
                save: this.$t('messages.save')}
        },
        mounted() {
            axios.get('/api/user').then(response => {
                this.form.name = response.data.data.name;
                this.form.last_name = response.data.data.last_name;
                this.form.email = response.data.data.email;
            });
        },
        methods: {
            onSubmit(){
                this.save = this.$t('messages.saving');
                this.form.setFormElement(document.getElementById('profileSettingsForm'));
                this.form.post('/profile')
                        .then( response => { window.location.href = "/profile" })
                        .catch( error => { this.save = this.$t('messages.save'); } );
            }
        },
    }
</script>
