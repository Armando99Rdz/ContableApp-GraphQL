<template>
    <div>

        <!-- Accounts Carousel -->
        <div class="relative rounded-lg block md:flex items-center bg-gray-100 shadow-xl transform motion-reduce:transform-none
                hover:-translate-y-1 hover:scale-110 transition ease-in-out duration-300" style="min-height: 15rem;">
            <div class="relative w-full md:w-2/5 h-full overflow-hidden rounded-t-lg md:rounded-t-none md:rounded-l-lg"
                    style="min-height: 15rem;">
                <div class="absolute inset-0 w-full h-full opacity-75 transition duration-500 ease-in-out"
                    v-bind:class="{
                    'bg-green-700' : data.color == 1,
                    'bg-blue-800' : data.color == 2,
                    'bg-red-600' : data.color == 3,
                    'bg-yellow-300' : data.color == 4,
                    'bg-orange-500' : data.color == 5,
                    }"
                ></div>
                <div class="absolute inset-0 w-full h-full flex items-center justify-center fill-current text-white px-10">
                    <h4 v-text="data.name" class="text-3xl font-semibold"></h4>
                </div>
            </div>
            <div class="w-full md:w-3/5 h-full flex items-center bg-gray-100 rounded-lg">
                <div class="p-12 md:pr-24 md:pl-16 md:py-12">
                    <div v-text="'$'+data.balance" class="text-gray-600 font-bold text-4xl text-center mb-1 transition duration-500 ease-in-out">$200</div>
                    <p v-text="data.description" class="text-gray-600 text-center break-words transition duration-500 ease-in-out"></p>
                    <a class="flex items-baseline mt-3 transition duration-500 ease-in-out" href="/accounts"
                        v-bind:class="{
                        'text-green-600 hover:text-green-800' : data.color == 1,
                        'text-blue-600 hover:text-blue-800' : data.color == 2,
                        'text-red-600 hover:text-red-800' : data.color == 3,
                        'text-yellow-500 hover:text-yellow-600' : data.color == 4,
                        'text-orange-500 hover:text-orange-600' : data.color == 5,
                        }"
                    >
                        <span v-if="data.showActions" class="flex-none mx-auto text-sm" v-bind:class="{'text-gray-700' : !data.showActions}">{{formateDate(data.created_at)}}</span>
                        <span v-else class="flex-none mx-auto">Ver cuenta <span class="text-xs ml-1">&#x279c;</span></span>
                    </a>
                    <div v-if="data.showActions" class="justify-center mt-4">
                        <button class="bg-gray-200 text-gray-500 hover:bg-indigo-700 hover:text-gray-200 font-bold py-2 px-4 rounded-l"
                        @click="editAccount(data)">
                            Editar
                        </button>
                        <button class="bg-gray-200 text-gray-500 hover:bg-red-700 hover:text-gray-200 font-bold py-2 px-4 rounded-r"
                        @click="deleteAccount(data)">
                            Eliminar
                        </button>
                    </div>
                </div>
                <svg class="hidden md:block absolute inset-y-0 h-full w-24 fill-current text-gray-100 -ml-12" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>
            </div>
            <div v-if="data.showCarouselBottons">
                <button @click="changeCarouselPage(-1)" class="absolute top-0 mt-32 left-0 bg-white rounded-full shadow-md h-12 w-12 text-2xl -ml-6 focus:outline-none focus:shadow-outline transition duration-500 ease-in-out"
                v-bind:class="{
                    'text-green-600 hover:text-green-700' : data.color == 1,
                    'text-blue-600 hover:text-blue-700' : data.color == 2,
                    'text-red-600 hover:text-red-700' : data.color == 3,
                    'text-yellow-400 hover:text-yellow-500' : data.color == 4,
                    'text-orange-500 hover:text-orange-600' : data.color == 5,
                }"
                >
                    <span class="block" style="transform: scale(-1);">&#x279c;</span>
                </button>
                <button @click="changeCarouselPage(1)" class="absolute top-0 mt-32 right-0 bg-white rounded-full shadow-md h-12 w-12 text-2xl -mr-6 focus:outline-none focus:shadow-outline transition duration-500 ease-in-out"
                v-bind:class="{
                    'text-green-600 hover:text-green-700' : data.color == 1,
                    'text-blue-600 hover:text-blue-700' : data.color == 2,
                    'text-red-600 hover:text-red-700' : data.color == 3,
                    'text-yellow-400 hover:text-yellow-500' : data.color == 4,
                    'text-orange-500 hover:text-orange-600' : data.color == 5,
                }"
                >
                    <span class="block" style="transform: scale(1);">&#x279c;</span>
                </button>
            </div>
            
        </div>

        <!---
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
        </div>-->
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
            },
            changeCarouselPage(param){
                this.$emit('changeCarouselPage', param);
            }
        },
    }
</script>

<style scoped>

</style>
