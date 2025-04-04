<template>
    <div>
        <form class="mx-auto max-w-4xl" @submit.prevent="handleOnSubmit">
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                    <input v-model="title" type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" required />
                </div>
                <div>
                    <label for="hours_spent" class="block mb-2 text-sm font-medium text-gray-900">Jumlah Jam Kerja</label>
                    <input v-model="hours_spent" type="number" id="hours_spent" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" required />
                </div>
                <div>
                    <label for="hourly_rate" class="block mb-2 text-sm font-medium text-gray-900">Tarif Perjam</label>
                    <input v-model="hourly_rate" type="number" id="hourly_rate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" required />
                </div>  
                <div>
                    <label for="addtional_charges" class="block mb-2 text-sm font-medium text-gray-900">Biaya Tambahan</label>
                    <input v-model="addtional_charges" type="number" id="addtional_charges" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" />
                </div>
            </div>

            <div v-for="(entry, index) in selectedEmployees" :key="index" class="flex gap-4 mb-2 max-w-2xl mx-auto">
                <select v-model="entry.employeeId" @change="updateEmployeeName(entry)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5">
                    <option v-for="employee in getAvailableEmployees(entry.employeeId)" :key="employee.id" :value="employee.id">
                        {{ employee.name }}
                    </option>
                </select>


                <input type="number" v-model="entry.hours" placeholder="Jam kerja" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5"/>

                <button type="button" @click="removeEmployee(index)" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                    Delete
                </button>
            </div>


            <div class="flex justify-center">
                <button type="button" @click="addEmployee" :disabled="employees.length === selectedEmployees.length" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add Employee
                </button>
            </div>

            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                <textarea v-model="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:border-blue-500" placeholder="Description task..."></textarea>
            </div> 
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['record', 'employees'],
    data() {
        return {
            selectedEmployees: this.record?.employees?.map(emp => ({
                employeeId: emp.id,
                employeeName: emp.name,
                hours: emp.hours || 0
            })) || [],
            title: this.record?.title || '',
            hours_spent: this.record?.hours_spent || '',
            hourly_rate: this.record?.hourly_rate || '',
            addtional_charges: this.record?.addtional_charges || '',
            description: this.record?.description || ''
        }
    },
    computed: {
        // Employee yang belum dipilih
        availableEmployees() {
            return this.employees.filter(emp => 
                !this.selectedEmployees.some(se => se.employeeId === emp.id)
            );
        }
    },
    methods: {
        addEmployee() {
            const firstAvailable = this.employees.find(emp => 
                !this.selectedEmployees.some(se => se.employeeId === emp.id)
            );
            if (firstAvailable) {
                this.selectedEmployees.push({
                    employeeId: firstAvailable.id,
                    employeeName: firstAvailable.name,
                    hours: 0
                });
            }
        },
        removeEmployee(index) {
            this.selectedEmployees.splice(index, 1);
        },
        updateEmployeeName(entry) {
            const selectedEmp = this.employees.find(e => e.id === entry.employeeId);
            if (selectedEmp) {
                entry.employeeName = selectedEmp.name;
            }
        },
        getAvailableEmployees(selectedId) {
            return this.employees.filter(emp => 
                !this.selectedEmployees.some(se => se.employeeId === emp.id) || emp.id === selectedId
            );
        },
        async handleOnSubmit() {
            if (this.record) {
                try {
                    const response = await axios.put(`/task/${this.record.id}`, {
                        title: this.title,
                        hours_spent: this.hours_spent,
                        hourly_rate: this.hourly_rate,
                        addtional_charges: this.addtional_charges,
                        description: this.description,
                        employee_task: this.selectedEmployees
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (response.status === 200) {
                        window.location.href = "/dashboard";
                    }
                } catch (error) {
                    console.error(error)
                }
            } else {
                try {
                    const response = await axios.post('/task', {
                        title: this.title,
                        hours_spent: this.hours_spent,
                        hourly_rate: this.hourly_rate,
                        addtional_charges: this.addtional_charges,
                        description: this.description,
                        employee_task: this.selectedEmployees
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
    
                    if (response.status === 200) {
                        window.location.href = "/dashboard";
                    }
                } catch (error) {
                    console.error(error)
                }
            }
        }
    }
}
</script>