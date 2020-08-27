<template>
    <div>
        <div class="max-w-sm rounded overflow-hidden shadow-lg transform motion-reduce:transform-none
                hover:-translate-y-1 hover:scale-110 transition ease-in-out duration-300">
            <div class="bg-white rounded lg:rounded-none lg:rounded p-5 flex flex-col justify-between leading-normal">
                <div class="inline-flex justify-center">
                    <button class="bg-gray-100 text-gray-500 hover:bg-blue-700 hover:text-gray-200 font-bold py-2 px-4 rounded-l">
                        Editar
                    </button>
                    <button class="bg-gray-100 text-gray-500 hover:bg-red-700 hover:text-gray-200 font-bold py-2 px-4 rounded-r">
                        Eliminar
                    </button>
                </div>
                <div class="mb-4 flex">
                    <div class="w-full">
                        <div class="text-gray-900 font-bold text-3xl text-center">{{data.name}}</div>
                        <div class="text-gray-500 font-bold text-4xl text-center">${{data.balance}}</div>
                        <p class="text-gray-700 text-base text-center">{{data.description}}</p>
                    </div>

                </div>
                <div class="max-w-sm md:flex">
                    <div class="text-sm">
                        <p class="text-gray-900 leading-none">por {{data.user.name}}</p>
                        <p class="text-gray-600">{{data.created_at}}</p>
                    </div>
                    <div class="rounded-full h-8 w-8 flex items-center md:ml-auto"
                         v-bind:class="{
                                'bg-green-400' : data.color[1] == 1,
                                'bg-blue-500' : data.color[1] == 2,
                                'bg-red-500' : data.color[1] == 3,
                                'bg-yellow-400' : data.color[1] == 4,
                                'bg-orange-400' : data.color[1] == 5,
                              }"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "account-card",
        props: ['data'],

    }
</script>

<style scoped>

</style>
