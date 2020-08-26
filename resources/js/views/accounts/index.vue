<template>
    <div class="w-full">
        <h2 class="font-semibold text-gray-800">Mis Cuentas</h2>
        <simple-table :headings="headings" :data="accounts"></simple-table>
    </div>
</template>

<script>
    import SimpleTable from '../../components/tables/simple-table';
    import gql from 'graphql-tag'

    export default {
        data(){
            return {
                headings: ['ID', 'Color', 'Nombre', 'Descripción'],
                accounts: [],
            }
        },
        components: {
            SimpleTable
        },
        mounted() {
            this.getAccounts();
        },
        methods: {
            async getAccounts(){
                const response = await this.$apollo.query({
                    query : gql(`
                        {accounts(first: 20) {data {id color name description}}}
                    `)
                });
                this.accounts = response.data.accounts.data.map(item => {
                    return {
                        id: item.id,
                        color: item.color,
                        name: item.name,
                        description: item.description
                    }
                });
            }

        }

    }
</script>

<style scoped>

</style>
