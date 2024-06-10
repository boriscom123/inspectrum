<script>
import {useToast} from "vue-toastification";

export default {
    name: "ComponentAdminHeaderNavigation",
    data: function () {
        return {
            theme_type: '',
            document_body: '',
            active_navigation: false,
        };
    },
    setup() {
        const toast = useToast();
        return {toast}
    },
    mounted() {
        this.document_body = document.body;
    },
    methods: {
        showToast() {
            this.toast.info("I'm an info toast!");
            this.toast.success("My toast success", {timeout: 2000});
            this.toast.error("My toast error");
        },
        change_theme() {
            this.toast.success('Меняем тему');
            if (this.theme_type !== 'dark') {
                this.theme_type = 'dark';
                if (!this.document_body.classList.contains("theme-dark")) {
                    this.document_body.classList.add("theme-dark");
                }
            } else {
                this.theme_type = '';
                if (this.document_body.classList.contains("theme-dark")) {
                    this.document_body.classList.remove("theme-dark");
                }
            }
        },
        toggle_to_news() {
            this.toast.success('Переключаемся на раздел Новости');
            this.active_navigation = 'news';
            this.emitter.emit('active_navigation', { active_navigation: this.active_navigation });
        },
        toggle_to_user_reviews() {
            this.toast.success('Переключаемся на раздел Отзывы клиентов');
            this.active_navigation = 'user-reviews';
            this.emitter.emit('active_navigation', { active_navigation: this.active_navigation });
        },
    },
}
</script>

<template>
    <header class="admin-panel-header">
        <div class="header-fixed">
            <div class="container">
                <div class="header-logo">
                    <a href="/admin-panel" class="logo">
                        <img src="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/logo/logo-icon.svg" alt="logo-icon.svg">
                    </a>
                    <div class="icons">
                        <div class="icon icon-moon-regular" @click="change_theme()" v-if="this.theme_type === ''"></div>
                        <div class="icon icon-sun-regular" @click="change_theme()" v-if="this.theme_type === 'dark'"></div>
                        <a href="/" class="icon icon-right-from-bracket-solid"></a>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="navigation-block">
                    <div class="navigation-item" @click="toggle_to_news()">Новости</div>
                    <div class="navigation-item" @click="toggle_to_user_reviews()">Отзывы клиентов</div>
                </div>
                <div class="divider"></div>
            </div>
        </div>

    </header>
</template>

<style scoped lang="scss">
.admin-panel-header {
    position: relative;

    > .header-fixed {
        position: fixed;
        height: 100vh;
        width: 100%;
        max-width: 350px;
        background-color: rgba(27, 37, 59, 1);

        > .container {
            width: 100%;
            padding: 20px 20px 20px 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;

            > .header-logo {
                display: flex;
                justify-content: space-between;
                align-items: center;

                > .logo {
                    height: 50px;
                    width: 50px;
                    min-width: 50px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    transition: $transition;

                    &:hover {
                        transform: scale(1.1);
                    }

                    > img {
                        height: 100%;
                        width: 100%;
                    }
                }

                > .icons {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 10px;

                    > .icon {
                        height: 25px;
                        width: 25px;
                        min-width: 25px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        cursor: pointer;
                        transition: $transition;
                    }
                }
            }

            > .divider {
                height: 1px;
                background-color: silver;
            }

            > .navigation-block {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: flex-start;
                gap: 10px;

                > .navigation-item {
                    padding: 10px 0 10px 0;
                    color: silver;
                    cursor: pointer;
                    transition: $transition;

                    &:hover {
                        color: white;
                    }
                }
                > .active {
                    color: $color-primary;
                }
            }
        }
    }
}

</style>
