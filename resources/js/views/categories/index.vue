<template>
    <div class="w-full">

        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>

        <!-- header -->
        <div class="">
            <h2 class="text-4xl font-medium capitalize text-gray-600">mis cuentas</h2>
            <div class="flex mt-1 mb-4 md:flex items-center justify-between text-gray-600">
                <span class="m-3 md:m-0 block md:flex">
                    Total de categorías: 
                    <strong v-text="categories.length" class="ml-2"></strong>
                </span>
                <button class="bg-indigo-700 hover:bg-indigo-800 text-white hover:text-white py-3 px-2 rounded"
                    @click="goToCrateCategory">
                    Nueva categoría
                </button>
            </div>
        </div>

        <!-- divider -->
        <div class="invisible md:visible md:mt-2 md:mb-4 border border-gray-300 transition duration-500
            ease-in-out">
        </div>

        <!-- content / table -->
        <div class="w-full">
            
            <div class="-mx-3 ">
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
