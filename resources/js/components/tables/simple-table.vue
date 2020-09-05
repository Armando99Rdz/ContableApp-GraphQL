<template>
    <div>
        <table class="table-auto w-full">
            <thead class="text-gray-700 bg-gray-300">
                <tr class="">
                    <th v-for="heading in headings" class="p-4 z-20 sticky top-0 text-sm font-semibold">{{heading}}</th>
                    <th class="p-4 z-20 sticky top-0 text-sm font-semibold"></th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr v-for="item in data" class="px-4 py-5">
                    <td v-for="row in item" class="border-b-2 border-gray-200 px-4 py-2">
                        <div class="text-gray-700">{{ row }}</div>
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-2 text-gray-700">
                        <button class="bg-transparent hover:bg-indigo-700 text-indigo-700 font-semibold hover:text-white
                            py-2 px-2 border border-indigo-700 hover:border-transparent rounded" @click="editRecord(item)">
                            Editar
                        </button>
                        <button class="bg-transparent hover:bg-red-700 text-red-700 font-semibold hover:text-white
                            py-2 px-2 border border-red-700 hover:border-transparent rounded" @click="deleteRecord(item)">
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
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
