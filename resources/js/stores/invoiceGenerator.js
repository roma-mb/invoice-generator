import { defineStore } from "pinia";
import http from "../clients/http.js";
import { useAuth } from "./auth.js";
import useModal from "./modal.js";

export const useInvoiceGenerator = defineStore("invoiceGenerator", {
    state: () => ({
        auth: useAuth(),
        invoice: {},
        zipCode: {},
        modal: useModal(),
    }),
    actions: {
        async generator(payload) {
            await http
                .post("/issue", payload, {
                    headers: {
                        Authorization: "Bearer " + this.auth.token,
                    },
                })
                .then(({ data }) => {
                    if (data.error) {
                        this.modal.open(data.error);
                        return;
                    }

                    this.invoice = data;
                })
                .catch(({ response }) => {
                    const message =
                        response?.data.description ?? response?.data.message;
                    this.modal.open(message);
                });
        },
        async findZipcode(code) {
            await http
                .get(`https://viacep.com.br/ws/${code}/json/`)
                .then(({ data }) => {
                    this.zipCode = data;
                })
                .catch(({ response }) => {
                    this.modal.open(response?.data.message);
                });
        },
    },
});

export default useInvoiceGenerator;
