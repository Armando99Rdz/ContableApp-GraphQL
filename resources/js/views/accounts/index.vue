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
        <div v-if="loading" class="mt-20">
            <loading :loading="loading" color="gray"></loading>
        </div>
        <!--<simple-table :headings="headings" :data="accounts"></simple-table>-->
        <div class="w-full h-full flex flex-wrap">
            <div v-for="account in accounts" class="sm:w-2/2 w-1/2">
                <account-card :data="account" class="py-5 pr-5" @editAccount="editAccount" @deleteAccount="deleteAccount"></account-card>
            </div>
        </div>
    </div>
</template>

<script>
    import SimpleTable from '../../components/tables/simple-table';
    import AccountCard from '../../components/cards/account-card';
    //import gql from 'graphql-tag'
    import ACCOUNTS from '../../graphql/accounts/accounts.graphql';
    import DELETE_ACCOUNT from '../../graphql/accounts/delete.graphql';
    import Loading from '../../components/common/loading';

    export default {
        data(){
            return {
                headings: ['ID', 'Color', 'Nombre', 'Descripción'],
                accounts: [],
                loading: true,
            }
        },
        components: {
            AccountCard,
            SimpleTable,
            Loading
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
            }

        }

    }
</script>

<style scoped>

</style>
