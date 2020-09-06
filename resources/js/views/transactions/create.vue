<template>
    <div>
        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>

        <div v-if="loading" class="mt-20">
            <loading :loading="loading" color="gray"></loading>
        </div>
        <div v-else class="w-full bg-white border-t border-b sm:rounded sm:border shadow">
            <div class="border-b">
                <div class="flex justify-between px-6 -mb-px">
                    <h3 class="text-indigo-700 py-4 font-normal text-lg">Nueva transacción</h3>
                </div>
            </div>
            <div class="w-full text-center">
                <!-- Display Container (not part of component) START -->
                <div class="mx-auto p-10 md:px-64 bg-white">

                    <!-- Carousel Body -->
                    <div class="relative rounded-lg block md:flex items-center bg-gray-100 shadow-xl transition duration-500 ease-in-out" style="min-height: 15rem;">
                        <div class="relative w-full md:w-2/5 h-full overflow-hidden rounded-t-lg md:rounded-t-none md:rounded-l-lg"
                             style="min-height: 15rem;">
                            <div class="absolute inset-0 w-full h-full bg-indigo-900 opacity-75"></div>
                            <div class="absolute inset-0 w-full h-full flex items-center justify-center fill-current text-white px-10">
                                <h4 v-text="currentAccount.name" class="text-3xl font-semibold"></h4>
                            </div>
                        </div>
                        <div class="w-full md:w-3/5 h-full flex items-center bg-gray-100 rounded-lg">
                            <div class="p-12 md:pr-24 md:pl-16 md:py-12">
                                <div v-text="'$'+currentAccount.balance" class="text-gray-600 font-bold text-4xl text-center mb-1">$200</div>
                                <p v-text="currentAccount.description" class="text-gray-600 break-words"></p>
                                <a class="flex items-baseline mt-3 text-indigo-600 hover:text-indigo-800 focus:text-indigo-900" href="/accounts">
                                    <span>Ver cuenta</span>
                                    <span class="text-xs ml-1">&#x279c;</span>
                                </a>
                            </div>
                            <svg class="hidden md:block absolute inset-y-0 h-full w-24 fill-current text-gray-100 -ml-12" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polygon points="50,0 100,0 50,100 0,100" />
                            </svg>
                        </div>
                        <button class="absolute top-0 mt-32 left-0 bg-white rounded-full shadow-md h-12 w-12 text-2xl text-indigo-600 hover:text-indigo-500 focus:text-indigo-500 -ml-6 focus:outline-none focus:shadow-outline">
                            <span class="block" style="transform: scale(-1);">&#x279c;</span>
                        </button>
                        <button class="absolute top-0 mt-32 right-0 bg-white rounded-full shadow-md h-12 w-12 text-2xl text-indigo-600 hover:text-indigo-500 focus:text-indigo-500 -mr-6 focus:outline-none focus:shadow-outline">
                            <span class="block" style="transform: scale(1);">&#x279c;</span>
                        </button>
                    </div>


                </div>
                <!-- Display Container (not part of component) END -->
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
                currentAccount: null
            }
        },
        created() {
            this.getInitialData();
        },
        methods: {
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
                this.currentAccount = this.accounts[0] || null;
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
