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
                    <account-card :data="accounts[currentAccountIndex]" class="py-4 px-4 md:py-5 md:pr-8" @changeCarouselPage="changeAccount"></account-card>
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
    import AccountCard from '../../components/cards/account-card';

    export default {
        name: "create",
        components: {
            Loading,
            GraphqlErrorToast,
            AccountCard
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
                        description: item.description,
                        showActions: false,
                        showCarouselBottons: true
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
                this.loading = true;
                this.errors = null;
            }
        }
    }
</script>

<style scoped>

</style>
