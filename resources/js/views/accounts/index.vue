<template>
    <div class="w-full">
        <div class="flex justify-between">
            <h2 class="font-semibold text-gray-800 mb-4">Mis Cuentas</h2>
            <button class="bg-transparent hover:bg-blue-700 text-blue-700 font-semibold hover:text-white py-1 px-2
                border border-blue-700 hover:border-transparent rounded"
                @click="goToCrateAccount"
            >
                Nueva cuenta
            </button>
        </div>
        <!--<simple-table :headings="headings" :data="accounts"></simple-table>-->
        <div class="w-full h-full flex flex-wrap">
            <div v-for="account in accounts" class="sm:w-2/2 w-1/2">
                <account-card :data="account" class="py-5 pr-5"></account-card>
            </div>
        </div>
    </div>
</template>

<script>
    import SimpleTable from '../../components/tables/simple-table';
    import AccountCard from '../../components/cards/account-card';
    //import gql from 'graphql-tag'
    import ACCOUNTS from '../../graphql/accounts/accounts.graphql';

    export default {
        data(){
            return {
                headings: ['ID', 'Color', 'Nombre', 'Descripción'],
                accounts: [],
            }
        },
        components: {
            AccountCard,
            SimpleTable
        },
        mounted() {
            this.getAccounts();
        },
        methods: {
            async getAccounts(){
                const response = await this.$apollo.query({
                    query: ACCOUNTS,
                    variables: {
                        first: 20,
                        page: 1
                    }
                });
                this.accounts = response.data.accounts.data.map(item => {
                    return {
                        id: item.id,
                        color: item.color,
                        name: item.name,
                        balance: item.balance,
                        description: item.description,
                        created_at: item.created_at,
                        user: item.user
                    }
                });
            },
            goToCrateAccount(){
                this.$router.push('/accounts/create');
            }

        }

    }
</script>

<style scoped>

</style>
