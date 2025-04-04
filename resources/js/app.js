import './bootstrap';
import Vue from 'vue'

import Login from './components/Login.vue';
import Sidebar from './components/Sidebar.vue';
import Task from './Pages/Task.vue';
import TaskForm from './components/TaskForm.vue';
import ShowTask from './Pages/ShowTask.vue';

Vue.component('login-component', Login);
Vue.component('sidebar-component', Sidebar);
Vue.component('task-component', Task);
Vue.component('task-form-component', TaskForm);
Vue.component('show-task-component', ShowTask);

const app = new Vue({
    el: '#app',
    methods: {
        MakeUrl(path) {
            return BaseUrl(path);
        }
    }
});
