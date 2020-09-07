<template>
    <div class="md:flex w-full items-center justify-between bg-white px-8 py-6 border-l-4 border-green-400">
        <div class="md:flex">
            <div class="flex flex-col ml-6 mt-6 md:mt-0 text-center md:text-left">
                <span class="text-xl text-gray-600 flex">
                    {{data.type === 'INCOME' ? 'Ingreso a ' : 'Gasto en '}}
                    <span class="font-bold flex ml-2">
                            {{data.name}}
                        <div class="rounded-lg h-5 w-5 ml-2 my-auto text-white"
                            v-bind:class="{
                                'bg-green-500' : data.account.color == 1,
                                'bg-blue-600' : data.account.color == 2,
                                'bg-red-600' : data.account.color == 3,
                                'bg-yellow-300' : data.account.color == 4,
                                'bg-orange-500' : data.account.color == 5,
                            }"
                        ></div>
                    </span>
                </span>
                
                <span class="text-2xl my-2 font-semibold text-green-500">
                    ${{data.amount}}
                </span> 
                <span class="text-sm mb-2 text-gray-600">{{data.description}}</span>
                <div class="mt-1 flex">
                    <div class="flex">
                        <svg
                            class="h-5 w-5 fill-current text-gray-600"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 4a4 4 0 014 4 4 4 0 01-4 4
                                4 4 0 01-4-4 4 4 0 014-4m0
                                10c4.42 0 8 1.79 8
                                4v2H4v-2c0-2.21 3.58-4 8-4z"></path>
                        </svg>
                        <span
                            class="ml-2 text-sm text-gray-600
                            dark:text-gray-300 capitalize md:pt-1">
                            {{getFirstWord(data.user.name)}}
                        </span>
                    </div>

                    <div class="flex ml-6">
                        <svg
                            class="h-5 w-5 fill-current text-gray-600"
                            viewBox="0 0 24 24">
                            <path
                                d="M19
                                19H5V8h14m-3-7v2H8V1H6v2H5c-1.11
                                0-2 .89-2 2v14a2 2 0 002 2h14a2 2
                                0 002-2V5a2 2 0 00-2-2h-1V1m-1
                                11h-5v5h5v-5z"></path>
                        </svg>
                        <span
                            class="ml-2 text-sm text-gray-600 capitalize md:pt-1">
                            {{formateDate(data.created_at)}}
                        </span>
                    </div>

                    <div class="flex ml-6">
                        <svg
                            class="h-5 w-5 fill-current text-gray-600"
                            viewBox="0 0 24 24">
                            <path d="M3 13h12v-2H3m0-5v2h18V6M3 18h6v-2H3v2z"></path>
                        </svg>
                        <span
                            class="ml-2 text-sm text-gray-600 capitalize md:pt-1">
                            {{data.category.name}}
                        </span>
                    </div>
                </div>

                <div class="mt-4 flex">

                </div>
            </div>
        </div>

        <div class="mx-auto md:flex md:flex-col md:-mt-10 md:mr-20 text-center">
            <div class="inline-flex justify-center md:mt-6 md:ml-auto">
                <button class="bg-gray-200 hover:bg-indigo-700 hover:text-white 
                text-gray-700 py-2 font-semibold px-4 rounded md:mr-2">
                    Editar
                </button>
                <button class="bg-gray-200 hover:bg-red-700 hover:text-white 
                text-gray-700 py-2 px-4 font-semibold rounded">
                    Eliminar
                </button>
            </div>

        </div>
    </div>

</template>

<script>
export default {
    name: "transaction-card",
    props: ['data'],
    methods: {
        editTransaction(transaction){
            this.$emit('editTransaction', transaction);
        },
        deleteTransaction(transaction){
            this.$emit('deleteTransaction', transaction);
        },
        formateDate(date){
            return moment(date).locale('es').format('DD [de] MMMM [del] YYYY');
        },
        getFirstWord(string){
            if (string.indexOf(' ') === -1)
                return string;
            return string.substr(0, string.indexOf(' '));
        }
    },
}
</script>