/**
 * Creación del Cliente Apollo
 * para consultar el GraphQL API
 */

import ApolloClient from 'apollo-boost';

const apolloClient = new ApolloClient({
    // URL donde está el GraphQL API, para este caso esta en el mismo servidor, por tanto:
    uri: '/graphql',
    headers: {
        // obtener el csrf token de laravel desde el <head> para enviarlo en cada request.
        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
        // para que mi apollo client actúe como un http client.
        'X-Requested-With': 'XMLHttpRequest',
    }
});

export default apolloClient;
