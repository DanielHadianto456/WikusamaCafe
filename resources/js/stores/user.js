import {defineStore} from "pinia";

export const getAllUsers = defineStore("getAllUsersStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
            });

            const data = await res.json();
            console.log(data);
            return data;
        },
    },
});

export const editUsers = defineStore("editUsersStore", {
    actions: {
        async authenticate(apiRoute, formData){
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                },
                body: formData,
            });

            const data = await res.json();
            console.log(data);
            this.router.push({
                name: "listUser",
            });
        }
    }
})

export const deleteUser = defineStore("deletUserStore", {
    actions: {
        async authenticate(apiRoute) {
            const token = localStorage.getItem("token");

            const res = await fetch(`/api/${apiRoute}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    Authorization: `Bearer ${token}`,
                },
            });

            const data = await res.json();
            console.log(data);
        },
    },
});
