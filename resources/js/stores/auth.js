import { defineStore } from "pinia";

export const useRegister = defineStore("registerStore", {
    state: () => {
        return {
            user: null,
        };
    },

    // getters: {},

    actions: {
        async authenticate(apiRoute, formData) {
            const res = await fetch(`/api/${apiRoute}`, {
                method: "post",
                headers: {
                    "Content-Type": "application/json", // Added header
                    Accept: "application/json",
                },
                body: JSON.stringify(formData),
            });

            const data = await res.json();
            console.log(data);
        },
    },
});

export const useLogin = defineStore("loginStore", {
    state: () => {
        return {
            token: null,
            // token: data.token
        };
    },

    // getters: {},

    actions: {
        async authenticate(apiRoute, formData) {
            const res = await fetch(`/api/${apiRoute}`, {
                method: "post",
                headers: {
                    "Content-Type": "application/json", // Added header
                    Accept: "application/json",
                },
                body: JSON.stringify(formData),
            });

            const data = await res.json();
            console.log(data);

            if(data){

                localStorage.setItem('token', data.token)
                this.token = data.token


            }
        },
    },
});
