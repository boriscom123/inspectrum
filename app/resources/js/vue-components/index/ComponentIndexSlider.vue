<script>
import {useToast} from "vue-toastification";

export default {
    name: "ComponentIndexSlider",
    props: [
        'app_env',
    ],
    data: function () {
        return {
            show_console: false,
        };
    },
    setup() {
        const toast = useToast();
        return {toast}
    },
    mounted() {
        if (this.app_env !== 'prod') {
            this.show_console = true;
        }
        if (this.show_console) {
            console.log('ComponentIndexSlider');
            console.log('app_env', this.app_env);
        }
    },
    methods: {
        showToast: function () {
            this.toast.info("I'm an info toast!");
            this.toast.success("My toast success", {timeout: 2000});
            this.toast.error("My toast error");
        },
    },
}
</script>

<template>
    <div class="component-index-slider">
        <div class="container">
            <div class="slider">
                <div class="slider-content">
                    <div class="item">
                        <div class="background-slider-urgent">
                            <div class="content">
                                <h2 class="title">Срочный медосмотр за 1 час</h2>
                                <p class="text">Согласно Приказу 29Н</p>
                                <a href="https://lk.inspectrum.ru/site/login" target="_blank" class="link">Записаться</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-control">
                    <div class="button button-left"></div>
                    <div class="button button-right"></div>
                </div>
                <div class="slider-dots">
                    <div class="dot active"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.component-index-slider {

    > .container {
        width: 100%;
        max-width: $bp-xxl;
        margin: 0 auto;

        @media (max-width: 1520px) {
            padding: 0 60px;
            max-width: 100%;
        }
        @media (max-width: $bp-xl) {
            padding: 0 20px;
        }
        @media (max-width: 350px) {
            padding: 0 10px;
        }

        > .slider {
            height: 600px;
            width: 100%;
            position: relative;

            @media (max-width: $bp-lg) {
                height: 500px;
            }
            @media (max-width: $bp-sm) {
                height: 400px;
            }

            > .slider-content {
                height: 100%;

                > .item {
                    height: 100%;

                    > div {
                        height: 100%;
                        border-radius: 10px;

                        > .content {
                            height: 100%;
                            display: flex;
                            flex-direction: column;
                            justify-content: center;
                            gap: 10px;
                            padding: 0 60px 0 60px;

                            @media (max-width: $bp-xl) {
                                padding: 0 20px 0 20px;
                            }
                            @media (max-width: 350px) {
                                padding: 0 10px 0 10px;
                            }

                            > .title {
                                font-size: 2rem;

                                @media (max-width: $bp-sm) {
                                    font-size: 1.5rem;
                                }
                                @media (max-width: 350px) {
                                    font-size: 1.1rem;
                                }
                            }

                            > .text {
                                font-size: 1rem;
                            }

                            > .link {
                                height: 50px;
                                width: 100%;
                                max-width: 300px;
                                margin: 10px 0 0 0;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                background-color: #347cd1;
                                border-radius: 15px;
                                color: #fff;
                                font-weight: 700;
                                cursor: pointer;
                                transition: $transition;

                                &:hover {
                                    background-color: #0050c9;
                                }
                            }
                        }
                    }
                }
            }

            > .slider-control {
                display: flex;
                gap: 10px;
                position: absolute;
                bottom: 60px;
                right: 60px;

                @media (max-width: $bp-xl) {
                    bottom: 20px;
                    right: 20px;
                }
                @media (max-width: 350px) {
                    bottom: 10px;
                    right: 10px;
                }

                > .button {
                    height: 50px;
                    width: 50px;
                    min-width: 50px;
                    background-color: rgba(256, 256, 256, 1);
                    transition: $transition;
                    cursor: pointer;
                    border-radius: 50%;
                    //border: 1px solid $color-footer-bg;

                    &:hover {
                        transform: scale(1.1);
                        //background-color: rgba(256, 256, 256, 1);
                    }
                }

                > .button-left {
                    background-image: url("https://storage.yandexcloud.net/storage.inspectrum.ru/icons/black/chevron-left-solid.svg");
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: 30%;
                }

                > .button-right {
                    background-image: url("https://storage.yandexcloud.net/storage.inspectrum.ru/icons/black/chevron-right-solid.svg");
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: 30%;
                }
            }

            > .slider-dots {
                height: 30px;
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                position: absolute;
                top: 100%;
                left: 50%;
                transform: translateX(-50%);

                > .dot {
                    height: 10px;
                    width: 10px;
                    min-width: 10px;
                    background-color: $color-footer-bg;
                    border-radius: 50%;
                    cursor: pointer;
                    transition: $transition;

                    &:hover {
                        background-color: $color-primary;
                        transform: scale(1.5);
                    }
                }
            }
        }
    }
}

.background-slider-urgent {
    background-image: url("https://storage.yandexcloud.net/storage.inspectrum.ru/inspectrum-clinic/backgrounds/background-slider-urgent.jpg");
    background-position: center;
    background-size: cover;
}
</style>
