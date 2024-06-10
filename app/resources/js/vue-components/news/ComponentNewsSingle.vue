<script>
export default {
    name: "ComponentNewsSingle",
    props: {
        newsList: {
            type: Array,
        },
        newsSingle: {
            type: Array,
        },
    },
    mounted() {
        console.log('newsList', this.newsList);
        console.log('newsSingle', this.newsSingle);
    },
}
</script>

<template>
    <div class="component-news-single">
        <div class="container">
            <div class="container-content">
                <h1>
                    {{ this.newsSingle.title }}
                </h1>

                <div class="news-info">

                    <div class="news-single" v-html=this.newsSingle.text></div>

                    <div class="news-list">

                        <template v-for="(item, index) in this.newsList" :key="index">
                            <a :href="item.link" class="news-item">
                                <div class="icon icon-chevron-right-solid"></div>
                                <div class="date">{{ item.date }}</div>
                                <div class="title">{{ item.title }}</div>
                                <div class="description">{{ item.description }}</div>
                            </a>
                        </template>

                    </div>
                </div>


            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.component-news-single {

    > .container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;

        > .container-content {
            padding: 0 60px 50px 60px;

            @media (max-width: $bp-xl) {
                padding: 0 20px 30px 20px;
            }
            @media (max-width: $bp-ssm) {
                padding: 0 10px 20px 10px;
            }

            > h1 {
                text-transform: uppercase;
                font-weight: bold;
            }

            > .news-info {
                margin: 20px 0 0 0;
                display: flex;
                justify-content: space-between;
                gap: 20px;

                @media (max-width: $bp-lg) {
                    flex-direction: column;
                }

                > .news-single {
                    width: calc(100% - 20px - 320px);
                    display: flex;
                    flex-direction: column;
                    gap: 10px;

                    @media (max-width: $bp-lg) {
                        width: 100%;
                    }

                    p {
                        line-height: 120%;

                        > img {
                            width: 100%;
                            object-fit: contain;
                        }
                    }
                }

                > .news-list {
                    width: 320px;
                    display: flex;
                    flex-direction: column;
                    gap: 20px;

                    @media (max-width: $bp-lg) {
                        flex-direction: row;
                        width: 100%;
                        flex-wrap: wrap;
                    }

                    > .news-item {
                        height: 350px;
                        width: 100%;
                        max-width: 400px;
                        padding: 30px;
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                        position: relative;
                        border: 2px solid #e6e6e6;
                        border-radius: 10px;
                        cursor: pointer;
                        transition: $transition;

                        &:hover {
                            border: 2px solid $color-primary;

                            > .icon {
                                border: 2px solid $color-primary;
                                background-color: $color-primary;
                            }
                        }

                        @media (max-width: $bp-lg) {
                            width: calc(100% /2 - 10px);
                            max-width: 100%;
                        }

                        @media (max-width: $bp-sm) {
                            width: 100%;
                        }

                        > .icon {
                            position: absolute;
                            top: 20px;
                            right: 20px;
                            height: 40px;
                            width: 40px;
                            min-width: 40px;
                            border-radius: 50%;
                            border: 2px solid #e6e6e6;
                            transition: $transition;
                            background-size: 30%;
                            background-color: $color-alter;
                        }

                        > .date {
                            color: grey;
                            font-size: 1.2rem;
                        }

                        > .title {
                            color: $font-bg-color;
                            font-size: 1.2rem;
                            font-weight: bold;
                            line-height: 150%;

                            @media (max-width: $bp-xxl) {
                                max-width: 250px;
                            }
                            @media (max-width: $bp-ssm) {
                                font-size: 1rem;
                            }
                        }

                        > .description {
                            margin: auto 0 0 0;
                            color: $font-bg-color;
                            font-size: 1.2rem;

                            @media (max-width: $bp-ssm) {
                                font-size: 1rem;
                            }
                        }
                    }
                }
            }
        }
    }
}
</style>
