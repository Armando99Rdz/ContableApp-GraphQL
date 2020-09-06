<template>
    <div>
        <div class="w-full rounded overflow-hidden shadow-lg transform motion-reduce:transform-none
                hover:-translate-y-1 hover:scale-110 transition ease-in-out duration-300">
            <div class="bg-white rounded lg:rounded p-5 flex flex-col justify-between leading-normal">
                <div class="inline-flex justify-center">
                    <button class="bg-gray-100 text-gray-500 hover:bg-indigo-700 hover:text-gray-200 font-bold py-2 px-4 rounded-l"
                    @click="editAccount(data)">
                        Editar
                    </button>
                    <button class="bg-gray-100 text-gray-500 hover:bg-red-700 hover:text-gray-200 font-bold py-2 px-4 rounded-r"
                    @click="deleteAccount(data)">
                        Eliminar
                    </button>
                </div>
                <div class="mb-4 flex">
                    <div class="w-full">
                        <div class="text-gray-900 font-bold text-3xl text-center">{{data.name}}</div>
                        <div class="text-gray-500 font-bold text-4xl text-center">${{data.balance}}</div>
                        <p class="text-gray-700 text-base text-center">{{data.description}}</p>
                    </div>

                </div>
                <div class="w-full md:flex">
                    <div class="text-sm">
                        <p class="text-gray-900 leading-none text-center md:text-left">{{ getFirstWord(data.user.name) }}</p>
                        <p class="text-gray-600 text-center mb-2 md:text-left">{{ formateDate(data.created_at) }}</p>
                    </div>
                    <div class="rounded-full h-8 w-8 flex items-center text-center md:ml-auto"
                         v-bind:class="{
                                'bg-green-400' : data.color == 1,
                                'bg-blue-500' : data.color == 2,
                                'bg-red-500' : data.color == 3,
                                'bg-yellow-300' : data.color == 4,
                                'bg-orange-400' : data.color == 5,
                              }"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        name: "account-card",
        props: ['data'],
        methods: {
            editAccount(account){
                this.$emit('editAccount', account);
            },
            deleteAccount(account){
                this.$emit('deleteAccount', account);
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

<style scoped>

</style>
