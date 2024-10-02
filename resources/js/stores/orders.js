import { defineStore } from "pinia";

export const getAllOrders = defineStore("getAllOrdersStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token"); // Get the token from local storage

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            return data;
        }
    }
})

export const addOrder = defineStore("addOrderStore", {
    actions: {
        async authenticate(apiRoute, formData){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
                body: JSON.stringify(formData),
            });

            const data = await res.json();
            console.log(data);
            this.router.push({ name: "kasirDetail", params: {id: data.id_transaksi} });
        }
    }
})

export const getAllTables = defineStore("getTableStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token"); // Get the token from local storage

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            return data;
        }
    }
})

export const payOrder = defineStore("payOrderStore",{
    actions: {
        async authenticate(apiRoute){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                }
            });

            const data = await res.json();
            console.log(data);
            this.router.push({ name: "kasirHistory" });
        }
    }
})