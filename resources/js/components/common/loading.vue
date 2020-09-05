<template>
    <div class="w-full">
        <fade-loader class="custom-class m-auto" :loading="loading" :color="color ? color : 'gray'"
                     :size="size ? size : 15" :sizeUnit="'px'"></fade-loader>
    </div>
</template>

<script>
    import { FadeLoader } from '@saeris/vue-spinners'

    export default {
        components: { FadeLoader },
        name: "loading",
        props: ['loading', 'color', 'size'], // true or false
    }

</script>

<style scoped>

</style>
