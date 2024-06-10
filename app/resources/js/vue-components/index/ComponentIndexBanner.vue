<script>
export default {
    name: "ComponentIndexBanner",
    props: [
        'app_env',
    ],
    mounted() {
        if (this.app_env !== 'prod') {
            this.show_console = true;
        }
        if (this.show_console) {
            console.log('ComponentIndexBanner');
            console.log('app_env', this.app_env);
        }
    },
}
</script>

<template>
    <div class="component-index-banner">
        <div class="container">
            <div class="content">
                <div class="banner">
                    <h2>Запишись на бесплатный медосмотр</h2>
                    <h3>Для инженеров по ОТ и владельцев бизнеса*</h3>
                    <div class="list">
                        <div class="item">
                            <div class="icon icon-check"></div>
                            <div class="text">МО за 1 час</div>
                        </div>
                        <div class="item">
                            <div class="icon icon-check"></div>
                            <div class="text">Электронная очередь</div>
                        </div>
                        <div class="item">
                            <div class="icon icon-check"></div>
                            <div class="text">Искусственный интеллект для принятия решения о годности сотрудника</div>
                        </div>
                    </div>
                    <div class="button">
                        <p>Записаться</p>
                        <div class="icon icon-chevron-right-solid"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.component-index-banner {
    > .container {
        width: 100%;
        max-width: $bp-xxl;
        margin: 0 auto;
        border-radius: 10px;

        @media (max-width: 1520px) {
            max-width: calc(100% - 120px);
        }
        @media (max-width: $bp-xl) {
            max-width: calc(100% - 40px);
        }

        @media (max-width: $bp-ssm) {
            max-width: 100%;
            border-radius: unset;
        }

        > .content {
            display: flex;
            flex-direction: column;

            > .banner {
                background-image: url("https://storage.yandexcloud.net/storage.inspectrum.ru/inspectrum-clinic/backgrounds/banner-main.jpg");
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center center;
                min-height: 200px;
                padding: 60px 60px 60px 60px;
                display: flex;
                flex-direction: column;
                gap: 20px;
                position: relative;
                border-radius: 10px;

                @media (max-width: $bp-xl) {
                    padding: 60px 20px 60px 20px;
                }

                @media (max-width: $bp-lg) {
                    padding: 20px 20px 20px 20px;
                }

                > h2 {
                    font-size: 2.2rem;
                    font-weight: bold;
                    color: #1b5ba3;
                    line-height: 1;

                    @media (max-width: $bp-lg) {
                        font-size: 2rem;
                    }
                    @media (max-width: $bp-sm) {
                        font-size: 1.8rem;
                    }
                    @media (max-width: $bp-ssm) {
                        font-size: 1.2rem;
                    }
                }

                > h3 {
                    font-size: 1.2rem;
                    font-weight: bold;
                    color: #000;

                    @media (max-width: $bp-ssm) {
                        font-size: 1rem;
                    }
                }

                > .list {
                    display: flex;
                    gap: 20px;

                    @media (max-width: $bp-lg) {
                        flex-direction: column;
                        gap: 10px;
                    }

                    > .item {
                        display: flex;
                        align-items: center;
                        gap: 10px;

                        > p {
                            font-weight: 500;
                            font-size: 1rem;
                            color: #000;
                        }

                        > .icon {
                            height: 30px;
                            width: 30px;
                            min-width: 30px;
                            border: 2px solid $color-primary;
                            border-radius: 50%;
                        }
                    }
                }

                > .button {
                    padding: 0 20px;
                    position: absolute;
                    top: 60px;
                    right: 60px;
                    min-height: 40px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 20px;
                    background-color: #0060a4;
                    border-radius: 10px;
                    cursor: pointer;

                    @media (max-width: $bp-xl) {
                        right: 20px;
                    }
                    @media (max-width: $bp-lg) {
                        position: static;
                        max-width: 280px;
                    }

                    > p {
                        color: #fff;
                    }

                    > .icon {
                        height: 15px;
                        width: 15px;
                        min-width: 15px;
                    }
                }
            }
        }
    }
}
</style>
