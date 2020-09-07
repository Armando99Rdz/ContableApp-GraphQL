
<template>
    <div>
        <h2 class="text-4xl font-medium capitalize text-gray-600">transacciones</h2>
        <div class="mt-1 mb-4 md:flex items-center justify-between text-gray-600">
            <span class="m-3  md:m-0 block md:flex">
                Balance total:
                <strong class="ml-2">$710.180</strong>
            </span>
            <span class="m-3 md:m-0 block md:flex">
                Total de transacciones:
                <strong class="ml-2">46</strong>
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
        <div class="flex flex-col mt-2">
            <div class="flex flex-row mt-2 px-5 md:px-0 md:border md:border-gray-300 md:shadow-md">
                <!-- card -->
                <TransactionCard v-for="tr in transactions" :key="tr.id" :data="tr"></TransactionCard>

            </div>

        </div>
    </div>
</template>

<script>

    import gql from 'graphql-tag'
    import TransactionCard from '../../components/cards/transaction-card';

    export default {
        components: [
            TransactionCard
        ],
        mounted() {
        },
        data(){
            return {
                transactions: [],
            }
        },
        methods: {
            goToCreateTransaction(){
                this.$router.push('/transactions/create')
            }
        }
    }

</script>


<style scoped>

</style>
