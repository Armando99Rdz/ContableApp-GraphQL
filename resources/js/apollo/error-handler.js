/**
 * Manejar los errores de graphql del lado del cliente.
 * Código de @joselfonseca, en base a la doc de apollo:
 * https://www.apollographql.com/docs/react/data/error-handling/
 */

const ErrorHandler = ( {graphQLErrors, networkError} ) => {

    // En caso de haber errores de graphql.
    if (graphQLErrors){
        graphQLErrors.forEach( (err) => { // recorre cada error
            switch (err.extensions.category) { // evalúa la categoria de cada error
                case 'authentication': // error de autenticación
                    localStorage.clear();
                    window.location.href = '/login'; // redirecciona al login
                    break;
                default:
                    console.log(`[GraphQL error]: ${err}`); // imprime el error
            }
        });
    }

    // En caso de error de red. Por lo regular se dá cuando no se
    // tiene conexion a internet o el servidor no está funcionando.
    if(networkError){
        console.log(`[Network error]: ${networkError}`); // imprime el error
    }
    return null;
};

export default ErrorHandler;
