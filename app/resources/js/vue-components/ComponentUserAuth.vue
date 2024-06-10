<script>
import {useToast} from "vue-toastification";
import axios from "axios";

export default {
    name: "ComponentUserAuth",
    props: {
        user: {
            type: Object,
        },
        app_env: {
            type: String,
        }
    },
    data: function () {
        return {
            show_console: false,
            is_open: false,
            template: 'login',
            pass_input_type: 'password',
            pass_value: '',
            pass_error: '',
            phone_value: '',
            phone_error: '',
            name_value: '',
            name_error: '',
            sms_code: '',
            sms_value: '',
            sms_error: '',
            user_name: 'Личный кабинет',
        };
    },
    mounted() {
        if (this.app_env !== 'prod') {
            this.show_console = true;
        }

        if (this.show_console) {
            console.log('ComponentUserAuth');
            console.log('user', this.user);
            console.log('app_env', this.app_env);
            if (this.user) {
                console.log('this.user.name', this.user.name);
                console.log('is_access_admin_part', this.user.options.role.options.is_access_admin_part);
            }
        }

        if (this.user) {
            this.user_name = this.user.name;
        }
        window.addEventListener('click', this.navigation_close);
    },
    setup() {
        const toast = useToast();
        return {toast}
    },
    methods: {
        showToast: function () {
            this.toast.info("I'm an info toast!");
            this.toast.success("My toast success", {timeout: 2000});
            this.toast.error("My toast error");
        },
        open: function () {
            this.is_open = true;
        },
        close: function () {
            this.is_open = false;
        },
        showPass: function () {
            if (this.pass_input_type === 'password') {
                this.pass_input_type = 'text';

            } else if (this.pass_input_type === 'text') {
                this.pass_input_type = 'password';
            }
        },
        validate: function () {
            this.phone_error = this.validatePhone(this.phone_value);
        },
        validatePhone: function (phone, required = false) {
            if (required && !phone) {
                return 'Поле обязательно для заполнения';
            }
            if (!required && phone === null) {
                return '';
            }
            const regexp = /^\+7\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}$/;
            const isValid = regexp.test(phone);
            if (isValid) {
                return '';
            } else {
                return 'Некорректно заполнен телефон';
            }
        },
        validatePass: function () {
            if (this.pass_value === '') {
                return 'Поле пароль пустое';
            }
            if (this.pass_value.length < 4) {
                return 'Пароль слишком короткий';
            }
            const regexp = /^.{4,}$/;
            const isValid = regexp.test(this.pass_value);
            if (isValid) {
                return '';
            } else {
                return 'Некорректно заполнен пароль';
            }
        },
        validateName: function () {
            if (this.name_value === '') {
                return 'Поле Имя пустое';
            }
            if (this.name_value.length < 2) {
                return 'Имя слишком короткое (минимум 2 символа)';
            }
            const regexp = /^.{2,}$/;
            const isValid = regexp.test(this.name_value);
            if (isValid) {
                return '';
            } else {
                return 'Поле некорректно заполнено';
            }
        },
        input: function () {
            if (this.phone_value === '') {
                return;
            }
            const x = this.phone_value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
            if (x[1] === '7' || x[1] === '8') {
                x[1] = '+7'
            } else {
                x[2] = x[1]
                x[1] = '+7'
            }
            this.phone_value = !x[3]
                ? x[1] + '(' + x[2]
                : x[1] + '(' + x[2] + ')' + x[3]
                + (x[4]
                    ? '-' + x[4]
                    : '')
                + (x[5]
                    ? '-' + x[5]
                    : '');

            if (this.phone_value.length === 16) {
                this.validate();
            }
        },
        login: function () {
            this.phone_error = this.validatePhone(this.phone_value, true);
            this.pass_error = this.validatePass(this.pass_value, true);
            if (this.phone_error === '' && this.pass_error === '') {
                if (this.show_console) {
                    this.toast.info('Осуществляем вход пользователя');
                }
                this.user_login();
            }
        },
        template_change: function (name = '') {
            if (name === '') {
                if (this.template === 'login') {
                    this.template = 'registration';
                } else if (this.template === 'registration') {
                    this.template = 'login';
                }
            } else {
                this.template = name;
            }
        },
        registration: function () {
            if (this.show_console) {
                this.toast.error('registration');
            }
            this.phone_error = this.validatePhone(this.phone_value, true);
            this.pass_error = this.validatePass(this.pass_value);
            this.name_error = this.validateName(this.name_value);
            if (this.phone_error === '' && this.pass_error === '' && this.name_error === '') {
                if (this.show_console) {
                    this.toast.info('Регистрируем пользователя');
                }
                this.user_check();
            }
        },
        async check_code() {
            if (this.show_console) {
                this.toast.error('check_code');
            }
            const requestData = {
                phone: this.phone_value,
                password: this.pass_value,
                name: this.name_value,
                code: this.sms_value,
            }

            const response = await axios.post('/user/check-code', requestData);

            if (response) {
                if (this.show_console) {
                    console.log(response);
                }
                if ('result' in response.data) {
                    if (response.data['result']) {
                        /** Регистрация и авторизация прошла успешно - перезагружаем страницу для обновления данных пользователя */
                        if ('redirect' in response.data) {
                            window.location.href = response.data['redirect'];
                        }
                    }
                }
            }

        },
        async user_check() {
            const requestData = {
                phone: this.phone_value,
                password: this.pass_value,
                name: this.name_value,
            }
            const response = await axios.post('/user/check', requestData);

            if (response) {
                if (this.show_console) {
                    console.log(response);
                }
                if ('result' in response.data) {
                    if (response.data['result']) {
                        /** Показываем окно ввода проверочного кода */
                        this.template_change('code');
                    } else {
                        /** Выводим сообщение из ответа */
                    }
                }
                if ('phone_error' in response.data) {
                    this.phone_error = response.data['phone_error'];
                }
            }
        },
        async user_login() {
            const requestData = {
                phone: this.phone_value,
                password: this.pass_value,
            }
            const response = await axios.post('/user/login', requestData);

            if (response) {
                if (this.show_console) {
                    console.log(response);
                }
                if ('result' in response.data) {
                    if (response.data['result']) {
                        /** Авторизация прошла успешно - перезагружаем страницу для обновления данных пользователя */
                        if ('redirect' in response.data) {
                            window.location.href = response.data['redirect'];
                        }
                    } else {
                        if ('phone_error' in response.data) {
                            this.phone_error = response.data['phone_error'];
                        }
                        if ('pass_error' in response.data) {
                            this.pass_error = response.data['pass_error'];
                        }
                    }
                }
            }
        },
        async user_logout() {
            if (this.show_console) {
                this.toast.info('Осуществляем выход пользователя');
            }

            const response = await axios.get('/user/logout');

            if (response) {
                if (this.show_console) {
                    console.log(response);
                }
                if ('result' in response.data) {
                    if (response.data['result']) {
                        /** Перезагружаем страницу для обновления данных пользователя */
                        if ('redirect' in response.data) {
                            window.location.href = response.data['redirect'];
                        }
                    }
                }
            }
        },
        navigation_toggle() {
            const menu = this.$refs.menu;
            if (menu) {
                menu.classList.toggle('active');
            }
        },
        navigation_close() {
            const menu = this.$refs.menu;
            if (menu) {
                if (menu.classList.contains('active')) {
                    menu.classList.remove('active');
                }
            }
        },
        redirect(event) {
            const element = event.target;
            if (element) {
                const url = element.getAttribute('data-redirect-url');
                if (url) {
                    window.location.href = url;
                }
            }
        },
    },
}
</script>

<template>
    <template v-if="!this.user">
        <div class="header-user transition" @click="open()">
            <div class="user-icon">
                <img
                    src="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/white/user-regular.svg"
                    alt="user-regular.svg">
            </div>
            <div class="user-text">
                {{ this.user_name }}
            </div>
        </div>
    </template>
    <template v-else>
        <div class="header-user" @click.stop="navigation_toggle()" ref="menu">
            <div class="user-icon">
                <img
                    src="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/white/user-regular.svg"
                    alt="user-regular.svg">
            </div>
            <div class="user-text">
                {{ this.user_name }}
            </div>
            <div class="user-navigation">
                <div class="content">
                    <div v-if="this.user.options.role.options.is_access_admin_part" @click="redirect($event)"
                         data-redirect-url="/admin-panel">Панель администратора
                    </div>
                    <div @click="redirect($event)" data-redirect-url="https://lk.inspectrum.ru/site/login">Перейти в
                        ЛК
                    </div>
                    <div @click="user_logout()">Выйти</div>
                </div>
            </div>
        </div>
    </template>

    <Transition name="fade">
        <div v-if="this.is_open" class="popup">
            <div v-if="this.template === 'login'" class="form-login">
                <div class="block-input">
                    <label for="input-tel">Номер телефона</label>
                    <div class="input">
                        <input name="input-tel"
                               v-model="this.phone_value"
                               type="text"
                               placeholder="+7(___)___-__-__"
                               @input="input()"
                        />
                    </div>
                    <p class="text"
                       :class="{ 'error': this.phone_error !== ''}"
                    >{{ this.phone_error }}</p>
                </div>
                <div class="block-input">
                    <label for="input-pass">Пароль</label>
                    <div class="input">
                        <input name="input-pass"
                               v-model="this.pass_value"
                               :type="this.pass_input_type"
                        />
                        <div class="icon icon-fixed"
                             :class="{ 'icon-eye-regular': this.pass_input_type === 'password', 'icon-eye-slash-regular': this.pass_input_type === 'text' }"
                             title="Показать пароль"
                             @click="showPass()"
                        ></div>
                    </div>
                    <p class="text"
                       :class="{ 'error': this.pass_error !== ''}"
                    >{{ this.pass_error }}</p>
                </div>
                <div class="block-buttons">
                    <button @click="login()" type="button">Войти</button>
                    <button @click="close()" type="button">Закрыть</button>
                </div>
                <div class="block-switch-template">
                    <div @click="this.template_change()">Регистрация</div>
                </div>
            </div>
            <div v-if="this.template === 'registration'" class="form-registration">
                <div class="block-input">
                    <label for="input-name">Введите Ваше Имя</label>
                    <div class="input">
                        <input name="input-name"
                               v-model="this.name_value"
                               type="text"
                        />
                    </div>
                    <p class="text"
                       :class="{ 'error': this.name_error !== ''}"
                    >{{ this.name_error }}</p>
                </div>
                <div class="block-input">
                    <label for="input-tel">Номер телефона</label>
                    <div class="input">
                        <input name="input-tel"
                               v-model="this.phone_value"
                               type="text"
                               placeholder="+7(___)___-__-__"
                               @input="input()"
                        />
                    </div>
                    <p class="text"
                       :class="{ 'error': this.phone_error !== ''}"
                    >{{ this.phone_error }}</p>
                </div>
                <div class="block-input">
                    <label for="input-pass">Пароль</label>
                    <div class="input">
                        <input name="input-pass"
                               v-model="this.pass_value"
                               :type="this.pass_input_type"
                        />
                        <div class="icon icon-fixed"
                             :class="{ 'icon-eye-regular': this.pass_input_type === 'password', 'icon-eye-slash-regular': this.pass_input_type === 'text' }"
                             title="Показать пароль"
                             @click="showPass()"
                        ></div>
                    </div>
                    <p class="text"
                       :class="{ 'error': this.pass_error !== ''}"
                    >{{ this.pass_error }}</p>
                </div>
                <div class="block-check">
                    Нажимая кнопку «Регистрация», вы принимаете согласие на обработку <a
                    href="https://storage.yandexcloud.net/storage.inspectrum.ru/documents/2024/%D0%9F%D0%BE%D0%BB%D0%B8%D1%82%D0%B8%D0%BA%D0%B0%20%D0%BA%D0%BE%D0%BD%D1%84%D0%B8%D0%B4%D0%B5%D0%BD%D1%86%D0%B8%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D1%81%D1%82%D0%B8.pdf"
                    target="_blank">персональных данных</a>
                </div>
                <div class="block-buttons">
                    <button @click="this.registration()" type="button">Регистрация</button>
                </div>
                <div class="block-switch-template">
                    <div @click="this.template_change()">Вход</div>
                </div>
            </div>
            <div v-if="this.template === 'code'" class="form-code">
                <div class="block-input">
                    <label for="input-tel">Введите код из СМС</label>
                    <div class="input">
                        <input name="input-tel"
                               v-model="this.sms_value"
                               type="text"
                        />
                    </div>
                    <p class="text"
                       :class="{ 'error': this.sms_error !== ''}"
                    >{{ this.sms_error }}</p>
                </div>
                <div class="block-buttons">
                    <button @click="check_code()" type="button">Подтвердить</button>
                </div>
            </div>
        </div>
    </Transition>
    <Transition name="fade-backdrop">
        <div v-if="this.is_open" class="backdrop" @click="close()"></div>
    </Transition>
</template>

<style scoped lang="scss">
.fade-enter-active,
.fade-leave-active {
    transition: opacity $transition ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.fade-backdrop-enter-from,
.fade-backdrop-leave-to {
    opacity: 0;
}

.backdrop {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, .5);
    width: 100vw;
    height: 100vh;
    z-index: 1119;
    transition: opacity $transition ease;
}

.popup {
    position: fixed;
    top: 50px;
    left: 50%;
    z-index: 1120;
    background-color: white;
    width: 100%;
    max-width: 400px;
    transform: translateX(-50%);
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    border-radius: 10px;

    > .form-login, > .form-registration, > .form-code {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 20px;

        > .block-input {
            display: flex;
            flex-direction: column;
            gap: 5px;

            > label {
                font-style: italic;
                color: #353535;
            }

            > .input {
                height: 50px;
                width: 100%;
                position: relative;

                > input {
                    height: 100%;
                    width: 100%;
                    padding: 0 0 0 20px;
                    overflow: hidden;
                    box-sizing: border-box;
                    border-radius: 10px;
                    border: 1px solid silver;
                }

                > .icon {
                    height: 20px;
                    width: 20px;
                    min-width: 20px;
                    cursor: pointer;
                }

                > .icon-fixed {
                    position: absolute;
                    right: 20px;
                    top: 50%;
                    transform: translateY(-50%);
                    transition: $transition;

                    &:hover {
                        transform: translateY(-50%) scale(1.1);
                    }
                }


            }

            > .text {
                font-size: 0.8rem;
                height: 15px;
            }

            > .error {
                color: $color-primary;
            }
        }

        > .block-check {
            font-size: 0.8rem;

            > a {
                transition: $transition;
                color: $color-primary;

                &:hover {
                    color: $color-primary-darken;
                }
            }
        }

        > .block-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;

            > button {
                height: 50px;
                width: 50%;
                border-radius: 10px;
                border: 1px solid silver;
                transition: $transition;

                &:hover {
                    transform: scale(1.05);
                }
            }
        }

        > .block-switch-template {
            display: flex;
            justify-content: center;
            align-items: center;

            > div {
                color: black;
                cursor: pointer;
                transition: $transition;

                &:hover {
                    color: $color-primary;
                }
            }
        }
    }
}

.header-user {
    position: relative;

    &:hover {

        > .user-navigation {
            height: auto;

            > .content {
                padding: 10px;
                border: 1px solid $color-primary;
            }
        }
    }

    > .user-navigation {
        position: absolute;
        top: 100%;
        right: 0;
        min-width: 280px;
        height: 0;
        overflow: hidden;
        transition: $transition;

        > .content {
            margin: 10px 0 0 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
            border-radius: 5px;
            border: 0;
            padding: 0;
            background-color: $color-header-bg;
            transition: $transition;

            > div {
                padding: 0 10px 0 10px;
                height: 40px;
                width: 100%;
                display: flex;
                justify-content: flex-end;
                align-items: center;
                white-space: nowrap;
                transition: $transition;

                &:hover {
                    background-color: $color-primary;
                    color: $color-alter;
                }
            }
        }
    }
}

.active {
    background-color: $color-primary-darken;

    > .user-navigation {
        height: auto;

        > .content {
            padding: 10px;
            border: 1px solid $color-primary;
        }
    }
}

</style>
