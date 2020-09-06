<template>
    <div>
        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>

        <div v-if="loading" class="mt-20">
            <loading :loading="loading" color="gray"></loading>
        </div>
        <div v-else class="w-full bg-white border-tborder-b sm:rounded sm:border shadow">
            <div class="border-b">
                <div class="flex justify-between px-6 -mb-px">
                    <h3 class="text-indigo-700 py-4 font-normal text-lg">Nueva transacción</h3>
                </div>
            </div>
            <div class="w-full text-center">
                <!-- Display Container (not part of component) START -->
                <div class="mx-auto p-10 md:px-64 bg-gray-200">

                    <!-- Accounts Carousel -->
                    <div class="relative rounded-lg block md:flex items-center bg-gray-100 shadow-xl" style="min-height: 15rem;">
                        <div class="relative w-full md:w-2/5 h-full overflow-hidden rounded-t-lg md:rounded-t-none md:rounded-l-lg"
                             style="min-height: 15rem;">
                            <div class="absolute inset-0 w-full h-full opacity-75 transition duration-500 ease-in-out"
                                v-bind:class="{
                                'bg-green-700' : accounts[currentAccountIndex].color == 1,
                                'bg-blue-800' : accounts[currentAccountIndex].color == 2,
                                'bg-red-600' : accounts[currentAccountIndex].color == 3,
                                'bg-yellow-300' : accounts[currentAccountIndex].color == 4,
                                'bg-orange-500' : accounts[currentAccountIndex].color == 5,
                              }"
                            ></div>
                            <div class="absolute inset-0 w-full h-full flex items-center justify-center fill-current text-white px-10">
                                <h4 v-text="accounts[currentAccountIndex].name" class="text-3xl font-semibold"></h4>
                            </div>
                        </div>
                        <div class="w-full md:w-3/5 h-full flex items-center bg-gray-100 rounded-lg">
                            <div class="p-12 md:pr-24 md:pl-16 md:py-12">
                                <div v-text="'$'+accounts[currentAccountIndex].balance" class="text-gray-600 font-bold text-4xl text-center mb-1 transition duration-500 ease-in-out">$200</div>
                                <p v-text="accounts[currentAccountIndex].description" class="text-gray-600 break-words transition duration-500 ease-in-out"></p>
                                <a class="flex items-baseline mt-3 transition duration-500 ease-in-out" href="/accounts"
                                    v-bind:class="{
                                    'text-green-600 hover:text-green-800' : accounts[currentAccountIndex].color == 1,
                                    'text-blue-600 hover:text-blue-800' : accounts[currentAccountIndex].color == 2,
                                    'text-red-600 hover:text-red-800' : accounts[currentAccountIndex].color == 3,
                                    'text-yellow-500 hover:text-yellow-600' : accounts[currentAccountIndex].color == 4,
                                    'text-orange-500 hover:text-orange-600' : accounts[currentAccountIndex].color == 5,
                                    }"
                                >
                                    <span>Ver cuenta</span>
                                    <span class="text-xs ml-1">&#x279c;</span>
                                </a>
                            </div>
                            <svg class="hidden md:block absolute inset-y-0 h-full w-24 fill-current text-gray-100 -ml-12" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polygon points="50,0 100,0 50,100 0,100" />
                            </svg>
                        </div>
                        <button @click="changeAccount(-1)" class="absolute top-0 mt-32 left-0 bg-white rounded-full shadow-md h-12 w-12 text-2xl -ml-6 focus:outline-none focus:shadow-outline transition duration-500 ease-in-out"
                        v-bind:class="{
                            'text-green-600 hover:text-green-700' : accounts[currentAccountIndex].color == 1,
                            'text-blue-600 hover:text-blue-700' : accounts[currentAccountIndex].color == 2,
                            'text-red-600 hover:text-red-700' : accounts[currentAccountIndex].color == 3,
                            'text-yellow-400 hover:text-yellow-500' : accounts[currentAccountIndex].color == 4,
                            'text-orange-500 hover:text-orange-600' : accounts[currentAccountIndex].color == 5,
                        }"
                        >
                            <span class="block" style="transform: scale(-1);">&#x279c;</span>
                        </button>
                        <button @click="changeAccount(1)" class="absolute top-0 mt-32 right-0 bg-white rounded-full shadow-md h-12 w-12 text-2xl -mr-6 focus:outline-none focus:shadow-outline transition duration-500 ease-in-out"
                        v-bind:class="{
                            'text-green-600 hover:text-green-700' : accounts[currentAccountIndex].color == 1,
                            'text-blue-600 hover:text-blue-700' : accounts[currentAccountIndex].color == 2,
                            'text-red-600 hover:text-red-700' : accounts[currentAccountIndex].color == 3,
                            'text-yellow-400 hover:text-yellow-500' : accounts[currentAccountIndex].color == 4,
                            'text-orange-500 hover:text-orange-600' : accounts[currentAccountIndex].color == 5,
                        }"
                        >
                            <span class="block" style="transform: scale(1);">&#x279c;</span>
                        </button>
                    </div>
                    <p class="text-gray-600 text-xs italic mt-8">Seleccione una cuenta para la transacción.</p>

                </div>
                <!-- Display Container (not part of component) END -->
                <form class="w-full px-6 md:px-60 mx-auto mt-8">
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                            Monto
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-city" type="number" placeholder="$200">
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                            Tipo
                        </label>
                        <div class="relative">
                            <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                <option>Ingreso</option>
                                <option>Gasto</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                            Descripción
                        </label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="description" type="text" placeholder="Detalles de la transacción">
                        </div>
                    </div>
                    <div class="w-full my-10">
                        <button @click="submit" class="bg-indigo-700 hover:bg-indigo-800 text-white font-bold py-3 px-4 rounded">
                            Crear transacción  
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import GET_TRANSACTION_INITAL_DATA from '../../graphql/transactions/create-inital-data.graphql';
    import Loading from '../../components/common/loading';
    import GraphqlErrorToast from '../../components/errors/graphql-error-toast';
    import CREATE_CATEGORY from "../../graphql/categories/create.graphql";

    export default {
        name: "create",
        components: {
            Loading,
            GraphqlErrorToast
        },
        data(){
            return {
                loading: true,
                accounts: [],
                categories: [],
                errors: null,
                form: {
                    account_id: null,
                    category_id: null,
                    type: 'INCOME', // por defecto sera ingreso
                    ammount: 0
                },
                currentAccountIndex: 0
            }
        },
        created() {
            this.getInitialData();
        },
        methods: {
            changeAccount(param){
                if(param == 1){
                    if(this.currentAccountIndex >= (this.accounts.length - 1))
                        this.currentAccountIndex = 0;
                    else
                        this.currentAccountIndex++;    
                }else{
                    if(this.currentAccountIndex <= 0)
                        this.currentAccountIndex = this.accounts.length - 1;
                    else
                        this.currentAccountIndex--;    
                }
            },
            async getInitialData(){
                const response = await this.$apollo.query({
                    query: GET_TRANSACTION_INITAL_DATA
                });
                this.accounts = response.data.accounts.data.map(item => {
                    return {
                        id: item.id,
                        name: item.name,
                        balance: item.balance,
                        color: item.color,
                        description: item.description
                    }
                });
                //this.currentAccount = this.accounts[0] || null;
                this.categories = response.data.categories.data.map(item => {
                    return {
                        id: item.id,
                        name: item.name
                    }
                });
                this.loading = this.$apollo.loading;
            },
            submit(){
                console.log('submit');
                this.loading = true;
                this.errors = null;
            }
        }
    }
</script>

<style scoped>

</style>
