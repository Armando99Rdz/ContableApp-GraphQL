<template>
<div>
    <div v-if="loading" class="mt-20">
        <loading :loading="loading" color="gray"></loading>
    </div>
    <div v-else>
        <div class="bg-white border-t border-b sm:border-l sm:border-r sm:rounded shadow mb-6">
            <div class="border-b px-6">
                <div class="flex justify-between -mb-px">
                    <div class="lg:hidden text-blue-dark py-4 text-lg">
                        Resumen
                    </div>
                    <div class="hidden lg:flex w-full">
                        <div class="appearance-none py-4 text-gray-600 w-full">
                            Balance General &middot; {{ currencyFormatter(generalBalance) }} MXN
                        </div>
                        <div class="mr-2 lg:flex w-full">
                            <div class="appearance-none py-4 text-gray-500 border-b border-transparent hover:border-grey-dark mr-8 ml-auto">
                                $1 USD &middot; {{ currencyFormatter(dollarValue) }} MXN
                            </div>
                            <div class="appearance-none py-4 text-gray-500 border-b border-transparent hover:border-grey-dark mr-8">
                                $1 EUR &middot; {{currencyFormatter(euroValue)}} MXN
                            </div>
                            <div class="appearance-none py-4 text-gray-500 border-b border-transparent hover:border-grey-dark mr-8">
                                $1 CAD &middot; {{ currencyFormatter(canadianValue) }} MXN
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center px-6 lg:hidden">
                <div class="flex-grow flex-no-shrink py-6">
                    <div class="mb-2">
                        <span class="text-3xl align-top text-gray-500">MXN$</span>
                        <span class="text-5xl text-gray-500">{{ currencyFormatter(generalBalance) }}</span>
                    </div>
                    <div class="text-sm text-green-500">
                    &uarr; MXN${{currencyFormatter(lastMonthIncomes)}} (Ingresos)
                    </div>
                </div>
            </div>
            <div class="hidden lg:flex">
                <div class="w-1/3 text-center py-8">
                    <div class="border-r">
                    <div class="text-gray-600 mb-2">
                        <span class="text-3xl align-top">MXN$</span>
                        <span class="text-5xl">{{ currencyFormatter(generalBalance) }}</span>
                    </div>
                    <div class="text-sm uppercase text-gray-500 tracking-wide">
                        Balance general
                    </div>
                    </div>
                </div>
                <div class="w-1/3 text-center py-8">
                    <div class="border-r">
                    <div class="text-gray-600 mb-2">
                        <span class="text-3xl align-top"><span class="text-green-500 align-top">+</span>MXN$</span>
                        <span class="text-5xl">{{currencyFormatter(lastMonthIncomes)}}</span>
                    </div>
                    <div class="text-sm uppercase text-gray-500 tracking-wide">
                        Ingresos en último mes
                    </div>
                    </div>
                </div>
                <div class="w-1/3 text-center py-8">
                    <div>
                    <div class="text-gray-600 mb-2">
                        <span class="text-3xl align-top"><span class="text-red-600 align-top">-</span>MXN$</span>
                        <span class="text-5xl">{{currencyFormatter(lastMonthExpenses)}}</span>
                    </div>
                    <div class="text-sm uppercase text-gray-500 tracking-wide">
                        Gastos en el último mes
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap -mx-4">
            <div class="w-full mb-6 lg:mb-0 lg:w-1/2 px-4 flex flex-col">
                <div class="flex-grow flex flex-col bg-white border-t border-b sm:rounded sm:border shadow overflow-hidden">
                    <div class="border-b">
                        <div class="flex justify-between px-6 -mb-px">
                            <h3 class="text-indigo-700 py-4 font-normal text-lg">Mis Cuentas</h3>
                            <div class="flex">
                                <div class="appearance-none py-4 text-gray-600 border-b border-indigo-700 mr-3">
                                    {{accounts.length}} cuentas
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-if="accounts.length <= 0" class="text-center px-6 py-4">
                        <div class="py-8">
                            <div class="mb-4">
                                <svg class="inline-block h-16 w-16 fill-current mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18 8H5.5v-.5l11-.88v.88H18V6c0-1.1-.891-1.872-1.979-1.717L5.98 5.717C4.891 5.873 4 6.9 4 8v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2zm-1.5 7.006a1.5 1.5 0 1 1 .001-3.001 1.5 1.5 0 0 1-.001 3.001z" fill-rule="nonzero"/></svg>
                            </div>
                            <p class="text-2xl text-gray-700 font-medium mb-4">Registra una cuenta</p>
                            <p class="text-gray-500 max-w-xs mx-auto mb-6">Registra tu primer cuenta para comenzar a realizar transacciones.</p>
                            <div>
                                <a href="/accounts/create" class="bg-indigo-700 hover:bg-indigo-800 text-white border border-indigo-900 rounded px-6 py-3">
                                    Registrar una cuenta
                                </a>
                            </div>
                        </div>
                    </div>
                    <div v-else v-for="account in accounts.slice(0, 3).reverse()" :key="account.id" class="flex px-6 py-6 text-grey-darker items-center border-b">
                        <div class="w-2/5 xl:w-2/4 px-4 flex items-center max-h-16">
                            <div class="rounded-lg h-8 w-8 flex items-center mr-3 my-auto"
                                v-bind:class="{
                                    'bg-green-400' : account.color == 1,
                                    'bg-blue-500' : account.color == 2,
                                    'bg-red-500' : account.color == 3,
                                    'bg-yellow-200' : account.color == 4,
                                    'bg-orange-400' : account.color == 5,
                                }"
                            ></div>
                            <span class="text-lg text-gray-700">{{account.name}}</span>
                        </div>
                        <div class="flex w-3/5 md:w/12">
                            <div class="w-1/2 px-4 text-gray-500">
                                <div class="text-right">
                                    {{formateDate(account.created_at)}}
                                </div>
                            </div>
                            <div class="w-1/2 px-4">
                                <div class="text-right text-gray-700" v-bind:class="{ 'text-red-700': account.balance <= 0 }">
                                    {{currencyFormatter(account.balance)}} MXN
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="accounts.length > 0" class="px-6 py-4 mt-auto">
                        <div class="text-center text-indigo-700 font-medium">
                            <a href="/accounts">Ir a mis cuentas</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/2 px-4">
                <div class="bg-white border-t border-b sm:rounded sm:border shadow">
                    <div class="border-b">
                        <div class="flex justify-between px-6 -mb-px">
                            <h3 class="text-indigo-700 py-4 font-normal text-lg">Actividad reciente</h3>
                        </div>
                    </div>
                    <div>
                        <div v-if="transactions.length <= 0" class="text-center px-6 py-4">
                            <div class="py-8">
                                <div class="mb-4">
                                    <svg class="inline-block h-16 w-16 fill-current mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8 7h10V5l4 3.5-4 3.5v-2H8V7zm-6 8.5L6 12v2h10v3H6v2l-4-3.5z" fill-rule="nonzero"/></svg> 
                                </div>
                                <p class="text-2xl text-gray-700 font-medium mb-4">Sin transacciones todavía</p>
                                <p class="text-gray-500 max-w-xs mx-auto mb-6">Esto parece estar muy vacío, registra unas cuantas transacciones.</p>
                                <div>
                                    <a href="/transactions/create" class="bg-indigo-700 hover:bg-indigo-800 text-white border border-indigo-900 rounded px-6 py-3">
                                        Registrar transacción
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div v-for="transaction in transactions.slice(0, 3).reverse()" :key="transaction.id" class="flex-grow flex px-6 py-6 text-grey-darker items-center border-b">
                            <div class="w-2/5 xl:w-2/5 px-4 flex items-center">
                                <span class="text-lg text-gray-700">{{formateExactDate(transaction.created_at)}}</span>
                            </div>
                            <div class="flex w-3/5 md:w/12">
                                <div class="w-1/2 pr-3 text-gray-700 flex items-center break-words">
                                    <div class="rounded-full h-4 w-4 flex items-center mr-3 my-auto"
                                        v-bind:class="{
                                            'bg-green-400' : transaction.account.color == 1,
                                            'bg-blue-500' : transaction.account.color == 2,
                                            'bg-red-500' : transaction.account.color == 3,
                                            'bg-yellow-200' : transaction.account.color == 4,
                                            'bg-orange-400' : transaction.account.color == 5,
                                        }"
                                    ></div>
                                    {{transaction.account.name}}
                                </div>
                                <div class="w-1/2 pl-1 pr-3">
                                    <div class="text-right text-gray-700">
                                        <span class="flex text-lg my-2 font-semibold text-gray-600 items-center">
                                            <svg v-if="transaction.type === 'INCOME'" width="22" height="22" viewBox="0 0 20 20" fill="currentColor" class="text-green-500">
                                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                                            </svg>
                                            <svg v-else fill="none" width="22" height="22" viewBox="0 0 24 24" stroke="currentColor" class="text-red-600">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                            </svg>
                                            ${{transaction.amount}} MXN
                                        </span> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-if="transactions.length > 0" class="px-6 py-4 mt-auto">
                            <div class="text-center text-indigo-700 font-medium">
                                <a href="/transactions">Ir a mis transacciones</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>

import TRANSACTIONS from '../graphql/transactions/transactions.graphql';
import ACCOUNTS from '../graphql/accounts/accounts.graphql';
import EXCHANGE_CONVERSION from '../graphql/exchange-rates/conversion.graphql';
import currency from 'currency.js';
import moment from 'moment';
import Loading from '../components/common/loading';

export default {
    components:{
        Loading
    },
    data(){
        return {
            loading: true,
            transactions: [],
            accounts: [],
            generalBalance: 0.00,
            dollarValue: 0.00,
            euroValue: 0.00,
            canadianValue: 0.00,
            lastMonthIncomes: 0.00,
            lastMonthExpenses: 0.00
        }
    },
    mounted(){
        this.getTransactions();
        this.getAccounts();
        this.getDollarValue();
        this.getEuroValue();
        this.getCanadianValue();
        this.getLastMonthTransactionsStatistics();
    },
    methods: {
        async getTransactions(){
            const response = await this.$apollo.query({
                query: TRANSACTIONS,
                variables: {
                    first: 20,
                    page: 1,
                    where: {
                        column: "CREATED_AT",
                        operator: "GTE",
                        value: moment().add(-1, 'month').format() // fecha actual menos 1 mes
                    }
                }
            });
            this.transactions = response.data.transactions.data.map(item => {
                return {
                    id: item.id,
                    amount: item.amount,
                    type: item.type,
                    account: item.account,
                    created_at: item.created_at
                }
            });
            this.loading = this.$apollo.loading;
            this.getLastMonthTransactionsStatistics();
        },
        async getAccounts(){
            const response = await this.$apollo.query({
                query: ACCOUNTS,
                variables: {
                    first: 20,
                    page: 1
                }
            });
            this.accounts = response.data.accounts.data.map(item => {
                return {
                    id: item.id,
                    color: item.color,
                    name: item.name,
                    balance: item.balance,
                    user: item.user,
                    created_at: item.created_at
                }
            });
            this.loading = this.$apollo.loading;
            this.getGeneralBalance();
        },
        getGeneralBalance(){
            const balance = this.accounts.forEach( (item, index) => {
                this.generalBalance += item.balance;
            });
        },
        async getDollarValue(){
            const response = await this.$apollo.query({
                query: EXCHANGE_CONVERSION,
                variables: {
                    input: {
                        from: "USD",
                        to: "MXN",
                        value: 1
                    }
                }
            });
            this.dollarValue = response.data.exchangeConversion.result;
            this.loading = this.$apollo.loading;
        },
        async getEuroValue(){
            const response = await this.$apollo.query({
                query: EXCHANGE_CONVERSION,
                variables: {
                    input: {
                        from: "EUR",
                        to: "MXN",
                        value: 1
                    }
                }
            });
            this.euroValue = response.data.exchangeConversion.result;
            this.loading = this.$apollo.loading;
        },
        async getCanadianValue(){
            const response = await this.$apollo.query({
                query: EXCHANGE_CONVERSION,
                variables: {
                    input: {
                        from: "CAD",
                        to: "MXN",
                        value: 1
                    }
                }
            });
            this.canadianValue = response.data.exchangeConversion.result;
            this.loading = this.$apollo.loading;
        },
        currencyFormatter(value){
            return currency(value).format();
        },
        getLastMonthTransactionsStatistics(){
            const incomes = this.transactions.forEach( (item, index) => {
                if(item.type == 'INCOME')
                    this.lastMonthIncomes += item.amount;
                else    
                    this.lastMonthExpenses += item.amount;
            });
        },
        formateDate(date){
            return moment(date).locale('es').format('DD [de] MMM');
        },
        formateExactDate(date){
            return moment(date).locale('es').format('h:mm, DD [de] MMM');
        }
    },
    
}
</script>