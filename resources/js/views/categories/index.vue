<template>
    <div class="w-full">
        <div class="w-full bg-white rounded-md overflow-hidden border-t border-b sm:border-l sm:border-r sm:rounded shadow">

            <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>
            <div class="border-b p-6">
                <div class="flex flex-wrap px-6 -mb-px">
                    <h3 class="text-indigo-700 py-2 font-normal text-lg">Listado de categorías</h3>
                    <button class="bg-transparent bg-indigo-700 text-white py-2 px-2
                        border hover:bg-indigo-800 hover:border-transparent rounded ml-auto"
                        @click="goToCrateCategory"
                    >
                        Nueva categoría
                    </button>
                </div>
            </div>

            <div class="-mx-3 px-12 py-4">
                <div v-if="loading" class="mt-20">
                    <loading :loading="loading" color="gray"></loading>
                </div>
                <div v-else>
                    <simple-table :headings="headings" :data="categories"
                                @editRecord="editRecord"
                                @deleteRecord="deleteRecord"
                    >
                    </simple-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SimpleTable from '../../components/tables/simple-table';
    import CATEGORIES from '../../graphql/categories/categories.graphql';
    import DELETE_CATEGORY from '../../graphql/categories/delete.graphql';
    import Loading from '../../components/common/loading';

    export default {
        data(){
            return {
                headings: ['ID', 'Nombre'],
                categories: [],
                loading: true,
                errors: null
            }
        },
        components: {
            SimpleTable,
            Loading
        },
        mounted() {
            this.getCategories();
        },
        methods: {
            async getCategories(){
                const response = await this.$apollo.query({
                    query: CATEGORIES,
                    variables: {
                        first: 20,
                        page: 1
                    }
                });
                this.categories = response.data.categories.data.map(item => {
                    return {
                        id: item.id,
                        name: item.name,
                    }
                });
                this.loading = this.$apollo.loading;
            },
            goToCrateCategory(){
                this.$router.push('/categories/create');
            },
            editRecord(category){
                this.$router.push(`/categories/${category.id}/edit`);
            },
            deleteRecord(data){
                console.log(data);
                swal({
                    title: "¿Estas seguro?",
                    text: `Quieres eliminar la categoria ${data.name}, los cambios son irreversibles.`,
                    icon: "warning",
                    dangerMode: true,
                    buttons: ["Cancelar", "Eliminar"],
                }).then( async (willDelete) => {
                    if (willDelete) {
                        const response = await this.$apollo.mutate({
                            mutation: DELETE_CATEGORY,
                            variables: {
                                id: data.id
                            }
                        });
                        this.getCategories();
                        swal({
                            title: "Categoría eliminada",
                            text: "La categoría ha sido eliminada satisfactoriamente.",
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
