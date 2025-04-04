<template>
    <div class="rounded shadow-lg p-4 max-w-[90%] mx-auto">
        <div class="grid grid-cols-5 gap-4">
            <div class="col-span-3">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Title</label>
                    <input v-model="record.title" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" disabled />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Total Jam Kerja</label>
                    <input v-model="record.hours_spent" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" disabled />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tarif Perjam</label>
                    <input v-model="record.hourly_rate" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" disabled />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Biaya Tambahan</label>
                    <input v-if="record.addtional_charges" v-model="record.addtional_charges" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" disabled />
                    <input v-else value="-" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" disabled />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Total Remunerasi</label>
                    <input v-model="record.total_remunation" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full p-2.5" disabled />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi</label>
                    <textarea v-model="record.description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:border-blue-500" disabled></textarea>
                </div>
            </div>
            <div class="col-span-2">
                <p class="block mb-2 text-sm font-medium text-gray-900">Employees</p>
                <table class="w-full text-sm text-left  text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jam
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Remunerasi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="employee in record.employees" class="odd:bg-white border-b dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 capitalize">
                                {{ employee.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ employee.pivot.hours }}
                            </td>
                            <td class="px-6 py-4">
                                {{ (employee.pivot.hours/record.hours_spent) * record.total_remunation }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['record']
}
</script>