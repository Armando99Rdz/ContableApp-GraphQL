<template>
    <div class="w-full">
        <div class="">
            <h2 class="text-4xl font-medium capitalize text-gray-600">mis cuentas</h2>
            <div class="flex mt-1 mb-4 md:flex items-center justify-between text-gray-600">
                <span class="m-3  md:m-0 block md:flex">
                    Balance total: 
                    <strong class="ml-2">{{ currencyFormatter(generalBalance) }}</strong>
                </span>
                <span class="m-3 md:m-0 block md:flex">
                    Total de cuentas: 
                    <strong v-text="accounts.length" class="ml-2"></strong>
                </span>
                <button class="bg-indigo-700 hover:bg-indigo-800 text-white hover:text-white py-3 px-2 rounded"
                    @click="goToCrateAccount">
                    Nueva cuenta
                </button>
            </div>
        </div>
        <div class="invisible md:visible md:mt-2 md:mb-4 border border-gray-300 transition duration-500
            ease-in-out">
        </div>
        <div v-if="loading" class="mt-20">
            <loading :loading="loading" color="gray"></loading>
        </div>
        <!--<simple-table :headings="headings" :data="accounts"></simple-table>-->
        <div class="w-full flex flex-wrap mt-4 md:mt-0">
            <div v-for="account in accounts" :key="account.id" class="w-full mx-auto md:w-1/2">
                <account-card :data="account" class="py-4 px-4 md:py-5 md:pr-8" @editAccount="editAccount" @deleteAccount="deleteAccount"></account-card>
            </div>
        </div>
    </div>
</template>

<script>
    import SimpleTable from '../../components/tables/simple-table';
    import AccountCard from '../../components/cards/account-card';
    import ACCOUNTS from '../../graphql/accounts/accounts.graphql';
    import DELETE_ACCOUNT from '../../graphql/accounts/delete.graphql';
    import Loading from '../../components/common/loading';
    import currency from 'currency.js';

    export default {
        data(){
            return {
                headings: ['ID', 'Color', 'Nombre', 'Descripción'],
                accounts: [],
                loading: true,
                generalBalance: 0.00,
            }
        },
        components: {
            AccountCard,
            SimpleTable,
            Loading
        },
        mounted() {
            this.getAccounts();
            this.getGeneralBalance();
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
                        user: item.user,
                        showActions: true
                    }
                });
                this.loading = this.$apollo.loading;
            },
            goToCrateAccount(){
                this.$router.push('/accounts/create');
            },
            editAccount(account){
                this.$router.push(`/accounts/${account.id}/edit`);
            },
            deleteAccount(account){
                console.log(account);
                swal({
                    title: "¿Estas seguro?",
                    text: `Quieres eliminar la cuenta ${account.name}, los cambios son irreversibles.`,
                    icon: "warning",
                    dangerMode: true,
                    buttons: ["Cancelar", "Eliminar"],
                }).then( async (willDelete) => {
                    if (willDelete) {
                        const response = await this.$apollo.mutate({
                            mutation: DELETE_ACCOUNT,
                            variables: {
                                id: account.id
                            }
                        });
                        this.getAccounts();
                        swal({
                            title: "Cuenta eliminada",
                            text: "La cuenta ha sido eliminada satisfactoriamente.",
                            icon: "success",
                        });
                    }
                });
            },
            getGeneralBalance(){
                const balance = this.accounts.forEach( (item, index) => {
                    this.generalBalance += item.balance;
                });
            },
            currencyFormatter(value){
                return currency(value).format();
            },

        }

    }
</script>

<style scoped>

</style>
