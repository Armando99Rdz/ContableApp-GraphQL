<template>
    <div class="md:flex w-full items-center justify-between bg-white px-8 py-6 border-l-4 my-2 shadow-md hover:shadow-lg hover:-translate-y-1 hover:scale-100 transition ease-in-out duration-300 transform motion-reduce:transform-none"
        v-bind:class="{
            'border-green-500' : data.account.color == 1,
            'border-blue-600' : data.account.color == 2,
            'border-red-600' : data.account.color == 3,
            'border-yellow-300' : data.account.color == 4,
            'border-orange-500' : data.account.color == 5,
        }"
    >
        <div class="md:flex">
            <div class="flex flex-col ml-6 mt-6 md:mt-0 text-center md:text-left">
                <span class="text-xl text-gray-600 flex">
                    {{data.type === 'INCOME' ? 'Ingreso registrado en ' : 'Gasto registrado en '}}
                    <span class="font-bold flex ml-2">
                            {{data.account.name}}
                        <div class="rounded-lg h-5 w-5 ml-2 my-auto text-white mr-2"
                            v-bind:class="{
                                'bg-green-500' : data.account.color == 1,
                                'bg-blue-600' : data.account.color == 2,
                                'bg-red-600' : data.account.color == 3,
                                'bg-yellow-300' : data.account.color == 4,
                                'bg-orange-500' : data.account.color == 5,
                            }"
                        ></div>
                        <span class="text-gray-600 font-normal">#{{data.id}}</span>
                    </span>
                </span>
                
                <span class="flex text-2xl my-2 font-semibold text-gray-600"
                >
                    ${{data.amount}}
                    <svg v-if="data.type === 'INCOME'" width="22" height="22" viewBox="0 0 20 20" fill="currentColor" class="text-green-500">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                    </svg>
                    <svg v-else fill="none" width="22" height="22" viewBox="0 0 24 24" stroke="currentColor" class="text-red-600">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
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
                            {{getFirstWord(data.account.user.name)}}
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

import moment from 'moment';

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