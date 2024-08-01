<script setup>
import { reactive, onMounted, ref, computed } from "vue";
import Modal from "../components/Modal.vue";
import { toClipboard } from "@soerenmartius/vue3-clipboard";
import useInvoiceGenerator from "../stores/invoiceGenerator.js";

const isApproved = ref(false);
const isCopied = ref(false);
const isSend = ref(false);
const invoiceGenerator = useInvoiceGenerator();
const step = ref(1);

const customer = reactive({
    cpf: "",
    nome_completo: "Jhon Doe",
    endereco: "",
    complemento: "Escritório",
    numero: 0,
    bairro: "",
    cidade: "",
    uf: "",
    cep: "",
    telefone: "",
    email: "",
});

const product = reactive({
    nome: "",
    codigo: "nome-do-produto",
    ncm: "6109.10.00",
    cest: "28.038.00",
    quantidade: 2,
    unidade: "UN",
    peso: "0.800",
    origem: 0,
    subtotal: "30.00",
    total: "60.00",
    classe_imposto: "REF49393847",
});

const order = reactive({
    pagamento: 0,
    presenca: 2,
    modalidade_frete: 0,
    frete: "30.00",
    desconto: "5.00",
    total: "125.00",
});

const data = reactive({
    ID: 1137,
    url_notificacao: "http://meudominio.com/retorno.php",
    operacao: 1,
    natureza_operacao: "Venda de produção",
    modelo: 1,
    finalidade: 1,
    ambiente: 2,
    cliente: {},
    produtos: [],
    pedido: {},
});

const clipBoard = () => {
    toClipboard(invoiceGenerator.invoice.danfe ?? "");
    isCopied.value = true;
    setTimeout(() => {
        isCopied.value = false;
    }, 1000);
};

const bindZipcode = async (event) => {
    const code = event.target.value.replace(
        /[\s~`!@#$%^&*(){}\[\];:"'<,.>?\/\\|_+=-]/g,
        "",
    );
    if (code.length === 8) {
        await invoiceGenerator.findZipcode(code);
        customer.endereco = invoiceGenerator.zipCode.logradouro;
        customer.bairro = invoiceGenerator.zipCode.bairro;
        customer.cidade = invoiceGenerator.zipCode.localidade;
        customer.uf = invoiceGenerator.zipCode.uf;
    }
};

const createInvoice = async () => {
    data.cliente = customer;
    data.produtos.push(product);
    data.pedido = order;

    isSend.value = true;

    await invoiceGenerator.generator(JSON.stringify(data));

    isSend.value = false;
    isApproved.value = invoiceGenerator.invoice.status === "aprovado";
};

const createNew = () => {
    isApproved.value = false;
    window.location.reload();
    step.value = 1;
};
</script>

<template>
    <!--Main-->
    <div
        class="container rounded-xl bg-indigo py-10 justify-center px-4 mx-auto mt-20"
    >
        <div class="flex mb-4 sm:mb-5 justify-center" v-show="!isApproved">
            <div class="w-1/2">
                <ol class="flex w-full items-center">
                    <li class="flex w-[50%]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 dark:bg-ash-gray shrink-0"
                        >
                            <svg
                                class="w-4 h-4 text-gray-600 lg:w-6 lg:h-6 dark:text-indigo"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 16"
                            >
                                <path
                                    d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"
                                />
                            </svg>
                        </div>
                        <div
                            class="flex items-center text-gray-600 dark:text-gray-500 after:w-full after:h-1 after:border-b after:border-gray-100 after:border-4 after:inline-block"
                            v-bind:class="{
                                'dark:after:border-ash-gray w-full': step > 1,
                                'dark:after:border-gray-600 w-full': step === 1,
                            }"
                        ></div>
                    </li>
                    <li class="flex w-[50%]">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                            v-bind:class="{
                                'dark:bg-ash-gray': step > 1,
                                'dark:bg-gray-700': step < 2,
                            }"
                        >
                            <svg
                                class="w-4 h-4 text-gray-600 lg:w-6 lg:h-6 dark:text-indigo"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 14"
                            >
                                <path
                                    d="M18 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM2 12V6h16v6H2Z"
                                />
                                <path
                                    d="M6 8H4a1 1 0 0 0 0 2h2a1 1 0 0 0 0-2Zm8 0H9a1 1 0 0 0 0 2h5a1 1 0 1 0 0-2Z"
                                />
                            </svg>
                        </div>
                        <div
                            class="flex items-center text-gray-600 dark:text-gray-500 after:w-full after:h-1 after:border-b after:border-gray-100 after:border-4 after:inline-block"
                            v-bind:class="{
                                'dark:after:border-ash-gray w-full': step > 2,
                                'dark:after:border-gray-600 w-full': step < 3,
                            }"
                        ></div>
                    </li>
                    <li class="flex items-center">
                        <div
                            class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                            v-bind:class="{
                                'dark:bg-ash-gray': step === 3,
                                'dark:bg-gray-700': step < 3,
                            }"
                        >
                            <svg
                                class="w-4 h-4 text-gray-600 lg:w-6 lg:h-6 dark:text-indigo"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 18 20"
                            >
                                <path
                                    d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z"
                                />
                            </svg>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
        <form class="px-10" onsubmit="return false" v-show="!isApproved">
            <TransitionGroup name="fade">
                <div v-if="step === 1" id="customerDetails">
                    <h3
                        class="mb-4 text-lg font-medium leading-none text-gray-100 dark:text-gray-100"
                    >
                        Invoice details
                    </h3>
                    <div class="flex justify-between gap-5 mb-4">
                        <div>
                            <label
                                for="id"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Id:</label
                            >
                            <input
                                v-model="data.ID"
                                type="number"
                                name="id"
                                id="id"
                                class="no-spinner bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="1137"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="operation"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Op:</label
                            >
                            <input
                                v-model="data.operacao"
                                type="number"
                                name="operation"
                                id="operation"
                                class="no-spinner bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="model"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Model:</label
                            >
                            <input
                                v-model="data.modelo"
                                type="number"
                                name="model"
                                id="model"
                                class="no-spinner bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="purpose"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Purpose:</label
                            >
                            <input
                                v-model="data.finalidade"
                                type="number"
                                name="purpose"
                                id="purpose"
                                class="no-spinner bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="1"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="environment"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Environment:</label
                            >
                            <input
                                v-model="data.ambiente"
                                type="number"
                                name="environment"
                                id="environment"
                                class="no-spinner bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="2"
                                required=""
                            />
                        </div>
                    </div>
                    <div class="grid gap-4 mb-10 sm:grid-cols-2">
                        <div>
                            <label
                                for="url_notify"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Url:</label
                            >
                            <input
                                v-model="data.url_notificacao"
                                type="text"
                                name="url_notify"
                                id="url_notify"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="http://meudominio.com/retorno.php"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="nature"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Nature:</label
                            >
                            <input
                                v-model="data.natureza_operacao"
                                type="text"
                                name="nature"
                                id="nature"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required=""
                            />
                        </div>
                    </div>

                    <h3
                        class="mb-4 text-lg font-medium leading-none text-gray-100 dark:text-gray-100"
                    >
                        Customer details
                    </h3>
                    <div class="flex justify-between gap-5 mb-4 sm:grid-cols-2">
                        <div class="w-1/3">
                            <label
                                for="name"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Name:</label
                            >
                            <input
                                v-model="customer.nome_completo"
                                type="text"
                                name="name"
                                id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="John doe"
                                required=""
                            />
                        </div>
                        <div class="w-1/3">
                            <label
                                for="cpf"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Cpf:</label
                            >
                            <input
                                v-model="customer.cpf"
                                v-mask="'###.###.###-##'"
                                type="text"
                                name="cpf"
                                id="cpf"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="000.000.000-00"
                                required=""
                            />
                        </div>
                        <div class="w-1/3">
                            <label
                                for="cep"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >CEP:</label
                            >
                            <input
                                @input="bindZipcode"
                                v-model="customer.cep"
                                v-mask="'#####-###'"
                                type="text"
                                name="cep"
                                id="cep"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="00000-000"
                                required=""
                            />
                        </div>
                    </div>
                    <div class="flex gap-5 mb-4">
                        <div class="w-3/5">
                            <label
                                for="address"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Address:</label
                            >
                            <input
                                v-model="customer.endereco"
                                type="text"
                                name="address"
                                id="address"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Av. ABC"
                                required=""
                            />
                        </div>
                        <div class="w-2/5">
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Email:</label
                            >
                            <input
                                v-model="customer.email"
                                type="email"
                                name="email"
                                id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="nome@email.com"
                                value="nome@email.com"
                                required=""
                            />
                        </div>
                    </div>
                    <div class="sm:flex justify-between gap-5 mb-10">
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="complement"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Complement:</label
                            >
                            <input
                                v-model="customer.complemento"
                                type="text"
                                name="complement"
                                id="complement"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Office"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="number"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Number:</label
                            >
                            <input
                                v-model="customer.numero"
                                type="number"
                                name="number"
                                id="number"
                                class="no-spinner bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="0"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="neighbourhood"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Neighbourhood:</label
                            >
                            <input
                                v-model="customer.bairro"
                                type="text"
                                name="neighbourhood"
                                id="neighbourhood"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Itaim"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="city"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >City:</label
                            >
                            <input
                                v-model="customer.cidade"
                                type="text"
                                name="city"
                                id="city"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="São Paulo"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="uf"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Uf:</label
                            >
                            <input
                                v-model="customer.uf"
                                type="text"
                                name="uf"
                                id="uf"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="SP"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="phone"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Phone:</label
                            >
                            <input
                                v-model="customer.telefone"
                                v-mask="'(##) ####-####'"
                                type="text"
                                name="phone"
                                id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="(00) 0000-0000"
                                required=""
                            />
                        </div>
                    </div>
                </div>

                <div v-if="step === 2" id="productDetails">
                    <h3
                        class="mb-4 text-lg font-medium leading-none text-gray-100 dark:text-gray-100"
                    >
                        Product details
                    </h3>
                    <div
                        class="grid justify-between gap-5 mb-10 sm:grid-cols-2"
                    >
                        <div>
                            <label
                                for="name"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Name:</label
                            >
                            <input
                                v-model="product.nome"
                                type="text"
                                name="name"
                                id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Product A"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="code"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Code:</label
                            >
                            <input
                                v-model="product.codigo"
                                type="text"
                                name="code"
                                id="code"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="nome-do-produto"
                                required=""
                            />
                        </div>
                    </div>
                    <div class="w-full sm:flex justify-between gap-5 mb-10">
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="ncm"
                                class="block text-sm font-medium text-gray-100 dark:text-white"
                                >Ncm:</label
                            >
                            <input
                                v-model="product.ncm"
                                v-mask="'####.##.##'"
                                type="text"
                                name="ncm"
                                id="ncm"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="6109.10.00"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="cest"
                                class="block text-sm font-medium text-gray-100 dark:text-white"
                                >Cest:</label
                            >
                            <input
                                v-model="product.cest"
                                v-mask="'##.###.##'"
                                type="text"
                                name="cest"
                                id="cest"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="28.038.00"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="quantity"
                                class="block text-sm font-medium text-gray-100 dark:text-white"
                                >Quantity:</label
                            >
                            <input
                                v-model="product.quantidade"
                                type="text"
                                name="quantity"
                                id="quantity"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="1"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="unity"
                                class="block text-sm font-medium text-gray-100 dark:text-white"
                                >Unity:</label
                            >
                            <input
                                v-model="product.unidade"
                                type="text"
                                name="unity"
                                id="unity"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="3"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="weight"
                                class="block text-sm font-medium text-gray-100 dark:text-white"
                                >Weight:</label
                            >
                            <input
                                v-model="product.peso"
                                type="text"
                                name="weight"
                                id="weight"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="0.800"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="origin"
                                class="block text-sm font-medium text-gray-100 dark:text-white"
                                >Origin:</label
                            >
                            <input
                                v-model="product.origem"
                                type="text"
                                name="origin"
                                id="origin"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="0"
                                value="0"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="subtotal"
                                class="block text-sm font-medium text-gray-100 dark:text-white"
                                >Subtotal:</label
                            >
                            <input
                                v-model="product.subtotal"
                                type="text"
                                name="subtotal"
                                id="subtotal"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="44.90"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="total"
                                class="block text-sm font-medium text-gray-100 dark:text-white"
                                >Total:</label
                            >
                            <input
                                v-model="product.total"
                                type="text"
                                name="total"
                                id="total"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="134.70"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="class"
                                class="block text-sm font-medium text-gray-100 dark:text-white"
                                >Class:</label
                            >
                            <input
                                v-model="product.classe_imposto"
                                type="text"
                                name="class"
                                id="class"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="REF49393847"
                                value="REF49393847"
                                required=""
                            />
                        </div>
                    </div>
                </div>

                <div v-if="step === 3" id="orderDetails">
                    <h3
                        class="mb-4 text-lg font-medium leading-none text-gray-100 dark:text-gray-100"
                    >
                        Order details
                    </h3>
                    <div
                        class="sm:flex justify-between gap-5 mb-10 sm:grid-cols-2"
                    >
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="payment"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >payment:</label
                            >
                            <input
                                v-model="order.pagamento"
                                type="text"
                                name="payment"
                                id="payment"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="0"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="presence"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Presence:</label
                            >
                            <input
                                v-model="order.presenca"
                                type="text"
                                name="presence"
                                id="presence"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="2"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="shipping-model"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Shipping model:</label
                            >
                            <input
                                v-model="order.modalidade_frete"
                                type="text"
                                name="shipping-model"
                                id="shipping"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="0"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="shipping"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Shipping:</label
                            >
                            <input
                                v-model="order.frete"
                                type="text"
                                name="shipping"
                                id="shipping"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="12.56"
                                required=""
                            />
                        </div>
                        <div class="sm:mb-0 mb-4">
                            <label
                                for="discount"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Discount:</label
                            >
                            <input
                                v-model="order.desconto"
                                type="text"
                                name="discount"
                                id="discount"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="10.00"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="total"
                                class="block mb-2 text-sm font-medium text-gray-100 dark:text-white"
                                >Total:</label
                            >
                            <input
                                v-model="order.total"
                                type="text"
                                name="total"
                                id="total"
                                class="bg-gray-50 border border-gray-300 text-gray-100 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="174.60"
                                value="0"
                                required=""
                            />
                        </div>
                    </div>
                </div>
            </TransitionGroup>

            <div v-show="!isSend" id="buttonSteps">
                <button
                    :disabled="step === 1"
                    type="button"
                    @click="step--"
                    class="w-28 mr-1 text-indigo bg-gray-600 hover:bg-indigo focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-ash-gray dark:hover:bg-gray-600 hover:text-gray-100 dark:focus:ring-indigo"
                >
                    Previous
                </button>
                <button
                    v-if="step < 3"
                    :disabled="step === 3"
                    type="button"
                    @click="step++"
                    class="w-28 ml-1 text-indigo bg-gray-600 hover:bg-indigo focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-ash-gray dark:hover:bg-gray-600 hover:text-gray-100 dark:focus:ring-indigo"
                >
                    Next
                </button>
                <button
                    v-if="step === 3 && !isSend"
                    type="button"
                    @click="createInvoice"
                    class="ml-1 text-indigo bg-gray-600 hover:bg-indigo focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-axolotl dark:hover:bg-gray-600 hover:text-gray-100 dark:focus:ring-blue-700"
                >
                    Create Invoice
                </button>
            </div>
            <div
                v-show="isSend"
                class="flex relative items-center p-6 bg-indigo border border-indigo rounded-lg dark:bg-indigo dark:border-indigo dark:hover:bg-indigo"
            >
                <div
                    role="status"
                    class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2"
                >
                    <svg
                        aria-hidden="true"
                        class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-ash-gray"
                        viewBox="0 0 100 101"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"
                        />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill"
                        />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </form>

        <div class="px-10" v-show="isApproved" id="resume">
            <h3
                class="my-4 text-lg font-medium leading-none text-gray-100 dark:text-gray-100"
            >
                Resume:
            </h3>
            <div class="justify-between sm:grid-cols-2">
                <div
                    class="relative bg-gray-50 dark:bg-gray-700 dark:border-gray-600 p-4 rounded-lg border border-gray-200 not-italic grid grid-cols-1"
                >
                    <div
                        class="text-gray-500 dark:text-gray-400 leading-loose hidden sm:block"
                    >
                        Invoice:
                    </div>
                    <a
                        id="result-details"
                        class="break-normal md:break-all text-gray-900 dark:text-white font-medium leading-loose"
                        v-bind:href="invoiceGenerator.invoice.danfe ?? ''"
                        target="_blank"
                    >
                        {{ invoiceGenerator.invoice.danfe ?? "" }}
                    </a>
                    <button
                        @click="clipBoard()"
                        data-copy-to-clipboard-target="result-details"
                        data-copy-to-clipboard-content-type="textContent"
                        data-tooltip-target="tooltip-result-details"
                        class="absolute end-2 top-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg p-2 inline-flex items-center justify-center"
                    >
                        <span
                            v-if="!isCopied"
                            id="default-icon-result-details"
                            class=""
                        >
                            <svg
                                class="w-3.5 h-3.5"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 18 20"
                            >
                                <path
                                    d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"
                                />
                            </svg>
                        </span>
                        <span
                            v-if="isCopied"
                            id="success-icon-result-details"
                            class="inline-flex items-center"
                        >
                            <svg
                                class="w-3.5 h-3.5 text-blue-700 dark:text-blue-500"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 16 12"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5.917 5.724 10.5 15 1.5"
                                />
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
            <button
                type="button"
                @click="createNew"
                class="mt-4 text-indigo bg-gray-600 hover:bg-indigo focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-axolotl dark:hover:bg-gray-600 hover:text-gray-100 dark:focus:ring-blue-700"
            >
                Create new
            </button>
        </div>

        <Modal
            :isOpen="invoiceGenerator.modal.isOpen"
            :message="invoiceGenerator.modal.message"
            @modal-close="invoiceGenerator.modal.close"
        />
    </div>
</template>
