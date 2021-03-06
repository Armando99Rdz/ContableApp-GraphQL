/**
 * Creación del Cliente Apollo
 * para consultar el GraphQL API
 */

import ApolloClient from 'apollo-boost';
import ErrorHandler from "./error-handler";

const apolloClient = new ApolloClient({
    // URL donde está el GraphQL API, para este caso esta en el mismo servidor, por tanto:
    uri: '/graphql',
    headers: {
        // obtener el csrf token de laravel desde el <head> para enviarlo en cada request.
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        // para que mi apollo client actúe como un http client.
        'X-Requested-With': 'XMLHttpRequest',
    },
    onError: ErrorHandler
});

apolloClient.defaultOptions = {
    watchQuery: {
        fetchPolicy: 'network-only',
    },
    query: {
        fetchPolicy: 'network-only',
    }
};

export default apolloClient;
