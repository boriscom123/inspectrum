<script>
import {useToast} from "vue-toastification";
import axios from "axios";

export default {
    name: "ComponentAdminNews",
    data: function () {
        return {
            active_navigation: false,
            active_template: false,
            news_list: false,
            news: {
                id: '',
                date_start: '',
                date_end: '',
                title: '',
                description: '',
                text: '',
                slug: '',
                is_active: false,
                created_at: '',
                updated_at: '',
            },
        };
    },
    setup() {
        const toast = useToast();
        return {toast}
    },
    mounted() {
        this.emitter.on("active_navigation", (data) => {
            this.active_navigation = data.active_navigation;
            console.log(data);

            if (this.active_navigation === 'news' && !this.news_list) {
                this.active_template = '';
                this.get_news_list();
            }
        });
    },
    methods: {
        news_clear_data() {
            this.news = {
                id: '',
                date_start: '',
                date_end: '',
                title: '',
                description: '',
                text: '',
                slug: '',
                is_active: false,
                created_at: '',
                updated_at: '',
            };
        },
        news_add() {
            this.toast.info("Добавляем новую новость");
            this.news_clear_data();
            this.active_template = 'news_add';
        },
        news_add_close() {
            this.news_clear_data();
            this.active_template = '';
        },
        news_edit(event) {
            this.toast.info("Изменяем новую новость");
            const element = event.target;
            if (element) {
                console.log('element', element);
                const id = Number(element.getAttribute('data-news-id'));
                if (id) {
                    console.log('id', id);

                    for (let key in this.news_list) {
                        console.log(this.news_list[key]);

                        if (this.news_list[key]['id'] === id) {
                            console.log(this.news_list[key]);
                            this.news = this.news_list[key];
                            this.active_template = 'news_edit';
                            console.log('active_template', this.active_template);
                            console.log('this.news', this.news);
                        }
                    }
                }
            }
        },
        async news_delete(event) {
            this.toast.info("Удаляем новую новость");
            const element = event.target;
            if (element) {
                console.log('element', element);
                const id = element.getAttribute('data-news-id');
                if (id) {
                    const requestData = {
                        id: id,
                    }
                    const response = await axios.post('/admin-panel/news-delete', requestData);
                    if (response) {
                        console.log(response);
                        if ('result' in response.data) {
                            if (response.data['result']) {
                                this.active_template = '';
                                this.get_news_list();
                            }
                        }
                        if ('message' in response.data) {
                            this.toast.error(response.data['message']);
                        }
                    }
                }
            }
        },
        async news_save() {
            this.toast.error("Сохраняем новую новость");
            console.log('this.news', this.news);

            const requestData = {
                news: this.news,
            }

            const response = await axios.post('/admin-panel/news-save', requestData);
            if (response) {
                console.log(response);
                if ('result' in response.data) {
                    if (response.data['result']) {
                        this.active_template = '';
                        this.news_clear_data();
                        this.get_news_list();
                    }
                }
                if ('message' in response.data) {
                    this.toast.error(response.data['message']);
                }
            }
        },
        async news_update() {
            this.toast.error("Обновляем новость с id " + this.news.id);
            const requestData = {
                news: this.news,
            }
            const response = await axios.post('/admin-panel/news-update', requestData);
            if (response) {
                console.log(response);
                if ('result' in response.data) {
                    if (response.data['result']) {
                        this.active_template = '';
                        this.news_clear_data();
                        this.get_news_list();
                    }
                }
                if ('message' in response.data) {
                    this.toast.error(response.data['message']);
                }
            }
        },
        async get_news_list() {
            const response = await axios.get('/admin-panel/get-news-list');
            if (response) {
                console.log(response);
                if ('result' in response.data) {
                    if (response.data['result']) {
                        if ('news_list' in response.data) {
                            this.news_list = response.data['news_list'];
                        }
                    }
                }
            }
        }
    }
}
</script>

<template>
    <div v-if="this.active_navigation === 'news'" class="component-admin-news">
        <div class="content">
            <h1 class="title">Новости</h1>
            <div class="actions">
                <div class="button" @click="news_add()">Добавить новость</div>
            </div>
            <div v-if="this.news_list && !this.active_template" class="news-list">
                <div class="news-title">
                    <div class="number">ID</div>
                    <div class="name">Наименование</div>
                    <div class="actions">Действия</div>
                </div>
                <template v-for="(item, index) in this.news_list" :key="index">
                    <div class="news-item">
                        <div class="number">{{ item.id }}</div>
                        <div class="name">{{ item.description }}</div>
                        <div class="actions">
                            <div class="icon icon-pen-to-square-regular" @click="news_edit($event)"
                                 :data-news-id="item.id"></div>
                            <div class="icon icon-trash-can-regular" @click="news_delete($event)"
                                 :data-news-id="item.id"></div>
                        </div>
                    </div>
                </template>
            </div>
            <div v-else-if="this.active_template === 'news_add' || this.active_template === 'news_edit'"
                 class="news-add">
                <h2>Добавление новости</h2>
                <form action="#">
                    <div class="input">
                        <label for="date-start">Дата начала показа новости</label>
                        <input type="date" name="date-start" v-model="this.news.date_start">
                    </div>
                    <div class="input">
                        <label for="date-end">Дата окончания показа новости</label>
                        <input type="date" name="date-end" v-model="this.news.date_end">
                    </div>
                    <div class="input">
                        <label for="news-title">Заголовок Новости</label>
                        <input type="text" name="news-title" v-model="this.news.title">
                    </div>
                    <div class="input">
                        <label for="news-description">Короткое описание Новости</label>
                        <input type="text" name="news-description" v-model="this.news.description">
                    </div>
                    <div class="textarea">
                        <label for="news-text">Текст Новости в формате HTML</label>
                        <textarea name="news-text" v-model="this.news.text"></textarea>
                    </div>
                    <div class="input" v-if="this.active_template === 'news_edit'">
                        <label for="news-slug">Ссылка на Новость</label>
                        <input type="text" name="news-slug" v-model="this.news.slug">
                    </div>
                    <div class="checkbox">
                        <label for="news-active">Активность Новости</label>
                        <input type="checkbox" id="news-active" name="news-active" v-model="this.news.is_active" :checked="this.news.is_active">
                    </div>
                    <div class="buttons">
                        <div @click="this.news_save()" v-if="this.active_template === 'news_add'" class="button">Создать</div>
                        <div @click="this.news_clear_data()" v-if="this.active_template === 'news_add'" class="button">Очистить</div>
                        <div @click="this.news_update()" v-if="this.active_template === 'news_edit'" class="button">Обновить</div>
                        <div @click="this.news_add_close()" class="button">Закрыть</div>
                    </div>
                </form>
            </div>
            <div v-else class="loading">
                <div class="image">
                    <img src="https://storage.yandexcloud.net/storage.inspectrum.ru/icons/logo/logo-icon.svg"
                         alt="logo-icon.svg">
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.component-admin-news {
    width: 100%;

    > .content {
        width: 100%;
        padding: 10px;
        display: flex;
        flex-direction: column;

        > .title {
            width: 100%;
            font-size: 2rem;
            padding: 0 0 28px 0;
            border-bottom: 1px solid silver;
        }

        > .actions {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 20px;
            margin: 20px 0 20px 0;

            > .button {
                height: 50px;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: $color-primary;
                color: $color-alter;
                padding: 0 10px 0 10px;
                border-radius: 5px;
                cursor: pointer;
                transition: $transition;

                &:hover {
                    background-color: $color-primary-darken;
                }
            }

        }

        > .news-list {
            display: flex;
            flex-direction: column;
            gap: 10px;

            > .news-title, > .news-item {
                display: flex;

                > .number {
                    height: 50px;
                    width: 100px;
                    padding: 0 10px 0 10px;
                    display: flex;
                    justify-content: center;
                    align-items: center;

                }

                > .name {
                    padding: 0 10px 0 10px;
                    display: flex;
                    flex-grow: 1;
                    align-items: center;
                }

                > .actions {
                    width: 100px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 10px;

                    > .icon {
                        height: 20px;
                        width: 20px;
                        min-width: 20px;
                        transition: $transition;
                        cursor: pointer;
                    }
                }
            }

            > .news-title {
                font-weight: 700;
            }

            > .news-item {
                border: 1px solid rgba(255, 255, 255, 0);
                transition: $transition;

                &:hover {
                    border-radius: 5px;
                    border: 1px solid silver;
                    cursor: pointer;
                }
            }
        }

        > .news-add {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px;

            > h2 {
                font-size: 1.2rem;
            }

            > form {
                display: flex;
                flex-direction: column;
                gap: 20px;
                width: 100%;
                max-width: 500px;

                > .input {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                }

                > .textarea {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;

                    > textarea {
                        min-height: 150px;
                    }
                }

                > .checkbox {
                    display: flex;
                    gap: 10px;
                    align-items: center;

                    > input {
                        appearance: auto;
                        height: 25px;
                        width: 25px;
                    }
                }

                > .buttons {
                    display: flex;
                    gap: 10px;
                    align-items: center;

                    > .button {
                        height: 50px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        background-color: $color-primary;
                        color: $color-alter;
                        padding: 0 10px 0 10px;
                        border-radius: 5px;
                        cursor: pointer;
                        transition: $transition;

                        &:hover {
                            background-color: $color-primary-darken;
                        }
                    }
                }
            }
        }

        > .loading {
            display: flex;

            > .image {
                height: 50px;
                width: 50px;
                min-width: 50px;
                display: flex;
                justify-content: center;
                align-items: center;
                animation: spinner 2s ease 0s infinite normal forwards;

                > img {
                    height: 100%;
                    width: 100%;
                }
            }
        }
    }
}
</style>
