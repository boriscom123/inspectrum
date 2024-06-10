<script>
export default {
    name: "ComponentIndexReviews",
    props: {
        app_env: {
            type: String,
        },
        reviewsList: {
            type: Array,
        },
    },
    data: function () {
        return {
            is_open: false,
            video_index: null,
        };
    },
    mounted() {
        if (this.app_env !== 'prod') {
            this.show_console = true;
        }
        if (this.show_console) {
            console.log('ComponentIndexReviews');
            console.log('app_env', this.app_env);
            console.log('reviewsList', this.reviewsList);
        }
    },
    methods: {
        open: function (event, index) {
            this.is_open = true;
            this.video_index = index;
        },
        close: function () {
            this.is_open = false;
        },
    },
}
</script>

<template>
    <div class="component-index-reviews">
        <div class="container">
            <div class="content">
                <div class="title">
                    <h2>Отзывы</h2>
                    <a href="/reviews" class="link">Смотреть все отзывы</a>
                </div>
                <div class="reviews-list">
                    <template v-for="(item, index) in this.reviewsList" :key="index">
                        <div class="item">
                            <div class="date">{{ item.date }}</div>
                            <div class="title">{{ item.title }}</div>
                            <div class="preview" @click="open($event, index)">
                                <video class="video" :poster="item.poster">
                                    <source :src="item.source.src" :type="item.source.type">
                                    <!--                                    <template v-for="(video, v_index) in item.source" :key="v_index">-->
                                    <!--                                        <source :src="video.src" :type="video.type">-->
                                    <!--                                    </template>-->
                                </video>
                                <div class="decoration">
                                    <img
                                        src="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/main/circle-play-solid.svg"
                                        alt="circle-play-solid">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    <Transition name="fade">
        <div v-if="this.is_open" class="popup">
            <video class="video" :poster="this.reviewsList[this.video_index].poster" controls="controls" autoplay>
                <source :src="this.reviewsList[this.video_index].source.src"
                        :type="this.reviewsList[this.video_index].source.type">
                <!--                <template v-for="(item, v_index) in this.reviewsList[this.video_index].source" :key="v_index">-->
                <!--                    <source :src="item.src" :type="item.type">-->
                <!--                </template>-->
            </video>
        </div>
    </Transition>
    <Transition name="fade-backdrop">
        <div v-if="this.is_open" class="backdrop" @click="close()"></div>
    </Transition>
</template>

<style scoped lang="scss">
.component-index-reviews {

    .container {
        width: 100%;
        max-width: $bp-xxl;
        margin: 0 auto;

        @media (max-width: 1520px) {
            max-width: calc(100% - 120px);
        }
        @media (max-width: $bp-xl) {
            max-width: calc(100% - 40px);
        }

        > .content {

            > .title {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
                gap: 20px;
                border-bottom: 2px solid #e6e6e6;
                padding: 0 60px 20px 60px;

                @media (max-width: $bp-xl) {
                    padding: 0 20px 20px 20px;
                }

                > h2 {
                    font-size: 2.2rem;
                    font-weight: bold;

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

                > .link {
                    font-size: 1.2rem;
                    text-decoration: underline;
                    color: $color-primary;
                    transition: $transition;
                    text-align: right;

                    @media (max-width: $bp-sm) {
                        font-size: 0.8rem;
                    }

                    &:hover {
                        transform: scale(1.1);
                    }
                }
            }

            > .reviews-list {
                margin: 20px 0 0 0;
                display: flex;
                justify-content: space-between;
                gap: 20px;

                @media (max-width: $bp-md) {
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }

                > .item {
                    width: 100%;
                    max-width: 400px;
                    border-radius: 10px;
                    border-top: 2px solid rgba(0, 0, 0, 0);
                    background: #f2f2f2;
                    padding: 20px;
                    display: flex;
                    flex-direction: column;
                    gap: 10px;

                    > .date {
                        font-size: 1.7rem;
                        color: #afafaf;

                        @media (max-width: $bp-lg) {
                            font-size: 1.5rem;
                        }
                        @media (max-width: $bp-sm) {
                            font-size: 1.3rem;
                        }
                        @media (max-width: $bp-ssm) {
                            font-size: 1rem;
                        }
                    }

                    > .title {
                        font-size: 1.2rem;

                        @media (max-width: $bp-sm) {
                            font-size: 1rem;
                        }
                    }

                    > .preview {
                        position: relative;
                        display: flex;
                        cursor: pointer;

                        &:hover {
                            > .decoration {
                                background: rgba(255, 255, 255, 0.3);

                                > img {
                                    transform: translateX(-50%) translateY(-50%) scale(1.1);
                                }
                            }
                        }

                        > .video {
                            max-height: 100%;
                            width: 100%;
                        }

                        > .decoration {
                            position: absolute;
                            height: 100%;
                            width: 100%;
                            background: rgba(255, 255, 255, 0.5);
                            transition: $transition;

                            > img {
                                position: absolute;
                                top: 50%;
                                left: 50%;
                                height: 50px;
                                width: 50px;
                                min-width: 50px;
                                transform: translateX(-50%) translateY(-50%);
                                transition: $transition;
                                background: $color-alter;
                                border-radius: 50%;
                            }
                        }
                    }
                }
            }
        }
    }
}

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
    z-index: 9000;
    transition: opacity $transition ease;
}

.popup {
    position: fixed;
    top: 50px;
    left: 50%;
    z-index: 9001;
    background-color: white;
    width: 100%;
    max-width: 800px;
    height: auto;
    max-height: calc(100vh - 100px);
    transform: translateX(-50%);
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    border-radius: 10px;

    > .video {
        height: 100%;
        max-height: calc(100vh - 160px);
        width: 100%;
    }
}
</style>
