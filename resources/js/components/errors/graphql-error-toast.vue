<template>
    <div>

    </div>
</template>

<script>
    export default {
        name: 'graphql-error-toast',
        props: ["errors"],
        mounted() {
            const { graphQLErrors } = this.errors;
            graphQLErrors.forEach( (err) => {
                switch (err.extensions.category) { // evalúa la categoria de cada error
                    case 'validation': // errores de validacion
                        let error = '';
                        for (let [key, value] of Object.entries(err.extensions.validation)){ // recorrer cada error de validacion
                            error += `${value}`;
                        }
                        this.$toasted.error(error, {
                            theme: "bubble",
                            position: "top-right",
                            duration : 5000
                        });
                        break;
                    default:
                        console.log(`[GraphQL error]: ${error}`); // imprime el error
                }
            });
        }
    }
</script>

<style scoped>

</style>
