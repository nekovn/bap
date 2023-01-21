<template>
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-tight">
                <form @submit.prevent="submit" accept-charset="UTF-8" name="admin_login"
                      id="form-login-page" class="" role="form">
                    <AlertMessages :errors="errors" className="mt-3"/>
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">{{ $t('global.login') }}</h2>
                        <div class="mb-3">
                            <label for="login-code" class="form-label">{{ $t('global.code') }}</label>
                            <input class="form-control" id="login-code" :placeholder="$t('global.code_placeholder')"
                                   name="code" type="text" v-model="loginForm.code" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                {{ $t('global.password') }}
                                <span class="form-label-description">
                                    <a href="/">{{ $t('global.cannot_login') }}</a>
                                </span>
                            </label>
                            <div class="input-group input-group-flat">
                                <input class="form-control" id="login-password"
                                       :placeholder="$t('global.password_placeholder')" autocomplete="off"
                                       name="password" type="password" v-model="loginForm.password">
                                <label @click="toggleEye">
                                    <span class="input-group-text px-2 nav-link" id="eye-on">
                                        <font-awesome-icon icon="eye" class="icon"/>
                                    </span>
                                    <span class="input-group-text px-2 nav-link d-none" id="eye-off">
                                        <font-awesome-icon icon="eye-slash" class="icon"/>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-check" for="login-remember">
                                <input class="form-check-input" id="login-remember" name="remember" type="checkbox"
                                       v-model="loginForm.remember" v-bind:disabled="isDisabled">
                                <span class="form-check-label">{{ $t('global.login_remember') }}</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <input class="btn btn-primary w-100" type="submit" :value="$t('global.login')"
                                   v-bind:disabled="isDisabled">
                        </div>
                    </div>
                </form>
                <div class="text-center text-muted mt-3">{{ $t('global.login_description') }}</div>
            </div>
        </div>
    </div>
</template>
<script>
import {useForm} from "@inertiajs/inertia-vue3";
import AlertMessages from "../../Layouts/Alert/AlertMessages";
import {Inertia} from '@inertiajs/inertia'
import {ref} from "vue";

export default {
    name: "LoginForm",
    components: {AlertMessages},
    props: {
        errors: {type: Object, default: null}
    },
    setup() {
        //フォーム項目
        const loginForm = useForm({
            code: '',
            password: '',
            remember: false
        });
        //クリック連続禁止
        const isDisabled = ref(false)
        //パスワード表示目
        const toggleEye = () => {
            const eyeOn = document.getElementById('eye-on');
            const eyeOff = document.getElementById('eye-off');
            const login_password = document.getElementById('login-password');
            if (eyeOn.classList.contains('d-none')) {
                login_password.type = 'password';
            } else {
                login_password.type = 'text';
            }
            eyeOn.classList.toggle('d-none');
            eyeOff.classList.toggle('d-none');
        }
        //Eventを開始
        Inertia.on('start', (event) => {
            isDisabled.value = true;
        });
        //Eventを終了
        Inertia.on('finish', (event) => {
            isDisabled.value = false;
        })
        //フォームを通信
        const submit = () => {
            //submitフォーム
            loginForm.post(route('admin.login'))
        }

        return {loginForm, toggleEye, submit, isDisabled}
    },

}
</script>

<style>
</style>
