<template>
    <div>
        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>

        <div v-if="loading" class="mt-20">
            <loading :loading="loading" color="gray"></loading>
        </div>
        <div v-else class="w-full bg-white p-12 rounded-md overflow-hidden shadow-lg">

        </div>
    </div>
</template>

<script>
    import GET_TRANSACTION_INITAL_DATA from '../../graphql/transactions/create-inital-data.graphql';
    import Loading from '../../components/common/loading';
    import GraphqlErrorToast from '../../components/errors/graphql-error-toast';

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
                    }
                });
                this.categories = response.data.categories.data.map(item => {
                    return {
                        id: item.id,
                        name: item.name
                    }
                });
                this.loading = this.$apollo.loading;
            },
        }
    }
</script>

<style scoped>

</style>
