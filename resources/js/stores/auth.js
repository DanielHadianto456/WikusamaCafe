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
            this.router.push({ name: "login" });
        },
    },
});

export const useLogin = defineStore("loginStore", {
    state: () => {
        return {
            user: null,
            role: null,
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

            if (data) {
                localStorage.setItem("token", data.token);
                localStorage.setItem("user", data.user);
                localStorage.setItem("role", data.role);

                this.token = data.token;
                this.user = data.user;
                this.role = data.role;

                if (this.role == "KASIR") {
                    this.router.push({ name: "kasir" });
                } else if (this.role == "MANAJER") {
                    this.router.push({ name: "manajer" });
                } else if (this.role == "ADMIN") {
                    this.router.push({ name: "admin" });
                } else {
                    this.router.push({ name: "home" });
                }
            }
            // this.router.push({ name: "home" });
        },
    },
});

export const useLogout = defineStore("logoutStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token"); // Get the token from local storage

            const res = await fetch(`/api/${apiRoute}`, {
                method: "post",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`, // Send the token in the Authorization header
                },
            });

            const data = await res.json();

            if (data) {
                localStorage.removeItem("token");
                localStorage.removeItem("user");
                localStorage.removeItem("role");
                this.router.push({ name: "login" });
            } else {
                console.error("Failed to logout");
            }
        },
    },
});
