<template>
    <div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="text-gray-700 bg-gray-200">
                                <tr class="">
                                    <th v-for="heading in headings" class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider" :key="heading.id">{{heading}}</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in data" class="px-4 py-5">
                                    <td v-for="row in item" :key="row.id" class="border-b-2 border-gray-100 px-4 py-2">
                                        <div class="text-gray-700 pl-3">{{ row }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        <button class="bg-indigo-700 hover:bg-indigo-800 text-white text-sm
                                            py-2 px-2 hover:border-transparent rounded" @click="editRecord(item)">
                                            Editar
                                        </button>
                                        <button class="bg-red-700 hover:bg-red-800 text-white text-sm
                                            py-2 px-2 hover:border-transparent rounded" @click="deleteRecord(item)">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "simple-table",
        props: [
            'headings',
            'data'
        ],
        methods: {
            editRecord(data){
                this.$emit('editRecord', data);
            },
            deleteRecord(data){
                this.$emit('deleteRecord', data);
            }
        }
    }
</script>

<style scoped>

</style>
