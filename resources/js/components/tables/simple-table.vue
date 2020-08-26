<template>
    <div>
        <table class="table-auto mt-5 w-full">
            <thead class="text-gray-700 bg-gray-300">
                <tr class="">
                    <th v-for="heading in headings" class="p-4 z-20 sticky top-0 text-sm font-semibold">{{heading}}</th>
                    <th class="p-4 z-20 sticky top-0 text-sm font-semibold"></th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr v-for="item in data" class="px-4 py-5">
                    <td v-for="row in item" class="border-b-2 border-gray-200 px-4 py-2">
                        <div v-if="row[0] === '#'" class="rounded-full h-6 w-6 flex items-center justify-center mx-auto"
                              v-bind:class="{
                                'bg-green-400' : row[1] == 1,
                                'bg-blue-400' : row[1] == 2,
                                'bg-red-400' : row[1] == 3,
                                'bg-yellow-400' : row[1] == 4,
                                'bg-orange-400' : row[1] == 5,
                              }"
                        ></div>
                        <div v-else class="text-gray-700">{{ row }}</div>
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-2 text-gray-700">
                        <button class="bg-transparent hover:bg-blue-700 text-blue-700 font-semibold hover:text-white
                            py-2 px-2 border border-blue-700 hover:border-transparent rounded">
                            Editar
                        </button>
                        <button class="bg-transparent hover:bg-red-700 text-red-700 font-semibold hover:text-white
                            py-2 px-2 border border-red-700 hover:border-transparent rounded">
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
        ]
    }
</script>

<style scoped>

</style>
