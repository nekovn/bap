<template>
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-tight">
                <form @submit.prevent="submit" accept-charset="UTF-8" name="admin_login"
                      id="form-login-page" class="" role="form">
                    <AlertMessages :errors="errors" :success="success"/>
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">{{ $t('global.two_factor') }}</h2>
                        <div class="mb-3">
                            <label for="two-factor-code" class="form-label">{{ $t('global.two_factor_label') }}</label>
                            <input class="form-control" id="two-factor-code"
                                   :placeholder="$t('global.two_factor_placeholder')"
                                   name="two_factor_code" type="number" v-model="loginForm.two_factor_code" autocomplete="off">
                        </div>
                        <div class="form-footer">
                            <input class="btn btn-primary w-100" type="submit" :value="$t('global.send')"
                                   v-bind:disabled="isDisabled">
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted mt-3">
                    <Link :href="route('admin.verify.resend')" class="text-center text-muted mt-3" preserve-scroll>{{ $t('global.two_factor_send_again') }}</Link>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import AlertMessages from "../../Layouts/Alert/AlertMessages";
import {useForm} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";
import {ref} from "vue";
import { Link } from '@inertiajs/inertia-vue3'

export default {
    name: "TwoFactorForm",
    components: {AlertMessages, Link    },
    props: {
        errors: {type: Object, default: null},
        success: {type: Object, default: null}
    },
    setup() {
        const loginForm = useForm({
            two_factor_code: '',
        });
        //クリック連続禁止
        const isDisabled = ref(false)
        const submit = () => {
            //submitフォーム
            loginForm.post(route('admin.verify.store'))
        }
        //Eventを開始
        Inertia.on('start', (event) => {
            isDisabled.value = true;
        });
        //Eventを終了
        Inertia.on('finish', (event) => {
            isDisabled.value = false;
        })
        return {loginForm, submit, isDisabled}
    },
}
</script>

<style>

</style>
