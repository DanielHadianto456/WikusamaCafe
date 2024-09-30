import { defineStore } from "pinia";

export const getAllOrders = defineStore("getAllOrdersStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token"); // Get the token from local storage

            const res = await fetch(`/api/${apiRoute}`, {
                method: "get",
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