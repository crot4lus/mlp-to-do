import './bootstrap';

import {createApp} from 'vue';

import TaskList from './Components/TaskList.vue'

const app = createApp({

});

app.component('TaskList', TaskList);

app.mount('[data-vue-wrapper]');