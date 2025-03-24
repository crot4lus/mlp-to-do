<template>
    <div class="flex task-list">
        <div class="fixed top-0 left-0 w-screen h-screen bg-white opacity-50 z-50" v-if="isLoading"></div>
        <div class="w-1/3 pr-8">
            <form v-on:submit.prevent="addTask" ref="taskSubmissionForm">
                <input required type="text" v-model="taskTitle" placeholder="Insert task name" class="task-list__input">
                <button type="submit" class="task-list__button">Add</button>
            </form>
        </div>
        <div class="w-2/3">
            <div class="task-list__container">
                <table class="w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0 w-5">#</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Task</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <div class="sr-only">Actions</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="(task, index) in tasks" v-bind:class="{ 'opacity-50': task.completed }">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ (index + 1) }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ task.title }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <button class="btn btn--orange btn--icon" v-if="task.completed" v-on:click.prevent="incompleteTask(task.id)"><i class="fa-solid fa-arrows-rotate"></i></button>
                                <button class="btn btn--green btn--icon" v-if="!task.completed" v-on:click.prevent="completeTask(task.id)"><i class="fa-solid fa-check"></i></button>
                                <button class="btn btn--red btn--icon" v-on:click.prevent="removeTask(task.id)"><i class="fa-solid fa-xmark"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

import {ENDPOINT_API_TASKS_GET} from './../endpoints';

export default{
    components: {
        ENDPOINT_API_TASKS_GET
    },
    mounted(){
        console.log('Task list mounted');

        this.getTasks();
    },
    data(){
        return {
            endpoint: ENDPOINT_API_TASKS_GET,
            tasks: [],
            isLoading: true,
            taskTitle: ''
        }
    },
    methods: {
        /**
         * Grabs a list of tasks from the API endpoint
         */
        getTasks() {
            let self = this;

            axios.get(this.endpoint)
            .then((response) => {
                self.tasks = response.data;
                self.isLoading = false;
            });
        },
        addTask() {
            let self = this;

            this.$refs.taskSubmissionForm.checkValidity();

            self.isLoading = true;

            axios.post(this.endpoint, {
                title: self.taskTitle
            })
            .then((response) => {
                self.taskTitle = '';
                self.getTasks();
            })
            .catch((response) => {
                console.log('Something went wrong...')
            })
        },
        removeTask(task_id) {
            let self = this;

            if(confirm('Are you sure you want to remove this task?') === true){
                self.isLoading = true;

                axios.delete(self.endpoint + '/' + task_id)
                .then((response) => {
                    self.getTasks();
                })
                .catch((response) => {
                    console.log('Something went wrong...')
                })
            }
        },
        completeTask(task_id) {
            let self = this;

            self.isLoading = true;

            axios.patch(self.endpoint + '/' + task_id, {
                completed: 1
            })
            .then((response) => {
                self.getTasks();
            })
            .catch((response) => {
                console.log('Something went wrong...')
            })
        },
        incompleteTask(task_id) {
            let self = this;

            self.isLoading = true;

            axios.patch(self.endpoint + '/' + task_id, {
                completed: 0
            })
            .then((response) => {
                self.getTasks();
            })
            .catch((response) => {
                console.log('Something went wrong...')
            })
        },
    }
}
</script>