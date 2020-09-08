<template>
<div>
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
                    <h3 class="text-indigo-700 py-4 font-normal text-lg">Your Portfolio</h3>
                    <div class="flex">
                    <button type="button" class="appearance-none py-4 text-indigo-700 border-b border-indigo-700 mr-3">
                        List
                    </button>
                    <button type="button" class="appearance-none py-4 text-grey-dark border-b border-transparent hover:border-gray-700">
                        Chart
                    </button>
                    </div>
                </div>
                </div>
                <div class="flex-grow flex px-6 py-6 text-grey-darker items-center border-b -mx-4">
                    <div class="w-2/5 xl:w-1/4 px-4 flex items-center">
                        <div class="rounded-full bg-orange inline-flex mr-3">
                            <svg class="fill-current text-gray-100 h-8 w-8 block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><g fill-rule="evenodd"><path d="M21.78 15.37c.51-.61.83-1.4.83-2.26 0-2.74-1.6-4.38-4.24-4.38V5.45c0-.12-.1-.22-.22-.22h-1.27c-.11 0-.2.1-.2.21v3.3h-1.7V5.44c0-.12-.1-.22-.22-.22H13.5c-.12 0-.2.1-.21.21v3.3H9.67c-.12 0-.21.09-.21.21v1.31c0 .12.1.22.21.22h.21c.94 0 1.7.79 1.7 1.75v7c0 .92-.68 1.67-1.55 1.75a.21.21 0 0 0-.18.16l-.33 1.32c-.01.06 0 .13.04.19.04.05.1.08.17.08h3.55v3.3c0 .1.1.2.2.2h1.28c.12 0 .21-.1.21-.22v-3.28h1.7v3.3c0 .1.1.2.21.2h1.27c.12 0 .22-.1.22-.22v-3.28h.85c2.65 0 4.24-1.64 4.24-4.37 0-1.28-.68-2.39-1.68-3zm-6.8-4.01h2.54c.94 0 1.7.78 1.7 1.75 0 .96-.76 1.75-1.7 1.75h-2.55v-3.5zm3.39 8.75h-3.4v-3.5h3.4c.93 0 1.7.78 1.7 1.75 0 .96-.77 1.75-1.7 1.75z"></path></g>
                            </svg>
                        </div>
                        <span class="text-lg text-gray-600">Bitcoin</span>
                    </div>
                    <div class="hidden md:flex lg:hidden xl:flex w-1/4 px-4 items-center text-gray-600">
                        <div class="bg-orange h-2 rounded-full flex-grow mr-2"></div>
                        100%
                    </div>
                    <div class="flex w-3/5 md:w/12">
                        <div class="w-1/2 px-4">
                            <div class="text-right">
                                0.0010 BTC
                            </div>
                        </div>
                        <div class="w-1/2 px-4">
                            <div class="text-right text-grey">
                                CA$21.28
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-grow flex px-6 py-6 text-grey-darker items-center border-b -mx-4">
                    <div class="w-2/5 xl:w-1/4 px-4 flex items-center">
                        <div class="rounded-full bg-blue-500 inline-flex mr-3">
                            <svg class="fill-current text-white h-8 w-8 block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38 38"><g fill-rule="evenodd"><path d="M12.29 28.04l1.29-5.52-1.58.67.63-2.85 1.64-.68L16.52 10h5.23l-1.52 7.14 2.09-.74-.58 2.7-2.05.8-.9 4.34h8.1l-.99 3.8z"></path></g></svg>
                        </div>
                        <span class="text-lg">Litecoin</span>
                    </div>
                    <div class="hidden md:flex lg:hidden xl:flex w-1/4 px-4 items-center">
                        <div class="bg-blue-500 h-2 w-2 rounded-full mr-2"></div>
                        0%
                    </div>
                    <div class="flex w-3/5 md:w/12">
                        <div class="w-1/2 px-4">
                            <div class="text-right">
                                0.0000 LTC
                            </div>
                        </div>
                        <div class="w-1/2 px-4">
                            <div class="text-right text-grey">
                                CA$0.00
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex-grow flex px-6 py-6 items-center border-b -mx-4">
                <div class="w-2/5 xl:w-1/4 px-4 flex items-center">
                    <div class="rounded-full text-red-500 inline-flex mr-3">
                    <svg class="fill-current text-white h-8 w-8 block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><g fill-rule="evenodd"><path d="M10.13 17.76c-.1-.15-.06-.2.09-.12l5.49 3.09c.15.08.4.08.56 0l5.58-3.08c.16-.08.2-.03.1.11L16.2 25.9c-.1.15-.28.15-.38 0l-5.7-8.13zm.04-2.03a.3.3 0 0 1-.13-.42l5.74-9.2c.1-.15.25-.15.34 0l5.77 9.19c.1.14.05.33-.12.41l-5.5 2.78a.73.73 0 0 1-.6 0l-5.5-2.76z"></path></g></svg>
                    </div>
                    <span class="text-lg">Ethereum</span>
                </div>
                <div class="hidden md:flex lg:hidden xl:flex w-1/4 px-4 items-center">
                    <div class="text-red-500 h-2 w-2 rounded-full mr-2"></div>
                    0%
                </div>
                <div class="flex w-3/5 md:w/12">
                    <div class="w-1/2 px-4">
                    <div class="text-right">
                        0.0000 ETH
                    </div>
                    </div>
                    <div class="w-1/2 px-4">
                    <div class="text-right text-grey">
                        CA$0.00
                    </div>
                    </div>
                </div>
                </div>
                <div class="px-6 py-4">
                <div class="text-center text-grey">
                    Total Balance &asymp; CA$21.28
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
                    <div class="text-center px-6 py-4">
                        <div class="py-8">
                            <div class="mb-4">
                                <svg class="inline-block h-16 w-16 fill-current mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8 7h10V5l4 3.5-4 3.5v-2H8V7zm-6 8.5L6 12v2h10v3H6v2l-4-3.5z" fill-rule="nonzero"/></svg> 
                            </div>
                            <p class="text-2xl text-gray-700 font-medium mb-4">Sin transacciones todavía</p>
                            <p class="text-gray-500 max-w-xs mx-auto mb-6">Agrega una nueva cuenta para poder registrar un gastos e ingresos.</p>
                            <div>
                                <button type="button" class="bg-indigo-700 hover:bg-indigo-800 text-white border border-indigo-900 rounded px-6 py-3">Registrar transacción</button>
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

export default {
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
                    user: item.user
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
    },
    computed: {
        
    }
    
}
</script>