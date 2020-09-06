<template>
    <div class="w-full bg-white rounded-md overflow-hidden border-t border-b sm:border-l sm:border-r sm:rounded shadow">

        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>

        <div class="border-b">
            <div class="flex justify-between px-6 -mb-px">
                <h3 class="text-indigo-700 py-4 font-normal text-lg">Editar categoría</h3>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 px-12 py-6 mt-5">
            <label class="block text-gray-600 text-sm font-bold mb-2" for="name">
                Nombre de la categoría
            </label>
            <input v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3
                text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="">

            <div v-if="loading" class="mt-5 w-full">
                <loading :loading="loading" :size="10"></loading>
            </div>
            <div v-else class="w-full text-center mt-5">
                <a href="/categories" class="bg-transparent hover:bg-gray-400 bg-gray-300 font-semibold text-gray-800
                    py-2 px-4 rounded mt-4">Cancelar</a>
                <button class="bg-transparent hover:bg-indigo-800 bg-indigo-700 font-semibold text-white py-2 px-4
                    rounded mt-4" @click="submit">Editar categoría</button>
            </div>
        </div>

    </div>
</template>

<script>
    import GET_CATEGORY from '../../graphql/categories/category.graphql';
    import UPDATE_CATEGORY from '../../graphql/categories/update.graphql';
    import GraphqlErrorToast from '../../components/errors/graphql-error-toast';
    import Loading from '../../components/common/loading';
    export default {
        components: { GraphqlErrorToast, Loading },
        data(){
            return {
                category: null,
                form: {
                    name: null
                },
                errors: null,
                loading: false
            }
        },
        created(){
            this.getCategory();
        },
        methods:{
            async getCategory(){
                this.loading = true;
                try{
                    const response = await this.$apollo.query({
                       query: GET_CATEGORY,
                       variables: {
                           id: this.$route.params.id
                       }
                    });
                    this.loading = false;
                    this.category = response.data.category;
                    this.form.name = response.data.category.name;
                }catch (e) {
                    console.log(e);
                }
            },
            async submit(){
                this.loading = true;
                this.errors = null;
                try{
                    const response = await this.$apollo.mutate({
                        mutation: UPDATE_CATEGORY,
                        variables: {
                            id: this.category.id,
                            input: {
                                name: this.form.name
                            }
                        }
                    });
                    this.loading = false;
                    if( response.data ){
                        return this.$router.push('/categories');
                    }
                }catch (error) {
                    this.errors = error;
                    this.loading = false;
                }
            }
        }
    }
</script>

<style scoped>

</style>
