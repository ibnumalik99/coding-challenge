<template>
    <div>
        <div class="w-full flex justify-end p-4">
            <button @click="create" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" style="cursor: pointer;">
                Create
            </button>
        </div>
        
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Tarif /Jam
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Jam Kerja
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total Remuneration
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="task in tasks" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white capitalize">
                            {{ task.title }}
                        </th>
                        <td class="px-6 py-4">
                            {{ task.hourly_rate }}
                        </td>
                        <td class="px-6 py-4">
                            {{ task.hours_spent }}
                        </td>
                        <td class="px-6 py-4">
                            {{ task.total_remunation }}
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <button @click="handleUpdate(task.id)" style="cursor: pointer;" type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Edit</button>
                            <button @click="handleView(task.id)" style="cursor: pointer;" type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">View</button>
                            <button @click="handleDelete(task.id)" style="cursor: pointer;" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Remove</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ["tasks"],
    data() {

    },
    methods: {
        create() {
            window.location.href = "/task"
        },
        handleView(id) {
            window.location.href = `/task/${id}`
        },
        handleUpdate(id) {
            window.location.href = `/task/${id}/edit`
        },
        async handleDelete(id) {
            const isConfirmed = window.confirm("Are you sure?");

            if (isConfirmed) {
                try {
                    const response = await axios.delete(`/task/${id}`);
                    if (response.status === 200) {
                        window.location.href = "/dashboard";
                    }
                } catch (error) {
                    console.error(error);
                }
            } else {
                console.log("Penghapusan dibatalkan");
            }
        }

    }
}
</script>