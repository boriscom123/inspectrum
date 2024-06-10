import './bootstrap';

/**
 * Подключение Vue.js
 */
import { createApp } from 'vue';

/**
 * Подключение eventBus';
 * import useEventsBus from './eventBus';
 */

import mitt from 'mitt'
const emitter = mitt();

/**
 * Подключение стилей для сборки
 */
import "../scss/app.scss";

/**
 * Подключение Toast сообщений
 */
// import Toast from "vue-toastification";
import Toast, { POSITION } from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

// import "vue-multiselect/dist/vue-multiselect.css";

const app = createApp({});

import ComponentAbout from "./vue-components/ComponentAbout.vue";
app.component('component-about', ComponentAbout);

import ComponentUserAuth from "./vue-components/ComponentUserAuth.vue";
app.component('component-user-auth', ComponentUserAuth);

import ComponentBreadcrumbs from "./vue-components/ComponentBreadcrumbs.vue";
app.component('component-breadcrumbs', ComponentBreadcrumbs);

import ComponentPageSingle from "./vue-components/ComponentPageSingle.vue";
app.component('component-page-single', ComponentPageSingle);

/**
 * Компоненты главной страницы
 */
import IndexComponents from "./vue-components/index";
IndexComponents.forEach(component => {
    app.component(component.name, component);
})


/**
 * Компоненты раздела News
 */
import NewsComponents from "./vue-components/news";
NewsComponents.forEach(component => {
    app.component(component.name, component);
})

/**
 * Компоненты раздела Reviews
 */
import ReviewsComponents from "./vue-components/reviews";
ReviewsComponents.forEach(component => {
    app.component(component.name, component);
})

/**
 * Компоненты Admin Panel
 */
import AdminPanelComponents from "./vue-components/admin";
AdminPanelComponents.forEach(component => {
    app.component(component.name, component);
})

app.use(Toast, {
    position: POSITION.TOP_RIGHT
});

app.config.globalProperties.emitter = emitter;

app.mount('#app');
