<template>
    <div class="w-full">
        <div class="flex justify-between px-4 md:px-0">
            <h2 class="font-semibold text-gray-700 mb-4">Mis cuentas</h2>
            <button class="bg-indigo-700 hover:bg-indigo-800 text-white hover:text-white py-1 px-2 rounded"
                @click="goToCrateAccount"
            >
                Nueva cuenta
            </button>
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
            }

        }

    }
</script>

<style scoped>

</style>
