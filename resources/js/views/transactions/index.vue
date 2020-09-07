
<template>
    <div>
        <h2 class="text-4xl font-medium capitalize text-gray-600 ml-2 md:ml-0">transacciones</h2>
        <div class="mt-1 mb-4 md:flex items-center justify-between text-gray-600">
            <span class="m-3 md:m-0 block md:flex">
                Transacciones totales:
                <strong class="ml-2">{{transactions.length}}</strong>
            </span>
            <div class="flex items-center select-none pl-3 md:pl-0">
                <button @click="goToCreateTransaction" class="bg-indigo-700 hover:bg-indigo-800 text-white hover:text-white py-3 px-2 rounded">
                    Nueva transacción
                </button>
            </div>
        </div>

        <div class="border border-gray-300 transition duration-500
            ease-in-out">
        </div>
        <div class="flex flex-col mt-4">
            <div class="px-5 md:px-0">
                <!-- card -->
                <transaction-card v-for="tr in transactions" :key="tr.id" :data="tr"></transaction-card>

            </div>

        </div>
    </div>
</template>

<script>

    import gql from 'graphql-tag';
    import TRANSACTIONS from '../../graphql/transactions/transactions.graphql';
    import TransactionCard from '../../components/cards/transaction-card';

    export default {
        components: {
            TransactionCard
       },
        mounted() {
            this.getTransactions();
        },
        data(){
            return {
                transactions: [],
                loading: true,
            }
        },
        methods: {
            goToCreateTransaction(){
                this.$router.push('/transactions/create');
            },
            async getTransactions(){
                const response = await this.$apollo.query({
                    query: TRANSACTIONS,
                    variables: {
                        first: 20,
                        page: 1
                    }
                });
                this.transactions = response.data.transactions.data.map(item => {
                    return {
                        id: item.id,
                        amount: item.amount,
                        type: item.type,
                        description: item.description,
                        account: item.account,
                        category: item.category,
                        created_at: item.created_at
                    }
                });
                this.loading = this.$apollo.loading;
            }
        }
    }

</script>


<style scoped>

</style>
