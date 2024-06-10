<script>
import {useToast} from "vue-toastification";

export default {
    name: "ComponentIndexOurAdvantages",
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
            console.log('ComponentIndexOurAdvantages');
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
    <div class="component-index-our-advantages">
        <div class="container">
            <div class="content">
                <div class="content-row first">
                    <div class="info">
                        <p>Наши преимущества перед конкурентами</p>
                    </div>
                    <div class="advantages">
                        <div class="icon icon-logo-text-white"></div>
                    </div>
                    <div class="competitors">
                        <p>Другие клиники</p>
                    </div>
                </div>
                <div class="content-row">
                    <div class="info">
                        <p>Электронная очередь</p>
                    </div>
                    <div class="advantages">
                        <div class="icon icon-check"></div>
                    </div>
                    <div class="competitors">
                        <div class="icon icon-minus"></div>
                    </div>
                </div>
                <div class="content-row">
                    <div class="info">
                        <p>Клиентский сервис для записи сотрудников</p>
                    </div>
                    <div class="advantages">
                        <div class="icon icon-check"></div>
                    </div>
                    <div class="competitors">
                        <div class="icon icon-minus"></div>
                    </div>
                </div>
                <div class="content-row">
                    <div class="info">
                        <p>Онлайн документооборот</p>
                    </div>
                    <div class="advantages">
                        <div class="icon icon-check"></div>
                    </div>
                    <div class="competitors">
                        <div class="icon icon-minus"></div>
                    </div>
                </div>
                <div class="content-row">
                    <div class="info">
                        <p>ИИ для принятия решений о годности/негодности</p>
                    </div>
                    <div class="advantages">
                        <div class="icon icon-check"></div>
                    </div>
                    <div class="competitors">
                        <div class="icon icon-minus"></div>
                    </div>
                </div>
                <div class="content-row">
                    <div class="info">
                        <p>Психиатрическое освидетельствование с предоставлением документов от ГБУЗ РБ</p>
                    </div>
                    <div class="advantages">
                        <div class="icon icon-check"></div>
                    </div>
                    <div class="competitors">
                        <div class="icon icon-minus"></div>
                    </div>
                </div>
                <div class="content-row">
                    <div class="info">
                        <p>Аккредитация в ПАО «Газпром Нефть»</p>
                    </div>
                    <div class="advantages">
                        <div class="icon icon-check"></div>
                    </div>
                    <div class="competitors">
                        <div class="icon icon-minus"></div>
                    </div>
                </div>
                <div class="content-row last">
                    <div class="info">
                        <p>Медосмотр Крайний Север</p>
                    </div>
                    <div class="advantages">
                        <div class="icon icon-check"></div>
                    </div>
                    <div class="competitors">
                        <div class="icon icon-minus"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.component-index-our-advantages {
    > .container {
        width: 100%;
        max-width: $bp-xxl;
        margin: 0 auto;
        padding: 60px 60px 60px 60px;
        border: 2px solid #e6e6e6;
        border-radius: 10px;

        @media (max-width: 1520px) {
            padding: 60px 60px 60px 60px;
            max-width: calc(100% - 120px);
        }
        @media (max-width: $bp-xl) {
            padding: 20px 20px 20px 20px;
            max-width: calc(100% - 40px);
        }
        @media (max-width: $bp-sm) {
            padding: 60px 20px 20px 20px;
        }
        @media (max-width: 450px) {
            padding: 60px 0 0 0;
            border: none;
            max-width: 100%;
        }

        > .content {
            display: flex;
            flex-direction: column;

            > .content-row {
                display: flex;
                gap: 20px;
                min-height: 50px;

                @media (max-width: $bp-sm) {
                    flex-wrap: wrap;
                    gap: 0;
                    position: relative;
                }

                > .info {
                    width: 50%;
                    display: flex;
                    align-items: center;
                    border-bottom: 2px solid rgba(0, 0, 0, .1);

                    @media (max-width: $bp-sm) {
                        width: 100%;
                        position: absolute;
                        border: unset;
                    }

                    > p {
                        font-weight: 500;
                        font-size: 1.1rem;

                        @media (max-width: $bp-md) {
                            font-size: 1rem;
                        }

                        @media (max-width: $bp-sm) {
                            width: 100%;
                            text-align: center;
                            font-weight: 700;
                        }

                        @media (max-width: 450px) {
                            font-size: 0.9rem;
                        }
                    }
                }

                > .advantages {
                    width: calc(25% - 20px);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background-color: $color-primary;
                    border-bottom: 2px solid rgba(0, 0, 0, .1);

                    @media (max-width: $bp-sm) {
                        width: 50%;
                        padding: 40px 0 10px 0;
                        border: unset;
                    }

                    > .icon {
                        height: 30px;
                        width: 30px;
                        min-width: 30px;
                    }
                }

                > .competitors {
                    width: calc(25% - 20px);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background-color: #e6e6e6;
                    border-bottom: 2px solid rgba(0, 0, 0, .1);

                    @media (max-width: $bp-sm) {
                        width: 50%;
                        padding: 40px 0 10px 0;
                        border: unset;
                    }

                    > p {
                        font-size: 1.1rem;

                        @media (max-width: $bp-md) {
                            font-size: 1rem;
                        }
                    }
                    > .icon {
                        height: 30px;
                        width: 30px;
                        min-width: 30px;
                    }
                }
            }


            > .first {
                > .info {
                    border-bottom: unset;
                    @media (max-width: $bp-sm) {
                        bottom: calc(100% + 20px);
                    }

                    > p {
                        font-weight: 700;
                        font-size: 2rem;

                        @media (max-width: $bp-md) {
                            font-size: 1.2rem;
                        }
                    }
                }

                > .advantages {
                    border-bottom: unset;
                    border-radius: 10px 10px 0 0;
                    padding: 10px 0 10px 0;

                    @media (max-width: 450px) {
                        border-radius: unset;
                    }

                    > .icon {
                        height: 91px;
                        width: 156px;
                    }
                }

                > .competitors {
                    border-bottom: unset;
                    justify-content: center;
                    align-items: center;
                    border-radius: 10px 10px 0 0;

                    @media (max-width: 450px) {
                        border-radius: unset;
                    }

                    > p {
                        font-weight: 700;
                        font-size: 1.5rem;
                        max-width: 200px;
                        text-align: center;

                        @media (max-width: $bp-md) {
                            font-size: 1.2rem;
                        }
                    }
                }
            }

            > .last {
                > .info {
                    border-bottom: unset;
                }
                > .advantages {
                    border-bottom: unset;
                    border-radius: 0 0 10px 10px;

                    @media (max-width: 450px) {
                        border-radius: unset;
                    }
                }
                > .competitors {
                    border-bottom: unset;
                    border-radius: 0 0 10px 10px;

                    @media (max-width: 450px) {
                        border-radius: unset;
                    }
                }
            }
        }
    }
}
</style>
