<template>
    <div class="w-full bg-white rounded-md overflow-hidden border-t border-b sm:border-l sm:border-r sm:rounded shadow">

        <graphql-error-toast v-if="this.errors" :errors="this.errors"></graphql-error-toast>
        
        <div class="border-b">
            <div class="flex justify-start px-6 -mb-px">
                <div class="rounded-lg h-8 w-8 flex items-center mr-2 my-auto"
                    v-bind:class="{
                        'bg-green-400' : form.color === 1,
                        'bg-blue-500' : form.color === 2,
                        'bg-red-500' : form.color === 3,
                        'bg-yellow-200' : form.color === 4,
                        'bg-orange-400' : form.color === 5,
                    }"
                ></div>
                <h3 class="text-indigo-700 py-4 font-normal text-lg md:ml-1">Nueva cuenta</h3>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 p-12">
            <div class="w-full md:w-1/2 px-3 mb-6">
                <label class="block text-gray-600 text-sm font-bold mb-2" for="name">
                    Nombre de la cuenta
                </label>
                <input v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3
                text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="">
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6">
                <label class="block text-gray-600 text-sm font-bold mb-2" for="balance">
                    Balance inicial
                </label>
                <input v-model="form.balance" class="shadow appearance-none border rounded w-full py-2 px-3
                text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="balance" type="number" min="0" value="0.0">
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6">
                <label class="block text-gray-600 text-sm font-bold mb-2" for="description">
                    Descripción
                </label>
                <input v-model="form.description" class="shadow appearance-none border rounded w-full py-2 px-3
                text-gray-700 leading-tight
                focus:outline-none focus:shadow-outline" id="description" type="text" placeholder="">
            </div>
            <div class="w-full md:w-1/2 px-3 mb-3">
                <label class="block text-gray-600 text-sm font-bold mb-2">
                    Color
                </label>
                <div class="inline-flex">
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-2 text-sm font-semibold text-gray-700
                        mr-2 mb-2 hover:bg-green-500 hover:text-gray-100 cursor-pointer"
                          v-bind:class="{'bg-green-500' : form.color === 1}" @click="setColor(1)">Verde</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-2 text-sm font-semibold text-gray-700
                        mr-2 mb-2 hover:bg-blue-500 hover:text-gray-100 cursor-pointer"
                          v-bind:class="{'bg-blue-500' : form.color === 2}" @click="setColor(2)">Azul</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-2 text-sm font-semibold text-gray-700
                        mr-2 mb-2 hover:bg-red-500 hover:text-gray-100 cursor-pointer"
                          v-bind:class="{'bg-red-500' : form.color === 3}" @click="setColor(3)">Rojo</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-2 text-sm font-semibold text-gray-700
                        mr-2 mb-2 hover:bg-yellow-200 hover:text-gray-700 cursor-pointer"
                          v-bind:class="{'bg-yellow-200' : form.color === 4}" @click="setColor(4)">Amarillo</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-2 text-sm font-semibold text-gray-700
                        mr-2 mb-2 hover:bg-orange-400 hover:text-gray-100 cursor-pointer"
                          v-bind:class="{'bg-orange-400' : form.color === 5}" @click="setColor(5)">Naranja</span>
                </div>
            </div>
            <div v-if="loading" class="mt-5 w-full">
                <loading :loading="loading" :size="10"></loading>
            </div>
            <div v-else class="w-full text-center">
                <a href="/accounts" type="reset" class="bg-transparent hover:bg-gray-400 bg-gray-300 font-semibold text-gray-800
                    py-2 px-4 rounded mt-4 cursor-pointer">Cancelar</a>
                <button class="bg-transparent hover:bg-indigo-800 bg-indigo-700 font-semibold text-white py-2 px-4
                    rounded mt-4" @click="submit">Crear cuenta</button>
            </div>
        </div>

    </div>
</template>

<script>

    import CREATE_ACCOUNT from '../../graphql/accounts/create-account.graphql';
    import GraphqlErrorToast from '../../components/errors/graphql-error-toast';
    import Loading from '../../components/common/loading';

    export default {
        components: { GraphqlErrorToast, Loading },
        data(){
            return {
                form: {
                    name: null,
                    balance: 0.0,
                    color: 1,
                    description: null
                },
                errors: null,
                loading: false
            }
        },
        methods:{
            setColor(numColor){
                if (numColor === 1) this.form.color = 1;
                if (numColor === 2) this.form.color = 2;
                if (numColor === 3) this.form.color = 3;
                if (numColor === 4) this.form.color = 4;
                if (numColor === 5) this.form.color = 5;
            },
            async submit(){
                this.loading = true;
                this.errors = null;
                try{
                    const response = await this.$apollo.mutate({
                        mutation: CREATE_ACCOUNT,
                        variables: {
                            input: {
                                name: this.form.name,
                                balance: this.form.balance,
                                color: this.form.color,
                                description: this.form.description
                            }
                        }
                    });
                    this.loading = false;
                    if( response.data ){
                        return this.$router.push('/accounts');
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
